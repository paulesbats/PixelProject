<?php
    session_start();
    include ("include/config.inc.php");
    $WrongAuth = false;
    
    if (isset($_POST["email"])){
        $sql="select Password from `User` where Email = ".QuoteStr($_POST["email"]);
        $passw = GetSQLValue($sql);

        $sql="select id from `User` where Email = ".QuoteStr($_POST["email"]);
        $id = GetSQLValue($sql);

        $sql="select Username from `User` where Email = ".QuoteStr($_POST["email"]);
        $name = GetSQLValue($sql);
        
        if (isset($passw)){
            $passw_test=hash('sha256', $_POST["pwd"]);
            if($passw_test==$passw){
                $_SESSION['isConnected']=true;
                $_SESSION['email']=$_POST["email"];
                $_SESSION['user_id']=$id;
                $_SESSION['user_name']=$name;
                header("location: homepage.php"); 
            }
            else{
                $WrongAuth=true;
            }
        }
        else{
            $WrongAuth=true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PixelProject - Index</title>
    <link href="css/style.css" rel="stylesheet">
</head>
    <body>
        <?php if ($WrongAuth){
                echo "<div class=error-message>";
                echo "<strong>ERROR : </strong>Try Again";
                echo "</div>";
            }   
        ?>
        <img src="img/LOGO PIXEL.png" alt="Pixel Project Logo" class="logo">
        <form method="POST" class="log-form">
            <h1>Welcome Back !</h1>
            <input type="email" name="email" placeholder="E-Mail" class="input-field" required>
            <input type="password" name="pwd" placeholder="Password" class="input-field" required>
            <input type="submit" value="Login" class="button">
            <input type="button" value="Sign Up" onClick="location.href='signup.php'" class="button"> 
            <td><a href="forgotpwd.php">Mot de passe oublié ?</a></td>
            <p>&copy; 2024 – Paul Lesbats</p>
        </form>
    </body>
</html>
