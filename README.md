# WHA Die Library
This is what I created during my summer internship at Worth Higgins & Associates. This is a content management system 
used to keep track of dies through a web portal.

## Why?
In printing, there is something called a *die*. Dies are used to cut, perforate, and fold paper in unconventional ways.
Originally, information about these dies were being kept in an excel spreadsheet that was accessed via samba share.
A couple weeks into my internship, we discovered that windows users were no longer able to access the share - we
were left puzzled and were unable to find a solution. Instead of just moving the share to another computer, I suggested 
we make a web portal to access the library. This would solve the access issue and would also save money (that way we 
wouldn't have to buy tons of licenses for Microsoft Office just to access one spreadsheet). This is the result of my 
work.

## Workflow
Here is a basic flowchart describing the target workflow

![Die Library Flowchart](https://github.com/krizboy12/WHADieLibrary/blob/master/Workflow/Workflow.png)

## Database
This is a basic diagram of what the database looks like. It is a relational database with a many-to-many connection.

![Die Library Database](https://github.com/krizboy12/WHADieLibrary/blob/master/Workflow/Database%20Relation.png)

#### SQL to build the database:
```sql
CREATE DATABASE IF NOT EXISTS `DieLibrary`;

USE `DieLibrary`;

--
-- Table structure for table `dies`
--

DROP TABLE IF EXISTS `dies`;
CREATE TABLE `dies` (
  `dieID` int(11) NOT NULL AUTO_INCREMENT,
  `datePurchased` date NOT NULL,
  `tags` text,
  `flatWidth` float DEFAULT NULL,
  `flatHeight` float DEFAULT NULL,
  `finishedWidth` float DEFAULT NULL,
  `finishedHeight` float DEFAULT NULL,
  `numPockets` int(11) DEFAULT NULL,
  `pocketSize` float DEFAULT NULL,
  `machine` enum('Sanwa','Heidelberg','Kluge') DEFAULT NULL,
  `location` enum('Green Inventory','Sanwa','Heidelberg','Kluge','Awaiting Arrival','Trashed') DEFAULT 'Awaiting Arrival',
  `expectedUsage` enum('One time use','More than once','Regular','Unknown') DEFAULT 'Unknown',
  `numberUp` int(11) DEFAULT NULL,
  `dieReviewed` enum('false','true') DEFAULT 'false',
  `description` text,
  `dateModified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dieID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `entryID` int(11) NOT NULL AUTO_INCREMENT,
  `jobNumber` int(11) NOT NULL,
  `dieID` int(11) NOT NULL,
  `customerName` varchar(50) DEFAULT NULL,
  `newDie` enum('no','yes') DEFAULT 'no',
  `jobDate` date NOT NULL,
  PRIMARY KEY (`entryID`),
  KEY `dieID` (`dieID`),
  CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`dieID`) REFERENCES `dies` (`dieID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
```

## The Site
This is my first real attempt at web development; before this my experience was limited to a little bit of html and css, 
but this project was heavy on php and javascript (mostly jquery).

I wanted the site to feel like a full on program - to accomplish this, I used a **ton** of ajax to prevent page reloads.

For the best results, please use a supported browser
- Chrome (recommended)
- Firefox
- IE > 9
- Edge

Here is the first page that comes up when the site is accessed (These screenshots are populated with data the users have entered).

![Die Table Page](https://github.com/krizboy12/WHADieLibrary/blob/master/screenshots/DieTablePage.png)

At the top, there are a few visible tabs:
- Die Table
- Transaction History
- Create New Die

Each of these take you to a different part of the site that I will show later (there are also some hidden tabs).

### Die Table
The content owned by the Die Table button is as follows:

- The quick search field
  - I used some regular expressions to make this thing quite powerful. It searches through all the text in the table (along with some hidden text for tags and sizes),
  and hides all non-matching rows. You can also search for multiple fields by simply adding a space between each field i.e. "Sanwa 9x17".
- The refresh button
  - Nothing *too* special, it simply refreshes the tables (both the die table and transaction table you'll see later).
  - Each table does refresh on their own every 5 minutes, so you don't have to click the button all the time if you leave the page open.
- Record count
- The table
  - The table is sorted by Die ID in descending order by default
  - Each of the headers are clickable and will sort the table by that header (shift+click to sort by multiple headers)
  - When hovering your mouse over a row, a button will appear, this is the pull button that opens up one of the hidden tabs I talked about earlier.
  ![Pull Button](https://github.com/krizboy12/WHADieLibrary/blob/master/screenshots/PullButton.png)
  - If you double click on a row, it will open up a hidden tab that allows you to update a die and preview/upload files associated with that die.

### Transaction History
This tab is very similar to the Die Table tab, it just accesses and displays a different table in the database

![Transaction History Page](https://github.com/krizboy12/WHADieLibrary/blob/master/screenshots/TransactionHistoryPage.png)

This table has all the same features as the die table, searching, refresh, record count, and sorting. It does *not* have a pull button on hover, and when you double click a
row, it will take you to the listed die's update form. By default, the most recent jobs are at the top of the table.

### Create New Die
If a new die has been ordered, this is where its information goes.

![Create New Die Page](https://github.com/krizboy12/WHADieLibrary/blob/master/screenshots/CreateNewDie.png)

- The only required field is the job number. 
- Multiple tags can be selected by ctrl+click or command+click for mac
- The file select for upload preview pdf only allows you to select one file and it is the file that will be displayed on the update form
- Upload other files allows you to select multiple files, it filters out anything but pdf's and illustrator files by default 
(just select All Files in you file explorer when it pops up if you need another type of file).
- The Job Number field, the Customer Name field, and the Job Date field are all entered into the "jobs table" which is viewable through the transaction history tab

When you are done filling out the form, click the button at the bottom labeled "Create Die" and you will be brough back to the die table where the new die will be added!

### Update Die
When you double click a row on the die table or transaction history table, the information about the die that row points to populates the update form.

![Update Die Page](https://github.com/krizboy12/WHADieLibrary/blob/master/screenshots/UpdateDiePage.png)

To update the die, simply change the fields you want to change and click "Update". You will be brought back to the die table and any changes will have been applied.

#### Updating Files
- On the right side of the update form, there are two buttons, "Preview" and "Download". By default the preview tab is opened - it displays the preview pdf 
that was upload when the die was created. If you wish to overwrite that file, just upload a new file via the "Overwrite PDF" file picker. You can also
upload new files through the other file picker (to overwrite old files, just make sure the new ones have the same name and they will be overwritten).
- If you click on the "Download" button, the previewable pdf will be hidden and a list of links will show up. These are set to download when you click on them.
![Update Die Page Download Links](https://github.com/krizboy12/WHADieLibrary/blob/master/screenshots/DieTable-DownloadLinks.png)
  - If you would like to preview them, right click a link and select "Open link in new tab". The pdf that is named as the die ID is the pdf that is seen through the preview.

### Pull Request
To create a new job with an existing die, click the pull button on the die table (as seen earlier). After you click the pull button, you will be brought to the "Pull Request" tab.

![Pull Request Page](https://github.com/krizboy12/WHADieLibrary/blob/master/screenshots/PullRequestPage.png)

After any data is submitted, the die's location will change (if you selected a new location) and the transaction history table will be appended with the new entry.

## To-do
- [ ] add login function, use Database()->connect($user, $pass)
- [ ] add direct connection to csr emails (rather than the catch all email)
- [ ] limit number of records the page will show by default, add "show all records"

### Special Thanks
- @christianbach for his awesome client side table sorting javascript magic. Check out his work [here](http://tablesorter.com).
- Mike Wilson, my boss
