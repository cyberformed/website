<?phpinclude(dirname(dirname(__FILE__)) . '/header.php');include(dirname(dirname(__FILE__)) . "/objects/class_connection.php");include(dirname(dirname(__FILE__)) . '/objects/class_setting.php');$con = new cleanto_db();$conn = $con->connect();$settings = new cleanto_setting();$settings->conn = $conn;$lang = $settings->get_option("ct_language");$label_language_values = array();$language_label_arr = $settings->get_all_labelsbyid($lang);if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != "") {    $default_language_arr = $settings->get_all_labelsbyid("en");    if ($language_label_arr[1] != '') {        $label_decode_front = base64_decode($language_label_arr[1]);    } else {        $label_decode_front = base64_decode($default_language_arr[1]);    }    if ($language_label_arr[3] != '') {        $label_decode_admin = base64_decode($language_label_arr[3]);    } else {        $label_decode_admin = base64_decode($default_language_arr[3]);    }    if ($language_label_arr[4] != '') {        $label_decode_error = base64_decode($language_label_arr[4]);    } else {        $label_decode_error = base64_decode($default_language_arr[4]);    }    if ($language_label_arr[5] != '') {        $label_decode_extra = base64_decode($language_label_arr[5]);    } else {        $label_decode_extra = base64_decode($default_language_arr[5]);    }    $label_decode_front_unserial = unserialize($label_decode_front);    $label_decode_admin_unserial = unserialize($label_decode_admin);    $label_decode_error_unserial = unserialize($label_decode_error);    $label_decode_extra_unserial = unserialize($label_decode_extra);    $label_language_arr = array_merge($label_decode_front_unserial, $label_decode_admin_unserial, $label_decode_error_unserial, $label_decode_extra_unserial);    foreach ($label_language_arr as $key => $value) {        $label_language_values[$key] = urldecode($value);    }} else {    $default_language_arr = $settings->get_all_labelsbyid("en");    $label_decode_front = base64_decode($default_language_arr[1]);    $label_decode_admin = base64_decode($default_language_arr[3]);    $label_decode_error = base64_decode($default_language_arr[4]);    $label_decode_extra = base64_decode($default_language_arr[5]);    $label_decode_front_unserial = unserialize($label_decode_front);    $label_decode_admin_unserial = unserialize($label_decode_admin);    $label_decode_error_unserial = unserialize($label_decode_error);    $label_decode_extra_unserial = unserialize($label_decode_extra);    $label_language_arr = array_merge($label_decode_front_unserial, $label_decode_admin_unserial, $label_decode_error_unserial, $label_decode_extra_unserial);    foreach ($label_language_arr as $key => $value) {        $label_language_values[$key] = urldecode($value);    }}?><style>    .ct-button {        color: #ffffff !important;        background: #e9403a !important;        border: 2px solid #e9403a !important;        position: relative;        font-weight: 400;        padding: 0px 38px;        /* display: block; */    }    .ct-btn-big {        width: 285px;        border-radius: 50px !important;        line-height: 46px !important;        /* height: 50px !important; */        font-size: 21px !important;        margin: 27px auto !important;        display: block;    }    a {       text-decoration: none;    }    a:hover {        text-decoration: none;    }</style><!DOCTYPE HTML><html>    <head>        <title><?php echo $settings->get_option("ct_page_title"); ?> | Thank You For Booking</title>        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>        <meta name="viewport" content="width=device-width, initial-scale=1">        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/ct-thankyou.css" type="text/css" media="all"/>        <!-- **Google - Fonts** -->        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">     </head>    <body>        <div id="ct" class="ct-wrapper">            <div class="ct-container">                <div class="booking-tankyou">				<img style="margin-bottom: 30px;" src="<?php echo BASE_URL; ?>/images/logo.jpg"/>                    <h1 class="header1" style="line-height: 35px;">Thank you for booking with YupServe</h1>                    <h3 class="header3">Your appointment has been booked successfully.</h3>                    <p class="thankyou-text">You will be notified once we confirm this booking.</p>                    <div class="">                        <a href="<?php echo SITE_URL; ?>" class="ct-button ct-btn-big">Back to Home</a>                    </div>                </div>            </div>        </div>    </body></html>