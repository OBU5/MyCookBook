
DROP TABLE IF EXISTS Recipe_Ingredients;
DROP TABLE IF EXISTS Ingredients;
DROP TABLE IF EXISTS OriginCountry;
DROP TABLE IF EXISTS Recipe_MealCategory;
DROP TABLE IF EXISTS MealCategory;
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
    directions VARCHAR(1000) NOT NULL,
    date Date NOT NULL,
    user_id int,
    originCountry_id int,
    imgUrl VARCHAR(1000),
    PRIMARY KEY (ID),
    FOREIGN KEY (user_id) REFERENCES Users(ID)
);


CREATE TABLE OriginCountry (
    ID int AUTO_INCREMENT NOT NULL ,
    name VARCHAR(50) NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE MealCategory (
    ID int AUTO_INCREMENT NOT NULL ,
    name VARCHAR(50) NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE Ingredients (
    ID int AUTO_INCREMENT NOT NULL,
    name varchar(40) NOT NULL,    
    quantity varchar(40) NOT NULL,
    unit varchar(40) NOT NULL,
    PRIMARY KEY (ID)
);

CREATE TABLE Recipe_MealCategory (
    ID int AUTO_INCREMENT NOT NULL,
    mealCategory_id int NOT NULL,
    recipe_id int NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (mealCategory_id) REFERENCES MealCategory(ID),
    FOREIGN KEY (recipe_id) REFERENCES Recipes(ID)
);


CREATE TABLE Recipe_Ingredients (
    ID int AUTO_INCREMENT NOT NULL ,
    recipe_id int NOT NULL,
    ingredient_id int NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (recipe_id) REFERENCES Recipes(ID),
    FOREIGN KEY (ingredient_id) REFERENCES Ingredients(ID)
);

