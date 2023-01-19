
/* --------------------------- display parts -------------------------- */

disp_info = document.querySelector(".informations");
    disp_articles = document.querySelector(".articles");
    disp_loc = document.querySelector(".locations");
    disp_user = document.querySelector(".user");


    info = document.getElementById("info");
    articles = document.getElementById("articles");
    loc = document.getElementById("locations");

    info.addEventListener("click", () => {
        disp_articles.classList.add("invisible");
        disp_loc.classList.add("invisible");
        disp_user.classList.add("invisible");

        disp_info.classList.remove("invisible");
        
    });

    articles.addEventListener("click", () => {
        disp_info.classList.add("invisible");
        disp_loc.classList.add("invisible");
        disp_user.classList.add("invisible");
        
        disp_articles.classList.remove("invisible");
        supprimer()
        getArticles(0);
        
    });


    loc.addEventListener("click", () => {
        disp_articles.classList.add("invisible");
        disp_info.classList.add("invisible");
        disp_user.classList.add("invisible");
    
        disp_loc.classList.remove("invisible");
        supprimer();
        getLocs(0);
        
    });

    user.addEventListener("click", () => {
        disp_articles.classList.add("invisible");
        disp_loc.classList.add("invisible");
        disp_info.classList.add("invisible");
        
        disp_user.classList.remove("invisible");
        supprimer()
        getUsr(0);
        
    });                            



var test = document.getElementById('formulaire');
console.log(test)


/* ---------------------- Change color theme ---------------------------*/

test.color.addEventListener('change', function() {
  validecolor(this);
});

