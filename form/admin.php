<?php 

/* -------------------------------- Initialisation --------------------------------- */

include 'dbConn.php';

session_start();

$mail = $_SESSION['mail'];
$lname = $_SESSION['lname'];

$rech  = "SELECT * from `tblstudents` where `email` = '$mail' ";

$res = mysqli_query($connect, $rech);

$usr = mysqli_fetch_assoc($res);

$fname = $usr['firstname'];

$lname = $usr['lastname'];

$from = $usr['ID'];

$verif = "SELECT COUNT(*) AS verif from `basket` where `id_user` = $from";
$verifQuery = mysqli_query($connect, $verif);
$verifFetch = mysqli_fetch_assoc($verifQuery);
$verifInt = (int) $verifFetch['verif'];


/*------------------ Informations section ----------------*/

// If file upload form is submitted 
$status = $statusMsg = ''; 
if(isset($_POST["submit"])){ 
    $status = 'error'; 
    if(!empty($_FILES["image"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            $image = $_FILES['image']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 
         
            // Insert image content into database 
            $insert = " UPDATE `tblstudents` SET `image` = '$imgContent' WHERE `email` = '$mail'"; 
             
            if(mysqli_query($connect, $insert)){ 
                $status = 'success'; 
                $statusMsg = "File uploaded successfully."; 
            }else{ 
                $statusMsg = "File upload failed, please try again."; 
            }  
        }else{ 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        } 
    }else{ 
        $statusMsg = 'Please select an image file to upload.'; 
    } 
} 


/*------------------------ Articles section ---------------------*/

/* ------------ Modify picture ------------------ */

if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}

// On détermine le nombre total d'articles
$sql = 'SELECT COUNT(*) AS nb_articles FROM `article`;';

// On prépare la requête
$query = mysqli_query($connect, $sql);
// $query = $db->prepare($sql);

// On exécute
// $query->execute();

// On récupère le nombre d'articles
$result = mysqli_fetch_assoc($query);
// $result = $query->fetch();

$nbArticles = (int) $result['nb_articles'];


if(isset($_POST['subtrie'])){
    $triArticle = $_POST['triArticle'];
    echo $triArticle;

    $triechoice = "SELECT * FROM `article` ORDER BY `$triArticle` DESC";
    $triechoicequery = mysqli_query($connect, $triechoice);

    while($rowArti = mysqli_fetch_assoc($triechoicequery)){
        $art[] = array(
            'ID' => $rowArti['ID'],
            'name' => $rowArti['name'],
            'desc' => $rowArti['description'],
            'stock' => $rowArti['stock'],
            'price' => $rowArti['price']
        );
    };
    
    $articles = json_encode($art);
    
    $file_name = "../js/articles" . ".json";  
     if(file_put_contents($file_name, $articles))  
     {  
        //echo "<meta http-equiv='refresh' content='0'>";    
     }  
     else  
     {  
          echo 'There is some error';  
     }  
}else{

    $sql = 'SELECT * FROM `article` ORDER BY `ID` DESC ';

    $result = mysqli_query($connect, $sql);

    $art = array();

    while($rowArti = mysqli_fetch_assoc($result)){
        $art[] = array(
            'ID' => $rowArti['ID'],
            'name' => $rowArti['name'],
            'desc' => $rowArti['description'],
            'stock' => $rowArti['stock'],
            'price' => $rowArti['price']
        );
    };

    $articles = json_encode($art);

    $file_name = "../js/articles" . ".json";  
    if(file_put_contents($file_name, $articles))  
    {  
            
    }  
    else  
    {  
        echo 'There is some error';  
    }  
}


/*------------------------ locations section ---------------------*/

if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}

// On détermine le nombre total d'articles
$sql = 'SELECT COUNT(*) AS loc FROM `signals`;';

// On prépare la requête
$query = mysqli_query($connect, $sql);
// $query = $db->prepare($sql);

// On exécute
// $query->execute();

// On récupère le nombre d'articles
$result = mysqli_fetch_assoc($query);

$nblocs = (int) $result['loc'];

$sql = 'SELECT * FROM `signals` ORDER BY `ID` DESC ';

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

$file_name = "../js/locs" . ".json";  
 if(file_put_contents($file_name, $locs))  
 {  
        
 }  
 else  
 {  
      echo 'There is some error';  
 }  


/*------------------------ Users section ---------------------*/

if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}else{
    $currentPage = 1;
}

// On détermine le nombre total d'articles
$sql = 'SELECT COUNT(*) AS nb_users FROM `tblstudents`;';

// On prépare la requête
$query = mysqli_query($connect, $sql);
// $query = $db->prepare($sql);

