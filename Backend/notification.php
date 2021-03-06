<?php
session_start();
require_once "objects/class_connection.php";
require_once "objects/class_userdetails.php";
require_once "objects/class_setting.php";
require_once "objects/class_booking.php";
require_once "objects/class_general.php";
require_once "objects/class_gc_hook.php";
require_once "objects/class_front_first_step.php";
require_once "objects/class_rating_review.php";
require_once "header.php";
?>
<?php
if (!isset($_SESSION['ct_login_user_id'])) {
    header('Location:' . SITE_URL . 'login.php');
}
$con = new cleanto_db();
$conn = $con->connect();
$objuserdetails = new cleanto_userdetails();
$objuserdetails->conn = $conn;
$booking = new cleanto_booking();
$booking->conn = $conn;
$setting = new cleanto_setting();
$setting->conn = $conn;
$general = new cleanto_general();
$general->conn = $conn;
$gc_hook = new cleanto_gcHook();
$gc_hook->conn = $conn;
$first_step = new cleanto_first_step();
$first_step->conn = $conn;
$rating_review = new cleanto_rating_review();
$rating_review->conn = $conn;
$symbol_position = $setting->get_option('ct_currency_symbol_position');
$decimal = $setting->get_option('ct_price_format_decimal_places');
$getdateformat = $setting->get_option('ct_date_picker_date_format');
$time_format = $setting->get_option('ct_time_format');
$date_format = $setting->get_option('ct_date_picker_date_format');
$getmaximumbooking = $setting->get_option('ct_max_advance_booking_time');


$lang = $setting->get_option("ct_language");
$label_language_values = array();
$language_label_arr = $setting->get_all_labelsbyid($lang);

if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != "" || $language_label_arr[6] != "") {
    $default_language_arr = $setting->get_all_labelsbyid("en");
    if ($language_label_arr[1] != '') {
        $label_decode_front = base64_decode($language_label_arr[1]);
    } else {
        $label_decode_front = base64_decode($default_language_arr[1]);
    }
    if ($language_label_arr[3] != '') {
        $label_decode_admin = base64_decode($language_label_arr[3]);
    } else {
        $label_decode_admin = base64_decode($default_language_arr[3]);
    }
    if ($language_label_arr[4] != '') {
        $label_decode_error = base64_decode($language_label_arr[4]);
    } else {
        $label_decode_error = base64_decode($default_language_arr[4]);
    }
    if ($language_label_arr[5] != '') {
        $label_decode_extra = base64_decode($language_label_arr[5]);
    } else {
        $label_decode_extra = base64_decode($default_language_arr[5]);
    }
    if ($language_label_arr[6] != '') {
        $label_decode_front_form_errors = base64_decode($language_label_arr[6]);
    } else {
        $label_decode_front_form_errors = base64_decode($default_language_arr[6]);
    }

    $label_decode_front_unserial = unserialize($label_decode_front);
    $label_decode_admin_unserial = unserialize($label_decode_admin);
    $label_decode_error_unserial = unserialize($label_decode_error);
    $label_decode_extra_unserial = unserialize($label_decode_extra);
    $label_decode_front_form_errors_unserial = unserialize($label_decode_front_form_errors);

    $label_language_arr = array_merge($label_decode_front_unserial, $label_decode_admin_unserial, $label_decode_error_unserial, $label_decode_extra_unserial, $label_decode_front_form_errors_unserial);
    foreach ($label_language_arr as $key => $value) {
        $label_language_values[$key] = urldecode($value);
    }
} else {
    $default_language_arr = $setting->get_all_labelsbyid("en");

    $label_decode_front = base64_decode($default_language_arr[1]);
    $label_decode_admin = base64_decode($default_language_arr[3]);
    $label_decode_error = base64_decode($default_language_arr[4]);
    $label_decode_extra = base64_decode($default_language_arr[5]);
    $label_decode_front_form_errors = base64_decode($default_language_arr[6]);

    $label_decode_front_unserial = unserialize($label_decode_front);
    $label_decode_admin_unserial = unserialize($label_decode_admin);
    $label_decode_error_unserial = unserialize($label_decode_error);
    $label_decode_extra_unserial = unserialize($label_decode_extra);
    $label_decode_front_form_errors_unserial = unserialize($label_decode_front_form_errors);

    $label_language_arr = array_merge($label_decode_front_unserial, $label_decode_admin_unserial, $label_decode_error_unserial, $label_decode_extra_unserial, $label_decode_front_form_errors_unserial);
    foreach ($label_language_arr as $key => $value) {
        $label_language_values[$key] = urldecode($value);
    }
}
?>
<?php
$english_date_array = array(
    "January", "Jan", "February", "Feb", "March", "Mar", "April", "Apr", "May", "June", "Jun", "July", "Jul", "August", "Aug", "September", "Sep", "October", "Oct", "November", "Nov", "December", "Dec", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "su", "mo", "tu", "we", "th", "fr", "sa", "AM", "PM");
