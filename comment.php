<?php
    if(isset($_POST['name']) && isset($_POST['content']) && isset($_POST['email']) && isset($_POST['post_id']))
    {
        require_once("include/init_mysql.php");
        $db = new db();
        $db->load_settings();
        if($db->query(
            sprintf('INSERT INTO `comments` (`author`, `content`, `email`, `post_id`) VALUES (\'%s\', \'%s\', \'%s\', %s)',
                $db->escape($_POST['name']), $db->escape($_POST['content']), $db->escape($_POST['email']), $db->escape($_POST['post_id']))))
        {
            $db->query('UPDATE `posts` SET `comment_count` = `comment_count` + 1');
            echo '<h2>دیدگاه با موفقیت ثبت گردید. <a href="' . $_BLOG_SETTINGS->blog_url . '/' . $_POST['post_id'] . '">بازگشت</a></h2>';
        }
        else
        {
            echo '<h2>خطا در وارد کردن دیدگاه.</h2>';
        }
    }
    else
    {
        echo '<h2>خطا در پارامترهای ورودی دیدگاه.</h2>';
    }
?>