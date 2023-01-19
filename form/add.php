
<?php

/* -------------------------------- Initialisation --------------------------------- */

include 'dbConn.php';

session_start();

$mail = $_SESSION['mail'];

$user = "SELECT * from `tblstudents` where `email` = '$mail' ";

$res = mysqli_query($connect, $user);

$usr = mysqli_fetch_assoc($res);

$from = $usr['ID'];

/*------------------ quantity in the card ---------------*/
 
$verif = "SELECT COUNT(*) AS verif from `basket` where `id_user` = $from";
$verifQuery = mysqli_query($connect, $verif);
$verifFetch = mysqli_fetch_assoc($verifQuery);
$verifInt = (int) $verifFetch['verif'];

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

            $query1 = "SELECT * from article";

            $result1 = mysqli_query($connect, $query1);
        
        
            $valid = 'true';
        
            $row = mysqli_fetch_assoc($result1);
        
            while (($row = mysqli_fetch_assoc($result1)) && $valid == true){
                
                if($row['name'] === $name){  // If the name of the article already exist
                    $valid = false; 
                }  
            
            } 
        
            if($valid == true){  // If the name of the article don't exist
                $query="INSERT INTO `article`(`name`, `picture`, `description`, `stock`, `price`) VALUES ('$name','$imgContent','$desc','$stock', '$price')";
                if(mysqli_query($connect,$query)) {
                    echo'  Record success added';        
                }
                else{
                    echo'Error in added';
                }
            }
            else{
                echo "Erreur le mail existe déja ";
            }             
        }
    }
}

?>

 <!----------------------------------- Html ------------------------------------>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <!----------------- css ------------------->
	<link rel="stylesheet" type="text/css" href="../css/formulaire.css"> 
	<link rel="stylesheet" type="text/css" href="../css/head.css">
	<link rel="stylesheet" type="text/css" href="../css/apparition.css">
	<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
	<link rel="shortcut icon" href="../images/logo" />

	<title> Add Article </title>
</head>

<body>

<!------------------------------------- header ------------------------------------------>

<header>
    <nav class="tete fond">
        <?php 
            if($mail == 'rayen.haddad@efrei.com'){  // If the user connected is the admin
                $link = 'admin.php';
            }
            else{  // If the user connected is a normal custommer
                $link = 'user.php';
            } 
        ?>
        
        <ul>
            <li>
            <a href="<?php echo $link;?>">
                <img id="profil" alt="image" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($usr['image']);?>">
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
</header>

<!------------------------------------- Form Add article ------------------------------------------>
	
	<div class="container">
		<div class="menu reveal ">
            <!----------------- titles ------------------->
			<div class="titres">
				<h1> Add Article </h1>
				<h2> For clients </h2>
			</div>
            <form action="" method="post" id="formulaire" enctype="multipart/form-data">
                <div class="forme">
                    <!----------------- name section ------------------->
                    <div>
                        <label for="name"></label>
                            <input type="text" name="name" id = "name" placeholder="name" required>
                    </div>
                    <!----------------- description section ------------------->
                    <div>
                        <label for="description"></label>
                            <input type="text" name="description" id = "desc" placeholder="description" required>
                    </div>
                    <!----------------- picture section ------------------->
                    <div>
                        <label for="picture"></label>
                            <input type="file" name="image" id="image-input" accept="image/jpeg, image/png, image/jpg" value="modify picture" required>
                    </div>
                    <!----------------- stock section ------------------->
                    <div>
                        <label for="stock"></label>
                            <input type="number" name="stock" id = "stock" placeholder="stock"  required>
                    </div>
                    <!----------------- price section ------------------->
                    <div>
                        <label for="price"></label>
                            <input type="number" name="price" id = "price" placeholder="price"  required>
                    </div>
                    <!----------------- buttons section ------------------->    
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
<script src="../js/apparition.js"></script>

