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
    if (file.files[0] != null) {
        var FileSize = file.files[0].size / 1024 / 1024; // in MiB
        if (FileSize > 20) {
            e.preventDefault();
            document.getElementById("errorMsg").innerHTML = 'Obrázek přesáhl maximální velikost 20 MB';
            file.classList.add("errorText");
        }
    }

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
        document.getElementById("errorMsg").innerHTML = "je potřeba zadat alespoň jednu ingredienci s délkou názvu maximálně 40 znaků";
        document.getElementById("errorMsg").classList.add("errorMessage");

    }
    // if there is no meal category, alert
    else if (!mealCategorySet) {
        e.preventDefault();
        document.getElementById("errorMsg").innerHTML = "je potřeba vybrat alespoň jednu jídelní kategorii";
        document.getElementById("errorMsg").classList.add("errorMessage");
    } else {
        if (recipename.value.length < 3 || recipename.value.length > 40) {
            e.preventDefault();
            recipename.classList.add("errorText");
            document.getElementById("errorMsg").innerHTML = "Název receptu musí být dlouhý 3 až 40 znaků";
            document.getElementById("errorMsg").classList.add("errorMessage");
        } else if (directions.value.length < 3) {
            e.preventDefault();
            directions.classList.add("errorText");
            document.getElementById("errorMsg").innerHTML = "pokyny receptu musíobsahovat nějaký text";
            document.getElementById("errorMsg").classList.add("errorMessage");
        } else if (directions.value.length < 3 || directions.value.length > 1000) {
            e.preventDefault();
            directions.classList.add("errorText");
            document.getElementById("errorMsg").innerHTML = "pokyny receptu nesmí přesáhnout délku 1000 znaků";
            document.getElementById("errorMsg").classList.add("errorMessage");
        }
    }
}

function addRow() { 
    var table = document.getElementById("tableIngredients");
    var row = table.insertRow(table.rows.length);
    var cell0 = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    cell0.innerHTML = table.rows.length -1;
    cell1.innerHTML = '<input type="text" maxlength = "40" id="ingredients'+table.rows.length+'" name="ingredients[]" >';
    cell2.innerHTML = '<input type="text" maxlength = "40" id="quantities'+table.rows.length+'" name="quantities[]" >';
    cell3.innerHTML = '<input type="text" maxlength = "40" id="units'+table.rows.length+'" name="units[]" >';
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

var file = document.querySelector("input[name = img]");