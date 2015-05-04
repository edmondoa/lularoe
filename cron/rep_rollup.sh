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
	query="SELECT llr_web.ledger.user_id,concat(llr_web.users.first_name,' ',llr_web.users.last_name) repname, date_format(llr_web.ledger.created_at,'%Y-%m-%d')ca, SUM(CASE txtype WHEN \"CARD\" THEN amount+tax END) CARD, SUM(CASE txtype WHEN \"CASH\" THEN amount+tax END) CASH, SUM(CASE txtype WHEN \"CARD\" then ROUND(transaction.authAmount,2) END) AUTHCARD, SUM(tax) as TAX, SUM(amount+tax) as TOTAL FROM llr_web.ledger left join transaction on (transaction.refNum = ledger.transactionid) LEFT JOIN llr_web.users ON (user_id=llr_web.users.id) WHERE llr_web.ledger.user_id > 0 group by user_id,ca order by repname,ca";
	echo $query	
}

echo "USER ROLLUP $report_date" > $report_filename
echo " " >> $report_filename

query | $mysqlcmd >> $report_filename

echo "See attached report" | mailx -a $report_filename -s "REP ROLLUP THROUGH: $report_date" $mailing_list
