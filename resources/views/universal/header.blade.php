<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Oviatt Assistant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/home/main.css')}}" />
    <link
            href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap"
            rel="stylesheet"
                />
    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
                />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <script async="" defer="" src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@1.17.0-beta.7/dist/tsparticles.min.js"></script>
    <style>
    @import url(//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css);
    @import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);
    </style>
</head>

<div class="header">
    <h1 class="logo">
    <img id="csun-icon-header" src="{{asset('img/csun-icon.png')}}">
    </h1>
    <i id="ham-menu" class="fas fa-bars"></i>
    <ul class="main-nav">
    </ul>
</div >
