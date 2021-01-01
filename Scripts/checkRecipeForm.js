function checkRecipename(e) {
    console.log("checking recipe title");
    console.log(e); //log metadata of the submit event

    //Recipe name can be between 3 and 12 characters
    if (recipename.value.length < 3 || recipename.value.length > 40) {
        recipename.classList.add("errorText");
    } else {
        recipename.classList.remove("errorText")
    }

}

function checkDirections(e) {
    console.log("checking recipe directions");
    console.log(e); //log metadata of the submit event

    //Recipe name can be between 3 and 12 characters
    if (directions.value.length < 3 || directions.value.length > 1000) {
        directions.classList.add("errorText");
    } else {
        directions.classList.remove("errorText")
    }

}



function checkBeforePost(e) {
    //check, if there is at least one ingredient
    ingredientSet = false;
    for (i = 0; i < 100; i++) {
        if (ingredients[i] != null && ingredients[i].value.length == 0) {
            ingredients[i].classList.add("errorText");
        } else if (ingredients[i] != null && ingredients[i].value.length > 40) {
            ingredients[i].classList.add("errorText");
        } else if (ingredients[i] != null && ingredients[i].value.length > 0 && ingredients[i].value.length < 40) {
            ingredientSet = true;
        }
    }
    // set  style to default state, if there is at least one ingredient set
    if (ingredientSet) {
        for (i = 0; i < 100; i++) {
            if (ingredients[i] != null) {
                ingredients[i].classList.remove("errorText")
            }
        }
    }


    //check, if there is at least one selected meal category
    mealCategorySet = false;
    for (i = 0; i < 100; i++) {
        if (mealCategories[i] != null && mealCategories[i].checked) {
            mealCategorySet = true;
        }
    }

    // if there is no ingredient, alert
    if (!ingredientSet) {
        e.preventDefault();
        alert("je potřeba zadat alespoň jednu ingredienci s délkou názvu maximálně 40 znaků");

    }
    // if there is no meal category, alert
    else if (!mealCategorySet) {
        e.preventDefault();
        alert("je potřeba vybrat alespoň jednu jídelní kategorii");

    } else {
        if (recipename.value.length < 3 || recipename.value.length > 40) {
            e.preventDefault();
            recipename.classList.add("errorText");
            alert("Název receptu musí být dlouhý 3 až 40 znaků");
        } else if (directions.value.length < 3) {
            e.preventDefault();
            directions.classList.add("errorText");
            alert("pokyny receptu musíobsahovat nějaký text");
        } else if (directions.value.length < 3 || directions.value.length > 1000) {
            e.preventDefault();
            directions.classList.add("errorText");
            alert("pokyny receptu nesmí přesáhnout délku 1000 znaků");
        }
    }
}


let errorText = "";

let recipename = document.querySelector("input[name = recipename]");
let directions = document.querySelector("textarea[name = directions]");
let originCountry = document.querySelector("input[name = originCountry]");
let ingredients = [];
for (i = 0; i < 100; i++) {
    ingredients[i] = document.getElementById("ingredients" + i);
}
let mealCategories = [];

for (i = 0; i < 100; i++) {
    mealCategories[i] = document.querySelector("input[name = mealCategory" + i + "]");
}






let submitButton = document.querySelector("input[name = submit]");

// event - on remove focus of element, function - check()
recipename.addEventListener("blur", checkRecipename);
directions.addEventListener("blur", checkDirections);
submitButton.addEventListener("click", checkBeforePost);

//--------------------------------------------------------------------
/*
function checkCreationDate(e) {
    console.log("checking");
    console.log(e); //log metadata of the submit event
    let creationDateText = creationDate.value;

    // regular expression to match required date format
    re = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
    let dateNow = new Date();
    dateNow.setHours(0, 0, 0, 0);

    if (creationDateText != '' && !creationDateText.match(re)) {
        e.preventDefault(); //prevent default action (ex submitting)
        //feedback
        creationDate.classList.add("errorText");
    } else
    if (Date.parse(creationDateText) - Date.parse(dateNow) <= 0) {
        e.preventDefault(); //prevent default action (ex submitting)
        //feedback
        creationDate.classList.add("errorText");
    } else {
        creationDate.classList.remove("errorText")
    }
}



let creationDate = document.querySelector("input[name = creationDate]");
let tags = document.querySelector("input[name = tags]");
let form = document.querySelector("form[name = myForm]")
    // event - on submit, function - check()
    //form.addEventListener("submit", check)

// event - on remove focus of element, function - check()
creationDate.addEventListener("blur", checkCreationDate)*/