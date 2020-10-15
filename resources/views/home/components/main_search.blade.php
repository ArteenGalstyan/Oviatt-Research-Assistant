<body xmlns="http://www.w3.org/1999/html">
<div class="wrapper">

    <!-- Logo + Particles -->
    <script async="" defer="" src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@1.17.0-beta.7/dist/tsparticles.min.js"></script>
    <div id="particles" class="half-background">
        <img src="{{asset('img/mainlogo.png')}}">
    </div>


    <div class="container">

        <!-- Search bar -->
        <form role="search" method="get" class="search-form form" action="">
            <label>
                <span class="screen-reader-text">Search for...</span>
                <input type="search" class="search-field" value="" placeholder="Find My Research" name="s" title="" />
            </label>
            <input type="submit" class="search-submit button" value="&#xf002" />
        </form>

        <!-- Optional info bar - Can't make this fit on mobile -->
        @if (!$isMobile)
            <div id="about-home">
                <span id="about-home-text">Powered by Machine Learning</span>
            </div>
            <img id="powered-by" src="{{asset('img/aibrain.png')}}">
        @endif
    </div>
</div>
</body>