const validecolor = function(insertcolor){
    console.log("val")

	/* ------- seulement des lettres ----------- */
	let testnom = insertcolor.value;
    var elements = document.getElementsByClassName('inputColor'); // get all elements
	for(var i = 0; i < elements.length; i++){
		elements[i].style.color = testnom;
        elements[i].style.borderColor = testnom;
	}

    var element = document.getElementsByClassName('textcolor'); // get all element
	for(var j = 0; j < element.length; j++){
		element[j].style.color = testnom;
	}

    document.body.style.backgroundColor = testnom;

    var element = document.getElementsByClassName('btn-primary'); // get all element
	for(var j = 0; j < element.length; j++){
		element[j].style.backgroundColor = testnom;
        element[j].style.borderColor = testnom;
	}

 };

    /* -------------------- get users ---------------- */
    function getUsr(page) {

        // On récupère les données depuis le serveur externe
        // Premier élément de la page courante

        const start = page * itemsPerPage;
        // Nombre d'éléments par page
        const limit = itemsPerPage;
        
        console.log("start ", start);
        console.log("limit", limit);

        fetch(
            "../js/users.json?_start=" +
            start +
            "&_limit=" +
            limit
            )
            
            .then((response) => response.json())
            .then(function (data) {

            // Un tableau (Array) de 200 objets javascript représentant des tâches s affiche dans la console du navigateur
            // On stocke le nombre total de tâches récupérées pour la pagination
            //usersCount = data.length;
            // On parcourt le tableau de tâches récupéré et on ajoute une ligne au tableau de tâche pour chaque élément du tableau

            createUser(data, start);

            });

}

    /* -------------------- get users ---------------- */
    function getArticles(page) {

        // On récupère les données depuis le serveur externe
        // Premier élément de la page courante

        const start = page * itemsPerPage;
        // Nombre d'éléments par page
        const limit = itemsPerPage;

        console.log("start ", start);
        console.log("limit", limit);

        fetch(
            "../js/articles.json?_start=" +
            start +
            "&_limit=" +
            limit
            )
            
            .then((response) => response.json())
            .then(function (data) {

            // Un tableau (Array) de 200 objets javascript représentant des tâches s affiche dans la console du navigateur
            // On stocke le nombre total de tâches récupérées pour la pagination
            //usersCount = data.length;
            // On parcourt le tableau de tâches récupéré et on ajoute une ligne au tableau de tâche pour chaque élément du tableau

            createArticles(data, start);

            });

    }


    /* -------------------- get locs ---------------- */
    function getLocs(page) {

        // On récupère les données depuis le serveur externe
        // Premier élément de la page courante
    
        console.log("item",itemsPerPage); 

        const start = page * itemsPerPage;
        // Nombre d'éléments par page
        const limit = itemsPerPage;
    
        console.log("start ", start);
        console.log("limit", limit);
    
        fetch(
            "../js/locs.json?_start=" +
            start +
            "&_limit=" +
            limit
            )
            
            .then((response) => response.json())
            .then(function (data) {
    
            // Un tableau (Array) de 200 objets javascript représentant des tâches s affiche dans la console du navigateur
            // On stocke le nombre total de tâches récupérées pour la pagination
            //usersCount = data.length;
            // On parcourt le tableau de tâches récupéré et on ajoute une ligne au tableau de tâche pour chaque élément du tableau
    
            createLocations(data, start);
    
            });
    
        }     
    
    
    /* ----------------------- Initialisation table ---------------------- */
    
        const tab = document.createElement('table');
        tab.classList.add("datatable");
        tab.classList.add("table");
        const titres = document.createElement('thead');
        const l1 = document.createElement('tr');
    
    /* ----------------------- table users ---------------------- */        
    
        const ID = document.createElement('th');
        ID.textContent = "ID"
        const fname = document.createElement('th');
        fname.textContent = "Fname"
        const lname = document.createElement('th');
        lname.textContent = "Lname"
        const email = document.createElement('th');
        email.textContent = "Email"
        const Country = document.createElement('th');
        Country.textContent = "Country"
        const Delete = document.createElement('th');
        Delete.textContent = "Delete"
        const Edit = document.createElement('th');
        Edit.textContent = "Edit"
       
    /* ----------------------- table articles ---------------------- */   
    
        const artID = document.createElement('th');
        artID.textContent = "ID"
        const name = document.createElement('th');
        name.textContent = "name"
        const stock = document.createElement('th');
        stock.textContent = "stock"
        const price = document.createElement('th');
        price.textContent = "price"
        const artEdit = document.createElement('th');
        artEdit.textContent = "Edit"
    
    /* ----------------------- table locations ---------------------- */   
    
        const locID = document.createElement('th');
        locID.textContent = "ID"
        const address = document.createElement('th');
        address.textContent = "address"
        const city = document.createElement('th');
        city.textContent = "city"
        const date = document.createElement('th');
        date.textContent = "date"
        const usr = document.createElement('th');
        usr.textContent = "user"
        
    /* ----------------------- creation line ---------------------- */  
    
        const tbody = document.createElement('tbody');
    
    /* ----------------------- creation articles ---------------------- */   
    
    function createArticles(art, start){
        l1.textContent = '';
        l1.append(artID, name, stock, price, artEdit);
        titres.append(l1);
        
        tab.append(titres, tbody)
    
        document.querySelector("#all_articles").append(tab)
    
        for (let i = start; i < start+8 ; i++) {
            
            const newItem = document.createElement('tr');
            const articlID = document.createElement('td');
            const articlename = document.createElement('td');
            const articlestock = document.createElement('td');
            const articleprice = document.createElement('td');
            const artedit = document.createElement('td');
            const buttonedit_art = document.createElement('a');              
            
            articlename.textContent = art[i].name;
            articlID.textContent = art[i].ID;
            articlestock.textContent = art[i].stock;
            articleprice.textContent = art[i].price;
            buttonedit_art.textContent = "modify";
            artedit.append(buttonedit_art);
    
            buttonedit_art.setAttribute('href', 'modify.php?id_a='.concat(art[i].ID));
            buttonedit_art.setAttribute('target', 'blank');
    
            newItem.append(articlID, articlename, articlestock, articleprice, artedit);
            tbody.append(newItem)
        
        }
    }
    
    /* ----------------------- creation locations ---------------------- */   
    
    function createLocations(loc, start){
    
    l1.textContent = '';
    l1.append(locID, address, city, date, usr);
    titres.append(l1);
    
    tab.append(titres, tbody)
    
    document.querySelector("#all_locations").append(tab)

    console.log(totalpagesloc)
                                                                                                                                                                
    for (let i = start; i < start+8 ; i++) {
        
        const newItem = document.createElement('tr');
        const locID = document.createElement('td');
        const locadd = document.createElement('td');
        const locity = document.createElement('td');
        const locdate = document.createElement('td');
        const locusr = document.createElement('td');
    
        locadd.textContent = loc[i].adress;
        locID.textContent = loc[i].ID;
        locity.textContent = loc[i].city;
        locdate.textContent = loc[i].date;
        locusr.textContent = loc[i].user;
    
        newItem.append(locID, locadd, locity, locdate, locusr);
        tbody.append(newItem)
    
    }
    }    
    
    /* ----------------------- creation users ---------------------- */   
    
