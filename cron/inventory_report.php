<?php
include('lib/rb.php');

R::setup('mysql:host=mwl.controlpad.com;dbname=llr_web','llr_web','7U8$SAV*NEjuB$T%');
R::freeze();

$days_ago		= (isset($argv[1])) ? $argv[1] : 1;
$report_folder	= (!empty($argv[2])) ? $argv[2] : "reports/orders/";

$start_date     = date('Y-m-d 00:00:00',strtotime("-{$days_ago} DAY"));
$end_date     	= date('Y-m-d 23:59:59',strtotime("-{$days_ago} DAY"));
$report_date	= date('Y-m-d',strtotime($start_date));


$receiptfile	= $report_folder."{$report_date}.receipts.csv";
$rollupfile		= $report_folder."{$report_date}.rollup.csv";
$pricerollup = $modelrollup = $userreceiptlist = array();

$rcf = fopen($receiptfile,'w');
fputs($rcf, "\"REPORTING DATE\",\"RECEIPT ID\", \"TXN IDS\", \"REP ID\",\"REP EMAIL\",\"REP FIRST\",\"REP LAST\",\"QTY\",\"ITEM\",\"PRICE\",\"TOTAL\"\n");

$ruf = fopen($rollupfile,'w');
fputs($ruf, "\"REPORTING DATE\",\"ITEM\",\"COUNT\", \"SALES\"\n");

$user = array();

try{ 
	$receipts = R::find('receipts','user_id=? AND created_at BETWEEN ? AND ?',[0, $start_date, $end_date ]);
}
catch (Exception $e) {
	die($e->getMessage());
}

foreach($receipts as $receipt) {
	addData($receipt);
}

foreach($userreceiptlist as $receipt_id=>$receipts) {
	$itemlistCSV 	= '';
	$user 			= '';
	foreach($receipts as $email=>$items) {
		foreach($items as $item) $itemlistCSV .= ','.arrayToCsv($item,',');	
	}
	$email = key($receipts);

	$ledger			= '';
	$user			= R::findOne('users','email=?',[$email]);
	$receipt		= R::findOne('receipts',"id=?",[$receipt_id]);
	$ledgeritems 	= R::find('ledger','receipt_id=?',[$receipt_id]);
	foreach($ledgeritems as $li) {
		$ledger .= $li->transactionid.',';
	}
	rtrim($ledger,',');

	@fputs($rcf, "{$report_date}, {$receipt_id}, \"{$ledger}\", {$user->id},\"{$receipt->to_email}\",\"{$receipt->to_firstname}\",\"{$receipt->to_lastname}\"".$itemlistCSV."\n");
}

foreach($modelrollup as $item=>$quan)  {
	fputs($ruf,"\"{$report_date}\", \"{$item}\", -{$quan}, {$pricerollup[$item]}\n");
}

fclose($rcf);
fclose($ruf);
`echo "See attached report" | mailx -A $rollupfile -A $receiptfile -s "End of day orders: $report_date" mfrederico@gmail.com`;


function addData($receipt) {
	global $userreceiptlist, $modelrollup, $pricerollup;
	$items = json_decode($receipt['data'], true);

	if (!isset($userreceiptlist[$receipt->id])) $userreceiptlist[$receipt->id] = array();
	
	foreach($items as $item) {
		$model	= strtoupper($item['model'].' - '.key($item['quantities']));
		$qty 	= array_shift($item['quantities']);
		$price	= $item['price'];
		$value	= $price * $qty;

		// Create a list of items per user
		$userreceiptlist[$receipt->id][$receipt->to_email][] = array('QTY'=>'-'.intval($qty),'ITEM'=>$model,'PRICE'=>$price,'VALUE'=>$value);

		// Create a rollup of items
		if (!isset($modelrollup[$model])) {
			$modelrollup[$model] = 0;
			$pricerollup[$model] = 0;
		}

		$modelrollup[$model] += intval($qty);
		$pricerollup[$model] += ($qty > 0) ? $price * $qty : 0;
	}

}

function arrayToCsv( array &$fields, $delimiter = ';', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false ) {
    $delimiter_esc = preg_quote($delimiter, '/');
    $enclosure_esc = preg_quote($enclosure, '/');

    $output = array();
    foreach ( $fields as $field ) {
        if ($field === null && $nullToMysqlNull) {
            $output[] = 'NULL';
            continue;
        }

        // Enclose fields containing $delimiter, $enclosure or whitespace
        if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) ) {
            $output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
        }
        else {
            $output[] = $field;
        }
    }
    return implode( $delimiter, $output );
}
