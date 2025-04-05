<?php
global $DBH;
global $SITE_URL;
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . '/../db/dbConnect.php';

if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])) {


    $sql = "INSERT INTO Users (username, password, email, user_level_id) VALUES (:username, :password, :email, 2)";
    $data = [
        'username' => $_POST['username'],
        'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
        'email' => $_POST['email']
    ];
    try {
        $STH = $DBH->prepare($sql);
        $STH->execute($data);
        if ($STH->rowCount() > 0) {
            header('Location: ' . $SITE_URL . '/user.php?message=User created successfully');
            exit;
        }
    } catch (PDOException $error) {
        echo "Could not insert user to the database.";
        file_put_contents(__DIR__ . '/../logs/PDOErrors.txt', 'insertUser.php - ' . $error->getMessage(), FILE_APPEND);
    }

} else {
    exit("No user added"); // tai die()
}