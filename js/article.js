

/* ----------------------------------- stars rate ------------------------------ */

document.getElementById('star1').addEventListener('mouseover', () => {
    document.getElementById('star1').classList.add('hover');
})

document.getElementById('star2').addEventListener('mouseover', () => {
    i = 2;
    for (j = 1; j<=i; j++){
            document.getElementById('star'.concat(j)).classList.add('hover');
        }
})

document.getElementById('star3').addEventListener('mouseover', () => {
    i = 3;
    for (j = 1; j<=i; j++){
            document.getElementById('star'.concat(j)).classList.add('hover');
        }
})

document.getElementById('star4').addEventListener('mouseover', () => {
    i = 4;
    for (j = 1; j<=i; j++){
            document.getElementById('star'.concat(j)).classList.add('hover');
        }
})

document.getElementById('star5').addEventListener('mouseover', () => {
    i = 5;
    for (j = 1; j<=i; j++){
            document.getElementById('star'.concat(j)).classList.add('hover');
        }
})

document.getElementById('star1').addEventListener('mouseleave', () => {
    document.getElementById('star1').classList.remove('hover');
})

document.getElementById('star2').addEventListener('mouseleave', () => {
    i = 2;
    for (j = 1; j<=i; j++){
            document.getElementById('star'.concat(j)).classList.remove('hover');
        }
})

document.getElementById('star3').addEventListener('mouseleave', () => {
    i = 3;
    for (j = 1; j<=i; j++){
            document.getElementById('star'.concat(j)).classList.remove('hover');
        }
})

document.getElementById('star4').addEventListener('mouseleave', () => {
    i = 4;
    for (j = 1; j<=i; j++){
            document.getElementById('star'.concat(j)).classList.remove('hover');
        }
})

document.getElementById('star5').addEventListener('mouseleave', () => {
    i = 5;
    for (j = 1; j<=i; j++){
            document.getElementById('star'.concat(j)).classList.remove('hover');
        }
})

document.getElementById('addAvis').addEventListener('click', () => {
    console.log("te")
    document.getElementById('avis').classList.remove('invisible');
    document.getElementById('avis').classList.add('avisForm');

})