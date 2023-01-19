
<?php

/* --------------------------- Initialisation ------------------------- */

include 'dbConn.php';

session_start();

$mail = $_SESSION['mail'];

$rech = $user = "SELECT * from `tblstudents` where `email` = '$mail' ";

$res = mysqli_query($connect, $rech);

$usr = mysqli_fetch_assoc($res);

$from = $usr['ID'];

$verif = "SELECT COUNT(*) AS verif from `basket` where `id_user` = $from";
$verifQuery = mysqli_query($connect, $verif);
$verifFetch = mysqli_fetch_assoc($verifQuery);
$verifInt = (int) $verifFetch['verif'];



$sql = "SELECT * FROM `signals` where `user` = '$mail' ORDER BY `ID` DESC ";

$result = mysqli_query($connect, $sql);

$loc = array();

while($row = mysqli_fetch_assoc($result)){
    $loc[] = array(
        'ID' => $row['id'],
        'city' => $row['city'],
        'date' => $row['date'],
        'user' => $row['user'],
        'adress' => $row['adress']
    );
};

$locs = json_encode($loc);

$file_name = "../js/locs_current" . ".json";  
 if(file_put_contents($file_name, $locs))  
 {  
        
 }  
 else  
 {  
      echo 'There is some error';  
 }  

?>

<!--------------------------------------------- Html ----------------------------------------->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/head.css">
	<link rel="stylesheet" type="text/css" href="../css/lieux.css">
	<link rel="stylesheet" type="text/css" href="../css/footer.css">
	<link rel="stylesheet" type="text/css" href="../css/apparition.css">
	<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
	<link rel="shortcut icon" href="../images/logo" />
	<title>Locations</title>
</head>
<body>

<!------------------------------------- header ------------------------------------------>

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
            <a href="<?php echo $link;?>">
				<?php
					if($usr['image'] == null){?>
						<img id="profil" src="../images/userdefault.png" alt="">
					<?php
					}else{
					?>
					<img id="profil" alt="image" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($usr['image']);?>">
                <?php } ?>
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

<!------------------------------------- all content ------------------------------------------>

<div class="contenu">

	<!------------------------------- slide 1 -------------------------------->
	
	 <div class="main reveal">

		<div class="test">

			<div class="titre">
		 		<h1>
		 			Signalez directement un lieu 
		 		</h1>
		 	</div>
			<!------------------------- form signals -------------------------------->
		 	<div class="formu" id="da">
		 		<form name="newTask" action="" method="POST" class="box" id="new-task">
					<div class="saisis" id="da" >
				        <label for="d"> </label>
				        	<input type="date" id="d" name="d" required>
				        	<p id="suitedate"></p>
				    </div>
				    <div class="saisis" id="ad">
				        <label for="Adresse"> </label>
				        	<input type="text" id="Adresse" name="Adresse" placeholder="Adresse" required>
				    </div>

				    <div class="saisis" id="v">
				        <label for="city"> </label>
				        	<input type="text" id="city" name="city" placeholder="City" required>
				    </div>			    

				<div class="formGroupe">
	                <input type="submit" value="Valid" name="Valid" class="buttonSub btn-menu">
	                <input type="reset" value="Reset" class="buttonSub" onclick="supprimer()">
	            </div>
				</form>
		 	</div>

		</div>
				<div class="image">
					<img alt="image" src="../images/phone">
				</div>
	</div>

		
	</div>
	<!----------------------------- slide 2 ------------------------------------->
	<div class="p2 reveal1">
		<h1>
			visualisez les lieux signalés
		</h1>
		<div class="table">
			<table> 
				<thead class="titres">
						<tr>
							<th class="titre"> DATE </th>
							<th class="titre"> ADRESS </th>
							<th class="titre"> CITY </th>
						</tr>
				</thead>
			</table>
		</div>
	</div>


<!--------------------------------------- footer ----------------------------------------->

	<footer>

		<div class="logo">
			<ul>
				<li> <a href="bientot.html"> <img alt="image" src="../images/insta.jpg" id="insta"></a></li>
				<li> <a href="bientot.html"> <img alt="image" src="../images/fa.png" id="fb"></a></li>
				<li> <a href="bientot.html"> <img alt="image" src="../images/linkedin.jpg" id="link"></a></li>
			</ul>	
		</div>

	</footer>


<script src="../js/apparition.js" defer></script>
<script src="../js/lieux.js" defer></script>


<!------------------------------------- script ------------------------------------------->


<script>
/* ---------------------- Validation submit ---------------------------*/

document.querySelector(".buttonSub").addEventListener('click', function(e){
	if (validedate(test.d) && valideville(test.ville) && valideadr(test.Adresse)) {
		<?php
		if(isset($_POST['Valid'])){

			$add = $_POST['Adresse'];
			$city = $_POST['city'];
			$date = $_POST['d'];
		
			$insert="INSERT INTO `signals` (`city`, `date`, `user`, `adress`)
					 VALUES ('$city','$date','$mail', '$add')";
			if(mysqli_query($connect,$insert)) {
				// header("refresh:1;url=connexion.php");
			}
			
			echo "<meta http-equiv='refresh' content='0'>";
		
		}
		?>
		//console.log(infos)
	}else{
		e.preventDefault();
		alert('Select corrects informations ');
	}
});
</script>

</body>

</html>






