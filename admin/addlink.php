<?php
if (isset($_POST['name']) && isset($_POST['url'])) {
    if (empty($_POST['name']) && empty($_POST['url'])) {
        $error = "نام لینک یا آدرس نمی‌تواند خالی باشد.";
    } else {
        $name = $db->escape($_POST['name']);
        $url = $db->escape($_POST['url']);

        $SQL = sprintf('INSERT INTO `links` (`display_name`, `address`) VALUES (\'%s\', \'%s\')',
            $name, $url);

        $qu = $db->query($SQL);
        if (!$qu) {
            $error = "خطایی رخ داده است.";
            $error .= '<p style="direction: ltr">' . $db->get_error() . '</p>';
        } else
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
                <div class="alert alert-success">لینک جدید با موفقیت افزوده شد.</div>
            <?php } ?>
            <form role="form" method="post">
                <div class="form-group">
                    <label for="link_name">نام نمایشی لینک:</label>
                    <input class="form-control" type="text" name="name" id="link_name">
                </div>
                <div class="form-group">
                    <label for="address_id">آدرس:</label>
                    <input class="form-control" type="url" name="url" id="address_id">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="افزودن لینک!">
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
<?php include "common/footer.php"; ?>