<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Oviatt Assistant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/main/main.css')}}" />
    <link
            href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap"
            rel="stylesheet"
    />
    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
</head>
<header class="header">
    <h1 class="logo"></h1>
    <ul class="main-nav">
    </ul>
</header>
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
                <input type="search" class="search-field" value="" name="s" title="" />
            </label>
            <input type="submit" class="search-submit button" value="&#xf002" />
        </form>
    </div>
</div>
<script src="{{asset('js/home.js')}}"></script>
</body>
</html>