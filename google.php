<?php

// default timezone
date_default_timezone_set('America/Chicago');
	
/*
*
* Datebase connection 
*
*/

$dbhost = 'localhost';
$dbuser = 'username';
$dbpass = 'password';
$dbname = 'database';

$connect = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql');

mysql_select_db($dbname);

/*
*
* Query, loop, etc 
*
*/
if($connect) {

	// google spreadsheet class
	include_once("google_spreadsheet.php");
	
	// username/password for google account
	$user = "email@gmail.com";
	$pass = "password";
	
	// connect to the spreadsheet
	$doc = new spreadsheet();
	$doc->authenticate($user, $pass);
	$doc->setSpreadsheet("Spreadsheet"); // spreadsheet name
	$doc->setWorksheet("Worksheet"); // worksheet name
 
	// current date/time
	$date = date('Y-m-d G:i:s', time());
	
	// query the database for entries that have not been put in the spreadsheet (googled lol)
	$query = "SELECT * FROM table WHERE googled = 0";

	$result = mysql_query($query);

	$count = 0;
	// loop through and if it's good add to spreadsheet
	while($row = mysql_fetch_array($result)){
		
		if ( $doc->add($row) ) {
			// if it's good, echo the id and update if it was added  (googled = 1)
			echo 'Entry ID: ' . $row['id'] . '<br />';
			mysql_query('UPDATE rsvp SET googled = 1 WHERE id = ' . $row['id']);
		} else {
			// fail
			echo 'Something went wrong, please try again.';
		}
		
		$count++;
	}
	
	echo 'Entries added: ' . $count . '<br />';
	
}

mysql_close($connect);

/* Sample database, used with RSVP for a wedding site

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

*/