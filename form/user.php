<?php

include('dbConn.php');

session_start();

$mail = $_SESSION['mail'];

$rech  = "SELECT * from `tblstudents` where `email` = '$mail' ";

$res = mysqli_query($connect, $rech);

$usr = mysqli_fetch_assoc($res);

$from = $usr['ID'];
$fname = $usr['firstname'];
$lname = $usr['lastname'];

$verif = "SELECT COUNT(*) AS verif from `basket` where `id_user` = $from";
$verifQuery = mysqli_query($connect, $verif);
$verifFetch = mysqli_fetch_assoc($verifQuery);
$verifInt = (int) $verifFetch['verif'];


/* --------------------------------------- input picture ------------------------------------------- */ 

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
    echo "<meta http-equiv='refresh' content='0'>";
} 
 


/*---------------------------------- edit info -----------------------------------*/

if(isset($_POST['submitChange'])){
    $newf = $_POST['newFname'];
    $newl = $_POST['newlname'];

    $change = "UPDATE `tblstudents`
    SET `firstname` = '$newf',
    `lastname` = '$newl'
    WHERE `ID` = $from ";
    if($set = mysqli_query($connect, $change)){
        echo "succ";
    };
    echo "<meta http-equiv='refresh' content='0'>";

}

?>

<!------------------------------------- html ------------------------------------------>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="../css/user.css">
    <link rel="stylesheet" type="text/css" href="../css/head.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo" />
    <title>Document</title>
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
</header>

<!------------------------------------------- User Section ------------------------------------------->

    <div class="padding">
        <div class="row container d-flex justify-content-center">
            <div class="col-xl-6 col-md-12">
                <div class="card">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-4 bg-c-lite-green user-profile" style="padding: 1.25 rem;">
                            <div class="top" style="padding: 1.25rem;">
                                <div class="gallery" id="display-image"> 
                                    <?php 
                                        $result = mysqli_query($connect, "SELECT image FROM tblstudents where email = '$mail'" );
                                        $row = mysqli_fetch_assoc($result)
                                    ?> 
                                    <?php
                                        if($usr['image'] == null){?>
                                            <img src="../images/userdefault.png" alt="">
                                        <?php
                                        }else{
                                        ?>
                                        <img alt="image" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($usr['image']);?>">
                                    <?php } ?>
                                </div>

                                <form action="#" method="post" enctype="multipart/form-data">
                                <input type="file" name="image" id="image-input" accept="image/jpeg, image/png, image/jpg" value="modify picture">
                                <input type="submit" name="submit">
                                </form>
                                
                                <h1> <?php echo " $fname "; ?> </h1>   
                            </div>
                        </div>
                        <div class="col-sm-8" style = "background-color: white;">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                <div class="row mid">
                                    <div class="mid1">
                                        <div class="col-sm-6">
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">First name</p>
                                                <h6 class="text-muted f-w-400"><?php echo " $fname "; ?></h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Last Name</p>
                                                <h6 class="text-muted f-w-400"><?php echo " $lname "; ?></h6>
                                            </div>    
                                                <p class="m-b-10 f-w-600">Email</p>
                                                <h6 class="text-muted f-w-400"><?php echo " $mail "; ?></h6>
                                            </div>
                                            <button id="changeForm">change informations</button>
                                        </div>
                                    <div class="mid2">
                                        <div id="test" class="disp_none" style="padding: 1.5 rem;">
                                            <form method="post">
                                                <div class="form-group">
                                                    <label for="newFname">first name</label>
                                                    <input type="text" name="newFname" class="form-control" id="newFname" aria-describedby="emailHelp" placeholder="Enter new first name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="newlname">last name</label>
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
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Password</p>
                                    <h6 class="text-muted f-w-400">**********</h6>
                                </div>
                                <h6 class="text-muted f-w-400">
                                        <a href="logout.php">Log Out</a>
                                    </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>

<style>
    body{
        margin: 0;
        padding: 0;
        background-color: #393838;
    }
</style>

<script src="../js/openform.js"></script>

</html>