
console.log('test')


/*------------------ lire les données ----------------*/

const formulaire = document.forms[0];
const d = document.getElementById('d');
const Adresse = document.getElementById('Adresse');
const ville = document.getElementById('city');


/*------------------ ajouter les lignes lorsque les infos sont correctes ----------------*/

fetch(
	"../js/locs_current.json"
	)
	
	.then((response) => response.json())
	.then(function (data) {

	// Un tableau (Array) de 200 objets javascript représentant des tâches s affiche dans la console du navigateur
	// On stocke le nombre total de tâches récupérées pour la pagination
	//usersCount = data.length;
	// On parcourt le tableau de tâches récupéré et on ajoute une ligne au tableau de tâche pour chaque élément du tableau

	createLocations(data);

	});



function createLocations(e){


	for(let i = 0; i < e.length ; i++){
		var ligne = document.createElement("tr");
		ligne.classList.add('nouveau');
		const c1 = document.createElement("td");
		const c2 = document.createElement("td");
		const c3 = document.createElement("td");


			c1.textContent = e[i].date;
			c2.textContent = e[i].adress;
			c3.textContent = e[i].city;


			ligne.appendChild(c1);
			ligne.appendChild(c2);
			ligne.appendChild(c3);
		
			document.querySelector(".table").appendChild(ligne);
	}

	

}

/*------------------ supprimer les lignes -----------------*/



function supprimer(){
	const nouveauArr = document.querySelectorAll(".table")
	nouveauArr.forEach(val => document.querySelector(".main").removeChild(val));
}


/*------------------ valider adresse -----------------*/



var test = document.getElementById('new-task');


test.Adresse.addEventListener('change', function() {
  valideadr(this);
});


const valideadr = function(insereradr){

	var regnom = new RegExp(/^[a-zA-Z0-9\s]{5,50}$/);
	let testnom = regnom.test(insereradr.value);

  if(testnom){
  	document.getElementById("ad").style.borderColor = "pink";
    return true;
  }else{
    document.getElementById("ad").style.borderColor = "red";

    return false;

  }
};


/*------------------ valider ville -----------------*/



var test = document.getElementById('new-task');


test.ville.addEventListener('change', function() {
  valideville(this);
});


const valideville = function(insererville){

	let regnom = new RegExp('^[a-zA-Z]+$', 'g');
	let testnom = regnom.test(insererville.value);

  if(testnom){
  	document.getElementById("v").style.borderColor = "pink";
    return true;
  }else{
    document.getElementById("v").style.borderColor = "red";

    return false;
  }
};



/*------------------ valider date -----------------*/


test.d.addEventListener('change', function() {
  validedate(this);
});


const validedate = function(insererdate){

  if(test.d.value){
    return true;
  }else{
    document.getElementById("da").style.borderColor = "red";

    return false;
  }
};

