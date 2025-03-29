<?php
require_once __DIR__ . '/inc/header.php';


if ($_SERVER['REQUEST_METHOD'] ==="POST"):
    if(isset($_POST['remember']));
        setcookie('username', $_POST['username']);
    else:
        setcookie('username', '', time() - 3600);
    endif;
    header('Location: '. $_SERVER['HTTP_REFERER']);

endif


?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label>
            username
            <?php
            $value = '';
            if (isset($_COOKIE['username']));
               $value = $_COOKIE['username'];

            ?>

        </label>






        <button type="submit">Submit</button>
    </form>

<?php
require_once __DIR__ . '/inc/footer.php';
