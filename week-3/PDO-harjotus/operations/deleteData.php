<?php
global $DBH;
global $SITE_URL;
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . '/../db/dbConnect.php';

if (!empty($_GET['media_id'])) {
    $media_id = $_GET['media_id'];
    $user_id = 1; // Gerçek uygulamada session'dan alınmalı

    try {
        // Önce dosyayı bul
        $sql = "SELECT filename FROM MediaItems WHERE media_id = :media_id AND user_id = :user_id";
        $STH = $DBH->prepare($sql);
        $STH->execute([':media_id' => $media_id, ':user_id' => $user_id]);
        $file = $STH->fetch(PDO::FETCH_ASSOC);

        if ($file) {
            // Dosyayı sil
            $file_path = __DIR__ . '/../uploads/' . $file['filename'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            // Veritabanından sil
            $sql = "DELETE FROM MediaItems WHERE media_id = :media_id AND user_id = :user_id";
            $STH = $DBH->prepare($sql);
            $STH->execute([':media_id' => $media_id, ':user_id' => $user_id]);

            header('Location: ' . $SITE_URL);
            exit();
        }
    } catch (PDOException $e) {
        echo "Could not delete data from the database.";
        file_put_contents(__DIR__ . '/../logs/PDOErrors.txt', 'deleteData.php - ' . $e->getMessage(), FILE_APPEND);
    }
} else {
    header('Location: ' . $SITE_URL);
    exit();
}