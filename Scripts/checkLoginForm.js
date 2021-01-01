function checkUsername(e) {
    console.log("checking username");
    console.log(e); //log metadata of the submit event

    //Username can be between 3 and 12 characters
    if (username.value.length < 3 || username.value.length > 12) {
        username.classList.add("errorText");
    } else {
        username.classList.remove("errorText")
    }

}

function checkPassword(e) {
    console.log("checking password");
    console.log(e); //log metadata of the submit event

    //Username can be between 3 and 12 characters
    if (password.value.length < 3 || password.value.length > 20) {
        password.classList.add("errorText");
    } else
        password.classList.remove("errorText")
}

function checkFirstname(e) {
    console.log("checking firstname");
    console.log(e); //log metadata of the submit event

    //firstname can be between 3 and 12 characters
    if (firstname.value.length < 3 || firstname.value.length > 12) {
        firstname.classList.add("errorText");
    } else
        firstname.classList.remove("errorText")
}

function checkLastname(e) {
    console.log("checking lastname");
    console.log(e); //log metadata of the submit event

    //lastname can be between 3 and 12 characters
    if (lastname.value.length < 3 || lastname.value.length > 12) {
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
    if (username.value.length < 3 || username.value.length > 12) {
        e.preventDefault();
        username.classList.add("errorText");
        alert("Uživatelské jméno musí být dlouhé 3 až 12 znaků");
    } else if (password.value.length < 3 || password.value.length > 20) {
        e.preventDefault();
        password.classList.add("errorText");
        alert("Heslo musí být dlouhé 3 až 12 znaků");
    } else if (firstname.value.length < 3 || firstname.value.length > 12) {
        e.preventDefault();
        firstname.classList.add("errorText");
        alert("Jméno musí být dlouhé 3 až 12 znaků");
    } else if (lastname.value.length < 3 || lastname.value.length > 12) {
        e.preventDefault();
        lastname.classList.add("errorText");
        alert("Příjmení musí být dlouhé 3 až 12 znaků");
    } else if (!(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email.value))) {
        e.preventDefault();
        email.classList.add("errorText");
        alert("Zadejte platný email");

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