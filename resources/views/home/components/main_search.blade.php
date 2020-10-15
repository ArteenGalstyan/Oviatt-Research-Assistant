<body>
<div class="wrapper">
    <script async="" defer="" src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@1.17.0-beta.7/dist/tsparticles.min.js"></script>
    <div id="particles" class="half-background">
        <img src="{{asset('img/mainlogo.png')}}">
    </div>
    <div class="container">
        <form role="search" method="get" class="search-form form" action="">
            <label>
                <span class="screen-reader-text">Search for...</span>
                <input type="search" class="search-field" value="" placeholder="Find My Research" name="s" title="" />
            </label>
            <input type="submit" class="search-submit button" value="&#xf002" />
        </form>
        @if (!$isMobile)
            <div id="about-home">
                Test
            </div>
        @endif
    </div>
</div>
</body>