$selected_lang_label = array(
    ucfirst(strtolower($label_language_values['january'])),
    ucfirst(strtolower($label_language_values['jan'])),
    ucfirst(strtolower($label_language_values['february'])),
    ucfirst(strtolower($label_language_values['feb'])),
    ucfirst(strtolower($label_language_values['march'])),
    ucfirst(strtolower($label_language_values['mar'])),
    ucfirst(strtolower($label_language_values['april'])),
    ucfirst(strtolower($label_language_values['apr'])),
    ucfirst(strtolower($label_language_values['may'])),
    ucfirst(strtolower($label_language_values['june'])),
    ucfirst(strtolower($label_language_values['jun'])),
    ucfirst(strtolower($label_language_values['july'])),
    ucfirst(strtolower($label_language_values['jul'])),
    ucfirst(strtolower($label_language_values['august'])),
    ucfirst(strtolower($label_language_values['aug'])),
    ucfirst(strtolower($label_language_values['september'])),
    ucfirst(strtolower($label_language_values['sep'])),
    ucfirst(strtolower($label_language_values['october'])),
    ucfirst(strtolower($label_language_values['oct'])),
    ucfirst(strtolower($label_language_values['november'])),
    ucfirst(strtolower($label_language_values['nov'])),
    ucfirst(strtolower($label_language_values['december'])),
    ucfirst(strtolower($label_language_values['dec'])),
    ucfirst(strtolower($label_language_values['sun'])),
    ucfirst(strtolower($label_language_values['mon'])),
    ucfirst(strtolower($label_language_values['tue'])),
    ucfirst(strtolower($label_language_values['wed'])),
    ucfirst(strtolower($label_language_values['thu'])),
    ucfirst(strtolower($label_language_values['fri'])),
    ucfirst(strtolower($label_language_values['sat'])),
    ucfirst(strtolower($label_language_values['su'])),
    ucfirst(strtolower($label_language_values['mo'])),
    ucfirst(strtolower($label_language_values['tu'])),
    ucfirst(strtolower($label_language_values['we'])),
    ucfirst(strtolower($label_language_values['th'])),
    ucfirst(strtolower($label_language_values['fr'])),
    ucfirst(strtolower($label_language_values['sa'])),
    strtoupper($label_language_values['am']),
    strtoupper($label_language_values['pm']));
