<?php
// Import CSV dump into new system

$fd = fopen('Consultants.csv','r');
$headers = fgetcsv($fd, 2048);
$pubids = array();

while($line = fgetcsv($fd,2048))
{
	$line = array_combine($headers,$line);

	// hacky way to create unique ids
	$id = preg_replace('/[^a-z]/','',strtolower($line['FirstName'].$line['Surname']));
	while(in_array($id, $pubids)) $id .= date('s');
	$pibids[] = $id;

	if ($line['MemberStatus'] == 'active') { 
		$Q="INSERT INTO users set id='{$line['ID']}', first_name='".addslashes($line['FirstName'])."', last_name='".addslashes($line['Surname'])."', public_id='".addslashes($id)."', email='".addslashes($line['Email'])."', sponsor_id='{$line['SponsorID']}' ON DUPLICATE KEY UPDATE first_name='".addslashes($line['FirstName'])."', last_name='".addslashes($line['Surname'])."', public_id='".addslashes($id)."', email='".addslashes($line['Email'])."'";
	}
	else $Q = "DELETE FROM users WHERE id='{$line['ID']}'";

	print $Q.";\n";
}



die();
/*
 id                    | int(10) unsigned | NO   | PRI | NULL                | auto_increment |
| sponsor_id            | int(11)          | YES  |     | NULL                |                |
| original_sponsor_id   | int(11)          | YES  | MUL | NULL                |                |
| public_id             | varchar(25)      | NO   |     | NULL                |                |
| first_name            | varchar(50)      | NO   |     | NULL                |                |
| last_name             | varchar(50)      | NO   |     | NULL                |                |
| email                 | varchar(255)     | NO   |     | NULL                |                |
| password              | varchar(255)     | NO   |     | NULL                |                |
| gender                | varchar(2)       | NO   |     | NULL                |                |
| key                   | varchar(255)     | NO   |     | NULL                |                |
| dob                   | date             | NO   |     | NULL                |                |
| phone                 | varchar(15)      | NO   |     | NULL                |                |
| role_id               | int(11)          | NO   |     | NULL                |                |
| mobile_plan_id        | int(11)          | YES  |     | NULL                |                |
| min_commission        | decimal(6,2)     | NO   |     | NULL                |                |
| disabled              | tinyint(1)       | NO   |     | NULL                |                |
| created_at            | timestamp        | NO   |     | 0000-00-00 00:00:00 |                |
| updated_at            | timestamp        | NO   |     | 0000-00-00 00:00:00 |                |
| remember_token        | varchar(100)     | YES  |     | NULL                |                |
| phone_sms             | tinyint(1)       | NO   |     | NULL                |                |
| rank_id               | int(11)          | NO   |     | NULL                |                |
| image                 | varchar(255)     | NO   |     | NULL                |                |
| hide_gender           | tinyint(1)       | NO   |     | NULL                |                |
| hide_dob              | tinyint(1)       | NO   |     | NULL                |                |
| hide_billing_address  | tinyint(1)       | NO   |     | NULL                |                |
| hide_shipping_address | tinyint(1)       | NO   |     | NULL                |                |
| hide_phone            | tinyint(1)       | NO   |     | NULL                |                |
| hide_email            | tinyint(1)       | NO   |     | NULL                |                |
| block_email           | tinyint(1)       | NO   |     | NULL                |                |
| block_sms             | tinyint(1)       | NO   |     | NULL                |                |
| subscription_notice   | date             | NO   |     | NULL                |                |
| subscribed            | date             | NO   |     | NULL                |                |
| verified              | int(11)          | NO   |     | NULL                |                |
| hasSignUp             | int(11)          | NO   |     | NULL                |                |
| consignment
*/
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
