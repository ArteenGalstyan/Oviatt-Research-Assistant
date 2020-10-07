<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400|Montserrat:700' rel='stylesheet' type='text/css'>
    <style>
        @import url(//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css);
        @import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);
        .rotate {
            -webkit-animation: rotation 2s infinite linear;
            animation: rotation 2s infinite linear;
        }

        @-webkit-keyframes rotation {
            from {-webkit-transform: rotate(0deg);}
            to   {-webkit-transform: rotate(359deg);}
        }

        @keyframes rotation {
            from {-ms-transform: rotate(0deg);}
            to   {-ms-transform: rotate(359deg);}

            from {transform: rotate(0deg);}
            to   {transform: rotate(359deg);}
        }
    </style>
    <link rel="stylesheet" href="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/default_thank_you.css">
</head>
<body>
<header class="site-header" id="header">
    <h1 id="title" class="site-header__title" data-lead-id="site-header-title">Verifying...</h1>
</header>
<div class="main-content">
    <i id="icon" class="fa rotate fa-spinner main-content__checkmark" id="checkmark"></i>
    <p id="text" class="main-content__body" data-lead-id="main-content-body">Hold on, we're verifying your email</p>
</div>
<footer class="site-footer" id="footer">
</footer>
</body>
<script src="/js/jquery-3.5.1.min.js"></script>
<script src="/js/api.js"></script>
<script src="/js/verify.js"></script>
</html>