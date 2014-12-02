<?
	session_start();
	if (isset($_GET['timezone'])) {$_SESSION['timezone'] = $_REQUEST['timezone'];}
	echo $_REQUEST['timezone'];
?>
