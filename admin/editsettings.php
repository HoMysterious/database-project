<?php
if (isset($_POST['blog_title']) && isset($_POST['admin_mail']) && isset($_POST['posts_per_page'])
    && isset($_POST['blog_url']) && isset($_POST['blog_desc']) && !empty($_POST['blog_title'])
    && !empty($_POST['admin_mail']) && !empty($_POST['posts_per_page']) && !empty($_POST['blog_url'])
    && !empty($_POST['blog_url']) && !empty($_POST['blog_desc'])
) {

    $blog_title = $db->escape($_POST['blog_title']);
    $admin_mail = $db->escape($_POST['admin_mail']);
    $ppp = intval($db->escape($_POST['posts_per_page']));
    $blog_url = $db->escape($_POST['blog_url']);
    $blog_desc = $db->escape($_POST['blog_desc']);

    $SQL = sprintf('UPDATE `settings` SET `blog_title` = \'%s\', `admin_email` = \'%s\', `posts_per_page` = %d, `blog_url` = \'%s\', `description` = \'%s\' WHERE `id` = 1',
                    $blog_title, $admin_mail, $ppp, $blog_url, $blog_desc);

    $qu = $db->query($SQL);
    if (!$qu) {
        $error = "خطایی رخ داده است!";
        $error .= '<p style="direction: ltr">' . $db->get_error() . '</p>';
    } else {
        $success = true;
        $db->load_settings();
    }
}
?>

<?php include "common/header.php"; ?>
<?php include "common/sidebar.php"; ?>

    <div class="col-lg-9">
        <div class="thhContainer">
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php } ?>
            <?php if (isset($success)) { ?>
                <div class="alert alert-success">تنظیمات با موفقیت بروز شد.</div>
            <?php } ?>
            <form role="form" method="post" id="add_user">
                <div class="form-group">
                    <label for="blog_title">عنوان وبلاگ:</label>
                    <input class="form-control" type="text" name="blog_title" id="blog_title"
                           value="<?php echo $_BLOG_SETTINGS->blog_title; ?>">
                </div>
                <div class="form-group">
                    <label for="admin_mail">ایمیل مدیر وبلاگ:</label>
                    <input class="form-control" type="email" name="admin_mail" id="admin_mail"
                           value="<?php echo $_BLOG_SETTINGS->admin_email; ?>">
                </div>
                <div class="form-group">
                    <label for="posts_per_page">تعداد پست‌ها در صفحه:</label>
                    <input class="form-control" type="number" name="posts_per_page" id="posts_per_page"
                           value="<?php echo $_BLOG_SETTINGS->posts_per_page; ?>">
                </div>
                <div class="form-group">
                    <label for="blog_url">آدرس وبلاگ:</label>
                    <input class="form-control" type="url" name="blog_url" id="blog_url"
                           value="<?php echo $_BLOG_SETTINGS->blog_url; ?>">
                </div>
                <div class="form-group">
                    <label for="blog_desc">شرح وبلاگ:</label>
                    <textarea rows="3" class="form-control" name="blog_desc"
                              id="blog_desc"><?php echo $_BLOG_SETTINGS->description; ?></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="ویرایش">
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
<?php include "common/footer.php"; ?>