?>
<!Doctype html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" type="image/png" href="<?php echo BASE_URL; ?>/assets/images/backgrounds/<?php echo $setting->get_option('ct_favicon_image'); ?>"/>
    <title><?php echo $setting->get_option("ct_page_title"); ?></title>
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!-- Manual Booking CSS Files Start -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/ct-main.css" type="text/css" media="all" />
    <link href="https://fonts.googleapis.com/css?family=Julius+Sans+One" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/ct-common.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tooltipster.bundle.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tooltipster-sideTip-shadow.min.css" type="text/css" media="all" />
    <?php if (in_array($lang, array('ary', 'ar', 'azb', 'fa_IR', 'haz'))) { ?>	
        <!-- Front RTL style -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/cta-front-rtl.css" type="text/css" media="all" />
    <?php } ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/jquery_editor/jquery-te-1.4.0.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/ct-responsive.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/ct-manual-booking.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/ct-reset.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/jquery-ui.theme.min.css" type="text/css" media="all" />
    <style>
        .error {
            color: red;
        }
    </style>
    <style>#ct .not-scroll-custom{ margin-top: 0 !important; }</style>
    <!-- Manual Booking CSS Files End -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/cta-reset.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/cta-admin-style.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/cta-admin-common.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/cta-admin-responsive.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap/bootstrap.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/daterangepicker.css" type="text/css" media="all">
    <?php if (in_array($lang, array('ary', 'ar', 'azb', 'fa_IR', 'haz'))) { ?>	
        <!-- admin rtl css -->
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap/bootstrap-rtl.min.css" type="text/css" media="all">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/cta-admin-rtl.css" type="text/css" media="all">
    <?php } ?>

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/fullcalendar.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/jquery.Jcrop.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/intlTelInput.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap/bootstrap-theme.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap-toggle.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap-select.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/jquery.minicolors.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/jquery.dataTables.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/responsive.dataTables.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/dataTables.bootstrap.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/buttons.dataTables.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/jquery-ui.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/star_rating.min.css" type="text/css" media="all">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/font-awesome/css/font-awesome.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/line-icons/simple-line-icons.css" type="text/css" media="all">
    <!-- ** Google Fonts **  -->
    <link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

    <!-- ** Jquery ** -->
    <script src="<?php echo BASE_URL; ?>/assets/js/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap-multiselect.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/jquery-ui.min.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/moment.min.js" type="text/javascript" ></script>   
    <script src="<?php echo BASE_URL; ?>/assets/js/jquery.Jcrop.min.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/jquery.color.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/fullcalendar.min.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/lang-all.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/intlTelInput.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/jquery.nicescroll.min.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/vue.min.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap-select.min.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/daterangepicker.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/Chart.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/jquery.minicolors.min.js" type="text/javascript" ></script>
    <!-- data tables all js inlcude pdf,csv, and excel -->
    <script src="<?php echo BASE_URL; ?>/assets/js/datatable/jquery.dataTables.min.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/datatable/dataTables.responsive.min.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/datatable/dataTables.bootstrap.min.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/datatable/dataTables.buttons.min.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/datatable/jszip.min.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/datatable/pdfmake.min.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/datatable/vfs_fonts.js" type="text/javascript" ></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/datatable/buttons.html5.min.js" type="text/javascript" ></script>

