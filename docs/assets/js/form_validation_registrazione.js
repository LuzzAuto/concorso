//INCLUDERE NELLA PAGINA HTML IL VALIDATION TOOL
window.addEventListener('load', function () {
	validateRegisterData();
});

function validateRegisterData(){    
    let form = document.getElementById('signup_form');
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
        if(!validatePassword()){
            msg+="<p>Hai inserito una <span lang'en-GB'>password</span> non valida, deve essere di almeno 8 caratteri e contenere almeno una lettera e un numero.</p>";
            ok = false;
        }
        if(!validatePasswordRepeat()){
            msg+="<p>Le <span lang'en-GB'>password</span> che hai inserito non coincidono.</p>";
            ok = false;
        }
        if(!validateDate()){
            msg+="<p>La data che hai inserito non &egrave; valida. Usa formato gg/mm/aaaa</p>";
            ok = false;
        }

        if(!ok){
            addFormError(msg, 0);
            event.preventDefault();
        }
    });
}

function validateNome(){
    var nome = document.getElementById("signup_nome").value;
    const validChars = /^[A-Za-z]+$/;
    if(!validChars.test(nome)){
        return false;
    }
    return true;
}

function validateCognome(){
    var cognome = document.getElementById("signup_cognome").value;
    const validChars = /^[A-Za-z]+$/;
    if(!validChars.test(cognome)){
        return false;
    }
    return true;
}

function validateUsername(){
    var username = document.getElementById("signup_username").value;
    const validChars = /^[A-Za-z0-9]+$/;
    if(!validChars.test(username) || username.length > 30){
        return false;
    }
    return true;
}

function validatePassword(){
    var password = document.getElementById("signup_pass").value;
    const validLetter = /[a-zA-Z]/;
    const validNumber = /\d/;
    if(!validLetter.test(password) || !validNumber.test(password) || password.length < 8){
        return false;
    }
    return true;
}

function validatePasswordRepeat(){
    var password = document.getElementById("signup_pass").value;
    var password2 = document.getElementById("signup_pass2").value;
    if(password != password2){
        return false;
    }
    return true;
}

function validateDate(){
    var date = document.getElementById("signup_data").value;
    const validChars = /^[0-9\-]+$/;
    var today = new Date();
    const month = ["01","02","03","04","05","06","07","08","09","10","11","12"];
    var dataOggi = today.getFullYear().toString()+"-"+month[today.getMonth()]+"-"+today.getDate();
    if(!validChars.test(date) || dataOggi < date){
        return false;
    }
    return true;
}