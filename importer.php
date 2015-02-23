<?php
// Import CSV dump into new system

$fd = fopen('Consultants.csv','r');
$headers = fgetcsv($fd, 2048);

while($line = fgetcsv($fd,2048))
{
	$line = array_combine($headers,$line); // transform($headers, $line);
	print_r($line);
}

die();
// Old LLR db importer into new system

$lnk	= mysql_connect('localhost','root','build4n0w');
if (!$lnk ) die("Cannot connect to DB .. \n");
mysql_select_db('llr_dev', $lnk);

// Set up query details
$row	= array();
$Q		= "select ID,SponsorID, Firstname,Surname,Email,Password,Phone,DOB from ezb2562d_ss.Member order by ID";

// fire off initial query
$res	= mysql_query($Q);

// If we have an error; Die - just die.
if (mysql_error()) die(mysql_error());
if (!$res) die("Nothing to show for that query.\n");

while($row = mysql_fetch_assoc($res)) {
/* FROM
[ID] => 10350
[Firstname] => Ronda
[Surname] => Cowley
[Email] => rondaleecowley@yahoo.com
[Password] => CGyctFqNTF
[Phone] => 
[DOB] => 1966-11-18 00:00:00
*/

	// INTO 
	$Q = "REPLACE INTO users SET 
		id			= '{$row['ID']}', 
		first_name	= '{$row['Firstname']}', 
		last_name	= '{$row['Surname']}', 
		sponsor_id	= '{$row['SponsorID']}',
		role_id		= '1',
		rank_id		= '1',
		email		= '{$row['Email']}', 
		password	= '{$row['Password']}', 
		phone		= '{$row['Phone']}', 
		dob			= '{$row['DOB']}'";

	print "Importing: {$row['Firstname']} {$row['Surname']}";
	mysql_query($Q);
	if (mysql_error()) die('DEATH: '.mysql_error());
	else print " OK\n";

}

// Set admin user
$Q="update users set email='mfrederico@gmail.com',role_id=5, password='".'$2y$10$EMboFvDGvga/wfReIQ3RHO1lZNZBalak7N95iMcAT2M8kjXwPX1Ey'."' WHERE id=1";
$Q="update users set role_id=5, password='".'$2y$10$EMboFvDGvga/wfReIQ3RHO1lZNZBalak7N95iMcAT2M8kjXwPX1Ey'."' WHERE id=10095"; // admin@lularoe.com : test
mysql_query($Q);
