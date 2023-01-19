<?php 

include 'dbConn.php';

if(isset($_POST['btnRegister'])){

    $email = $_POST['email_address'];
    $password = md5($_POST['password']);

    $query = "SELECT * from `tblstudents` where `email` = '$email' AND password = '$password'";

    $result = mysqli_query($connect, $query);

    $row = mysqli_fetch_assoc($result);

    $count = mysqli_num_rows($result);

    if($count == 1){
       
        session_start();
        $_SESSION['mail'] = $email;
        $_SESSION['fname'] = $row['firstname'];
        $_SESSION['lname'] = $row['lastname'];

        echo '<script>alert(" Welcome ! ")</script>';
        header("refresh:1;url=shop.php");
    }
    else{
        echo '<script>alert(" Mail or Password is wrong ! ")</script>';
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/formulaire.css"> 
	<link rel="stylesheet" type="text/css" href="../css/footer.css">
	<link rel="stylesheet" type="text/css" href="../css/tete.css">
	<link rel="stylesheet" type="text/css" href="../css/apparition.css">
	<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="shortcut icon" href="../images/logo" />
    <title> Login </title>
</head>
<body>

<!------------------------------------- header ------------------------------------------>

<div class="haut">
    <nav class="tete" id="test">
        <a href="../html/main.html"> <img alt="logo" src="../images/logo"></a>
        <ul>
            <li><a href="../html/propos.html"> About Us </a>
            <li><a href="../form/insc.php"> Join Us </a></li>
            <li><a href="../html/competence.html"> Content </a></li>
        </ul>
    </nav>

</div>

<div class = "container">
		<div class="menu ">
			<div class="titres">
				<h1> Connexion </h1>
				<h2> So that you too can come home safe </h2>
			</div>
            <form action='#' method="post">
                <label for="email_address"></label>
                    <input type="email" name="email_address" placeholder="email"><br>
                <label for="email_address"></label>    
                    <input type="password" name="password" placeholder="password"><br>
                <div class="formGroupe">
                    <input type="submit" value="Register" name="btnRegister" class="buttonSub" >
                    <input type="reset" value="Reset" class="buttonSub" onclick="supprimer()">
                </div>
            </form>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Forget password</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="forgetpasswrd.php" method="post">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Email</label>
                                    <input type="text" name="emailsend" class="form-control" placeholder="mail@example.fr">
                                </div>
                                <input type="submit" name="changepass" value="send mail">
                            </form>
                        </div>
                    </div>
                </div>

            </div> <!----------------- End Modal -------------------->


            <form>    
                <input type="button" data-toggle="modal" data-target="#exampleModal" value="forgot password ?" name="changepass" class="buttonSub" >
            </form>
        </div>
</div>


<style>
    body{
        background-color: #6A1212;
    }
</style>