// On exécute
// $query->execute();

// On récupère le nombre d'articles
$result = mysqli_fetch_assoc($query);

$nbUsers = (int) $result['nb_users'];

$sql = 'SELECT * FROM `tblstudents` ORDER BY `ID` DESC ';

$result = mysqli_query($connect, $sql);


$us = array();

while($row = mysqli_fetch_assoc($result)){

    $usID = $row['ID'];
    $usmail = $row['email'];
    if(isset($_POST["submitChange2_$usID"])){

        $newf = $_POST["newFname2_$usID"];
        $newl = $_POST["newlname2_$usID"];

        $change = "UPDATE tblstudents
        SET `firstname` = '$newf',
        `lastname` = '$newl'
        WHERE `ID` = $usID ";
        $set = mysqli_query($connect, $change);
        echo "<meta http-equiv='refresh' content='0'>";
    }

    if(isset($_POST["$usID"])){
        $dropbask = "DELETE FROM `basket` WHERE id_user = $usID";
        $dropchat = "DELETE FROM `chat` WHERE fromUsr = $usID or toUsr = $usID";
        $dropsignals = "DELETE  FROM `signals` WHERE user = '$usmail'";
        $drop = "DELETE  FROM `tblstudents` WHERE ID = $usID";
        $deletebask = mysqli_query($connect, $dropbask);
        $deletechat = mysqli_query($connect, $dropchat);
        $deletesignals = mysqli_query($connect, $dropsignals);
        $delete = mysqli_query($connect, $drop);
        echo "<meta http-equiv='refresh' content='0'>";
    }

    $us[] = array(
        'ID' => $row['ID'],
        'fname' => $row['firstname'],
        'lname' => $row['lastname'],
        'email' => $row['email'],
        'country' => $row['country']
    );
};

$usrs = json_encode($us);

$file_name = "../js/users" . ".json";  
 if(file_put_contents($file_name, $usrs))  
 {  
        
 }  
 else  
 {  
      echo 'There is some error';  
 }  


/*---------------------------------- edit info -----------------------------------*/

if(isset($_POST['submitChange'])){
    $newf = $_POST['newFname'];
    $newl = $_POST['newlname'];

    $change = "UPDATE tblstudents
    SET `firstname` = '$newf',
    `lastname` = '$newl'
    WHERE `ID` = $from ";
    $set = mysqli_query($connect, $change);
    echo "<meta http-equiv='refresh' content='0'>";

}


?>
 
<!--------------------------------------------- Html ----------------------------------------->

 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/settings.css">
    <link rel="stylesheet" href="../css/head.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="shortcut icon" href="../images/logo" />
    <title>Admin settings</title>
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