function createUser(usr, start){
    
    l1.textContent = '';
    l1.append(ID, fname, lname, email, Country, Edit, Delete);
    titres.append(l1);
    
    tab.append(titres, tbody)
    
    document.querySelector("#all_usr").append(tab)
    
    for (let i = start; i < start+8 ; i++) {
        
        const newItem = document.createElement('tr');
        const userID = document.createElement('td');
        const userfname = document.createElement('td');
        const userlname = document.createElement('td');
        const usermail = document.createElement('td');
        const usercountry = document.createElement('td');
        const userdrop = document.createElement('td');
        const fromdrop = document.createElement('form');
        const buttondrop = document.createElement('input');
        const useredit = document.createElement('td');
        const buttonedit = document.createElement('input');
    
        newItem.setAttribute('class', 'personne');
        fromdrop.setAttribute('method', 'post');
        buttondrop.setAttribute('type', 'submit');
        buttondrop.setAttribute('name', usr[i].ID);
        buttondrop.setAttribute('class', 'drop');
        buttondrop.setAttribute('value', 'delete');
               
        buttonedit.setAttribute('type', 'button');
        buttonedit.setAttribute('name', 'edit'.concat(usr[i].ID));
        buttonedit.setAttribute('class', 'edit');
        buttonedit.setAttribute('id', 'edit'.concat(usr[i].ID));
        buttonedit.setAttribute('value', 'edit'); 
    
        userfname.textContent = usr[i].fname;
        userID.textContent = usr[i].ID;
        userlname.textContent = usr[i].lname;
        usermail.textContent = usr[i].email;
        usercountry.textContent = usr[i].country;
    
        useredit.append(buttonedit);
        fromdrop.append(buttondrop);
        userdrop.append(fromdrop);
        newItem.append(userID, userfname, userlname, usermail, usercountry, useredit, userdrop);
        tbody.append(newItem)
    
        console.log(buttonedit)
        buttonedit.addEventListener('click', () => {
            console.log("but", buttonedit)
            document.getElementById("test2").classList.add('disp_yes')
            document.getElementById("test2").classList.remove('disp_none')
            document.getElementById("newFname2").setAttribute("name", "newFname2_".concat(usr[i].ID))
            document.getElementById("newlname2").setAttribute("name", "newlname2_".concat(usr[i].ID))
            document.getElementById("submitChange2").setAttribute("name", "submitChange2_".concat(usr[i].ID))
            
        })
    }
}    
    
    /* ---------------------------- change page ------------------------------  */ 
    
    function getNextPage() {
        page = page + 1;
        return page;
    }
    
    function getPreviousPage() {
        page = page - 1;
        return page;
    }

    /* -----------------  show next users -------------------- */
    
    function showNextPage(){
        supprimer();
        page = getNextPage()
        getUsr(page);
    }
    
    function showPreviousPage(){
        supprimer();
        page = getPreviousPage()
        getUsr(page);
    }

    document.getElementById("suivant_usr").addEventListener("click", () => {
        if(page != totalpagesusr){
            showNextPage()
        }
        
    })
    
    document.getElementById("precedent_usr").addEventListener("click", () => {
        if(page != 0){
            showPreviousPage()
        }
        
    })

    /* -----------------  show next articles -------------------- */
    
    function showNextPage_arti(){
        supprimer();
        page = getNextPage()
        getArticles(page);
    }
    
    function showPreviousPage_arti(){
        supprimer();
        page = getPreviousPage()
        getArticles(page);
    }

    document.getElementById("suivant_art").addEventListener("click", () => {
        console.log("test")
        if(page != totalpagesarti){
            showNextPage_arti()
        }
        
    })
    
    
    document.getElementById("precedent_art").addEventListener("click", () => {
        if(page != 0){
            showPreviousPage_arti()
        }
        
    })

    /* -----------------  show next locs -------------------- */
    
    function showNextPage_loc(){
        supprimer();
        page = getNextPage()
        getLocs(page);
    }
    
    function showPreviousPage_loc(){
        supprimer();
        page = getPreviousPage()
        getLocs(page);
    }
    
    document.getElementById("suivant_loc").addEventListener("click", () => {
        console.log("a", totalpagesloc)
        if(page != totalpagesloc){
            showNextPage_loc()
        }
        
    })
    
    document.getElementById("precedent_loc").addEventListener("click", () => {
        if(page != 0){
            showPreviousPage_loc()
        }
        
    })
    
    
    
    function supprimer () {
        console.log(tbody)
        while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild)
        }
    }

    /* ---------------------------- Open form Information ------------------------------  */ 

    document.getElementById("changeForm").addEventListener('click', () => {
        console.log(document.getElementById("test"))
        document.getElementById("test").classList.add('disp_yes')
        document.getElementById("test").classList.remove('disp_none')
    })

    /* ---------------------------- close form Information ------------------------------  */  
    
    document.getElementById("close").addEventListener('click', () => {
        document.getElementById("test").classList.remove('disp_yes')
        document.getElementById("test").classList.add('disp_none')
    })

    /* ---------------------------- close form users ------------------------------  */      
    
    document.getElementById("close2").addEventListener('click', () => {
        document.getElementById("test2").classList.remove('disp_yes')
        document.getElementById("test2").classList.add('disp_none')
    })




/* -------------------------------- search users -----------------------------------*/ 
function search() {
    let input = document.getElementById('searchbar').value
    input=input.toLowerCase();
    let x = document.getElementsByClassName('personne');
    
    for (i = 0; i < x.length; i++) { 
        console.log('e')
        if (!x[i].childNodes[1].innerText.toLowerCase().includes(input)) {
            x[i].style.display="none";
        }
        else {
            x[i].style.display="tab";                 
        }
    }
}