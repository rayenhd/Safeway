<?php 

/* --------------------------- Initialisation ------------------------- */

include 'dbConn.php';

session_start();

$mail = $_SESSION['mail'];

$rech  = "SELECT * from `tblstudents` where `email` = '$mail' ";

$res = mysqli_query($connect, $rech);

$usr = mysqli_fetch_assoc($res);

$from = $usr['ID'];

$verif = "SELECT COUNT(*) AS verif from `basket` where `id_user` = $from";
$verifQuery = mysqli_query($connect, $verif);
$verifFetch = mysqli_fetch_assoc($verifQuery);
$verifInt = (int) $verifFetch['verif'];

$msg = "SELECT DISTINCT `fromUsr`, `toUsr` from `chat` where `fromUsr` = '$from' or `toUsr` = '$from' ORDER BY `id` DESC";

$quer =  mysqli_query($connect, $msg);

$cr = "SELECT * from chat";


if(isset($_POST['newsubmit'])){
    $newmsg = $_POST['newMsg'];
    $newusr = $_POST['newUsr'];

    $verif = "SELECT * FROM `tblstudents` where `email` = '$newusr' ";
    $verifquery = mysqli_query($connect, $verif);
    $verifetch = mysqli_fetch_assoc($verifquery);

    if(strlen($verifetch['email']) > 0){
        $verifnew = $verifetch['ID'];
        $addnew = "INSERT INTO `chat` (`fromUsr`, `toUsr`, `message`, `sentdate`) VALUES ('$from', '$verifnew', '$newmsg', NOW())";
        $addquery = mysqli_query($connect, $addnew);
        echo "<meta http-equiv='refresh' content='0'>";
    }
}

?>

<!-------------------------------------- html -------------------------------------->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/head.css">
    <link rel="stylesheet" href="../css/chat.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/0807d00da4.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="../images/logo" />
    <title>Chat</title>
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
            <a href="<?php echo $link;?>" >
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

<div id="newmsg" class=" left">

    <div class="newtop">
        <h1>Send New Message</h1>
        <button id="slide" >⬅</button>
    </div>

    <form method="post" class="newform">
        <label for="newUsr">User Mail</label>
        <input type="text" name="newUsr" placeholder="user" required>
        <label for="newMsg">Message</label>
        <input type="text" name="newMsg" placeholder="message" required>
        <input type="submit" name="newsubmit" value="send">
    </form>
    
</div>


