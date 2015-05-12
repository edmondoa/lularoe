# MySQL settings
mysql_user="root"
mysql_password="53eqRpYtQPP94apf"
database="llr_web"
launchdate="2015-04-07"

mailing_list="m.fred@cyberteknix.com,ammon@lularoe.com,jeff@lularoe.com"
mailing_list="mfrederico@gmail.com"

report_date=$(date "+%Y-%m-%d" -d "-1 days")
startdate="$report_date 00:00:00"
enddate="$report_date 23:59:59"

# Full cmd
mysqlcmd="mysql -u root -p$mysql_password $database"
 
# Create backup directory and set permissions
# report_date=`date +%Y_%m_%d`
report_filename="reports/orders_rollup-$report_date.tsv"


function query {
	query="SELECT txtype as 'Payment Type',CONCAT(receipts.id) as 'Order ID#',receipts.tax,subtotal,CONCAT(to_firstname,' ',to_lastname) 'Rep Name',date_paid as 'Paid Date',CASE shipped WHEN shipped != '0000-00-00 00:00:00' THEN 'shipped' ELSE 'warehouse' END 'Shipped Status',transactionid as 'Gateway TXID' from receipts left join ledger ON (ledger.receipt_id=receipts.id) where date_paid >= '$startdate' AND receipts.user_id=0 order by receipts.created_at DESC"
	echo $query	
}

echo "ORDER ROLLUP $report_date" > $report_filename
echo " " >> $report_filename

query | $mysqlcmd >> $report_filename

echo "See attached report" | mailx -a $report_filename -s "ORDER ROLLUP THROUGH: $report_date" $mailing_list
