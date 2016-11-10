<?php
    if(isset($_SESSION['logged_in'])) {
        header('Location: ' . $_BLOG_SETTINGS->blog_url . '/admin/add_post');
        exit();
    }
?>
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
<body class="login-body">

<?php
if (isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $submit = 1;
    $SQL = 'SELECT * FROM `authors` WHERE `username` = \'' . $db->escape($_POST['username'])
        . '\' AND `password` = MD5(\'' . $db->escape($_POST['password']) . '\')';

    $q = $db->query($SQL);

    if ($q->num_rows == 1) {
        $success = true;
        $ob = $q->fetch_object();
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $ob->username;
        $_SESSION['user_id'] = $ob->id;
    }
    else
        $success = false;
}
?>

<div class="container">
    <div class="login-container">
        <?php if (isset($submit)) :
            if ($success) : ?>
                <div class="alert alert-success">
                    <strong>ورود موفقیت آمیر بود!</strong> <a href="<?php url(); ?>/admin/add_post">به صفحه اول مدیریت بروید.</a>
                </div>
            <?php else : ?>
                <div class="alert alert-danger">
                    <strong>نام کاربری یا رمز عبور اشتباه است!</strong>ورودی‌های خود ر ا کنترل کرده و دوباره سعی کنید. توجه کنید نام کاربری و پسورد حساس به حروف بزرگ و کوچک هستند.
                </div>
            <?php endif; endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="username">نام کاربری:</label>
                <input class="form-control" type="text" name="username" id="username">
            </div>
            <div class="form-group">
                <label for="password">گذرواژه:</label>
                <input class="form-control" type="password" name="password" id="password">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" value="وارد شو!">
            </div>
        </form>
    </div>
</div>
</body>
</html>