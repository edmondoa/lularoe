<?php
// Old LLR db importer into new system

$lnk	= mysql_connect('localhost','root','build4n0w');
if (!$lnk ) die("Cannot connect to DB .. \n");
mysql_select_db('llr_dev', $lnk);

// Set up query details
$row	= array();
$Q		= "select * from ledger where user_id=0";

// fire off initial query
$res	= mysql_query($Q);

// If we have an error; Die - just die.
if (mysql_error()) die(mysql_error());
if (!$res) die("Nothing to show for that query.\n");

$numsold = array();
while($row = mysql_fetch_assoc($res)) {
	$orderdata = json_decode($row['data']);
	$cartitems = json_decode($orderdata->cart);
	foreach($cartitems as $item) {
		$numsold[$item->model.'-'.$item->size] +=  $item->numOrder;
	}
}
print_r($numsold);
