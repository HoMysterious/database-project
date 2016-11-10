<?php
if (isset($_POST['name'])) {
    if (empty($_POST['name'])) {
        $error = "نام دسته نمی‌تواند خالی باشد.";
    } else {
        $cname = $db->escape($_POST['name']);
        $SQL = sprintf('INSERT INTO `categories` (`name`, `title`) VALUES (\'%s\', \'%s\')',
            preg_replace('/\s/', '_', $cname), $cname);

        $qu = $db->query($SQL);
        if (!$qu)
            $error = "نام دسته تکراری!.";
        else
            $success = true;
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
                <div class="alert alert-success">
                    دسته با موفقیت ایجاد شد.
                </div>
            <?php } ?>
            <form role="form" method="post">
                <div class="form-group">
                    <label for="category_name">نام دسته جدید:</label>
                    <input class="form-control" type="text" name="name" id="category_name">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="افزودن">
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
<?php include "common/footer.php"; ?>