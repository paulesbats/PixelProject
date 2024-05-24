<?php
    include("include/config.inc.php");

    $data = json_decode(file_get_contents('php://input'), true);

    $grid_ID = intval($data['gridID']);
    $hor_pos = intval($data['horpos']);
    $ver_pos = intval($data['verpos']);
    $color = mysqli_real_escape_string($link, $data['color']);

    $userID = $_SESSION['user_id'];

    $sql = "SELECT * FROM `Pixel` WHERE Grid_ID = $grid_ID AND Horizontal_pos = $hor_pos AND Vertical_pos = $ver_pos";
    $result = mysqli_query($link, $sql);
    $resultrow = mysqli_num_rows($result);

    if ($result && $resultrow > 0){
        $sql = "UPDATE `Pixel` SET Color = '$color', User_ID = '$userID' WHERE Grid_ID = $grid_ID AND Horizontal_pos = $hor_pos AND Vertical_pos = $ver_pos";
    } else {
        $sql = "INSERT INTO `Pixel` (`User_ID`, `Grid_ID`, `Color`, `Horizontal_pos`, `Vertical_pos`) VALUES ('$userID', '$grid_ID', '$color', '$hor_pos', '$ver_pos')";
    }
    mysqli_query($link, $sql);
?>
