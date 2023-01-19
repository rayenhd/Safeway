
var test = document.getElementById('formulaire');


/* ---------------------- Validation nom, prenom ---------------------------*/

test.nom.addEventListener('change', function() {
  validenom(this);
});

const validenom = function(inserernom){

	/* ------- seulement des lettres ----------- */
	let regnom = new RegExp('^[a-zA-Z]+$', 'g');
	let testnom = regnom.test(inserernom.value);

  if(testnom){
    return true;
  }else{   
    return false;
  }
};

test.prenom.addEventListener('change', function() {
  valideprenom(this);
});

const valideprenom = function(insererprenom){

	/* ------- seulement des lettres ----------- */
	let regprenom = new RegExp('^[a-zA-Z]+$', 'g');
	let testprenom = regprenom.test(insererprenom.value);

  if(testprenom){
    return true;
  }else{   
    return false;
  }
};


/* ------------------------- Validation Mail -------------------------*/

test.mail.addEventListener('change', function() {
  validemail(this);
});

const validemail = function(insererMail){

 /* ------- minimum un caractère, max un @, des chiffres et des lettres, un point, des lettres minuscules ------- */	
 let regmail = new RegExp('^[a-zA-Z0-9._-]+@{1}[a-zA-Z0-9-]{2,252}[.]{1}[a-z]{1,6}$', 'g');
 
 let testmail = regmail.test(insererMail.value);
  if(testmail){
    return true;
  }else{
    return false;    
  }
};


/* ---------------------- Validation MDP ---------------------------*/

test.mdp.addEventListener('change', function() {
  validemdp(this);
});

const validemdp = function(insererMdp){

	let msg;
	let validation = false;
	/*----- 8 caractères min -----*/
	if(insererMdp.value.length < 8){
		msg = 'veuillez mettre au min 8 caractères';   
	/*--------- Majuscule ---------*/
	} else if (!/[A-Z]/.test(insererMdp.value)){
		msg = 'veuillez insérer une maj';
	/*------- 1 chiffre min -------*/	
	} else if (!/[0-9]/.test(insererMdp.value)){
		msg = 'le mdp doit avoir au min un chiffre';
	} else{
		msg = 'le mdp est valide';
		validation = true;
	}

  if(validation){
    return true;
  }else{
    return false;  
  }
};


/* ---------------------- Validation Telephone ---------------------------*/

test.telephone.addEventListener('change', function() {
  validephone(this);
});

const validephone = function(insererphone){
	console.log(insererphone)

	let validation = false;
	/*----- 8 caractères min -----*/
	if(insererphone.value.length < 10){
		return false;   
	} else{
		validation = true;	
		return true;	
	}
};



/* ---------------------- Validation submit ---------------------------*/



document.querySelector(".buttonSub").addEventListener('click', function(e){
	if (validemail(test.mail) && validemdp(test.mdp) && validenom(test.nom) && valideprenom(test.prenom) && validephone(test.phone)) {
		//console.log(infos)
		//window.location.href ="welcome.html"
	}else{
		e.preventDefault();
		alert('saisir les infos correctes ');
		console.log('mauvais');
	}
});