<!--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo BASE_URL; ?>/assets/js/star_rating_min.js" type="text/javascript"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/jquery.validate.min.js"></script>
<!--    <script src="<?php echo BASE_URL; ?>/assets/js/ct-common-admin-jquery.js" type="text/javascript"></script>-->
    <!-- Global site tag (gtag.js) - Google Analytics --> 
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XVTEKTYP43"></script> <script> window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-XVTEKTYP43');
    </script> 
    <?php
    echo "<style>
	
	#cta #cta-main-navigation .navbar-inverse{
		background:" . $setting->get_option('ct_primary_color_admin') . " !important;
	}
	#cta #cta-main-navigation .navbar .nav.cta-nav-tab > .active > a,
	#cta #cta-main-navigation .navbar .nav.user-nav-bar > .active > a,
	#cta #cta-top-nav .navbar .nav > .active > a:focus{
		background-color: " . $setting->get_option('ct_secondary_color_admin') . " ;
		color: " . $setting->get_option('ct_text_color_admin') . "  ;
	}
	#cta #cta-main-navigation .navbar .nav.cta-nav-tab > li > a:hover,
	#cta #cta-main-navigation .navbar .nav.user-nav-bar > li > a:hover {
		background-color: " . $setting->get_option('ct_secondary_color_admin') . " ;
		color: " . $setting->get_option('ct_text_color_admin') . "  ;
	}
	#cta #cta-main-navigation .navbar .nav.cta-nav-tab > li > a,
	#cta #cta-main-navigation .navbar .nav.user-nav-bar > li > a{
		color: " . $setting->get_option('ct_text_color_admin') . "  ;
	}
	#cta .noti_color{
		color: " . $setting->get_option('ct_text_color_admin') . "  ;
	}
	#cta a#ct-notifications i.icon-bell.cta-new-booking{
		color: " . $setting->get_option('ct_secondary_color_admin') . " !important ;
	}
	
	#cta a.ct-tooltip-link{
		color: " . $setting->get_option('ct_primary_color_admin') . " !important ;
	}
	.navbar-inverse .navbar-nav>.open>a, .navbar-inverse .navbar-nav>.open>a:focus,
	.navbar-inverse .navbar-nav>.open>a:hover{
		background-color: " . $setting->get_option('ct_secondary_color_admin') . " !important  ;
	}
	#cta #cta-staff-panel .ct-staff-right-details .member-offdays .ct-custom-checkbox  ul.ct-checkbox-list label span,
	#cta .ct-custom-radio ul.ct-radio-list label span{
		border-color: " . $setting->get_option('ct_primary_color_admin') . " !important;
	}
	#cta #cta-staff-panel .ct-staff-right-details .member-offdays .ct-custom-checkbox  	ul.ct-checkbox-list input[type='checkbox']:checked + label span{
		border-color: " . $setting->get_option('ct_secondary_color_admin') . " !important;
		background-color: " . $setting->get_option('ct_secondary_color_admin') . " !important;
	}
	#cta .ct-custom-radio ul.ct-radio-list input[type='radio']:checked + label span{
		border-color: " . $setting->get_option('ct_secondary_color_admin') . " !important;
	}
	#cta .fc-toolbar {
		background-color: " . $setting->get_option('ct_primary_color_admin') . " !important;
	}
	#cta .ct-notification-main .notification-header{
		color: " . $setting->get_option('ct_text_color_admin') . " !important;
		background-color: " . $setting->get_option('ct_secondary_color_admin') . " !important;
	}
	
	#cta .fc-toolbar {
		border-top: 1px solid " . $setting->get_option('ct_primary_color_admin') . " !important;
		border-left: 1px solid " . $setting->get_option('ct_primary_color_admin') . " !important;
		border-right: 1px solid " . $setting->get_option('ct_primary_color_admin') . " !important;
	}
	#cta .fc button,
	#cta .ct-notification-main .notification-header #ct-close-notifications{
		color: " . $setting->get_option('ct_text_color_admin') . " !important ;
	}
	#cta .ct-notification-main .notification-header #ct-close-notifications:hover{
		background-color: " . $setting->get_option('ct_primary_color_admin') . " !important;
	}
	#cta .fc button:hover{
		color: " . $setting->get_option('ct_secondary_color_admin') . " !important ;
	}
	
	
	/* iPads (portrait and landscape) ----------- */
	@media only screen and (min-width : 768px) and (max-width : 1024px) {
		#cta #cta-main-navigation .navbar-header,
		#cta #cta-main-navigation .navbar .nav.cta-nav-tab > li > a:hover,
		#cta #cta-main-navigation .navbar .nav.user-nav-bar > li > a:hover {
			color: " . $setting->get_option('ct_secondary_color_admin') . "  ;
		}
		
	}
	/* iPads (landscape) ----------- */
	@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : landscape) {
		#cta #cta-main-navigation .navbar .nav.cta-nav-tab > li > a:hover,
		#cta #cta-main-navigation .navbar .nav.user-nav-bar > li > a:hover {
			background-color: " . $setting->get_option('ct_secondary_color_admin') . " ;
			color: " . $setting->get_option('ct_text_color_admin') . "  ;
		}
	
	}
	/* iPads (portrait) ----------- */
	@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : portrait) {
		#cta #cta-top-nav .navbar-header,
		#cta #cta-main-navigation .navbar-header,
		#cta #cta-main-navigation .navbar .nav.cta-nav-tab > .active > a,
		#cta #cta-main-navigation .navbar .nav.user-nav-bar > .active > a,
		#cta #cta-top-nav .navbar .nav > .active > a:focus,
		#cta #cta-top-nav .navbar-nav > li > a:hover,
		#cta #cta-main-navigation .navbar .nav.cta-nav-tab > li > a:hover,
		#cta #cta-main-navigation .navbar .nav.user-nav-bar > li > a:hover {
			color: " . $setting->get_option('ct_secondary_color_admin') . "  ;
		}
		#cta #cta-main-navigation .navbar .nav.cta-nav-tab > .active > a,
		#cta #cta-main-navigation .navbar .nav.user-nav-bar > .active > a,
		#cta #cta-top-nav .navbar .nav > .active > a:focus{
			background: unset !important;
		}
	}	
	/********** iPad 3 **********/
	@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : landscape) and (-webkit-min-device-pixel-ratio : 2) {
		#cta #cta-main-navigation .navbar .nav.cta-nav-tab > li > a:hover,
		#cta #cta-main-navigation .navbar .nav.user-nav-bar > li > a:hover {
			background-color: " . $setting->get_option('ct_secondary_color_admin') . " ;
			color: " . $setting->get_option('ct_text_color_admin') . "  ;
		}
	}
	@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : portrait) and (-webkit-min-device-pixel-ratio : 2) {	
		#cta #cta-top-nav .navbar-header,
		#cta #cta-main-navigation .navbar-header,
		#cta #cta-main-navigation .navbar .nav.cta-nav-tab > .active > a,
		#cta #cta-main-navigation .navbar .nav.user-nav-bar > .active > a,
		#cta #cta-top-nav .navbar .nav > .active > a:focus,
		#cta #cta-top-nav .navbar-nav > li > a:hover,
		#cta #cta-main-navigation .navbar .nav.cta-nav-tab > li > a:hover,
		#cta #cta-main-navigation .navbar .nav.user-nav-bar > li > a:hover {
			color: " . $setting->get_option('ct_secondary_color_admin') . "  ;
		}
		#cta #cta-main-navigation .navbar .nav.cta-nav-tab > .active > a,
		#cta #cta-main-navigation .navbar .nav.user-nav-bar > .active > a,
		#cta #cta-top-nav .navbar .nav > .active > a:focus{
			background: unset !important;
		}
	}
	/* Smartphones (landscape) ----------- */
	@media only screen and (max-width: 767px) {
		#cta #cta-top-nav .navbar-header,
		#cta #cta-main-navigation .navbar-header,
		#cta #cta-main-navigation .navbar .nav.cta-nav-tab > .active > a,
		#cta #cta-main-navigation .navbar .nav.user-nav-bar > .active > a,
		#cta #cta-top-nav .navbar .nav > .active > a:focus,
		#cta #cta-top-nav .navbar-nav > li > a:hover,
		#cta #cta-main-navigation .navbar .nav.cta-nav-tab > li > a:hover,
		#cta #cta-main-navigation .navbar .nav.user-nav-bar > li > a:hover {
			color: " . $setting->get_option('ct_secondary_color_admin') . "  ;
		}
		#cta #cta-main-navigation .navbar .nav.cta-nav-tab > .active > a,
		#cta #cta-main-navigation .navbar .nav.user-nav-bar > .active > a,
		#cta #cta-top-nav .navbar .nav > .active > a:focus{
			background: unset !important;
		}
		
	}	
	/* Smartphones (portrait and landscape) ----------- */
	@media only screen and (min-width : 320px) and (max-width : 480px) {
		
		#cta #cta-top-nav .navbar-header,
		#cta #cta-main-navigation .navbar-header,
		#cta #cta-main-navigation .navbar .nav.cta-nav-tab > .active > a,
		#cta #cta-main-navigation .navbar .nav.user-nav-bar > .active > a,
		#cta #cta-top-nav .navbar .nav > .active > a:focus,
		#cta #cta-top-nav .navbar-nav > li > a:hover,
		#cta #cta-main-navigation .navbar .nav.cta-nav-tab > li > a:hover,
		#cta #cta-main-navigation .navbar .nav.user-nav-bar > li > a:hover {
			color: " . $setting->get_option('ct_secondary_color_admin') . "  ;
		}
		#cta #cta-main-navigation .navbar .nav.cta-nav-tab > .active > a,
		#cta #cta-main-navigation .navbar .nav.user-nav-bar > .active > a,
		#cta #cta-top-nav .navbar .nav > .active > a:focus{
			background: unset !important;
		}
	}
