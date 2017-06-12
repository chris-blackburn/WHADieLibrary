CREATE TABLE IF NOT EXISTS dieBase (
	id INT PRIMARY KEY AUTO_INCREMENT,
    description TEXT,
    dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
    expectedUsage TEXT,
    jobNumber INT UNIQUE,
    customerID INT UNIQUE,
    location TEXT,
    tags TEXT,
    reviewed INT,
    machine TEXT
);