<!------------------------------------- Main conten ------------------------------------------> 
    
    <div class="container">

        <!-------------------------------- Menu section -------------------------------->
        <div class="menus">
            <div class="top">
                <h3 class="textcolor">Settings</h3>
            </div>
            <div class="bottom">
                    <input type="button" value="informations" id="info" class="inputColor">
                    <input type="button" value="articles" id="articles" class="inputColor">
                    <input type="button" value="users" id="user" class="inputColor">
                    <input type="button" value="location" id="locations" class="inputColor">
            </div>
        </div>

        <!-------------------------------- Content section -------------------------------->
        
        <div class="content">
            <!-------------------- Information section ------------------------>
            <div class="informations invisible">                
                    <?php 
                        $result = mysqli_query($connect, "SELECT image FROM tblstudents where email = '$mail'" );
                        $row = mysqli_fetch_assoc($result)
                    ?> 
                    <div class="main">
                        <div class="left">

                            <h5 class="textcolor">mail</h5>
                            <h6> <?php echo " $mail "; ?> </h6>   

                            <h5 class="textcolor">Name</h5>
                            <h6> <?php echo " $fname "; ?> </h6>

                            <form action="" method="post" id="formulaire">
                                <input type="color" name="color" id="color" value = "change color theme">
                            </form>

                            <a href="logout.php" class="textcolor"> log out</a>
                            
                        </div>
                        <div class="right">
                            <div class="gallery">
                                <img alt="image" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($usr['image']);?>">
                            </div>
                            <form action="#" method="post" enctype="multipart/form-data">
                                <input type="file" class="btn btn-primary upload" name="image" id="image-input" accept="image/jpeg, image/png, image/jpg" value="modify picture">
                                <input type="submit" id="newpic" name="submit" value = "✔️">
                            </form>
                        </div>
                    </div>

                    <div class="other">
                        <form action="" method="post" id = "changeValues">
                            <div class="names">

                                <div class="fname">
                                        <h5 class="textcolor">firstname</h5>
                                        <input class="info" type="text" placeholder="<?php echo  $fname; ?>" name = "country">
                                </div>
                                
                                <div class="lname">
                                    <h5 class="textcolor">lastname</h5>
                                    <input class="info" type="text" placeholder="<?php echo  $lname; ?>" name = "country">
                                </div>
                                
                            </div>
                                <h5 class="textcolor">Country</h5>
                                <input class="info" type="text" placeholder="<?php echo  $usr['country']; ?>" name = "country">
                        </form>    

                            <h5 class="textcolor">Password</h5>
                            <h6> ******** </h6> 
                            
                        <button id="changeForm" class="btn btn-primary" >change informations</button>

                        <div id="test" class="disp_none" >
                            <form method="post">
                                <div class="form-group">
                                    <label for="newFname" class="textcolor">first name</label>
                                    <input type="text" name="newFname" class="form-control" id="newFname" aria-describedby="emailHelp" placeholder="Enter new first name" required>
                                </div>
                                <div class="form-group">
                                    <label for="newlname" class="textcolor">last name</label>
                                    <input type="text" name="newlname" class="form-control" id="newlname" placeholder="enter new last name" required>
                                </div>
                                <div class="butts">
                                    <button type="submit" name="submitChange" class="btn btn-primary">Submit</button>
                                    <button type="submit" name="Close" id="close" class="btn btn-primary">Close</button>
                                </div>
                            </form>
                        </div>

                    </div>  
            </div>
            
            <!-------------------- articles section ------------------------>
            <div class="articles invisible">
                <div class="usertop">
                    <h1> All Articles </h1>
                </div>
                <div id="all_articles">
                    <nav class="nav_article">
                        <div class="buts">
                            <button id="precedent_art" class="btn btn-primary"> précédent </button>
                            <button id="suivant_art" class="btn btn-primary"> suivant </button>
                            <a href="add.php" target="_blank" class="textColor"> add article</a>
                        </div>
                        <form action="" method="post">
                            <select id="triArticle" name="triArticle" required>
                                <option value="price">Price</option>
                                <option value="stock">quantity</option>
                                <option value="ID">ID</option>
                            </select>
                            <input type="submit" value="✔️" name="subtrie">
                        </form>
                    </nav>
                </div>
            </div>
            
            <!-------------------- users section ------------------------>
            <div class="user invisible"> 
                <div class="usertop">
                    <h1> All users </h1>
                </div>
                <div id="all_usr">
                    <div id="test2" class="disp_none">
                        <form method="post">
                            <div class="form-group">
                                <label for="newFname2">first name</label>
                                <input type="text" class="form-control" id="newFname2" aria-describedby="emailHelp" placeholder="Enter new first name" required>
                            </div>
                            <div class="form-group">
                                <label for="newlname2">last name</label>
                                <input type="text" class="form-control" id="newlname2" placeholder="enter new last name" required>
                            </div>
                            <div class="butts">
                                <button type="submit" id="submitChange2" class="btn btn-primary">Submit</button>
                                <button type="submit" id="close2" class="btn btn-primary">Close</button>
                            </div>
                        </form>
                    </div>
                    <nav>
                        <button id="precedent_usr" class="btn btn-primary"> précédent </button>
                        <button id="suivant_usr" class="btn btn-primary"> suivant </button>
                        <input type="text" id="searchbar" placeholder="username" name="user" onkeyup="search()">

                    </nav>
                    
                </div>
            </div>

            <!-------------------- locations section ------------------------>
            <div class="locations invisible">
                <div class="loctop">
                        <h1> All Locations </h1>
                    </div>
                    <div id="all_locations">
                        <nav>
                            <button id="precedent_loc" class="btn btn-primary"> précédent </button>
                            <button id="suivant_loc" class="btn btn-primary"> suivant </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!--------------------------------------------- scipt ----------------------------------------->

<script>
    /* ----------------------- initialisation ----------------------- */
    let page = 0;
    const itemsPerPage = 8; // nbr lines per page

    const usersCount = <?php echo $nbUsers; ?>; // total users
    const artiCount = <?php echo $nbArticles; ?>; // total articles
    const locCount = <?php echo $nblocs; ?>; // total locations

    const totalpagesusr = (usersCount / 8) + 1;
    const totalpagesarti = (artiCount / 8) + 1;
    const totalpagesloc = (locCount / 8) + 1;

   
</script>                   


<style>
 body{
    background-color: #DDDD;
}
</style>


</body>

<script src="../js/admin.js"></script>

</html>