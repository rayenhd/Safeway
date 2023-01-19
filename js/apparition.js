const ratio = 0.1


const options = {
	root : null,
	rootmargin : '0px',
	threshold : ratio
}

/* -------------- Animations ------------ */

const handleIntersect = function(entries, observer) {
	console.log("entries", entries)
	 entries.forEach( (entry) => {
		if (entry.intersectionRatio > ratio){
			entry.target.classList.add("visible");
			console.log("entry", entry)
		}
		else {
			entry.target.classList.remove("visible");
		}
	 });
};


var observer = new IntersectionObserver(handleIntersect, options);
observer.observe(document.querySelector(".reveal"));

for (i = 0; i < 9; i++){
	if(document.querySelector(".reveal"+i) == null){
		console.log("null")
	}else{
		observer.observe(document.querySelector(".reveal"+i));
	}
}

	






