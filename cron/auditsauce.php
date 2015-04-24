<?php
include('lib/rb.php');

#R::setup('mysql:host=mwl.controlpad.com;dbname=llr_web','llr_web','7U8$SAV*NEjuB$T%');
R::setup('mysql:host=localhost;dbname=llr_dev','root','build4n0w');
R::freeze();

$fd = fopen('Exported_transactions.csv','r');
$headers = fgetcsv($fd,0);

$orphantotal = 0;
$ledgertotal = 0;
$ledgercount = 0;
$txtotal	 = 0;
$txcount	 = 0;
$orphancount = 0;

while($line = fgetcsv($fd,0)) { 
	$line = array_combine($headers, $line);
	$txcount++;
	$txtotal += floatval($line['Amount']) + floatval($line['Tax']);
	$ledger	= R::getRow("SELECT id,created_at,amount,tax FROM ledger WHERE transactionid=?",[ $line['Transaction ID'] ]);
	if ($ledger) {
		$lsum = floatval($ledger['amount']) + floatval($ledger['tax']);
		$asum = floatval($line['Amount']) + floatval($line['Tax']);
		$ledgercount++;
		$ledgertotal += $lsum;
	//	print "FOUND : {$ledger['id']} [{$lsum}] / [{$asum}]\n";
	}
	else {
		$asum = floatval($line['Amount']) + floatval($line['Tax']);
		$orphantotal += $asum;
		$orphancount++;
		print "ORPHAN: {$line['Transaction ID']} {$asum} @ {$line['Date & Time']} {$line['Merchant Name']} {$line['Card Holder']} {$line['AVS Street']} {$line['AVS Zip']}\n";
	}
}

print "ORPHAN TOTAL      : #{$orphancount} - \${$orphantotal}\n";
print "LEDGER TOTAL      : #{$ledgercount} - \${$ledgertotal}\n";
print "TRANSACTION TOTAL : #{$txcount} - \${$txtotal}\n";

/*
    [Transaction ID] => 805271367
    [Batch ID] => 26149452
    [Transaction Type] => S
    [Authcode] => 01154Z
    [Date & Time] => 03/16/15 14:47:03
    [Merchant Name] => LuLaRoe Field East
    [Invoice] => 
    [Amount] => 4.75
    [Currency] => 
    [Tax] => 0.00
    [Shipping] => 0.00
    [Subtotal] => 4.75
    [Card Holder] => Adam Campbell
    [AVS Street] => 1684 North 280 West
    [AVS Zip] => 84057
    [Card Type] => M
*/
