<?phprequire_once 'header.php';?><style>    .ct-button {        color: #ffffff !important;        background: #e9403a !important;        border: 2px solid #e9403a !important;        position: relative;        font-weight: 400;        padding: 0px 38px;        /* display: block; */    }    .ct-btn-big {        width: 285px;        border-radius: 50px !important;        line-height: 46px !important;        /* height: 50px !important; */        font-size: 21px !important;        margin: 27px auto !important;        display: block;    }    a {       text-decoration: none;    }    a:hover {        text-decoration: none;    }</style><!DOCTYPE HTML><html>    <head>        <title>Payment Success</title>        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>        <meta name="viewport" content="width=device-width, initial-scale=1">        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/ct-thankyou.css" type="text/css" media="all"/>        <!-- **Google - Fonts** -->        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">     </head>    <body>        <div id="ct" class="ct-wrapper">            <div class="ct-container">                <div class="booking-tankyou">                    <h1 class="header1">Thank You</h1>                    <h3 class="header3">Your payment has been processed successfully.</h3>                    <div class="">                        <a href="<?php echo SITE_URL; ?>" class="ct-button ct-btn-big">Back to Home</a>                    </div>                </div>            </div>        </div>    </body></html>