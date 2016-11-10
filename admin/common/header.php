<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $PARAMETERS['title']; ?></title>

    <!-- Bootstrap and theme -->
    <link href="<?php url(); ?>/assets/style/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap rtl theme -->
    <link href="<?php url(); ?>/assets/style/bootstrap-rtl.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php url(); ?>/assets/script/html5shiv.min.js"></script>
    <script src="<?php url(); ?>/assets/script/respond.min.js"></script>
    <![endif]-->

    <link rel="icon" href="favicon.png" type="image/png">

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="<?php url(); ?>/assets/style/style.css">
    <link rel="stylesheet" href="<?php url(); ?>/admin/admin.css">
</head>
<body>

<div class="wrapper">
    <div class="container">
        <div class="title col-lg-12 clearfix"><h2>مدیریت وبلاگ</h2><a class="home-btn btn btn-default btn-xs" href="<?php url(); ?>"><?php echo $_BLOG_SETTINGS->blog_title; ?></a><small><a class="logout-btn btn btn-default" href="<?php url(); ?>/admin/logout">خروج</a></small></div>