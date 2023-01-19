<?php

/* -------------------------------- Initialisation --------------------------------- */

include('dbConn.php');

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

?>

<!--------------------------------------------- Html ----------------------------------------->

<!DOCTYPE html>
<head>

   <meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
    ================================================== -->
   <link rel="stylesheet" href="../css/default.css">
	<link rel="stylesheet" href="../css/layoute.css">
   <link rel="stylesheet" href="../css/head.css">
   <link rel="stylesheet" href="../css/apparition.css">

   <!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="../img/rhlogo.png" >
   <script src="https://kit.fontawesome.com/0807d00da4.js" crossorigin="anonymous"></script>
   <link rel="shortcut icon" href="../images/logo" />
   
   <title>Shop</title>
   
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

    <div class="row banner reveal2">
        <div class="banner-text">
            <h1 class="responsive-headline">Safeway</h1>
            <style>
                .tit{
                    opacity: 0;
                }
                .app{
                    transition: all 0.6;
                    opacity: 1;
                }
            </style>
            <h3>When coming home is no more stressfull</h3>
            <hr />
        </div>
    </div>

      
   </header> <!-- Header End -->

   <!-- About Section
   ================================================== -->
   <section id="about" class="reveal">

      <div class="row">

         <div class="three columns">

            <img class="profile-pic"  src="../images/shop.png" alt="" />

         </div>

         <div class="nine columns main-col">

            <h2>Shop</h2>

            <p> Explore the website And find bests products to defend yourself          
            </p>

         </div> <!-- end .main-col -->

      </div>

   </section> <!-- About Section End-->


      <!-- Portfolio Section
   ================================================== -->
   <section class="portfolio reveal3" id="porto">

      <div class="row">

         <div class="twelve columns collapsed">

            <h1>Shop</h1>

            <!-- portfolio-wrapper -->
            <div id="portfolio-wrapper" class="bgrid-quarters s-bgrid-thirds cf">

                <?php 
                
                    $query = "SELECT * from `article`";
    
                    $result = mysqli_query($connect, $query);

                    while($row = mysqli_fetch_assoc($result)){
    
                ?>

                    <div class="columns portfolio-item">
                        <div class="item-wrap" style="border: 1px solid white ;">
                            <a href="article.php?id=<?php echo $row['name']?>" target="_blank">
                            <img alt="" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['picture']); ?>" style="width: 100%; height: 100%;">
                            <div class="overlay">
                                <div class="portfolio-item-meta">
                                        <h2><?php echo $row['name'] ?></h2>
                                    <p><?php echo $row['price']; ?>$</p>
                                        </div>
                            </div>
                        <div class="link-icon"><i class="icon-plus"></i></div>
                        </a>
                    </div>
                </div> <!-- item end -->
                <?php 
                    
                    }
                ?>

            </div> <!-- portfolio-wrapper end -->

         </div> <!-- twelve columns end -->

      </div> <!-- row End -->

   </section> <!-- Portfolio Section End-->


   <!-- footer
   ================================================== -->
   <footer class="reveal6">

      <div class="row">

         <div id="go-top"><a class="smoothscroll" title="Back to Top" href="#home"><i class="icon-up-open"></i></a></div>

      </div>

   </footer> <!-- Footer End-->

   <!-- Java Script
   ================================================== -->

   <script src="../js/propos.js"></script>
   <script src="../js/apparition.js"></script>
   <script src="../js/tete.js"></script>

</body>

</html>

