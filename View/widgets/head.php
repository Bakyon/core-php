<?php
defined('BASE_URL') OR exit('Access denied !!!');
?>
<!-- basic -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- mobile metas -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<!-- site metas -->
<title> User management </title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">
<!-- bootstrap css -->
<link rel="stylesheet" type="text/css" href="src/css/bootstrap.min.css">
<!-- style css -->
<link rel="stylesheet" type="text/css" href="src/css/style.css">
<!-- Responsive-->
<link rel="stylesheet" href="src/css/responsive.css">
<!-- fevicon -->
<link rel="icon" href="src/templates/picked/images/fevicon.png" type="image/gif" />
<!-- Scrollbar Custom CSS -->
<link rel="stylesheet" href="src/css/jquery.mCustomScrollbar.min.css">
<!-- Tweaks for older IEs-->
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
<!-- owl stylesheets -->
<link rel="stylesheet" href="src/css/owl.carousel.min.css">
<!--<link rel="stylesheet" href="src/css/owl.theme.default.min.css">-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">

<style>
    /* The container <div> - needed to position the dropdown content */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #252525;
        min-width: 160px;
        z-index: 1;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {background: #818182;}

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {display: block;}

    a.nav-link {
        min-height: 50px;
    }
    .fixed-table {
        overflow-x: auto;
        width: 1300px;
        min-width: 1300px;
        table-layout: fixed;
        margin: 0;
    }
    th.user-table, td.user-table{
        text-align: center;
        justify-content: center;
    }
    th.user-table:first-child, td.user-table:first-child {
        width: 100px;

    }
    th.user-table:nth-child(2), td.user-table:nth-child(2) {
        width: 200px;
        word-wrap: break-word;
    }

    th.user-table:nth-child(3), td.user-table:nth-child(3) {
        width: 100px;
        word-wrap: break-word;
    }

    th.user-table:nth-child(4), td.user-table:nth-child(4) {
        width: 200px;
    }

    th.user-table:nth-child(5), td.user-table:nth-child(5) {
        width: 80px;
        word-wrap: break-word;
    }
    th.user-table:nth-child(6), td.user-table:nth-child(6) {
        width: 70px;
    }
    th.user-table:nth-child(7), td.user-table:nth-child(7) {
        width: 180px;
    }
    th.user-table:nth-child(8), td.user-table:nth-child(8) {
        width: 200px;
        padding: 5px 10px 5px 10px;
        justify-items: center;
    }
    .profile-container {
        padding: 20px 100px 20px 100px;
    }
    .comment, .email-bt {
        margin: 0;
        padding: 0 0 0 20px;
    }
    .prod-name {
        margin: 10px 0 10px 0;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 70px;
        max-height: 70px;
    }
</style>