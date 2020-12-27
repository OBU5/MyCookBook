
DROP TABLE IF EXISTS Recipe_Ingredients;
DROP TABLE IF EXISTS Ingredient;
DROP TABLE IF EXISTS Recipes;
DROP TABLE IF EXISTS Users;


CREATE TABLE Users (
    ID INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(40) NOT NULL,
    lastname VARCHAR(40),
    email VARCHAR(40),
    username VARCHAR(40),
    password VARCHAR(100) NOT NULL,
    role VARCHAR(40),
    PRIMARY KEY(ID)
);

CREATE TABLE Recipes (
    ID int AUTO_INCREMENT NOT NULL ,
    name VARCHAR(40) NOT NULL,
    date Date NOT NULL,
    user_id int,
    PRIMARY KEY (ID),
    FOREIGN KEY (user_id) REFERENCES Users(ID)
);

CREATE TABLE Ingredient (
    ID int AUTO_INCREMENT NOT NULL,
    name varchar(40) NOT NULL,    
    quantity DECIMAL(5,2) NOT NULL,
    unit varchar(40) NOT NULL,
    PRIMARY KEY (ID)
);


CREATE TABLE Recipe_Ingredients (
    ID int AUTO_INCREMENT NOT NULL ,
    recipe_id int NOT NULL,
    ingredient_id int NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (recipe_id) REFERENCES Recipes(ID),
    FOREIGN KEY (ingredient_id) REFERENCES Ingredient(ID)
);


