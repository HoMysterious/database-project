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
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php url(); ?>"><i class="glyphicon glyphicon-cloud"></i><span class="header-title">پروژه اصول طراحی پایگاه داده</span></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li<?php echo $PARAMETERS['slug'] == 'home' ? ' class="active"' : ''?>><a href="<?php url(); ?>">خانه</a></li>
                <?php while ($category = $db->next_category()) : ?>
                <li<?php echo $PARAMETERS['slug'] == $category->name ? ' class="active"' : ''?>><a href="<?php echo url(); echo '/category/' . $category->name; ?>"><?php echo $category->title; ?></a></li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</nav>
