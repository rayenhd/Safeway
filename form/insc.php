
<?php
include 'dbConn.php';



if (isset($_POST['btnRegister'])) {
    $fname=$_POST['first_name'];
    $lname=$_POST['last_name'];
    $Email=$_POST['email_address'];
    $passw= md5($_POST['password']);
    $country=$_POST['country'];

    $query1 = "SELECT * from tblstudents";

    $result1 = mysqli_query($connect, $query1);

    $valid = 'true';

    $row = mysqli_fetch_assoc($result1);

    while (($row = mysqli_fetch_assoc($result1)) && $valid == true){
        
        if($row['email'] === $Email){
            $valid = false; 
        }  
    
    } 

    if($valid == true){
        $query = "INSERT INTO `tblstudents`(`firstname`, `lastname`, `email`, `password`, `country`) VALUES ('$fname','$lname','$Email','$passw','$country')";
        if (mysqli_query($connect, $query)) {

            $to = $Email;
            $subject = "Utilisation de mail() avec PHP depuis Windows";
            $message = "Salut, comment ça va ? ";
            $headers = "Content-Type: text/plain; charset=utf-8\r\n";
            $headers .= "From: rayen.haddad@gmail.com\r\n";
            if (mail($to, $subject, $message, $headers)) {
                echo "mail envoyé";

                // header("refresh:1;url=connexion.php");
            } else {
                echo "erreur mail";
            }
        } 
    }
    else{
        echo'Error in added';
    }
}
else{
    echo "Erreur le mail existe déja ";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/formulaire.css"> 
	<link rel="stylesheet" type="text/css" href="../css/footer.css">
	<link rel="stylesheet" type="text/css" href="../css/tete.css">
	<link rel="stylesheet" type="text/css" href="../css/apparition.css">
	<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
	<link rel="shortcut icon" href="../images/logo" />
	<title> Join Us </title>
</head>
 <body>

 <body>

    <div class="haut">
        <nav class="tete" id="test">
            <a href="../html/main.html"> <img alt="logo" src="../images/logo"></a>
            <ul>
                <li><a href="../html/propos.html"> About us </a>
                <li><a href="insc.php"> Rejoins nous </a></li>
                <li><a href="../html/competence.html"> Content </a></li>
            </ul>
        </nav>
    </div>
	
	<div class="container">
		<div class="menu reveal">
			<div class="titres">
				<h1> Register </h1>
				<h2> So that you too can come home safe </h2>
			</div>

            <form action="" method="post" id="register" enctype="multipart/form-data">
                <div class="forme">
                    <div>
                        <label for="first_name"></label>
                            <input type="text" name="first_name" id = "fname" placeholder="first name" required>
                            <p id="suitenom"></p>
                    </div>
                
                    <div>
                        <label for="last_name"></label>
                            <input type="text" name="last_name" id = "lname" placeholder="last_name" required>
                            <p id="suiteprenom"></p>
                    </div>

                    <div>
                        <label for="mail"></label>
                            <input type="email" name="email_address" id = "mail" placeholder="mail" required>
                            <p id="suitemail"> </p>
                    </div>

                    <div>
                        <label for="password"></label>
                            <input type="password" name="password" id = "pass" placeholder="password"  required>
                    </div>	

                    <div>
                        <select id="country" name="country" required>
                            <option value="Afghanistan">Afghanistan</option>
                            <option value="Aland Islands">Aland Islands</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antarctica">Antarctica</option>
                            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                            <option value="Argentina">Argentina</option>
                            <option value="Armenia">Armenia</option>
                            <option value="Aruba">Aruba</option>
                            <option value="Australia">Australia</option>
                            <option value="Austria">Austria</option>
                            <option value="Azerbaijan">Azerbaijan</option>
                            <option value="Bahamas">Bahamas</option>
                            <option value="Bahrain">Bahrain</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Barbados">Barbados</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Belgium">Belgium</option>
                            <option value="Belize">Belize</option>
                            <option value="Benin">Benin</option>
                            <option value="Bermuda">Bermuda</option>
                            <option value="Bhutan">Bhutan</option>
                            <option value="Bolivia">Bolivia</option>
                            <option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
                            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                            <option value="Botswana">Botswana</option>
                            <option value="Bouvet Island">Bouvet Island</option>
                            <option value="Brazil">Brazil</option>
                            <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                            <option value="Brunei Darussalam">Brunei Darussalam</option>
                            <option value="Bulgaria">Bulgaria</option>
                            <option value="Burkina Faso">Burkina Faso</option>
                            <option value="Burundi">Burundi</option>
                            <option value="Cambodia">Cambodia</option>
                            <option value="Cameroon">Cameroon</option>
                            <option value="Canada">Canada</option>
                            <option value="Cape Verde">Cape Verde</option>
                            <option value="Cayman Islands">Cayman Islands</option>
                            <option value="Central African Republic">Central African Republic</option>
                            <option value="Chad">Chad</option>
                            <option value="Chile">Chile</option>
                            <option value="China">China</option>
                            <option value="Christmas Island">Christmas Island</option>
                            <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                            <option value="Colombia">Colombia</option>
                            <option value="Comoros">Comoros</option>
                            <option value="Congo">Congo</option>
                            <option value="Congo, Democratic Republic of the Congo">Congo, Democratic Republic of the Congo</option>
                            <option value="Cook Islands">Cook Islands</option>
                            <option value="Costa Rica">Costa Rica</option>
                            <option value="Cote D'Ivoire">Cote D'Ivoire</option>
                            <option value="Croatia">Croatia</option>
                            <option value="Cuba">Cuba</option>
                            <option value="Curacao">Curacao</option>
                            <option value="Cyprus">Cyprus</option>
                            <option value="Czech Republic">Czech Republic</option>
                            <option value="Denmark">Denmark</option>
                            <option value="Djibouti">Djibouti</option>
                            <option value="Dominica">Dominica</option>
                            <option value="Dominican Republic">Dominican Republic</option>
                            <option value="Ecuador">Ecuador</option>
                            <option value="Egypt">Egypt</option>
                            <option value="El Salvador">El Salvador</option>
                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                            <option value="Eritrea">Eritrea</option>
                            <option value="Estonia">Estonia</option>
                            <option value="Ethiopia">Ethiopia</option>
                            <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                            <option value="Faroe Islands">Faroe Islands</option>
                            <option value="Fiji">Fiji</option>
                            <option value="Finland">Finland</option>
                            <option value="France">France</option>
                            <option value="French Guiana">French Guiana</option>
                            <option value="French Polynesia">French Polynesia</option>
                            <option value="French Southern Territories">French Southern Territories</option>
                            <option value="Gabon">Gabon</option>
                            <option value="Gambia">Gambia</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Germany">Germany</option>
                            <option value="Ghana">Ghana</option>
                            <option value="Gibraltar">Gibraltar</option>
                            <option value="Greece">Greece</option>
                            <option value="Greenland">Greenland</option>
                            <option value="Grenada">Grenada</option>
                            <option value="Guadeloupe">Guadeloupe</option>
                            <option value="Guam">Guam</option>
                            <option value="Guatemala">Guatemala</option>
                            <option value="Guernsey">Guernsey</option>
                            <option value="Guinea">Guinea</option>
                            <option value="Guinea-Bissau">Guinea-Bissau</option>
                            <option value="Guyana">Guyana</option>
                            <option value="Haiti">Haiti</option>
                            <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                            <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                            <option value="Honduras">Honduras</option>
                            <option value="Hong Kong">Hong Kong</option>
                            <option value="Hungary">Hungary</option>
                            <option value="Iceland">Iceland</option>
                            <option value="India">India</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                            <option value="Iraq">Iraq</option>
                            <option value="Ireland">Ireland</option>
                            <option value="Isle of Man">Isle of Man</option>
                            <option value="Italy">Italy</option>
                            <option value="Jamaica">Jamaica</option>
                            <option value="Japan">Japan</option>
                            <option value="Jersey">Jersey</option>
                            <option value="Jordan">Jordan</option>
                            <option value="Kazakhstan">Kazakhstan</option>
                            <option value="Kenya">Kenya</option>
                            <option value="Kiribati">Kiribati</option>
                            <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                            <option value="Korea, Republic of">Korea, Republic of</option>
                            <option value="Kosovo">Kosovo</option>
                            <option value="Kuwait">Kuwait</option>
                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                            <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                            <option value="Latvia">Latvia</option>
                            <option value="Lebanon">Lebanon</option>
                            <option value="Lesotho">Lesotho</option>
                            <option value="Liberia">Liberia</option>
                            <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                            <option value="Liechtenstein">Liechtenstein</option>
                            <option value="Lithuania">Lithuania</option>
                            <option value="Luxembourg">Luxembourg</option>
                            <option value="Macao">Macao</option>
                            <option value="Macedonia, the Former Yugoslav Republic of">Macedonia, the Former Yugoslav Republic of</option>
                            <option value="Madagascar">Madagascar</option>
                            <option value="Malawi">Malawi</option>
                            <option value="Malaysia">Malaysia</option>
                            <option value="Maldives">Maldives</option>
                            <option value="Mali">Mali</option>
                            <option value="Malta">Malta</option>
                            <option value="Marshall Islands">Marshall Islands</option>
                            <option value="Martinique">Martinique</option>
                            <option value="Mauritania">Mauritania</option>
                            <option value="Mauritius">Mauritius</option>
                            <option value="Mayotte">Mayotte</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                            <option value="Moldova, Republic of">Moldova, Republic of</option>
                            <option value="Monaco">Monaco</option>
                            <option value="Mongolia">Mongolia</option>
                            <option value="Montenegro">Montenegro</option>
                            <option value="Montserrat">Montserrat</option>
                            <option value="Morocco">Morocco</option>
                            <option value="Mozambique">Mozambique</option>
                            <option value="Myanmar">Myanmar</option>
                            <option value="Namibia">Namibia</option>
                            <option value="Nauru">Nauru</option>
                            <option value="Nepal">Nepal</option>
                            <option value="Netherlands">Netherlands</option>
                            <option value="Netherlands Antilles">Netherlands Antilles</option>
                            <option value="New Caledonia">New Caledonia</option>
                            <option value="New Zealand">New Zealand</option>
                            <option value="Nicaragua">Nicaragua</option>
                            <option value="Niger">Niger</option>
                            <option value="Nigeria">Nigeria</option>
                            <option value="Niue">Niue</option>
                            <option value="Norfolk Island">Norfolk Island</option>
                            <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                            <option value="Norway">Norway</option>
                            <option value="Oman">Oman</option>
                            <option value="Pakistan">Pakistan</option>
                            <option value="Palau">Palau</option>
                            <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                            <option value="Panama">Panama</option>
                            <option value="Papua New Guinea">Papua New Guinea</option>
                            <option value="Paraguay">Paraguay</option>
                            <option value="Peru">Peru</option>
                            <option value="Philippines">Philippines</option>
                            <option value="Pitcairn">Pitcairn</option>
                            <option value="Poland">Poland</option>
                            <option value="Portugal">Portugal</option>
                            <option value="Puerto Rico">Puerto Rico</option>
                            <option value="Qatar">Qatar</option>
                            <option value="Reunion">Reunion</option>
                            <option value="Romania">Romania</option>
                            <option value="Russian Federation">Russian Federation</option>
                            <option value="Rwanda">Rwanda</option>
                            <option value="Saint Barthelemy">Saint Barthelemy</option>
                            <option value="Saint Helena">Saint Helena</option>
                            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                            <option value="Saint Lucia">Saint Lucia</option>
                            <option value="Saint Martin">Saint Martin</option>
                            <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                            <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                            <option value="Samoa">Samoa</option>
                            <option value="San Marino">San Marino</option>
                            <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                            <option value="Saudi Arabia">Saudi Arabia</option>
                            <option value="Senegal">Senegal</option>
                            <option value="Serbia">Serbia</option>
                            <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                            <option value="Seychelles">Seychelles</option>
                            <option value="Sierra Leone">Sierra Leone</option>
                            <option value="Singapore">Singapore</option>
                            <option value="Sint Maarten">Sint Maarten</option>
                            <option value="Slovakia">Slovakia</option>
                            <option value="Slovenia">Slovenia</option>
                            <option value="Solomon Islands">Solomon Islands</option>
                            <option value="Somalia">Somalia</option>
                            <option value="South Africa">South Africa</option>
                            <option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                            <option value="South Sudan">South Sudan</option>
                            <option value="Spain">Spain</option>
                            <option value="Sri Lanka">Sri Lanka</option>
                            <option value="Sudan">Sudan</option>
                            <option value="Suriname">Suriname</option>
                            <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                            <option value="Swaziland">Swaziland</option>
                            <option value="Sweden">Sweden</option>
                            <option value="Switzerland">Switzerland</option>
                            <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                            <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                            <option value="Tajikistan">Tajikistan</option>
                            <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Timor-Leste">Timor-Leste</option>
                            <option value="Togo">Togo</option>
                            <option value="Tokelau">Tokelau</option>
                            <option value="Tonga">Tonga</option>
                            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                            <option value="Tunisia">Tunisia</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Turkmenistan">Turkmenistan</option>
                            <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                            <option value="Tuvalu">Tuvalu</option>
                            <option value="Uganda">Uganda</option>
                            <option value="Ukraine">Ukraine</option>
                            <option value="United Arab Emirates">United Arab Emirates</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="United States">United States</option>
                            <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                            <option value="Uruguay">Uruguay</option>
                            <option value="Uzbekistan">Uzbekistan</option>
                            <option value="Vanuatu">Vanuatu</option>
                            <option value="Venezuela">Venezuela</option>
                            <option value="Viet Nam">Viet Nam</option>
                            <option value="Virgin Islands, British">Virgin Islands, British</option>
                            <option value="Virgin Islands, U.s.">Virgin Islands, U.s.</option>
                            <option value="Wallis and Futuna">Wallis and Futuna</option>
                            <option value="Western Sahara">Western Sahara</option>
                            <option value="Yemen">Yemen</option>
                            <option value="Zambia">Zambia</option>
                            <option value="Zimbabwe">Zimbabwe</option>
                        </select>

                        <a href = "connexion.php"> already register ? logsin</a>

                    </div>

                    <input type="file" name="image" value="../images/userdefault.png" style="display: none;">
                    
                    <div class="formGroupe">
                        <input type="submit" value="Register" name="btnRegister" class="buttonSub" >
                        <input type="reset" value="Reset" class="buttonSub" onclick="supprimer()">
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>    

<script>
    form = document.getElementById("register");
console.log(form);

/* ---------------------- Validation fname, lname ---------------------------*/

form.last_name.addEventListener('change', function() {
    validename(this);
  });
  
  const validename = function(insertlname){
    
      /* ------- seulement des lettres ----------- */
      let regnom = new RegExp('^[a-zA-Z]+$', 'g');
      let testlname = regnom.test(insertlname.value);
  
    if(testlname){
      return true;
    }else{   
      return false;
    }
  };
  
  form.first_name.addEventListener('change', function() {
    validefname(this);
  });
  
  const validefname = function(insertfname){
  
      /* ------- seulement des lettres ----------- */
      let regprenom = new RegExp('^[a-zA-Z]+$', 'g');
      let testfname = regprenom.test(insertfname.value);
    
    if(testfname){
      return true;
    }else{   
      return false;
    }
  };


/* ------------------------- Validation Mail -------------------------*/

form.email_address.addEventListener('change', function() {
    validemail(this);
  });
  
  const validemail = function(insertMail){
  
   /* ------- minimum un caractère, max un @, des chiffres et des lettres, un point, des lettres minuscules ------- */	
   let regmail = new RegExp('^[a-zA-Z0-9._-]+@{1}[a-zA-Z0-9-]{2,252}[.]{1}[a-z]{1,6}$', 'g');
   
   let testmail = regmail.test(insertMail.value);
    if(testmail){
      return true;
    }else{
      return false;    
    }
  };
  

/* ---------------------- Validation submit ---------------------------*/

document.querySelector(".buttonSub").addEventListener('click', function(e){
	if (validefname(form.first_name) && validename(form.last_name) && validemail(form.email)) {
		<?php
            if (isset($_POST['btnRegister'])) {
                $fname=$_POST['first_name'];
                $lname=$_POST['last_name'];
                $Email=$_POST['email_address'];
                $passw= md5($_POST['password']);
                $country=$_POST['country'];
            
                $query1 = "SELECT * from tblstudents";
            
                $result1 = mysqli_query($connect, $query1);
            
                echo $Email;
            
                $valid = 'true';
            
                $row = mysqli_fetch_assoc($result1);
            
                while (($row = mysqli_fetch_assoc($result1)) && $valid == true){
                    
                    if($row['email'] === $Email){
                        $valid = false; 
                    }  
                
                } 
            
                if($valid == true){
                    $query="INSERT INTO `tblstudents`(`firstname`, `lastname`, `email`, `password`, `country`) VALUES ('$fname','$lname','$Email','$passw','$country')";
                    if(mysqli_query($connect,$query)) {
                        
                        $to = $Email;
                        $subject = "Utilisation de mail() avec PHP depuis Windows";
                        $message = "Salut, comment ça va ? ";
                        $headers = "Content-Type: text/plain; charset=utf-8\r\n";
                        $headers .= "From: rayen.haddad@gmail.com\r\n";
                        if(mail($to, $subject, $message, $headers)){
                            echo "mail envoyé";
            
                            header("refresh:1;url=connexion.php");
                        }else{
                            echo "erreur mail";
                        }
            
                    }
                    else{
                        echo'Error in added';
                    }
                }
                else{
                    echo "Erreur le mail existe déja ";
                }
            
            }
        ?>
	}else{
		e.preventDefault();
		alert('saisir les infos correctes ');
		console.log('mauvais');
	}
});
</script>

</html>

<script src="../js/apparition.js" async></script>

