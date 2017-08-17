# WHA Die Library
This is what I created during my summer internship at Worth Higgins & Associates. This is a content management system 
used to keep track of dies through a web portal. It is run internally at the company.

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

![Die Library Flowchart](https://github.com/krizboy12/WHADieLibrary/blob/master/Workflow/Workflow.png?raw=true)

## Database
This is a basic diagram of what the database looks like. It is a relational database with a many-to-many connection.

![Die Library Database](https://raw.githubusercontent.com/krizboy12/WHADieLibrary/master/Workflow/Database%20Relation.png)

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

![Die Table Page](https://github.com/krizboy12/WHADieLibrary/blob/master/screenshots/DieTablePage.png?raw=true)

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
  ![Pull Button](https://github.com/krizboy12/WHADieLibrary/blob/master/screenshots/PullButton.png?raw=true)
  - If you double click on a row, it will open up a hidden tab that allows you to update a die and preview/upload files associated with that die.

### Transaction History
This tab is very similar to the Die Table tab, it just accesses and displays a different table in the database

![Transaction History Page](https://github.com/krizboy12/WHADieLibrary/blob/master/screenshots/TransactionHistoryPage.png?raw=true)

This table has all the same features as the die table, searching, refresh, record count, and sorting. It does *not* have a pull button on hover, and when you double click a
row, it will take you to the listed die's update form. By default, the most recent jobs are at the top of the table.

### Create New Die
If a new die has been ordered, this is where its information goes.

![Create New Die Page](https://github.com/krizboy12/WHADieLibrary/blob/master/screenshots/CreateNewDie.png?raw=true)

- The only required field is the job number. 
- Multiple tags can be selected by ctrl+click or command+click for mac
- The file select for upload preview pdf only allows you to select one file and it is the file that will be displayed on the update form
- Upload other files allows you to select multiple files, it filters out anything but pdf's and illustrator files by default 
(just select All Files in you file explorer when it pops up if you need another type of file).
- The Job Number field, the Customer Name field, and the Job Date field are all entered into the "jobs table" which is viewable through the transaction history tab

When you are done filling out the form, click the button at the bottom labeled "Create Die" and you will be brough back to the die table where the new die will be added!

### Update Die
When you double click a row on the die table or transaction history table, the information about the die that row points to populates the update form.

![Update Die Page](https://github.com/krizboy12/WHADieLibrary/blob/master/screenshots/UpdateDiePage.png?raw=true)

To update the die, simply change the fields you want to change and click "Update". You will be brought back to the die table and any changes will have been applied.

#### Updating Files
- On the right side of the update form, there are two buttons, "Preview" and "Download". By default the preview tab is opened - it displays the preview pdf 
that was upload when the die was created. If you wish to overwrite that file, just upload a new file via the "Overwrite PDF" file picker. You can also
upload new files through the other file picker (to overwrite old files, just make sure the new ones have the same name and they will be overwritten).
- If you click on the "Download" button, the previewable pdf will be hidden and a list of links will show up. These are set to download when you click on them.

![Update Die Page Download Links](https://github.com/krizboy12/WHADieLibrary/blob/master/screenshots/UpdateDie-DownloadLinks.png?raw=true)
  - If you would like to preview them, right click a link and select "Open link in new tab". The pdf that is named as the die ID is the pdf that is seen through the preview.

### Pull Request
To create a new job with an existing die, click the pull button on the die table (as seen earlier). After you click the pull button, you will be brought to the "Pull Request" tab.

![Pull Request Page](https://github.com/krizboy12/WHADieLibrary/blob/master/screenshots/PullRequestPage.png?raw=true)

After any data is submitted, the die's location will change (if you selected a new location) and the transaction history table will be appended with the new entry.

## Automated Emails
There are triggers throughout the site that sends email notifications.
- When a die is created
  1. If the die has already been reviewed
      - Subject: Job *[Job Number]* has been created
      - Body: A new die (*[Die ID]*) has been created for this job  
      Review status: **reviewed**
  2. If the die has **not** been reviewed
      - Subject: Job *[Job Number]* Needs die approval
      - Body: A new die (*[Die ID]*) has been created  
      Review status: **not reviewed**
- When a die is updated
  1. If the die has been updated to being reviewed
     - Subject: Die *[Die ID]* has been approved
     - Body: Die *[Die ID]* has been approved
  2. If the die has been set to not reviewed
      - Subject: Die *[Die ID]* has been unapproved
      - Body: Die *[Die ID]* has been been unapproved and needs to be reviewed
- When a pull request is made
  - Subject: Pull request for die *[Die ID]*
  - Body: Die *[Die ID]* needs to be pulled for job *[Job Number]*  
  Die review status: ***[reviewed|not reviewed]***

Automated emails are sent to these groups (one or the other or both depending on the email)
1. die approvals
2. customer service

## Administration
There were lots of configurations for apache and other services that had to be done. This is just where I'll keep all that information. Some of this stuff 
may already be configured depending on your install method. I used MAMP to run this site off of a mac server, so a lot of things were preconfigured and many of the directory paths are specific to that installation.

### Install Location
I installed everything on the seefile server mac. `/Volumes/Storage\ II` was empty so I stored the site files there. There are three folders in Storage II.
- workspace
	- This is where I pull updates from github. To do so, you can do it one of two ways.
		1. Open terminal and navigate to that directory: `cd /Volumes/Storage\ II/workspace`.
		2. Type `git pull`, then the site will update in the workspace folder
		3. copy all the new contents (files with that day's date as date modified) and copy them over in their corresponding folders in the `dielibrary.com` folder.
	- The other way is to use the github desktop GUI
		1. There should be the icon for the GUI on the desktop, run that.
		2. At the top there should be a button that sais, *fetch* or *pull*. By clicking that, the site will update and you can proceed to step three in the previous method.
	- Backup scripts are also located here in the backups folder.
- dielibrary.com
	- This is where apache points to for the site
	- All the die files are in a folder called `dies` in this directory. The dies folder is also backed up via cronjob
- dielibrary_backup
	- This is where all the backup scripts point to. There are zipped archives of backups located here. They are named with the date of the backup.

### Logs
There are various log files that can be populated by the site.
1. Site specific logs located in the site's directory under `logs/client_logs.clogs`.
2. The mail logs for Mac are located in `/var/log/mail.log`.
3. The virtual host-specific logs for MAMP are located in `/Applications/MAMP/Library/logs`.

There are also logs for MAMP's apache, php, and sql services which can all be found in `/Applications/MAMP`.

### Apache
Apache configuration is all held in the `conf` directory of your apache installation. The directory path for MAMP is `/Applications/MAMP/conf/apache`.

There are two main files that need to be configured:
1. httpd.conf
2. extra/httpd-vhosts.conf

#### httpd.conf
First, you need to enable virtual hosting. To do this, uncomment (remove the "#" at the beginning of the line) or add this line somehwere in this file:
`Include /Applications/MAMP/conf/apache/extra/httpd-vhosts.conf`.

#### extra/httpd-vhosts.conf
```
NameVirtualHost *:80

<VirtualHost *:80>
    ServerAdmin mwilson@whaprint.com
    DocumentRoot "/Volumes/Storage II/dielibrary.com"
    ServerName dielibrary
    ErrorLog "logs/dielibrary-error_log"
    CustomLog "logs/dielibrary-access_log" common

    <Directory "/Volumes/Storage II/dielibrary.com/dies">
    Options +Indexes
    </Directory>

    <FilesMatch "\.(html|htm|js|css)$">
      FileETag None
      <ifModule mod_headers.c>
          Header unset ETag
          Header set Cache-Control "max-age=0, no-cache, no-store, must-revalidate"
          Header set Pragma "no-cache"
          Header set Expires "Wed, 11 Jan 1984 05:00:00 GMT"
      </ifModule>
    </FilesMatch>
</VirtualHost>
```

### MySQL
I added 3 users to the sql database.

1. The first user is used by the site to Read, Insert, and Update
    - Username: **monty**
    - Password: **some_pass**
    - Permissions: **SELECT, INSERT, UPDATE**
2. The second is used by one of the backup scripts to backup the database
    - Username: **exporter**
    - Password: **exporter**
    - Permissions: **SELECT**
3. The third is optional but recommended. It's just an admin account.
    - Username: **_administrator**
    - Password:
    - Permissions: **ALL**

#### Adjusting the Database
If someone enters in bad data or test data into the site and it needs to be removed
1. Login to phpmyadmin (to access phpmyadmin type in the url of the site along with `/phpmyadmin`)
2. Navigate to the job table and delete the unwanted entries
    - It's important to delete from the job table first because of the foreign key relationship to the die table
3. Navigate to the die table and delete the unwanted entries
4. Click on the Die Library database and then click on the sql tab
    - Enter this script and run it. Put the number of the die ID that should be generated next after the equals sign (i.e. if that last valid entry is 9427, put 9428.
    - `ALTER TABLE dies AUTO_INCREMENT=`

### PHP
MAMP allows you to choose which version of php to use. If you want to enable phpmyadmin, you must use 7.0.20 (at least with this installation of MAMP)

To enable the login screen for phpmyadmin, you need to edit the file `/Applications/MAMP/bin/phpMyAdmin/config.inc.php`.

Change this line from  
`$cfg['Servers'][$i]['auth_type']     = 'config';` to  
`$cfg['Servers'][$i]['auth_type']     = 'cookie';`

(optional/recommended)
populate this line with a blowfish secret (google "blowfish secret generator" and pop the output between the quotes, it doesn't have to be anything special. This is mainly to keep phpmyadmin from barking at you for not having it.  
`$cfg['blowfish_secret'] = '';`

### Postfix
This was a pain to play around with. This is a working configuration that I found. This is what makes the mailing system work.  
- [main.cf](https://github.com/krizboy12/WHADieLibrary/blob/master/configs/postfix/main.cf)  
- [sasl_MAMP_passwd](https://github.com/krizboy12/WHADieLibrary/blob/master/configs/postfix/sasl_MAMP_passwd)

Both of these files should be placed in `/etc/postfix`.

### Backup-Scripts
There are a couple scripts to run backups for the site. One backs up the apache config and the other backs up the die files and the sql database
- [apache backup](https://github.com/krizboy12/WHADieLibrary/blob/master/backup%20scripts/backup_apache_conf)
- [data backup](https://github.com/krizboy12/WHADieLibrary/blob/master/backup%20scripts/backup_dies)

I set up a crontab rule to run the data backup every friday at 7pm
`0 19 * * 5 "/Volumes/Storage II/workspace/backup scripts/backup_dies" &>/dev/null`

This is where the exporter user I set up in the database comes in. This script runs a mysqldump using that user and the password is stored as plaintext, so I just made a new user that could only select for security.

### Semi-annual Reports
I set up a cron job to run a php script that grabs all the dies that have not been used in the past six months and sends an email with that list.
`0 0 1 */6 * curl http://dielibrary.whaprint.com/php/usageReport.php >> /Volumes/Storage\ II/dielibrary.com/logs/client_logs.clogs`

## To-do
- [ ] add login function, use Database()->connect($user, $pass)
- [ ] add delete function through the site (need logins first)
- [ ] add direct connection to csr emails (rather than the catch all email)
- [ ] limit number of records the page will show by default, add "show all records"

## Special Thanks
- @christianbach for his awesome client side table sorting javascript magic. Check out his work [here](http://tablesorter.com).
- Mike Wilson - my boss