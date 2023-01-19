<?php

/* --------------------------- Initialisation ------------------------- */

include('dbConn.php');

session_start();

$name = $_GET['id'];

$mail = $_SESSION['mail'];

$user = "SELECT * from `tblstudents` where `email` = '$mail' ";

$res = mysqli_query($connect, $user);

$usr = mysqli_fetch_assoc($res);

$from = $usr['ID'];

$verif = "SELECT COUNT(*) AS verif from `basket` where `id_user` = $from";
$verifQuery = mysqli_query($connect, $verif);
$verifFetch = mysqli_fetch_assoc($verifQuery);
$verifInt = (int) $verifFetch['verif'];

$query = "SELECT * from `article` where `name` = '$name'";

$result = mysqli_query($connect, $query);

$row = mysqli_fetch_assoc($result);

$id_a = $row['ID'];
$id_u = $usr['ID'];

$avis = "SELECT * FROM `avis` where `id_article` = '$id_a'";
$avisQuery = mysqli_query($connect, $avis);
$aviSlides = mysqli_query($connect, $avis);

/* --------------------------- Add In Basket ------------------------- */

if(isset($_POST['add'])){
    $user = "SELECT COUNT(*) AS checke FROM `basket` where `id_user` = '$id_u' and `id_article` = '$id_a'";
    $resultat = mysqli_query($connect, $user);
    $fetch = mysqli_fetch_assoc($resultat);
    $nblocs = (int) $fetch['checke'];
    if($nblocs == 0){
        $bask = "INSERT into `basket`(`id_article`, `id_user`, `quantité`) VALUES ('$id_a','$id_u', 1) ";
        $result = mysqli_query($connect, $bask);
    }else{
        $quantite = "UPDATE basket
        SET `quantité` = `quantité` + 1
        WHERE `id_article` = '$id_a' 
        and `id_user` = '$id_u' ";
        $quer = mysqli_query($connect, $quantite);
    }
    echo "<meta http-equiv='refresh' content='0'>";
}

/* --------------------------- Add new notice ------------------------- */

if(isset($_POST['sub'])){
        $title = $_POST['title'];
        $aviss = $_POST['avis'];
        $cherch = "SELECT COUNT(*) AS test FROM `avis` where `id_user` = '$id_u' and `id_article` = '$id_a'";
        $cherchQuery = mysqli_query($connect, $cherch);
        $cherchFetch = mysqli_fetch_assoc($cherchQuery);
        $check = (int) $cherchFetch['test'];
        /* ------------- Modify notice -------------- */
        if($check != 0){ 
            $modify = "UPDATE avis
            SET `title` = '$title',
                `avis` = '$aviss'
            WHERE `id_article` = '$id_a' 
            and `id_user` = '$id_u' ";
            $modifyQuery = mysqli_query($connect, $modify);
            /* ------------- Add new -------------- */
        }else{
            $inseravis = "INSERT into `avis`(`id_article`, `id_user`, `title`, `avis`) VALUES ('$id_a','$id_u', '$title', '$aviss')  "; 
            $inseravisQuery = mysqli_query($connect, $inseravis); 
        }  
        echo "<meta http-equiv='refresh' content='0'>";
}

/* --------------------------- Rates ------------------------- */

$i = 1;
for($i = 1; $i <= 5;  $i++){
    if(isset($_POST['s'.$i])){
        $cherch = "SELECT COUNT(*) AS test FROM `avis` where `id_user` = '$id_u' and `id_article` = '$id_a'";
        $cherchQuery = mysqli_query($connect, $cherch);
        $cherchFetch = mysqli_fetch_assoc($cherchQuery);
        $check = (int) $cherchFetch['test'];
        if($check != 0){
            $modify = "UPDATE avis
            SET `rate` = $i
            WHERE `id_article` = '$id_a' 
            and `id_user` = '$id_u' ";
            $modifyQuery = mysqli_query($connect, $modify);
        }else{
            $inserate = "INSERT into `avis`(`id_article`, `id_user`, `rate`) VALUES ('$id_a','$id_u',$i)";
            $inserateQuery = mysqli_query($connect, $inserate); 
        }
        echo "<meta http-equiv='refresh' content='0'>";
    }    
} 


/* --------------------------- delete notice ------------------------- */

