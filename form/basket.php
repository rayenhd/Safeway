<?php 

/* --------------------------- Initialisation ------------------------- */

include 'dbConn.php';
session_start();

$email = $_SESSION['mail'];

$rech = $user = "SELECT * from `tblstudents` where `email` = '$email' ";

$res = mysqli_query($connect, $rech);

$usr = mysqli_fetch_assoc($res);

$user = $usr['ID'];

$verif = "SELECT COUNT(*) AS verif from `basket` where `id_user` = $user";
$verifQuery = mysqli_query($connect, $verif);
$verifFetch = mysqli_fetch_assoc($verifQuery);
$verifInt = (int) $verifFetch['verif'];


$query = "SELECT * from `article` join `basket` on article.ID = basket.id_article  where basket.id_user = $user";

$result = mysqli_query($connect, $query);

$resultcount = mysqli_query($connect, $query);

$test =  mysqli_query($connect, $query);
$art = mysqli_fetch_assoc($test);


?>

<!--------------------------------------------- Html ----------------------------------------->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/basket.css">
    <link rel="stylesheet" href="../css/head.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/0807d00da4.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="../images/logo" />
    <title>Basket</title>
</head>

<body>

<!-------------------------------------- Header -------------------------------------->

<nav class="tete fond">
        <?php 
            if($email == 'rayen.haddad@efrei.com'){
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


<!--------------------------------------------- Main Content ----------------------------------------->

<div class="contain1">

    <div class="container">

        <!------------------------------- All articles --------------------------------->
        <div class="all">

            <div class="title">
                <h1>
                    your basket
                </h1>
            </div>

            <div class="empty">
                <h1>your card Is empty go <a href="shop.php">fill it</a> </h1>
            </div>
            <?php
                if($verifInt != 0){
                    $i_a = $art['id_article']; ?>
                    <script>
                        document.querySelector('.empty').style.display = "none";
                    </script>
                    <?php
                
                }
            ?>
            <?php while($row = mysqli_fetch_assoc($result)){ 

                $article = $row['id_article'];
                $action = $row['id_action'];
                $cherch = "SELECT * from `basket` where `id_action` = $action";
                
                if(isset($_POST['delete'.$article])){
                    $drop = "DELETE FROM `basket` WHERE id_user = $user and id_article = $article";
                    $delete = mysqli_query($connect, $drop);
                    $del = mysqli_query($connect, $query);
                    
                    echo "<meta http-equiv='refresh' content='0'>";
                }

            ?>

                <div class="bask">
                    <div class="pict">
                        <a href="article.php?id=<?php echo $row['name']?>" target="_blank">
                            <img alt="" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['picture']); ?>">       
                        </a>
                    </div>
                    <div class="contente">
                        <div class="left">
                        <a href="article.php?id=<?php echo $row['name']?>" class="name_art" target="_blank">
                            <h3><?php echo $row['name'] ?></h3>
                        </a>
                            <div class="quant">
                                <form action="" method="post">
                                    <div class="qte"> 
                                        <h4>
                                            <label for="Quantity">Quantity : </label>
                                        </h4>
                                        <h4 id="qte_<?php echo $row['id_article'] ?>">
                                            <?php 
                                                echo $row['quantité']; 
                                            ?>
                                        </h4>
                                    </div>
                                    <div class="containModify">
                                        <div id="textmodify<?php echo $row['id_article'] ?>">
                                            Modify The Quantity
                                        </div>
                                        <div id="modify<?php echo $row['id_article'] ?>" class=" modify nosee">
                                            <select  name="Quantity_<?php echo $row['id_article']?>" id="quant">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                            <input type="submit" name="changeQ<?php echo $row['id_article'] ?>" class="subm" value="✔️" id="changeQ">
                                </form>
                                        </div>
                                    </div>
                                <form action="" method="post" class="drop">
                                        <button type="submit" class="delete subm" name="delete<?php echo $row['id_article']; ?>" id="delete"> <i class="fa-solid fa-trash-can"> </i> </button>
                                </form>

                                <?php 

                                    if(isset($_POST['changeQ'.$article])){
                                        $new = $_POST['Quantity_'.$row['id_article']];
                                        $change = "UPDATE basket
                                        SET `quantité` = $new
                                        WHERE `id_article` = $article
                                        and `id_user` = $user ";
                                        $set = mysqli_query($connect, $change);
                                    }                                  

                                ?></h4>

                            </div>
                            
                        </div>
                        <div class="right">
                            <h4 id="prix_<?php echo $row['id_action'];?>">
                            <?php 

                                $prix = $row['price'] * $row['quantité'];
                                $oldId = $row['id_action'];
                                
                                echo $prix; 

                                if(isset($_POST['changeQ'.$article])){
                                    $test = mysqli_query($connect, $query); 
                                    while($nouv = mysqli_fetch_assoc($test)){
                                        if($oldId == $nouv['id_action']){
                                            $q = $nouv['quantité'];
                                            $prix = $row['price'] * $nouv['quantité'];
                            ?>

                                <script>
                                    id = <?php echo $oldId;?>;
                                    newq = <?php echo $q;?>;
                                        if(document.querySelector('#prix_'+id) != null){
                                            document.querySelector('#prix_'+id).textContent = '';
                                            document.getElementById('qte_<?php  echo $row['id_article'];?>').textContent = '';
                                            document.getElementById('qte_<?php  echo $row['id_article'];?>').textContent = newq;
                                        }
                                </script>
                                
                                <?php  
                                            echo " $prix";
                                        }
                                    };  
                                }    
                                ?>
                            </h4>
                            
                        </div>
                    </div>
                </div>

            <?php 
                }
            ?>
        </div>  <!------------------- End All articles ---------------------> 

        <!------------------------------ Total ------------------------------->
        <div class="content">
            <div class="infos">
                <h2>Summary</h2>
                <div class="subtot">
                    <h4>Subtotal</h4>
                    <?php
                        $total = 0; 
                        while($count = mysqli_fetch_assoc($resultcount)){
                            $total = $total + $count['price'] * $count['quantité'];
                        }
                    ?>
                    <h4 class="total" id="totalNoFees">
                        <?php 
                            echo $total;
                        ?>
                    </h4>
                </div>
                <div class="fees">
                    <h4>delivery fees</h4>
                    <h4>free</h4>
                </div>
                
                <div class="totalprice">
                    <div class="showtot">
                        <h3>Total</h3>
                        <h3 id="totalP" class="total">
                     
                        <?php 
                        echo $total;
                        $parcours = mysqli_query($connect, $query);
                        $newtotal = 0;
                        while($through = mysqli_fetch_assoc($parcours)){
                            $articless = $through['id_article'];?>
                            <script>console.log(<?php echo $articless;?>);</script>
                        <?php    
                            if(isset($_POST['changeQ'.$articless])){?>
                            <?php 
                            $newcount = mysqli_query($connect, $query);
                            while($newcnt = mysqli_fetch_assoc($newcount)){
                                $newtotal = $newtotal + $newcnt['price'] * $newcnt['quantité'];
                            }
                        ?>
                        
                        <script>
                            console.log("test");
                            console.log(<?php echo $newtotal;?>);
                                tot = <?php echo $newtotal;?>;
                            document.getElementById('totalP').textContent = tot;
                            document.getElementById('totalNoFees').textContent = tot;

                        </script>    

                        <?php
                        }
                        }
                        ?>
                    </h3>
                    </div> 
                    <!------------------- Button submit card --------------------->
                    <form action="" method="post">
                        <button class="button" type="submit" name="valid" id="valid">
                            <div class="t">
                            <span class="button__text">
                                <span>V</span><span>a</span>l</span><span></span><span>i</span><span>d</span> <span>C</span><span>a</span><span>r</span><span>d</span>
                            </span>
                            </div>
                            <svg class="button__svg" role="presentational" viewBox="0 0 600 600">
                                <defs>
                                <clipPath id="myClip">
                                    <rect x="0" y="0" width="100%" height="50%" />
                                </clipPath>
                                </defs>
                                <g clip-path="url(#myClip)">
                                <g id="money">
                                    <path d="M441.9,116.54h-162c-4.66,0-8.49,4.34-8.62,9.83l.85,278.17,178.37,2V126.37C450.38,120.89,446.56,116.52,441.9,116.54Z" fill="#699e64" stroke="#323c44" stroke-miterlimit="10" stroke-width="14" />
                                    <path d="M424.73,165.49c-10-2.53-17.38-12-17.68-24H316.44c-.09,11.58-7,21.53-16.62,23.94-3.24.92-5.54,4.29-5.62,8.21V376.54H430.1V173.71C430.15,169.83,427.93,166.43,424.73,165.49Z" fill="#699e64" stroke="#323c44" stroke-miterlimit="10" stroke-width="14" />
                                </g>
                                <g id="creditcard">
                                    <path d="M372.12,181.59H210.9c-4.64,0-8.45,4.34-8.58,9.83l.85,278.17,177.49,2V191.42C380.55,185.94,376.75,181.57,372.12,181.59Z" fill="#a76fe2" stroke="#323c44" stroke-miterlimit="10" stroke-width="14" />
                                    <path d="M347.55,261.85H332.22c-3.73,0-6.76-3.58-6.76-8v-35.2c0-4.42,3-8,6.76-8h15.33c3.73,0,6.76,3.58,6.76,8v35.2C354.31,258.27,351.28,261.85,347.55,261.85Z" fill="#ffdc67" />
                                    <path d="M249.73,183.76h28.85v274.8H249.73Z" fill="#323c44" />
                                </g>
                                </g>
                                <g id="wallet">
                                <path d="M478,288.23h-337A28.93,28.93,0,0,0,112,317.14V546.2a29,29,0,0,0,28.94,28.95H478a29,29,0,0,0,28.95-28.94h0v-229A29,29,0,0,0,478,288.23Z" fill="#a4bdc1" stroke="#323c44" stroke-miterlimit="10" stroke-width="14" />
                                <path d="M512.83,382.71H416.71a28.93,28.93,0,0,0-28.95,28.94h0V467.8a29,29,0,0,0,28.95,28.95h96.12a19.31,19.31,0,0,0,19.3-19.3V402a19.3,19.3,0,0,0-19.3-19.3Z" fill="#a4bdc1" stroke="#323c44" stroke-miterlimit="10" stroke-width="14" />
                                <path d="M451.46,435.79v7.88a14.48,14.48,0,1,1-29,0v-7.9a14.48,14.48,0,0,1,29,0Z" fill="#a4bdc1" stroke="#323c44" stroke-miterlimit="10" stroke-width="14" />
                                <path d="M147.87,541.93V320.84c-.05-13.2,8.25-21.51,21.62-24.27a42.71,42.71,0,0,1,7.14-1.32l-29.36-.63a67.77,67.77,0,0,0-9.13.45c-13.37,2.75-20.32,12.57-20.27,25.77l.38,221.24c-1.57,15.44,8.15,27.08,25.34,26.1l33-.19c-15.9,0-28.78-10.58-28.76-25.93Z" fill="#7b8f91" />
                                <path d="M148.16,343.22a6,6,0,0,0-6,6v92a6,6,0,0,0,12,0v-92A6,6,0,0,0,148.16,343.22Z" fill="#323c44" />
                                </g>

                            </svg>
                        </button>
                    </form>  <!------------------- End submit card --------------------->
                </div> <!------------------- End totalprice --------------------->
            </div>
        </div> <!------------------- End total --------------------->
    </div>   
