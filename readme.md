#Add Content from Database to Google Spreadsheet

I used this via cron job to auto fill a Google Spreadsheet with data from a database. This script could be run whenever, I chose to once a day.

Since I couldn't query the spreadsheet to check if an ID existed, I made a field called 'googled' and default it to 0, once it gets added an update runs and sets it to 1. That way we don't get duplicates in the spreadsheet.

###Here's a sample database

It was used for a wedding website for the RSVP.

	CREATE TABLE `rsvp` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(255) DEFAULT NULL,
	  `attending` varchar(4) DEFAULT NULL,
	  `guest_number` int(11) DEFAULT NULL,
	  `guest_names` text,
	  `email` varchar(255) DEFAULT NULL,
	  `comments` text,
	  `entrydate` datetime DEFAULT NULL,
	  `googled` tinyint(1) DEFAULT '0',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

###Notes

It should be noted that google.php is the script to be run, google_spreadsheet.php, is a class that allows for sending the data to Google Spreadsheets.

###Google Spreadsheet class

The Google spreadsheet class comes from the PHP Form Builder Class [located here](http://code.google.com/p/php-form-builder-class/) and is not my creation, google.php is my creation.

Here's a direct link to the [class](http://code.google.com/p/php-form-builder-class/source/browse/branches/1.x/includes/class.spreadsheet.php).