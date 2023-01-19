<?php 

/* --------------------------- initialisation ------------------------ */

session_start();
$mail = $_SESSION['mail'];
include('dbConn.php');

$rech = $user = "SELECT * from `tblstudents` where `email` = '$mail' ";

$res = mysqli_query($connect, $rech);

$usr = mysqli_fetch_assoc($res);

$from = $usr['ID'];

$verif = "SELECT COUNT(*) AS verif from `basket` where `id_user` = $from";
$verifQuery = mysqli_query($connect, $verif);
$verifFetch = mysqli_fetch_assoc($verifQuery);
$verifInt = (int) $verifFetch['verif'];

/* -------------- current user ---------------  */

$rech = $user = "SELECT * from `tblstudents` where `email` = '$mail' ";

$res = mysqli_query($connect, $rech);

$usr = mysqli_fetch_assoc($res);

$user = $usr['ID'];

/* --------------------- fetch all articles on the card ----------------- */

$stock = "SELECT * FROM `article` join `basket` on article.id = basket.id_article where `id_user`= $user"; 

$stockQuery = mysqli_query($connect, $stock);

while($stockFetch = mysqli_fetch_assoc($stockQuery)){

    $id_a = $stockFetch['id_article'];
    $qte = $stockFetch['quantité'];
    $modify = "UPDATE article
        SET `stock` = `stock` - $qte
        WHERE `ID` = '$id_a'";
    $modifyQuery = mysqli_query($connect, $modify);

}

/* --------------------------- drop all articles of the basket ------------------*/
$delete = "DELETE FROM `basket` WHERE `id_user`='$user'";
$deleteQuery = mysqli_query($connect, $delete);

?><!--------------------------------------------- Html ----------------------------------------->

<!DOCTYPE html>
<head>

   <meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


   <!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="../img/rhlogo.png" >
    <link rel="stylesheet" href="../css/head.css">
   <script src="https://kit.fontawesome.com/0807d00da4.js" crossorigin="anonymous"></script>
   <link rel="shortcut icon" href="../images/logo" />
   <title>thanks</title>
   
</head>

<body>

   <!-- Header
   ================================================== -->
<header id="home">
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

    <h1>thanks for submiting your command wend send your receipt in your mail </h1>

</body>

<style>
    body{
        margin: 0;
        padding: 0;
    }

    h1{
        margin-top: 100px;
    }

</style>

</html>