<div class="container">

    <div class="menus" id="menus">
        <ul>
            <?php 
                while($user = mysqli_fetch_assoc($quer)){
                    if($user['fromUsr'] == $usr['ID'] || $user['toUsr'] == $usr['ID']){
                        if ($user['toUsr'] != $usr['ID'] ){
                            $receiver = $user['toUsr'];
                            $toWho = "SELECT * from `chat` join `tblstudents` on chat.toUsr = tblstudents.ID where `toUsr` = '$receiver'  ";
                            $toWhoQuery = mysqli_query($connect, $toWho);
                            $toWhoFetch = mysqli_fetch_assoc($toWhoQuery); 
                            ?>
                                <script> 
                                    test = document.getElementById('info_<?php echo $receiver;?>')
                                    if(test == null){
                                        var x = document.createElement("INPUT");

                                        x.setAttribute("type", "button");
                                        x.classList.add("personne");
                                        x.setAttribute("value", "<?php echo $toWhoFetch['email'];?>");
                                        x.setAttribute("id", "info_<?php echo $receiver;?>");
                                        document.querySelector(".menus").appendChild(x);
                                    }
                                </script>
                            <?php  
                            
                        }else if($user['toUsr'] == $usr['ID']) {
                            $receiver = $user['fromUsr'];
                            $toWho = "SELECT * from `chat` join `tblstudents` on chat.fromUsr = tblstudents.ID where `fromUsr` = '$receiver' ";
                            $toWhoQuery = mysqli_query($connect, $toWho);
                            $toWhoFetch = mysqli_fetch_assoc($toWhoQuery); 
                            ?>
                                <script> 
                                    if(document.getElementById('info_<?php echo $receiver;?>') == null){
                                        var x = document.createElement("INPUT");
                                        x.setAttribute("type", "button");
                                        x.classList.add('personne');
                                        x.setAttribute("value", "<?php echo $toWhoFetch['email'];?>");
                                        x.setAttribute("id", "info_<?php echo $receiver;?>");
                                        document.querySelector(".menus").appendChild(x);
                                    }
                                </script>
                            <?php
                            } 
                    }
                }                                                  
            ?>
        </ul>
        <form action="" method="post">
            <input type="text" id="searchbar" placeholder="username" name="user" onkeyup="search()">
            <button type="button" name="checkusr" value="check" id="newrite"> <i class="fa-regular fa-pen-to-square"></i></button>
        </form>

        <script>
            function search() {
                let input = document.getElementById('searchbar').value
                input=input.toLowerCase();
                let x = document.getElementsByClassName('personne');
                
                for (i = 0; i < x.length; i++) { 
                    if (!x[i].value.toLowerCase().includes(input)) {
                        x[i].style.display="none";
                    }
                    else {
                        x[i].style.display="list-item";                 
                    }
                    document.getElementById('menus').classList.add('searchflex');
                }

                if(input.length < 1){
                    document.getElementById('menus').classList.remove('searchflex');
                }

            }

            document.getElementById('newrite').addEventListener('click', () => {
                document.getElementById('newmsg').classList.add('right');
                document.getElementById('newmsg').classList.remove('left');
            })

            document.getElementById('slide').addEventListener('click', () => {
                document.getElementById('newmsg').classList.add('left');
                document.getElementById('newmsg').classList.remove('right');
            })

        </script>

    </div>

    <div class="content">

        <div class="title">
            <h3 class="nameID" >hello</h3>
        </div>

        <?php     
            $content = mysqli_query($connect, $msg);
            while($cont = mysqli_fetch_assoc($content)){
        ?>
                <?php   
                    if($cont['fromUsr'] == $usr['ID'] || $cont['toUsr'] == $usr['ID']){
                        $id = $cont['fromUsr'];
                        $to = $cont['toUsr'];
                        $userCurrent = $usr['ID'];
                        if($cont['fromUsr'] == $usr['ID']){
                            $receiv = $cont['toUsr'];
                            $crea = "SELECT * FROM `chat` where `toUsr` = '$receiv'";
                            $creaQuery = mysqli_query($connect, $crea);
                            $creaFetch = mysqli_fetch_assoc($creaQuery);
                        }else if($cont['fromUsr'] != $usr['ID']){
                            $receiv = $cont['fromUsr'];
                            $crea = "SELECT * FROM `chat` where `fromUsr` = '$receiv'";
                            $creaQuery = mysqli_query($connect, $crea);
                            $creaFetch = mysqli_fetch_assoc($creaQuery);
                        }
                        $chat = "SELECT * from `chat` where (`fromUsr` = '$receiv' AND `toUsr` = '$userCurrent') OR (`fromUsr` = '$userCurrent' AND `toUsr` = '$receiv') ";
                        $chatQuery = mysqli_query($connect, $chat); 
                ?>
                <script>
                    teste = document.getElementById('disp_<?php echo $receiv;?>');
                    if (teste != null){
                        console.log('not empty');
                    }else if(teste == null){
                        var msg = document.createElement("div");
                        var texte = document.createElement("input");
                        var form = document.createElement("form");
                        var submit = document.createElement("button");
                        var emoji = document.createElement("i");

                        form.setAttribute('method', 'post');
                        texte.setAttribute('type', 'texte');
                        texte.setAttribute('class', 'newmsg');
                        texte.setAttribute('placeholder', 'Write A Message');
                        texte.setAttribute('id', 'texto<?php echo $receiv;?>');
                        texte.setAttribute('name', 'texto<?php echo $receiv;?>');

                        submit.setAttribute('type', 'submit');
                        emoji.setAttribute('class', 'fa-solid fa-paper-plane');

                        submit.setAttribute('name', 'send<?php echo $receiv;?>');
                        submit.append(emoji);
                        
                        form.append(texte,submit);
                        msg.append(form);

                        msg.setAttribute('id', 'disp_<?php echo $receiv;?>');
                        msg.classList.add("invisible");
                        msg.classList.add("textos");
                        document.querySelector(".content").append(msg);                       
                        
                    }

                    <?php 
                        while($chatFetch = mysqli_fetch_assoc($chatQuery)){?>
                            
                             message = document.createElement('div');
                            if(<?php echo $chatFetch['fromUsr'];?> == <?php echo $userCurrent;?>){
                                message.classList.add('fromCurrent');
                            }else{
                                message.classList.add('toCurrent');
                            }

                            messages = document.createElement('h3')
                            messages.textContent ="<?php echo $chatFetch['message'];?>";
                            message.append(messages);
                            document.querySelector('#disp_<?php echo $receiv;?>').prepend(message)
                            
                        <?php
                        } 
                    ?>
   
                </script>
        <?php    
                    }
            }  
                    
        ?>            
    </div>
</div>

