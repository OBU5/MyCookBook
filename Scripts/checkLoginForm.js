function checkUsername(e) {
    console.log("checking username");
    console.log(e); //log metadata of the submit event

    //Username can be between 3 and 20 characters
    if (username.value.length < 3 || username.value.length > 20) {
        username.classList.add("errorText");
    } else {
        username.classList.remove("errorText")
    }

}

function checkPassword(e) {
    console.log("checking password");
    console.log(e); //log metadata of the submit event

    //Username can be between 3 and 20 characters
    if (password.value.length < 3 || password.value.length > 20) {
        password.classList.add("errorText");
    } else
        password.classList.remove("errorText")
}

function checkFirstname(e) {
    console.log("checking firstname");
    console.log(e); //log metadata of the submit event

    //firstname can be between 3 and 20 characters
    if (firstname.value.length < 3 || firstname.value.length > 20) {
        firstname.classList.add("errorText");
    } else
        firstname.classList.remove("errorText")
}

function checkLastname(e) {
    console.log("checking lastname");
    console.log(e); //log metadata of the submit event

    //lastname can be between 3 and 20 characters
    if (lastname.value.length < 3 || lastname.value.length > 20) {
        lastname.classList.add("errorText");
    } else {
        lastname.classList.remove("errorText")
    }
}

function checkEmail(e) {
    console.log("checking email");
    console.log(e); //log metadata of the submit event
    if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email.value)) {
        email.classList.remove("errorText")
    } else {
        email.classList.add("errorText");
    }

}


function checkBeforePost(e) {
    if (username.value.length < 3 || username.value.length > 20) {
        e.preventDefault();
        username.classList.add("errorText");       
        document.getElementById("errorMsg").classList.add("errorMessage");


        document.getElementById("errorMsg").innerHTML = "Uživatelské jméno musí být dlouhé 3 až 20 znaků";
    } else if (password.value.length < 3 || password.value.length > 20) {
        e.preventDefault();
        password.classList.add("errorText");
        document.getElementById("errorMsg").classList.add("errorMessage");
        document.getElementById("errorMsg").innerHTML = "Heslo musí být dlouhé 3 až 40 znaků";
    } else if (firstname.value.length < 3 || firstname.value.length > 40) {
        e.preventDefault();
        firstname.classList.add("errorText");
        document.getElementById("errorMsg").classList.add("errorMessage");
        document.getElementById("errorMsg").innerHTML = "Jméno musí být dlouhé 3 až 20 znaků";
    } else if (lastname.value.length < 3 || lastname.value.length > 20) {
        e.preventDefault();
        lastname.classList.add("errorText");
        document.getElementById("errorMsg").classList.add("errorMessage");
        document.getElementById("errorMsg").innerHTML = "Příjmení musí být dlouhé 3 až 20 znaků";
    } else if (!(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email.value))) {
        e.preventDefault();
        email.classList.add("errorText");
        document.getElementById("errorMsg").classList.add("errorMessage");
        document.getElementById("errorMsg").innerHTML = "Zadejte platný email";
    }

}

let errorText = "";
let firstname = document.querySelector("input[name = name]");
let lastname = document.querySelector("input[name = lastname]");
let username = document.querySelector("input[name = username]");
let password = document.querySelector("input[name = password]");
let email = document.querySelector("input[name = email]");
let submitButton = document.querySelector("input[name = register]");
// event - on remove focus of element, function - check()
firstname.addEventListener("blur", checkFirstname);
lastname.addEventListener("blur", checkLastname);
username.addEventListener("blur", checkUsername);
password.addEventListener("blur", checkPassword);
email.addEventListener("blur", checkEmail);
submitButton.addEventListener("click", checkBeforePost);