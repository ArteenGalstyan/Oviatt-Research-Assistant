import mxnet as mx
import os
import boto3
import io
import sagemaker
import pandas as pd
import csv

from sagemaker import get_execution_role
role = get_execution_role()
s3_client = boto3.client('s3')
data_bucket_name='s3bucket-mxnet-out'
sess = sagemaker.Session()

obj_list=s3_client.list_objects(Bucket=data_bucket_name)
files = list(map(lambda i: i['Key'], filter(lambda x: "train/part-" in x['Key'], obj_list['Contents'])))

file_data=files[0]
response = s3_client.get_object(Bucket=data_bucket_name, Key=file_data)
response_body = response["Body"].read()
some_abstracts = pd.read_csv(io.BytesIO(response_body), header=None, delimiter=",", low_memory=False)
for f_data in files[1:]:
    response = s3_client.get_object(Bucket=data_bucket_name, Key=f_data)
    response_body = response["Body"].read()
    some_abstracts.append(pd.read_csv(io.BytesIO(response_body), header=None, delimiter=",", low_memory=False))
    
from sagemaker import KMeans

num_clusters = 10
kmeans = KMeans(role=role,
                instance_count=1,
                instance_type='ml.c4.xlarge',
                output_path='s3://'+ data_bucket_name +'/cluster-output/',
               k=num_clusters)

kmeans.fit(kmeans.record_set(train_data))
kmeans_predictor = kmeans.deploy(initial_instance_count=1, 
                                 instance_type='ml.t2.medium')