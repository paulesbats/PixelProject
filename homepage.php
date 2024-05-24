<?php
    session_start();
    include ("include/config.inc.php");

    if (!isset($_SESSION['isConnected']) || $_SESSION['isConnected'] !== true) {
        header('Location: index.php');
        exit();
    }

    $email = $_SESSION['email'];
    $user_name = $_SESSION['user_name'];
    $create_success = false;

    if (isset($_POST["gridName"])){
        $gridName = QuoteStr($_POST["gridName"]);
        $sql = "INSERT INTO `Grid` (`User_ID`, `Name`) VALUES ('$_SESSION[user_id]', $gridName)";
        if (mysqli_query($link, $sql)){
            $create_success = true;
        }
    }

    if (isset($_POST['gridSelect'])){
        $gridSelect = QuoteStr($_POST['gridSelect']);
        $sql = "SELECT * FROM `Grid` WHERE `Name` = $gridSelect";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) > 0){
            $sql = "SELECT `id` FROM `Grid` WHERE `Name` = $gridSelect";
            $gridID2 = GetSQLValue($sql);
            header('Location: gridpage.php?gridID='.$gridID2);
            exit();
        } else {
            $grid_not_exist = true;
        }
    }

    if (isset($_POST['disconnect'])){
        session_destroy();
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PixelProject - Homepage</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

    <img src="img/LOGO PIXEL.png" alt="Pixel Project Logo" class="home-logo">
    <?php if ($create_success){
            echo "<div class=success-message>";
            echo "<strong>SUCCESS : </strong>Grid Creation Successful !";
            echo "</div>";
        }   
    ?>

    <?php if ($grid_not_exist){
            echo "<div class=error-message>";
            echo "<strong>ERROR : </strong>Grid Name does not exist !</div>";
            echo "</div>";
        }   
    ?>

<h2>Welcome Back <?php echo $user_name; ?>!</h2>

<div class="container">
    <form method="POST" class="log-form">
        <h2>Create a New Grid</h2>
        <input type="text" placeholder="Choose Name" name="gridName" required class="input-field">
        <input type="submit" value="Create Grid" class="button">
    </form>

    <form method="POST" class="log-form">
        <h2>Join an Existing Grid by Name</h2>
        <input type="text" placeholder="Grid Name" name="gridSelect" required class="input-field">
        <input type="submit" value="Join Grid" class="button">
    </form>

    <div class="centered-btn">
        <form method="POST">
            <input type="submit" name="disconnect" value="Disconnect" class="button-dis">
        </form>
    </div>
</div>
</body>
</html>
