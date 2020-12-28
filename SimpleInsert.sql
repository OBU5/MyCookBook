

INSERT INTO Recipes (name, date)
VALUES 
('Palacinky','2019-9-1'),           -- id = 1
('Pizza margarita','2019-9-11');    -- id = 2


INSERT INTO Ingredients (name, quantity, unit)
VALUES
('mléko', 0.5, 'litru'),        -- id = 1
('vajicko', 2, 'žloutky'),      -- id = 2
('mouka hladká', 200, 'g'),     -- id = 3
('mouka polohrubá', 300, 'g'),  -- id = 4
('vajicko', 1, 'kus'),          -- id = 5
('rajče', 2, 'kusy' );          -- id = 6


INSERT INTO OriginCountry (name)
VALUES  
('Itálie'),           -- id = 1
('Maďarsko'),         -- id = 2
('Česko'),            -- id = 3
('Vietnam');          -- id = 4


INSERT INTO MealCategory (name)
VALUES  
('Předkrm'),            -- id = 1
('Hlavní chod'),        -- id = 2
('Dezert'),             -- id = 3
('Zákusek');            -- id = 4

INSERT INTO Recipe_Ingredients ( recipe_id, ingredient_id)
VALUES
(1,1),
(1,2),
(1,3),

(2,4),
(2,5),
(2,6);

