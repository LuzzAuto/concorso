function addFormError(error, indexForm){
    let div = document.getElementsByClassName("form_errors")[indexForm];
    div.innerHTML += error;
    // div.children[0].focus();             // funziona solo se l'elemento è interattivo (tabindex)
}

function resetFormError(indexForm){
    let div = document.getElementsByClassName("form_errors")[indexForm];
    div.innerHTML = "";
}