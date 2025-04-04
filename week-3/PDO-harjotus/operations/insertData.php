<?php
global $DBH;
global $SITE_URL;
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . '/../db/dbConnect.php';

if (!empty($_POST['title']) && !empty($_POST['user_id']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $filename = $_FILES['file']['name'];
    $filesize = $_FILES['file']['size'];
    $filetype = $_FILES['file']['type'];
    $tmp_name = $_FILES['file']['tmp_name'];
    $destination = __DIR__ . '/../uploads/' . $filename;

    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_POST['user_id'];

    // vain kuvia ja videoita
    $allowed_types = array('image/jpeg', 'image/png', 'image/gif',
        'image/webp', 'video/mp4', 'video/webm', 'video/ogg', 'video/mov');
    if (!in_array($filetype, $allowed_types)) {
        exit('Invalid file type.');
    }

    if (move_uploaded_file($tmp_name, $destination)) {
        echo "File uploaded successfully";
    } else {
        echo "Error uploading file";
    }

    $sql = "INSERT INTO MediaItems (user_id, filename, filesize, media_type, title, description) VALUES (:user_id, :filename, :filesize, :media_type, :title, :description)";
    $data = [
        'user_id' => $user_id,
        'filename' => $filename,
        'filesize' => $filesize,
        'media_type' => $filetype,
        'title' => $title,
        'description' => $description
    ];
    try {
        $STH = $DBH->prepare($sql);
        $STH->execute($data);
        if ($STH->rowCount() > 0) {
            header('Location: ' . $SITE_URL);
        }
    } catch (PDOException $error) {
        echo "Could not insert data to the database.";
        file_put_contents(__DIR__ . '/../logs/PDOErrors.txt', 'insertData.php - ' . $error->getMessage(), FILE_APPEND);
    }

} else {
    exit("No file uploaded"); // tai die()
}