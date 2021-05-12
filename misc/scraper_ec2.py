from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
import json
import csv
from datetime import date
import boto3

driver = webdriver.Chrome()
wait = WebDriverWait(driver, 10)

def login(username, password):
    driver.get("https://library.csun.edu/cgi/ez-alma/ezalma.php?url=http%3a%2f%2fsearch.ebscohost.com%2flogin.aspx%3fauthtype%3dip%2cuid%26profile%3dehost%26defaultdb%3daph")

    userID = driver.find_element_by_id("user")
    passwrd = driver.find_element_by_id("password")
    login = driver.find_element_by_name("submit")

    userID.send_keys(username)
    passwrd.send_keys(password)
    login.click()
    return

def search(value):
    box = wait.until(EC.presence_of_element_located((By.ID, "Searchbox1")))
    box.send_keys(Keys.LEFT_CONTROL + 'a')
    box.send_keys(value)
    driver.find_element_by_id("SearchButton").click()
    return

def first_element():
    results = driver.find_elements_by_class_name("result-list-record")
    if results:
        first = results[0]
        data_amplitude = json.loads(first.get_attribute("data-amplitude"))
        if data_amplitude["result_index"] == "1":
            doc = driver.find_element_by_id("Result_1")
            return doc, data_amplitude["formats"]

def collect_item():
    base = "/html/body/form/div[2]/div[1]/div[3]/div/div[3]/div[1]/dl/d"
    features = ["Authors:", "Author-Supplied Keywords:", "Abstract:", "Full Text Word Count:"]
    table = wait.until(EC.presence_of_all_elements_located((By.CSS_SELECTOR, 'dt[data-auto="citation_field_label"]')))
    table_length = len(table)
    i = 6
    citation_element = driver.find_element_by_xpath(base + "d[1]/a")
    citation = json.loads(citation_element.get_attribute("data-amplitude"))
    while (i <= table_length) and features:
        f = driver.find_element_by_xpath(base + "t[" + str(i) + "]")
        attribute = f.get_attribute("innerHTML")
        if attribute in features:
            features.remove(attribute)
            ff = driver.find_element_by_xpath(base + "d[" + str(i) + "]")
            attribute = attribute.replace(' ', '_').replace('-', '_').replace(':', '')
            if attribute == 'lexile_score':
                attribute = 'lixical_score'
            citation.update({attribute: ff.get_attribute("innerText")})
        
        i += 1
    # citation.update({'url': driver.current_url})
    citation.update({'item_no': ''})
    return citation

def next_page():
    driver.find_element_by_id("ctl00_ctl00_MainContentArea_MainContentArea_topNavControl_btnNext").click()
    return 

def getFromfile(file_path):
    f = open(file_path, 'r')
    info = f.readline()
    f.close()
    return info.split()

def getCategoriesFromfile(file_path):
    f = open(file_path, 'r')
    info = f.readlines()
    f.close()
    info_split = list(map(lambda x: x.split(','), info))
    flatten = lambda t: [item for sublist in t for item in sublist]
    return flatten(info_split)

def writeTofile(file_path, content):
    with open(file_path, 'w') as f:
        f.write(content)

def unpack_nested_json(citation_json: dict):
    """
    Pulls JSON keys out of citation and de-nests the 'jinfo' and 'bkinfo' entries in the citation JSON
    :param citation_json: dict - JSON loaded from citation CSV
    :return:
    """

    json_out = {}
    for key, val in citation_json.items():
        if key in ['jinfo', 'bkinfo']:
            for nkey, nval in val.items():
                # For single values - put as is, otherwise join as CSV
                json_out[nkey] = nval if not isinstance(nval, list) else ",".join(nval)
        elif isinstance(val, list):
            json_out[key] = ",".join(val)
        else:
            json_out[key] = val
    for key, val in json_out.items():
        # Maintain original escape characters
        json_out[key] = json_out[key].replace('\n', '\\n')
    return json_out

def get_all_headers(csv_out_data):
    """
    JSON keys seem to vary from citation to citation, so collect all headers and de-dupe
    :param csv_out_data: Finalized CSV output list of dicts
    :return: list[str]
    """
    headers = []
    for line in csv_out_data:
        for key in line.keys():
            headers.append(key)
    return list(set(headers))

def convert_toString(prev_links):
    s = ''
    for p in prev_links:
        s += p + ' '
    return s

def main():
    username, password = getFromfile('login_info.txt') #keep login information in a .txt seperating username and password by a space
    login(username, password) #username and password
    categories = getCategoriesFromfile('categories.txt') #keep categories to be searched in a .txt seperating search terms by a comma
    amount_of_categories = len(categories)
    previous_links = getFromfile('previous-links.txt')
    amount_of_prev = len(previous_links)
    
    if amount_of_prev < amount_of_categories:
        for _ in range(amount_of_categories - amount_of_prev):
            previous_links.append('')

    index = 0
    LIMIT = 45 # limit of how many items to collect per category
    items = [] # list of items collected
    base_pg_number_path = 'ctl00_ctl00_MainContentArea_MainContentArea_topNavControl_'
    def check_page_number():
        current_pg_number_element = wait.until(EC.presence_of_element_located((By.ID, base_pg_number_path + 'lblCurrent')))
        total_pg_number_element = driver.find_element_by_id(base_pg_number_path + 'lblTotal')
        current_pg_number = current_pg_number_element.get_attribute('innerHTML')
        total_pg_number = total_pg_number_element.get_attribute('innerHTML')
        return current_pg_number.strip() is not total_pg_number.strip()

    while index < amount_of_categories:
        if previous_links[index] is '':
            search(categories[index])
            element = first_element()
            if element:
                doc, doc_type = element
                doc.click()
                if 'P' in doc_type:
                    detailed_record = wait.until(EC.presence_of_element_located((By.ID, "formatCitation")))
                    detailed_record.click()
        else:
            driver.get(previous_links[index])

        if check_page_number():
            i = 0
            while i < LIMIT:
                items.append(unpack_nested_json(collect_item()))
                i += 1
                if i == LIMIT:
                    previous_links[index] = driver.current_url
                    login(username, password)
                else:
                    next_page()
    
        index += 1

    a = str(date.today()).split('-')
    b = str(int(a[-1]))
    a[-1] = b
    c = a[0] + '-' + a[1] + '-' + a[2]
    out_file = 'citations-' + c + '.csv'
    of = open(out_file, 'w', newline='', encoding='utf8')
    writer = csv.DictWriter(of, get_all_headers(items))
    writer.writeheader()
    for line in items:
        if 'Abstract' in line:
            writer.writerow(line)


    session = boto3.Session()
    s3 = boto3.client('s3')
    s3.upload_file(out_file, 's3bucket-in', 'citations/' + out_file)

    # writeTofile('previous-links.txt', convert_toString(previous_links))

if __name__ == '__main__':
    main()
    driver.close()