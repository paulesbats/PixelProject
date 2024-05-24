<?php
    session_start();
    include("include/config.inc.php");

    $data = json_decode(file_get_contents('php://input'), true);
    $userID = $data['userID'];

    $sql = "SELECT `Username` FROM `User` WHERE `id` = $userID";
    $username = GetSQLValue($sql);
    echo "$username";
?>