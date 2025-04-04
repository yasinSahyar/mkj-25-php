<?php
global $DBH;
global $SITE_URL;
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . '/../db/dbConnect.php';

$sql = "SELECT MediaItems.*, Users.username FROM MediaItems JOIN Users ON Users.user_id = MediaItems.user_id;";

try {
    $STH = $DBH->query($sql);
    $STH->setFetchMode(PDO::FETCH_ASSOC);
    while ($row = $STH->fetch()):
        ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo date_format(date_create($row['created_at']), 'd.m.Y H:i'); ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><img src="<?php echo $SITE_URL; ?>/uploads/<?php echo $row['filename']; ?>"
                     alt="<?php echo $row['title']; ?>"></td>
            <td>
                <button class="modify-button" data-media_id="<?php echo $row['media_id']; ?>">Modify</button>
                <a href="<?php echo $SITE_URL; ?>/operations/deleteData.php?media_id=<?php echo $row['media_id']; ?>">Delete</a>
            </td>
        </tr>
    <?php
    endwhile;
} catch (PDOException $error) {
    echo "Could not select data from the database.";
    file_put_contents(__DIR__ . '/../logs/PDOErrors.txt', 'selectData.php - ' . $error->getMessage(), FILE_APPEND);
}