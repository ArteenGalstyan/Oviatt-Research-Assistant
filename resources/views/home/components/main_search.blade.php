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
                <table id="trending" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col" class="col-md-1">Total</th>
                        <th scope="col" class="col-md-1">Trending Searches</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($trending as $query => $count)
                        <tr data-seq="1">
                            <td class="td_row_text">{{$count}}</td>
                            <td class="td_row_text">{{$query}}</td>
                        </tr>
                        @if ($entry_count++ & $entry_count > 5)
                            @break
                        @endif

                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
</body>