</style>
";
    ?>
    <style>
        .clicked {
            background: #fdfafa !important;
        }
    </style>
</head>
<body>
    <div id="rtl-width-setter-enable" style="display:none;"><?php echo $label_language_values['enable']; ?></div>
    <div id="rtl-width-setter-disable" style="display:none;"><?php echo $label_language_values['disable']; ?></div>
    <div id="rtl-width-setter-on" style="display:none;"><?php echo $label_language_values['o_n']; ?></div>
    <div id="rtl-width-setter-off" style="display:none;"><?php echo $label_language_values['off']; ?></div> 
    <div class="ct-wrapper"  id="cta"> <!-- main wrapper -->
        <!-- loader -->
        <?php if ($setting->get_option("ct_loader") == 'css' && $setting->get_option("ct_custom_css_loader") != '') { ?>
            <div class="ct-loading-main" align="center">
                <?php echo $setting->get_option("ct_custom_css_loader"); ?>
            </div>
        <?php } elseif ($setting->get_option("ct_loader") == 'gif' && $setting->get_option("ct_custom_gif_loader") != '') { ?>
            <div class="ct-loading-main" align="center">
                <img style="margin-top:18%;" src="<?php echo BASE_URL; ?>/assets/images/gif-loader/<?php echo $setting->get_option("ct_custom_gif_loader"); ?>"></img>
            </div>
        <?php } else { ?>
            <div class="ct-loading-main">
                <div class="loader">Loading...</div>
            </div>
        <?php } ?>	
        <header class="ct-header new-ct">
            <!--  USER MENUS  -->
            <div id="cta-main-navigation" class="navbar-inner">

                <nav role="navigation" class="navbar navbar-inverse navbar-fixed-top" style="background-color: #ffffff !important; background-image: none !important;">
                    <div class="container">
                        <div class="navbar-header" style="width: 100%;">
                            <!--                            <button type="button" data-target="#navbarCollapsetop" data-toggle="collapse" class="navbar-toggle">
                                                            <span class="sr-only">Toggle navigation</span>
                                                            <i class="fa fa-cog"></i>
                                                        </button>-->
                            <a href="<?php echo SITE_URL; ?>" class="navbar-brand res-nav" style="display: block !important"><img class="admin-logo " src="<?php echo SITE_URL; ?>images/yupserve-logo.jpg"/></a> 

                            <!--                                <ul class="nav navbar-nav">
                                                                <li><a  href="<?php echo BASE_URL; ?>/admin/cleanto-welcome.php"><span><?php echo $label_language_values['whats_new']; ?></span></a></li>
                            <?php
                            /*                             * * auto updater code  ** */
                            $version_updated_checker = $setting->get_contents('http://skymoonlabs.com/cleanto/versioncheck.php?' . time());
                            if ($version_updated_checker > $setting->get_option("ct_version")) {
                                ?>
                                                                                                                                                            <li><a href="#ct-update-version-modal" class="pulse-update" title="Cleanto Update Available"  data-toggle="modal"><i class="fa fa-download"></i></a></li>
                            <?php } /*                             * * auto updater code  ** */ ?>
                                                                <li><a href="#ct-buy-support-modal" class="pulse-update" title="Cleanto Support" data-toggle="modal"><i class="fa fa-ticket"></i> Support</a></li>
                                                                <li><a href="<?php echo BASE_URL; ?>/admin/extensions.php" class="pulse-update" title="Cleanto Extensions" data-toggle="modal"><i class="fa fa-puzzle-piece"></i> Extensions</a></li>
                                                            </ul>-->
                            <ul class="nav navbar-nav navbar-right user-header-top" style="margin-right:0px;">
                                <li>
                                    <a id="" data-id="user" href="<?php echo SITE_URL; ?>notification.php">
                                        <?php
                                        $sql_cstm_notif = "SELECT COUNT(*) AS total FROM ct_user_notification WHERE user_id='{$_SESSION['ct_login_user_id']}' AND is_read=0";
                                        $notif_res = mysqli_query($conn, $sql_cstm_notif);
                                        $row_cstm_notif = mysqli_fetch_object($notif_res);
                                        ?><i class="icon-bell <?php if ($row_cstm_notif->total != 0) { ?> cta-new-booking <?php } ?>"></i>
                                        <?php if ($row_cstm_notif->total != 0) { ?>
                                            <span class="total_notification noti_color" id="ct-notification-top">
                                                <?php echo $row_cstm_notif->total; ?>
                                            </span>
                                        <?php } else { ?>
                                            <span class="total_notification noti_color" id="ct-notification-top"></span>
                                        <?php } ?>
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="user-name">
                                        <img alt="" src="<?php echo SITE_URL; ?>assets/images/avatar1_small.jpg">
                                        <?php
                                        $userQuery = "SELECT * FROM ct_users WHERE id='{$_SESSION['ct_login_user_id']}'";
                                        $exeQuery = mysqli_query($conn, $userQuery);
                                        $valueUser = mysqli_fetch_object($exeQuery);
                                        ?>
                                        <span class="username"><?php echo $valueUser->first_name; ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>


                <nav role="navigation" class="navbar navbar-inverse navbar-fixed-top"  style="top:65px;">
                    <div class="container">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" data-target="#navbarCollapseMain" data-toggle="collapse" class="navbar-toggle">
                                <span class="sr-only">Toggle navigation</span>
                                <i class="fa fa-bars"></i>
                            </button>
                            <!--                            <a href="javascript:void()" class="navbar-brand res-nav" style="display: block !important">Menu</a> -->
                        </div>
                        <!-- Collection of nav links and other content for toggling -->
                        <div id="navbarCollapseMain" class="collapse navbar-collapse">
                            <ul class="nav navbar-nav user-nav-bar" style="float: right">
                                <li class="<?php
                                if (strpos($_SERVER['SCRIPT_NAME'], 'my-appointments.php') != false) {
                                    echo 'active';
                                }
                                ?>"><a href="<?php echo BASE_URL; ?>/my-appointments.php"><i class="fa fa-calendar"></i><span><?php echo $label_language_values['my_appointments']; ?></span></a></li>
                                <li class="<?php
                                if (strpos($_SERVER['SCRIPT_NAME'], 'user-profile.php') != false) {
                                    echo 'active';
                                }
                                ?>"><a href="<?php echo BASE_URL; ?>/user-profile.php"><i class="fa fa-user-o"></i><span><?php echo $label_language_values['profile']; ?></span></a></li>
                                    <?php
