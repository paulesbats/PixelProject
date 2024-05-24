<?php     
    header("refresh: 30;");
    session_start();
    include ("include/config.inc.php");

    if (isset($_POST['user_id'])){
        $user_id = $_POST['user_id'];
        $sql = "SELECT Username FROM User WHERE user_id = $user_id";
        $user_name = mysqli_query($link,$sql);
    }

    $gridID=$_GET["gridID"];
    $sql = "SELECT `Name`  FROM `Grid` WHERE `id` = '$gridID'";
    $gridName = GetSQLValue($sql);

    $sql = "SELECT `User_id`  FROM `Grid` WHERE `id` = '$gridID'";
    $gridUser_ID = mysqli_query($link,$sql);

    $sql = "SELECT * FROM `Pixel` WHERE Grid_ID = $gridID";
    $result = mysqli_query($link, $sql);
    $pixels = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $pixels[] = $row;
        }
    }
    echo "<script>const grid_ID = $gridID;</script>";
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PixelProject - Grid</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php 
    echo "<div class = grid-title>";
    echo "<strong>Grid : $gridName</strong>";
    echo "</div>";
    ?>

    <div id="palette">
        <div class="color-swatch" data-color="#000000" style="background-color: #000000;"></div>
        <div class="color-swatch" data-color="#FFFFFF" style="background-color: #FFFFFF;"></div>
        <div class="color-swatch" data-color="#FF0000" style="background-color: #FF0000;"></div>
        <div class="color-swatch" data-color="#00FF00" style="background-color: #00FF00;"></div>
        <div class="color-swatch" data-color="#0000FF" style="background-color: #0000FF;"></div>
        <div class="color-swatch" data-color="#FFFF00" style="background-color: #FFFF00;"></div>
        <div class="color-swatch" data-color="#FF00FF" style="background-color: #FF00FF;"></div>
    </div>

    <div class="grid" id="grid" data-pixels='<?php echo json_encode($pixels); ?>'></div>
    <script src="js/grid.js"></script>
    <input type="button" value="Back to Homepage" onClick="location.href='homepage.php'" class="button-back"> 
</body>
</html>
