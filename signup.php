<?php 
    include ("include/config.inc.php");
    $signin_success = false;
    $username_notuniq = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = QuoteStr($_POST['login']);
        $isuniq = "SELECT Username FROM User WHERE Username = $username";
        $uniqcond = GetSQLValue($isuniq);
        $testuniq = $_POST['login'];
        if ($uniqcond == $testuniq){
            $username_notuniq = true;
        } else{
            $email = Quotestr($_POST['email']);
            $password=QuoteStr(hash('sha256', $_POST['pwd']));
            $sql = "INSERT INTO `User` (`id`, `Username`, `Email`, `Password`) VALUES (NULL,$username,$email,$password)";
    
            if (mysqli_query($link, $sql)){
                $signin_success = true;
            }
        }

        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PixelProject - Sign Up</title>
    <link href="css/style.css" rel="stylesheet">
</head>
    <body>
        <?php
        if ($username_notuniq){
            echo "<div class=error-message>";
            echo "<strong>ERROR : </strong>Username already exist";
            echo "</div>";
        }
        if ($signin_success){
            echo "<div class=success-message>";
            echo "<strong>SUCCESS : </strong>Sign Up Successful !";
            echo "</div>";
        }   
        ?>
        <img src="img/LOGO PIXEL.png" alt="Pixel Project Logo" class="logo">
        <form method="POST" class="log-form">
            <h1>Sign Up Page</h1>
            <input type="login" name= "login" placeholder="Username" class="input-field" required>
            <input type="email" name = "email" placeholder="E-Mail" class="input-field" required>
            <input type="password" name= "pwd" placeholder="Password" class="input-field" required>
            <input type="submit" value="Sign Up" class="button">
            <input type="button" value="Back" onClick="location.href='index.php'" class="button"> 
            <p>&copy; 2024 – Paul Lesbats</p>
        </form>
    </body>
</html>