//                                    $sql_cstm_notif = "SELECT COUNT(*) AS total FROM ct_user_notification WHERE user_id='{$_SESSION['ct_login_user_id']}' AND is_read=0";
//                                    $notif_res = mysqli_query($conn, $sql_cstm_notif);
//                                    $row_cstm_notif = mysqli_fetch_object($notif_res);
//                                    
                                    ?>
                                <!--<li><a id="" data-id="user" href="//<?php //echo SITE_URL;    ?>notification.php"><i class="fa fa-bell-o"><span style="position:absolute;top:-3px;right:-12px;background:red;border-radius:50%;width:20px;height:20px;font-size:12px;padding-top:4px;font-weight:bold;"><?php //echo $row_cstm_notif->total;    ?></span></i><span>Notification</span></a></li>-->
                                <li><a id="logout" data-id="user" href="<?php echo SITE_URL; ?>logout.php"><i class="fa fa-power-off"></i><span><?php echo $label_language_values['logout']; ?></span></a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div><!-- top bar end here -->
            <div id="booking-details-dashboard" class="modal fade booking-details-index-dashboard" tabindex="-1" role="dialog" aria-hidden="true">
            </div>
        </header>

        <div id="cta-user-appointments">
            <div class="panel-body">
                <div class="tab-content">
                    <h4 class="header4">Notifications</h4>
                    <form>
                        <div class="table-responsive">
                            <table id="user-profile-booking-table" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <!-- <th>#</th> -->
                                        <th>Notification</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $k = 1;
                                    if (isset($_SESSION['ct_login_user_id'])) {
                                        $id = $_SESSION['ct_login_user_id'];
                                        $sql = "SELECT * FROM ct_user_notification WHERE user_id='{$id}'";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($dd = mysqli_fetch_array($result)) {
                                                if($dd['is_read'] == 0){
                                                    $style = "style = 'background-color: #f5f5f5 !important;'";
                                                }else{
                                                   $style = ""; 
                                                }
                                                ?>
                                                <!--  class="<?php echo ($dd['is_read'] == 1) ? "clicked" : ""; ?>" -->
                                                <tr <?php echo $style; ?>>
                                                    <!-- <td><?php echo $k++; ?></td> -->
                                                    <td><?php echo $dd['text']; ?></td>
                                                    <td>
                                                        <input type="hidden" name="order_id" id="order_id" class="order_id" value="<?php echo $dd['order_id']; ?>" />
                                                        <a href="javascript:void(0);" id="<?php echo $dd['id']; ?>" class="ct_notification btn btn-info"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                </div>
                </form>
            </div>
        </div>
        <a href="javascript:void(0)" class="cta-back-to-top" title="Back to Top"><i class="icon-arrow-up-circle icons txt-info"></i></a>
    </div><!-- main wrapper end -->
</body>
<script>
    $(document).ready(function () {
        $('#user-profile-booking-table').DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            /*'ordering': true,*/
            /*'order': [[0, "desc"]],*/
            /*'columnDefs': [{
                    "targets": -1,
                    "orderable": false
                }]*/
        });
        $('.dataTables_length').addClass('bs-select');

        $('.ct_notification').on('click', function () {
            var id = $(this).attr('id');
            var order_id = $(this).siblings('.order_id').val();
            //alert(order_id);
            var site_url = '<?php echo SITE_URL; ?>';
            var dataString = {id: id, action: "click_notification"};
            $.ajax({
                type: "POST",
                url: site_url + "process.php",
                data: dataString,
                success: function (response) {
                    var data = $.parseJSON(response);
                    window.location.href = site_url + "view/" + order_id;
                    /*if (data['success']) {
                        window.location.href = site_url + "view/" + order_id;
                    }*/
                }
            });
        });
    });
</script>
</html>