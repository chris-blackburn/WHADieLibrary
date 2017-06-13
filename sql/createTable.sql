CREATE TABLE IF NOT EXISTS dieBase (
	id INT PRIMARY KEY AUTO_INCREMENT,
    jobNumber INT UNIQUE NOT NULL,
    customerID INT UNIQUE NOT NULL,
    description TEXT,
    tags TEXT,
    dateEntered DATETIME DEFAULT CURRENT_TIMESTAMP,
    expectedUsage ENUM("One time use", "More than once", "Regular", "Unknown"),
    location ENUM("Green Inventory", "Gold Inventory", "Sanwa", "Heidelberg", "Kluge", "Awaiting Arrival"),
    machine ENUM("Sanwa", "Heidelberg", "Kluge"),
    flatWidth INT,
    flatHeight INT,
    finishedWidth INT,
    finishedHeight INT,
    numPockets INT,
    pocketSize TEXT,
    numberUp INT,
    reviewed BOOLEAN
);