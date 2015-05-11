# MySQL settings
mysql_user="root"
mysql_password="53eqRpYtQPP94apf"
database="llr"
launchdate="2015-04-07"

mailing_list="mfrederico@gmail.com,ammon@lularoe.com,jeff@lularoe.com"
mailing_list="mfrederico@gmail.com"

report_date=$(date "+%Y-%m-%d" -d "-1 days")
startdate="$report_date 00:00:00"
enddate="$report_date 23:59:59"

# Full cmd
mysqlcmd="mysql -u root -p$mysql_password $database"
 
# Create backup directory and set permissions
# report_date=`date +%Y_%m_%d`
report_filename="rep_rollup-$report_date.tsv"


function query {
	query="SELECT CONCAT(user_id,'-',id) as 'Order ID#',tax,subtotal,CONCAT(to_firstname,' ',to_lastname) 'Rep Name',date_paid as 'Paid Date',CASE shipped WHEN shipped != '0000-00-00 00:00:00' THEN 'shipped' ELSE 'warehouse' END 'Shipped Status',note from receipts where date_paid != '0000-00-00 00:00:00' order by created_at DESC"
	echo $query	
}

echo "ORDER ROLLUP $report_date" > $report_filename
echo " " >> $report_filename

query | $mysqlcmd >> $report_filename

echo "See attached report" | mailx -a $report_filename -s "ORDER ROLLUP THROUGH: $report_date" $mailing_list
