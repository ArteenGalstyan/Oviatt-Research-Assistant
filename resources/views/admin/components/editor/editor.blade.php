<section class="panel important">
    <h2>Write a post</h2>
    <form action="#">
        <div class="twothirds">
            <label for="name">Text Input:</label>
            <input type="text" name="name" id="name" placeholder="John Smith" />

            <label for="textarea">Textarea:</label>
            <textarea cols="40" rows="8" name="textarea" id="textarea"></textarea>

        </div>
        <div class="onethird">
            <legend>Radio Button Choice</legend>

            <label for="radio-choice-1">
                <input type="radio" name="radio-choice" id="radio-choice-1" value="choice-1" /> Choice 1
            </label>

            <label for="radio-choice-2">
                <input type="radio" name="radio-choice" id="radio-choice-2" value="choice-2" /> Choice 2
            </label>


            <label for="select-choice">Select Dropdown Choice:</label>
            <select name="select-choice" id="select-choice">
                <option value="Choice 1">Choice 1</option>
                <option value="Choice 2">Choice 2</option>
                <option value="Choice 3">Choice 3</option>
            </select>


            <div>
                <label for="checkbox">
                    <input type="checkbox" name="checkbox" id="checkbox" /> Checkbox
                </label>
            </div>

            <div>
                <input type="submit" value="Submit" />
            </div>
        </div>
    </form>
</section>