$avidrop = mysqli_query($connect, $avis);
while ($avisftechdrop = mysqli_fetch_assoc($avidrop)){
if(isset($_POST['drop_'.$avisftechdrop['id_avis']])){
    $avisToDrop = $avisftechdrop['id_avis'];
    $drop = "DELETE  FROM `avis` WHERE id_avis = $avisToDrop";
    $dropQuer = mysqli_query($connect, $drop);
    echo "<meta http-equiv='refresh' content='0'>";
}
}

?>

<!--------------------------------------------- Html ----------------------------------------->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/article.css">
    <link rel="stylesheet" href="../css/head.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/0807d00da4.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="../images/logo" />
    <title>Article</title>
</head>

<body>

<!------------------------------------- header ------------------------------------------>

    <header>
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

<!------------------------------------- container ------------------------------------------>

    <div class="contain">
        <!--------------------------- picture ------------------------------>
        <div class="pict">
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['picture']); ?>" alt="">
        </div>
        <!--------------------------- infos ------------------------------>
        <div class="right">

            <!----------------- top -------------------->
            <div class="top">
                <div class="informations">
                    <h1><?php echo $row['name']; ?> : <?php echo $row['price']; ?> $</h1>
                    <h4><?php echo $row['description']; ?></h4>
                    <div class="wrap">
                        <form action="" method="post">
                            <button type="submit" name="add" class="buttonSub">Add to card</button>
                        </form>
                        <!-- <button type="submit" name="add" class="button">ajouter au panier</button> -->
                    </div>
                </div>
            </div>

            <!----------------- bottom -------------------->
            <div class="bott">
                <!----------------- notices -------------------->
                <div class="container">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li id="p_0" data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            <?php
                                $i = 1;
                                while($avisFetch = mysqli_fetch_assoc($avisQuery)){
                            ?>
                                <li id="p_<?php echo $i; ?>" data-target="#myCarousel" data-slide-to="<?php $i;?>"></li>
                            <?php 
                                    $i = $i + 1;
                                }
                            ?>
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">

                            <div class="item active">
                                <div class="carousel-caption">
                                <h3>Avis</h3>
                                <p>Read All Avis About the Product </p>
                                </div>
                            </div>
                            <!----------------- create avis -------------------->
                            <?php 
                                while($slide = mysqli_fetch_assoc($aviSlides)){
                                    $avID = $slide['id_avis'];
                                    $searchUsr = "SELECT * from `tblstudents` join `avis` on avis.id_user = tblstudents.ID where avis.id_avis = '$avID'";
                                    $userQuery = mysqli_query($connect, $searchUsr);
                                    $userFetch = mysqli_fetch_assoc($userQuery);
                            ?> 
                                    <div class="item">
                                        <div class="carousel-caption">
                                            <div class="titles">
                                                <div class="profil">
                                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($userFetch['image']); ?>" alt="">
                                                </div>
                                                <div class="name">
                                                    <h3><?php echo $userFetch['firstname']; ?></h3>
                                                </div>
                                            </div>
                                            <div class="desc">
                                                <?php 
                                                    $i = (int) $slide['rate'];
                                                ?>
                                                <h3>
                                                    <?php for($j = 1; $j<=$i; $j++){?>
                                                        <i class="star hover">&#9733;</i>
                                                    <?php } ?>
                                                </h3>
                                                <h2><?php echo $slide['title']; ?></h2>
                                                <h5><?php echo $slide['avis']; ?></h5>
                                                <?php if($slide['id_user'] == $from && $mail != "rayen.haddad@efrei.com"){?>
                                                    <form method="post">
                                                        <input name="drop_<?php echo $slide['id_avis']?>" type="submit" value="drop">
                                                    </form>
                                                <?php
                                                }if($mail == "rayen.haddad@efrei.com"){?>
                                                    <form method="post">
                                                        <input name="drop_<?php echo $slide['id_avis']?>" id="drop<?php echo $slide['id_avis']?>" type="submit" value="drop" data-toggle="modal" data-target="#exampleModal2">
                                                    </form> 
                                                <?php
                                                } ?>
                                            </div>
                                        </div>
                                    </div>       
                            <?php 
                                } 
                            ?>    
                        </div>

                        <!-- Left and right controls -->
                        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <!--------------------------------------- End Notices --------------------------------------->
                    
                    <button type="button" class=" buttonSub" data-toggle="modal" data-target="#exampleModal"> Add avis</button>
        
                    <!--------------------------------------- New Notices Modal --------------------------------------->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                       
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">New Avis</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Title</label>
                                            <input type="text" name="title" class="form-control" id="recipient-name" placeholder="Title">
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Message:</label>
                                            <input type="text" name="avis" placeholder="Avis" class="form-control" id="message-text">
                                        </div>
                                        <input type="submit" value="sub" name="sub">
                                    </form>
                                    <div class="stars">
                                        <form action="" method="post" class="f1">
                                            <button type="submit" id="star1" class="rate" name="s1">
                                                <i  class="star" data-note="1">&#9733;</i>
                                            </button>
                                            <button type="submit" id="star2" class="rate" name="s2">
                                                <i  class="star" data-note="2">&#9733;</i>
                                            </button>
                                            <button type="submit" id="star3" class="rate" name="s3">
                                                <i  class="star" data-note="3">&#9733;</i>
                                            </button>
                                            <button type="submit" id="star4" class="rate" name="s4">
                                                <i  class="star" data-note="4">&#9733;</i>
                                            </button>
                                            <button type="submit" id="star5" class="rate" name="s5">
                                                <i  class="star" data-note="5">&#9733;</i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!----------------- End Modal -------------------->
                </div> <!----------------- End Container -------------------->
            </div> <!----------------- End Bottom -------------------->
        </div> <!----------------- End right -------------------->
    </div> <!----------------- End Container -------------------->


