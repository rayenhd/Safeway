<?php

include "dbConn.php";
session_start();

// $mail = $_SESSION['mail'];

function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}




if(isset($_POST['changepass'])){

    $tmpass = generateRandomString();
    $to = $_POST['emailsend'];
    
    $_SESSION['temp'] = $tmpass;
    $_SESSION['to'] = $to;

    $subject = "HTML email";

    $message = "
<html>
        <head>
        <title>Reset password</title>
        </head>
        <body>
        <h1>Hello $to</h1> <br> <h3> Hello, you asked to change your password. 
            There is here your temporary password for changing it :</h3> <br>
            <h1 style='color : orange'>$tmpass</h1> <br> <br>
            <h3>don't show it to anybody and write It on the changepassword page to renitialize it</h3>

        </body>
        </html>";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <webmaster@example.com>' . "\r\n";

if(mail($to, $subject, $message, $headers)){
    echo "mail sent";

    //header("refresh:1;url=connexion.php");
}else{
    echo "erreur mail";
}

}

if(isset($_POST['btnRegister'])){
    echo "test";

    $tmpass = $_SESSION['temp'];
    $to = $_SESSION['to'];
    $temp = $_POST['temp'];
    $new = md5($_POST['password']);

    if($temp = $tmpass){
        $update = "UPDATE tblstudents
        SET `password` = '$new'
        WHERE `email` = '$to'";

        if(mysqli_query($connect, $update)){
            echo '<script>alert(" You change your paswword successfully ! ")</script>';
        }
    }else{
        echo '<script>alert(" Temporary password is wrong ! ")</script>';
    }

}

?>

<!-------------------------------------- html -------------------------------------->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="../css/formulaire.css"> 
    <link rel="stylesheet" type="text/css" href="../css/tete.css"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo" />
    <title>forget password</title>
</head>
<body>

<!------------------------------------- header ------------------------------------------>

<div class="haut">
    <nav class="tete" id="test">
        <a href="../html/main.html"> <img alt="logo" src="../images/logo"></a>
        <ul>
            <li><a href="../html/propos.html"> About Us </a>
            <li><a href="insc.php"> Join Us </a></li>
            <li><a href="../html/competence.html"> Content </a></li>
        </ul>
    </nav>

</div>

<!------------------------------------------ form new password -------------------------------->
    
<div class = "container">
    <div class="menu ">
        <div class="titres">
            <h1> You Forget your password ? </h1>
            <h2> Change It </h2>
        </div>
        <form method="post">
                <input type="text" name="temp" placeholder="temporary password"><br>
                <input type="text" name="password" placeholder=" new password"><br>
            <div class="formGroupe">
                <input type="submit" value="Register" name="btnRegister" class="buttonSub" >
            </div>
        </form>
    </div>
</div>

</body>
</html>



