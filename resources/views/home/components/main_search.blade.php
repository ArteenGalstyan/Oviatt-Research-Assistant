<body xmlns="http://www.w3.org/1999/html">
<div class="wrapper">

    <!-- Logo + Particles -->
    <div id="particles" class="half-background">
        <img src="{{asset('img/mainlogo.png')}}">
    </div>


    <div class="container">

        <!-- Search bar -->
        <form role="search" method="get" class="search-form form" action="/search">
            <label>
                <span class="screen-reader-text">Search for...</span>
                <input type="search" class="search-field" value="" placeholder="Find My Research" name="s" title="" />
            </label>
            <input type="submit" class="search-submit button" value="&#xf002" />
        </form>

        <!-- Optional info bar - Can't make this fit on mobile -->
        @if (!($isMobile ?? ''))
            <div id="about-home">
                <span id="about-home-text">Powered by Machine Learning</span>
            </div>
            <img id="powered-by" src="{{asset('img/aibrain.png')}}">
        @endif
    </div>
</div>
</body>