<!------------------------------------- Css ----------------------------------->

<style>

        body{
            background-color: #303030;
        }

        .profil{
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
        }

        .container{
            width: 50%;

        }

        .pict{
            display: flex;
            align-items: center;
            height: 100%;
            width: 60%;
        }

        .pict img{
            border-radius: 4%;
        }


        img{
            width: 100%;
            height: 100%;
        }

        .right{
            background-color: #F1D5A5;
            display: flex;
            flex-direction: column;
            align-items: space-around;
            width: 100%;
            height: 100%;
            margin-left: 2%;
            border-radius: 4%;

        }

        .top{
            height: 60%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contain{
            width: 92vw;
            height: 81vh;
            display: flex;
            align-items: center;
            justify-content: space-around;
            top: 10%;
            margin-left: 4%;
            margin-top: 110px;
        }

        #myCarousel{
            width: 150%;
            height: 300px;
            border: 1px solid #F1D5A5;
            display: flex;
            justify-content: center;
            left: -20%;
        }

        .carousel-caption{
            position: relative;
            left: 3%;
        }

        .carousel-control{
            width: 5%;
        }

        .item{
            color: white;
        }

        .star {
            font-size: 1.5rem;
        }
        
        .hover {
            color: rgb(255, 196, 0);
        }

        .rate{
            background: none;
            border: none;
        }

        ul{
            margin-top: 10px;
        }

        h4{
            max-width: 500px;
        }

        
        .wrap {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ---------------------- form pop-up ------------------------ */

        .invisible{
            display: none;
        }

        .avisForm{
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            width: 30%;
            margin-left: 25%;
            border-radius: 4%;
            background-color: cyan;
        }

        .avisForm input{
            background: none;
            outline-style: none; 
            border: none;
            border-bottom: 3px solid #6A1212;
            padding: 8px;
            width: 96%;
            color: #6A1212;
        }

        .f1{
            display: inline;
        }

        .stars{
            cursor: pointer;
            display: flex;
            flex-direction: row;
        }

        /* button */

.contain .buttonSub {
    display: block;
    margin: 7px;
    width: auto;
    padding: 10px 20px;
    border: 3px solid #6A1212;
    border-radius: 999px;
    background-image: linear-gradient(to right, transparent 20%, #6A1212, #F1D5A5);
    background-size: 200%;
    color: #6A1212;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
}

.contain .buttonSub:hover {
    color: #F1D5A5;
    background-position: 100%;
    border: 3px solid #F1D5A5;
}


.contain button{
    display: INITIAL;
    width: 15%;
    padding: 10px 0px;
    border: none;
    outline: none;
    background: none;
    font-size: 20px;
    transition: 0.4s ease-out;
}

.tete{
    box-shadow: 1px 5px 13px 0px rgba(0,0,0,0.83);
-webkit-box-shadow: 1px 5px 13px 0px rgba(0,0,0,0.83);
-moz-box-shadow: 1px 5px 13px 0px rgba(0,0,0,0.83);
}

</style>

</body>


<!----------------- script -------------------->
<script src="../js/article.js"></script>i

</html>