<?php 
$post = array();
$messages = "SELECT DISTINCT `fromUsr`, `toUsr` from `chat` where fromUsr = '$from' OR toUsr = '$from' ORDER BY `id` DESC";
$messagesQuery = mysqli_query($connect, $msg);
while ($receive = mysqli_fetch_assoc($messagesQuery)){
    if($receive['fromUsr'] == $from){
        $active = $receive['toUsr'];
    }else{
        $active = $receive['fromUsr'];
    }
    if(isset($_POST["send$active"])){
        $verifValue = 0;
        
        foreach ($post as $postValue){
            if($postValue == $active){
                $verifValue = 1;
            }
        }

        array_push($post, $active);
        if($verifValue == 0){
            $chat = $_POST["texto$active"];
            if($receive['fromUsr'] == $from){
                $newmsg = "INSERT INTO `chat` (`fromUsr`, `toUsr`, `message`, `sentdate`) VALUES ('$from', '$active', '$chat', NOW())";
            }else{
                $newmsg = "INSERT INTO `chat` (`fromUsr`, `toUsr`, `message`, `sentdate`) VALUES ('$from', '$active', '$chat', NOW())";
            }
            if($newmsgQuery = mysqli_query($connect, $newmsg)){
                echo "<meta http-equiv='refresh' content='0'>";
            }

        }
            
    }
}


if(isset($_POST['checkusr'])){

    $to = $_POST['user'];
    $_SESSION['to'] = $to;
    $from = $_SESSION['mail'];

    $query = "SELECT * from `tblstudents` where `email` = '$to' ";
    
    $result = mysqli_query($connect, $query);

    $row = mysqli_fetch_assoc($result);

    $count = mysqli_num_rows($result);

    if($count == 1){
    echo "send message to ";
    echo $row['firstname'];

?>

    <form action="" method="post">
            <input type="text" placeholder="message" name="chat">
            <input type="submit" name="sendmessage" value="send">
    </form>

<?php

    }
    }
    if(isset($_POST['sendmessage'])){

        $to =  $_SESSION['to'];
        $from = $_SESSION['mail'];

        echo "sending... to";
        echo $to;
        $message = $_POST['chat'];
       
    }

?>

</div>

</body>

<script>
        /* ------------------------- menu settings ------------------------ */

        <?php
            $create = mysqli_query($connect, $msg);
            while($test = mysqli_fetch_assoc($create)){;
                if($test['fromUsr'] == $usr['ID'] || $test['toUsr'] == $usr['ID']){
                    if ($test['toUsr'] != $usr['ID']){
                        $receiver = $test['toUsr'];
                        echo "test";
                        $towhotitle  = "SELECT * FROM `tblstudents` join `chat` on tblstudents.ID = chat.toUsr where `toUsr` = '$receiver'";
                    }else{
                        $receiver = $test['fromUsr'];
                        $towhotitle  = "SELECT * FROM `tblstudents` join `chat` on tblstudents.ID = chat.fromUsr where `fromUsr` = '$receiver'";
                    }

                    $towhotitleQuery = mysqli_query($connect, $towhotitle);
                    $toWhotitleFetch = mysqli_fetch_assoc($towhotitleQuery);
                    $email = $toWhotitleFetch['email'];
        ?>                                         
                    disp_<?php echo $receiver;?> = document.querySelector("#disp_<?php echo $receiver;?>");
                    select_<?php echo $receiver; ?> = document.getElementById('info_<?php echo $receiver; ?>');

                    select_<?php echo $receiver; ?>.addEventListener("click", () => {
                        document.querySelector('.nameID').textContent = '<?php echo $email; ?>';
                
                        disp_<?php echo $receiver;?>.classList.remove("invisible");
                        disp_<?php echo $receiver; ?>.classList.add("textos");
                        <?php 
                            $to = $receiver;
                            $id = $usr['ID'];
                            $diff = "SELECT * from `chat` where (`fromUsr` != '$to' and `toUSr` = '$from')  OR (`toUsr` != '$to' and `fromUsr` = '$from')";
                            $difference = mysqli_query($connect, $diff);

                            while($d = mysqli_fetch_assoc($difference)){
                                if($d['toUsr'] == $usr['ID']){
                                    $too = $d['fromUsr'];
                                }else{
                                    $too = $d['toUsr'];
                                }
                                ?>
                                disp_<?php echo $too; ?>.classList.add("invisible");
                                disp_<?php echo $too; ?>.classList.remove("textos");
                            <?php
                            }
                        ?>
                       
                       
                    });

            <?php 
                }
            } 
            ?>                            

    </script> 


</html>


