<form role="search" method="get" class="search-form form" action="/search" style="width: 90%; margin: 15px auto;">
    <label>
        <span class="screen-reader-text">Search for...</span>
        <input id="sb" type="search" class="search-field" value="" placeholder="" name="s" title="" />
    </label>
    <input type="submit" class="search-submit button" value="&#xf002" />
</form>
<script>
    document.getElementById('sb').value = new URLSearchParams(new URL(window.location.href).search).get('s')
</script>
