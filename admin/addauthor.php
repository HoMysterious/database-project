<?php
if (isset($_POST['name']) && isset($_POST['lname']) && isset($_POST['username']) && isset($_POST['password'])
    && !empty($_POST['name']) && !empty($_POST['lname']) && !empty($_POST['username'])
    && !empty($_POST['password'])
) {

    $name = $db->escape($_POST['name']);
    $lname = $db->escape($_POST['lname']);
    $username = $db->escape($_POST['username']);
    $password = $db->escape($_POST['password']);

    $SQL = sprintf('INSERT INTO `authors` (`name`, `lastname`, `username`, `password`) VALUES (\'%s\', \'%s\', \'%s\', MD5(\'%s\'))',
        $name, $lname, $username, $password);

    $qu = $db->query($SQL);
    if (!$qu) {
        $error = "خطایی رخ داده است!";
        $error .= '<p style="direction: ltr">' . $db->get_error() . '</p>';
    } else
        $success = true;
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
                <div class="alert alert-success">نویسنده با موفقیت افزوده شد.</div>
            <?php } ?>
            <form role="form" method="post" id="add_user">
                <div class="form-group">
                    <label for="author_name">نام:</label>
                    <input class="form-control" type="text" name="name" id="author_name">
                </div>
                <div class="form-group">
                    <label for="author_lname">نام خانوادگی:</label>
                    <input class="form-control" type="text" name="lname" id="author_lname">
                </div>
                <div class="form-group">
                    <label for="author_username">نام کاربری:</label>
                    <input class="form-control" type="text" name="username" id="author_username">
                </div>
                <div class="form-group">
                    <label for="author_password">گذرواژه:</label>
                    <input class="form-control" type="password" name="password" id="author_password">
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