//INCLUDERE NELLA PAGINA HTML IL VALIDATION TOOL
window.addEventListener('load', function () {
	validateRegisterData();
});

function validateRegisterData(){    
    let form = document.getElementById('modUtente_form');
    form.addEventListener('submit', function (event){
        resetFormError(0);
        let msg = "";
        let ok = true;
        if(!validateNome()){
            msg += "<p>Hai inserito un nome non valido, può contenere solo lettere.</p>";
            ok = false;
        }
        if(!validateCognome()){
            msg+="<p>Hai inserito un cognome non valido, può contenere solo lettere.</p>";
            ok = false;
        }
        if(!validateUsername()){
            msg+="<p>Hai inserito un <span lang'en-GB'>username</span> non valido, può contenere al massimo 30 caratteri tra lettere e numeri.</p>";
            ok = false;
        }
        if(validatePasswordInputs() == -1){
            msg+="<p>Devi inserire anche la nuova <span lang'en-GB'>password</span>.</p>";
            ok = false;
        }else if(validatePasswordInputs() == -2){
            msg+="<p>Devi inserire anche la vecchia <span lang'en-GB'>password</span>.</p>";
            ok = false;
        }
        if(!validatePassword()){
            msg+="<p>Hai inserito una <span lang'en-GB'>password</span> non valida, deve essere di almeno 8 caratteri e contenere almeno una lettera e un numero.</p>";
            ok = false;
        }

        if(!ok){
            addFormError(msg, 0);
            event.preventDefault();
        }
    });
}


function validateNome(){
    var nome = document.getElementById("modUtente_nome").value;
    const validChars = /^[A-Za-z]+$/;
    if(!validChars.test(nome)){
        return false;
    }
    return true;
}

function validateCognome(){
    var cognome = document.getElementById("modUtente_cognome").value;
    const validChars = /^[A-Za-z]+$/;
    if(!validChars.test(cognome)){
        return false;
    }
    return true;
}

function validateUsername(){
    var username = document.getElementById("modUtente_username").value;
    const validChars = /^[A-Za-z0-9]+$/;
    if(!validChars.test(username) || username.length > 30){
        return false;
    }
    return true;
}

function validatePasswordInputs() {
    var password = document.getElementById("modUtente_pass").value;
    var password2 = document.getElementById("modUtente_pass2").value;

    if (password && !password2) {
        return -1;      // La prima è inserita, la seconda è vuota
    } else if (!password && password2) {
        return -2;      // La prima è vuota, la seconda è inserita
    }
    return 0;
}

function validatePassword(){
    var password = document.getElementById("modUtente_pass").value;
    var password2 = document.getElementById("modUtente_pass2").value;

    if (password2 && !password) {
        return true; 
    }

    if (password2) {
        const validLetter = /[a-zA-Z]/;
        const validNumber = /\d/;
        if (password2.length < 8 || !validLetter.test(password2) || !validNumber.test(password2)) {
            return false; 
        }
    }

    return true;
}


