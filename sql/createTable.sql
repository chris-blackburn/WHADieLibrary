CREATE TABLE IF NOT EXISTS dies (
    dieID INT AUTO_INCREMENT NOT NULL,
    datePurchased DATE NOT NULL,
    tags TEXT,
    flatWidth INT,
    flatHeight INT,
    finishedWidth INT,
    finishedHeight INT,
    numPockets INT,
    pocketSize INT,
    machine ENUM("Sanwa", "Heidelberg", "Kluge"),
    location ENUM("Green Inventory", "Gold Inventory", "Sanwa", "Heidelberg", "Kluge", "Awaiting Arrival") DEFAULT "Awaiting Arrival",
    expectedUsage ENUM("One time use", "More than once", "Regular", "Unknown") DEFAULT "Unknown",
    numberUp INT,
    dieVendor VARCHAR(50),
    dieReviewed ENUM("false", "true") DEFAULT "false",
    description TEXT,
    dateModified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (dieID)
);

CREATE TABLE IF NOT EXISTS jobs (
    jobNumber INT NOT NULL,
    dieID INT NOT NULL,
    customerName VARCHAR(50),
    newDie ENUM("no", "yes") DEFAULT "no",
    jobDate DATE NOT NULL,
    PRIMARY KEY (jobNumber),
    FOREIGN KEY (dieID) REFERENCES dies(dieID)
);