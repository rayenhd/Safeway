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

form.mail.addEventListener('change', function() {
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
	if (validefname(form.first_name) && validename(form.last_name) && validemail(form.mail)) {
		//console.log(infos)
	}else{
		e.preventDefault();
		alert('saisir les infos correctes ');
		console.log('mauvais');
	}
});

