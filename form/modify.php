<?php

/* -------------------------------- Initialisation --------------------------------- */

include 'dbConn.php';
session_start();

$mail = $_SESSION['mail'];
$id = $_GET['id_a'];

$rech  = "SELECT * from `tblstudents` where `email` = '$mail' ";

$res = mysqli_query($connect, $rech);

$usr = mysqli_fetch_assoc($res);

$from = $usr['ID'];


$verif = "SELECT COUNT(*) AS verif from `basket` where `id_user` = $from";
$verifQuery = mysqli_query($connect, $verif);
$verifFetch = mysqli_fetch_assoc($verifQuery);
$verifInt = (int) $verifFetch['verif'];



$rech_art = "SELECT * FROM `article` where `ID` = $id";
$rechQuery = mysqli_query($connect, $rech_art);
$rechFetch = mysqli_fetch_assoc($rechQuery);



$status = $statusMsg = ''; 
if(isset($_POST["submit"])){ 

    $name=$_POST['name'];
    $desc=$_POST['description'];
    $stock= $_POST['stock'];
    $price= $_POST['price'];
    $status = 'error'; 

    /*------------------ picture adding ---------------*/

    if(!empty($_FILES["image"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            $image = $_FILES['image']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 
        
                $newpic="UPDATE `article` 
					SET `picture` = '$imgContent' 
					WHERE `ID` = '$id'";
                $newpicQuery = mysqli_query($connect,$newpic);
                        
        } 
    }

	if(strlen($name) > 0){
		$newname="UPDATE `article` 
			SET `name` = '$name' 
			WHERE `ID` = '$id'";
		$newnameQuery = mysqli_query($connect,$newname);
	}

	if(strlen($desc) > 0){
		$newdesc="UPDATE `article` 
			SET `description` = '$desc' 
			WHERE `ID` = '$id'";
		$newdescQuery = mysqli_query($connect,$newdesc);
	}

	if(strlen($stock) > 0){
		$newstock="UPDATE `article` 
			SET `stock` = '$stock' 
			WHERE `ID` = '$id'";
		$newstockQuery = mysqli_query($connect,$newstock);
	}

	if(strlen($price) > 0){
		
		$sendmail = "SELECT * FROM `tblstudents` join `basket` on tblstudents.ID = basket.id_user join 
		`article` on basket.id_article = article.ID where article.ID = $id ";

		$sendquery = mysqli_query($connect, $sendmail);
		while ($sendfetch = mysqli_fetch_assoc($sendquery)) {

			// 	echo "t";

				$to = $sendfetch['email'];
				$old = $sendfetch['price'];


			$subject = "An article of your basket just become cheaper";
			$message = "
				<html>
				<head>
				<title>Reset password</title>
				</head>
				<body>
				<h1>Hello $to</h1> <br> <h3> Hello, An article of your gard just get discount. and went from : </h3>
				<h1 style='color : orange'>   $old $   </h1> <h3> to : </h3> 
				<h1 style='color : orange'>  $price $  </h1> <br>
				<h3>go complete and submit your card</h3>
				</body>
				</html>
			";

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


			//More headers
			$headers .= 'From: <rayen.haddad@gmail.com>' . "\r\n";

			if(mail($to, $subject, $message, $headers)){
				echo "mail sent";

				//header("refresh:1;url=connexion.php");
			}else{
				echo "erreur mail";
			}



			$newstock = "UPDATE `article` 
				SET `price` = '$price' 
				WHERE `ID` = '$id'";
			$newstockQuery = mysqli_query($connect, $newstock);
		}
	}
}

?>

<!--------------------------------------------- Html ----------------------------------------->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/formulaire.css"> 
	<link rel="stylesheet" type="text/css" href="../css/head.css">
	<link rel="stylesheet" type="text/css" href="../css/apparition.css">
	<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
	<link rel="shortcut icon" href="../images/logo" />
	<title> Modify Article </title>
</head>

<body>

<!--------------------------------------------- header ----------------------------------------->

<nav class="tete fond">
	<?php 
		if($mail == 'rayen.haddad@efrei.com'){
			$link = 'admin.php';
		}
		else{
			$link = 'user.php';
		} 
	?>
	
	<ul>
		<li>
		<a href="<?php echo $link;?>" target="_blank">
			<img id="profil" alt="image" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($usr['image']);?>">
			<style>

			#profil{
				width: 40px;
				height: 40px;
				border-radius: 50%;
				position: relative;
				margin-top: 10px;
			}

			#cpt{
				position: relative;
				top: 0%;
				margin-bottom: 10px;
			}
			
			</style>
		</a>
		</li>
		<li class="link"><a href="chat.php" id="prop"> Chat </a>
		<li class="link"><a href="lieux.php" id="parc"> Locs </a></li>
		<li class="link"><a href="shop.php" id="pro"> Shop </a></li>
		<?php
			if($verifInt == 0){?>
				<li><a href="basket.php" id="cpt"> <img id="card" src="../images/caddie.png" alt="caddie"> </a></li>
		<?php
			}else if($verifInt > 9){?>
				<li><a href="basket.php" id="cpt"> <img src="../images/caddieplus.png" alt="caddie"> </a></li>
		<?php
			}else{?>
				<li><a href="basket.php" id="cpt"> <img src="../images/caddie<?php echo $verifInt?>.png" alt="caddie"> </a></li>
		<?php
			}
		?>
	</ul>
</nav>

<!--------------------------------------------- container  ----------------------------------------->

	<div class="container">
		<div class="menu ">
			<div class="titres">
				<h1> Modify <?php echo $rechFetch['name']; ?> </h1>
				<h2> For clients </h2>
			</div>
			<form method="post" id="formulaire" enctype="multipart/form-data">
				<div class="forme">
					<div>
						<label for="name"></label>
							<input type="text" name="name" id = "name" placeholder="name" >
					</div>
				
					<div>
						<label for="description"></label>
							<input type="text" name="description" id = "desc" placeholder="description" >
					</div>

					<div>
						<label for="picture"></label>
							<input type="file" name="image" id="image-input" accept="image/jpeg, image/png, image/jpg" value="modify picture" >
					</div>

					<div>
						<label for="stock"></label>
							<input type="number" name="stock" id = "stock" placeholder="stock"  >
					</div>
					
						<div>
						<label for="price"></label>
							<input type="number" name="price" id = "price" placeholder="price"  >
					</div>
					
					<div class="formGroupe">
						<input type="submit" value="Register" name="submit" class="buttonSub" >
						<input type="reset" value="Reset" class="buttonSub" onclick="supprimer()">
					</div>
				</div>
			</form>
		</div>
	</div>

</body>    

</html>

<script src="verif.js" async></script>

