<?php
if (isset($_POST['submitted'])) {
    if (empty($_POST['title'])) {
        $error[] = "عنوان نوشته نمیتواند خالی باشد.";
    }
    if (empty($_POST['content'])) {
        $error[] = "متن نوشته نمی‌تواند خالی باشد.";
    }

    if (!isset($error)) {
        $SQL = sprintf('INSERT INTO `posts` (`active`, `title`, `content`, `comment_count`, `user_id`) VALUES (1, \'%s\', \'%s\', \'0\', %s)',
            $db->escape($_POST['title']), $db->escape($_POST['content']), $db->escape($_POST['author']));

        $qu = $db->query($SQL);

        if ($qu) {
            $id = $db->insert_id();

            echo '<pre>';
            var_dump($_POST['tag']);
            echo '</pre>';

            if (isset($_POST['category'])) {
                foreach ($_POST['category'] as $cat) {
                    $SQL = sprintf('INSERT INTO `category_relationship` (`post_id`, `category_id`) VALUES (%d, %s)',
                        $id, $cat);
                    $db->query($SQL);
                }
            }

            if (isset($_POST['tag'])) {
                foreach ($_POST['tag'] as $tag) {
                    $SQL = sprintf('INSERT INTO `tag_relationship` (`post_id`, `tag_id`) VALUES (%d, %s)',
                        $id, $tag);
                    $db->query($SQL);
                }
            }
        } else {
            $error[] = 'خطایی در وارد کردن اطلاعات به پایگاه داده رخ داده! بار دیگر سعی کنید.';
        }
    }
}
?>

<?php include "common/header.php"; ?>
    <!-- TinyMCE -->
    <script src="<?php url(); ?>/admin/tinymce.min.js"></script>
    <script>
        tinymce.init({
            'selector': 'textarea',
            'plugins': 'directionality emoticons',
            'toolbar': 'rtl ltr emoticons',
            'fontsize_formats': '14pt 18pt 24pt 36pt',
            'content_css': '<?php url(); ?>/assets/style/style.css',
            'relative_urls': false
        });
    </script>
<?php include "common/sidebar.php"; ?>

    <div class="col-lg-9">
        <?php if (isset($error)) { ?>
            <div class="alert alert-danger">
                <?php foreach ($error as $err) { ?>
                    <p><?php echo $err; ?></p>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if (isset($id)) { ?>
            <div class="alert alert-success">
                نوشته با موفقیت پست شد. <a href="<?php url();
                echo '/' . $id; ?>">ببینید!</a>
            </div>
        <?php } ?>
        <form role="form" method="post">
            <div class="form-group">
                <input name="title" type="text" class="form-control" placeholder="عنوان نوشته">
            </div>
            <div class="form-group">
                <textarea name="content" class="form-control"></textarea>
            </div>
            <div class="scndrow">
                <div class="col-lg-1">
                    <input type="submit" id="submit" class="btn btn-primary" value="انتشار!">
                </div>
                <div class="col-lg-3 col-lg-offset-5 separator">
                    <h3>دسته‌ها</h3>
                    <?php $db->load_categories();
                    $category = $db->next_category();
                    if (!$category) : echo '<h4>هیچ دسته‌ای وجود ندارد</h4>';
                    else :
                    echo '<div class="list-group">';
                    do { ?>
                        <div class="checkbox">
                            <label><input type="checkbox"
                                          id="<?php echo 'category-' . $category->name ?>"
                                          name="category[]"
                                          value="<?php echo $category->id; ?>"><?php echo $category->title; ?></label>
                        </div>
                    <?php } while ($category = $db->next_category()); ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-3 separator">
                <h3>برچسب‌ها</h3>
                <?php $db->load_tags();
                $tag = $db->next_tag();
                if (!$tag) : echo '<h4>هیچ برچسبی وجود ندارد</h4>';
                else :
                echo '<div class="list-group">';
                do { ?>
                    <div class="checkbox">
                        <label><input type="checkbox"
                                      id="<?php echo 'tag-' . $tag->name ?>"
                                      name="tag[]"
                                      value="<?php echo $tag->id; ?>"><?php echo $tag->title; ?></label>
                    </div>
                <?php } while ($tag = $db->next_tag()); ?>
            </div>
            <?php endif; ?>
            <input type="hidden" name="author" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="hidden" name="submitted" value="1">
    </div>
    </div>
    </form>
    </div>
    </div>
    </div>

<?php include "common/footer.php"; ?>