document.getElementById("changeForm").addEventListener('click', () => {
    console.log(document.getElementById("test"))
    document.getElementById("test").classList.add('disp_yes')
    document.getElementById("test").classList.remove('disp_none')
    
})

document.getElementById("close").addEventListener('click', () => {
    document.getElementById("test").classList.remove('disp_yes')
    document.getElementById("test").classList.add('disp_none')
})

if(document.getElementById("close2") != null){
    document.getElementById("close2").addEventListener('click', () => {
        document.getElementById("test2").classList.remove('disp_yes')
        document.getElementById("test2").classList.add('disp_none')
    })
}
