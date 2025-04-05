<?php
global $SITE_URL;
require_once __DIR__ . "/../config/config.php";
?>
<section id="register-form">
    <h2>Register</h2>
    <!--suppress HtmlUnknownTarget -->
    <form action="<?php echo $SITE_URL; ?>/operations/insertUser.php" method="POST">
        <div class="form-control">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username"/>
        </div>
        <div class="form-control">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password"/>
        </div>
        <div class="form-control">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email"/>
        </div>
        <button type="submit">Register</button>
    </form>
</section>