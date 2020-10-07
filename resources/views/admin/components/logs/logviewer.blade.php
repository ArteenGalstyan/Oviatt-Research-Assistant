<section class="panel important">
    <h2>Log Viewer</h2>
    <form action="/get_logs" method="post">
        @csrf
        <select id="host" name="host" onchange="getLogs()">
            <option value="prod">Production</option>
            <option value="dev">Develop</option>
            <option value="nick">Nick</option>
            <option value="arteen">Arteen</option>
            <option value="tyler">Tyler</option>
        </select>
        <textarea id="logview" disabled style="height: 600px;"></textarea>
    </form>
</section>
<script>
    function getLogs() {
        post('/get_logs', {'host': $('#host').val()}, (response) => {
            const lv = document.getElementById('logview');
            lv.innerHTML = response;
        }, () => {});
        localStorage.setItem('adminHostSelection', $('#host').val())
    }
    let lastHost;
    if ((lastHost = localStorage.getItem('adminHostSelection'))) {
        $('#host').val(lastHost);
    }
    getLogs();
</script>



