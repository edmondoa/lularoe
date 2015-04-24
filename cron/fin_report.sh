# MySQL settings
mysql_user="root"
mysql_password="53eqRpYtQPP94apf"
database="llr"
launchdate="2015-04-07"

mailing_list="mfrederico@gmail.com,ammon@lularoe.com,jeff@lularoe.com"

report_date=$(date "+%Y-%m-%d" -d "-1 days")
startdate="$report_date 00:00:00"
enddate="$report_date 23:59:59"

# Full cmd
mysqlcmd="mysql -u root -p$mysql_password $database"
 
# Create backup directory and set permissions
# report_date=`date +%Y_%m_%d`
report_filename="fin-$report_date.tsv"


function query {
	query="SELECT DATE_FORMAT(created_at,'%Y-%m-%d') TXDATE, SUM(amount) Amount, SUM(tax) Tax,count(*) '# Txns', round(avg(amount),2) as 'Avg' from llr_web.ledger WHERE txtype='$1' AND $2 AND created_at BETWEEN \"$startdate\" AND \"$enddate\" GROUP BY TXDATE"
	echo $query	
}

echo "END OF REPORTING DAY $report_date" > $report_filename
echo " " >> $report_filename
echo "--- REP SALES ---" >> $report_filename
echo "CREDIT CARDS" >> $report_filename
query 'CARD' 'user_id > 0' | $mysqlcmd >> $report_filename
                                                     
echo " " >> $report_filename
echo "CASHOLA " >> $report_filename
query 'CASH' 'user_id > 0'  | $mysqlcmd >> $report_filename
                                                     
echo " " >> $report_filename
echo "ACH" >> $report_filename
query 'ACH' 'user_id > 0'  | $mysqlcmd >> $report_filename

echo " " >> $report_filename
echo "--- CORP SALES ---" >> $report_filename
echo "CREDIT CARDS" >> $report_filename
query 'CARD' 'user_id = 0' | $mysqlcmd >> $report_filename
                                                     
echo " " >> $report_filename
echo "CASHOLA " >> $report_filename
query 'CASH' 'user_id = 0'  | $mysqlcmd >> $report_filename
                                                     
echo " " >> $report_filename
echo "ACH" >> $report_filename
query 'ACH' 'user_id = 0'  | $mysqlcmd >> $report_filename

echo " " >> $report_filename
echo "--- RECEIPTS and ORDERS -- " >> $report_filename
echo "select date_format(receipts.created_at,'%Y-%m-%d') as \`date\`,concat('https://mylularoe.com/invoice/view/',receipts.id) invoice,subtotal,to_email,users.id,concat(to_firstname,' ',to_lastname)name from llr_web.receipts left join llr_web.users on(users.email=to_email) where user_id=0 AND receipts.created_at BETWEEN \"$startdate\" AND \"$enddate\" ORDER BY receipts.created_at desc;" | $mysqlcmd >> $report_filename

#echo "See attached report" | mailx -a $report_filename -s "End of day report: $report_date" mfrederico@gmail.com
echo "See attached report" | mailx -a $report_filename -s "End of day report: $report_date" $mailing_list