</div> <!------------------- End main --------------------->

</body>

<?php

if(isset($_POST['valid'])){
    $validTest = true;
    $cant = array();
    $verifValid = mysqli_query($connect, $query);
    while ($veriFetch = mysqli_fetch_assoc($verifValid)){
        if($veriFetch['stock'] < $veriFetch['quantité']){
            array_push($cant, $veriFetch['name']);
            $validTest = false;
        }
    }
    if($validTest == false){?>
    
        <script>
                errors = [];
                <?php
                    foreach ($cant as $valeur) { ?>
                        errors.push("<?php echo ($valeur)?>")
                    <?php    
                    }
                ?>
            document.getElementById('valid').addEventListener('click', () => {
                console.log("yesy")
                if(errors.length != 0){                    
                    alert("Some articles of your card are out of stock : " + errors.join("\n"));
                }
            })
            
        </script>
    <?php
    }else{ 

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


    //More headers
    $headers .= 'From: <rayen.haddad@gmail.com>' . "\r\n";
        $to = $email;
        $subject = "Thank's for your command";
        $message = 'Put your html message here<br>';
        $message .= "<h1>Hello $email</h1> <br> <h3>thank you for chosing our site to make your command and there is details of your command : </h3> <br> <table border='1' cellpading='5px'>";
        $message .= "<th><td>name</td><td>quantity</td><td>price</td></th>";

        $commandetailsquery = mysqli_query($connect, $query);
        while($commandfetch = mysqli_fetch_assoc($commandetailsquery)){
            $pic = base64_encode($commandfetch['picture']);
            $name = $commandfetch['name'];
            $quanti = $commandfetch['quantité'];
            $price = $quanti * $commandfetch['price'];
            $message .= "<tr>";
            $message .= "<td></td>";
            $message .= "<td><a href='http://localhost//work/projet_copie/form/article.php?id=$name'>$name</a></td>";
            $message .= "<td>$quanti</td>";
            $message .= "<td>$price</td>";
            $message .= "</tr>";
        }
        $message .= "</table>";
        $message .= "total : $total";
        if(mail($to, $subject, $message, $headers)){
            echo "mail envoyé";
        }else{
            echo "erreur mail";
        }
    ?>
    <script>
        console.log("a")
        window.location.href = 'thanks.php';
    </script>

    <?php
    }

}



?>

</html>
