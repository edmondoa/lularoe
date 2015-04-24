# MySQL settings
mysql_user="root"
mysql_password="53eqRpYtQPP94apf"
database="llr"

mailing_list="m.fred@cyberteknix.com" #,acampbell@controlpad.com"

# Full cmd
mysqlcmd="mysql -u root -p$mysql_password $database"
 
# Create backup directory and set permissions
report_date=`date +%Y_%m_%d`
report_filename=$report_date.tsv

report_date=$(date "+%Y-%m-%d" -d "-1 days")
startdate="$report_date 00:00:00"
enddate="$report_date 23:59:59"


atest=$report_date

# dump database for nightly backup
mysqldump -u $mysql_user -p$mysql_password llr_web | gzip > llr_web-$report_date.sql.gz
mysqldump -u $mysql_user -p$mysql_password llr | gzip > llr-$report_date.sql.gz

echo "LLR Database Backup $report_date" | mailx -a llr_web-$report_date.sql.gz -a llr-$report_date.sql.gz -s "LLR Database backup: $report_date" m.fred@cyberteknix.com

function query {
	query="SELECT DATE_FORMAT(created_at,'%Y-%m-%d') TXDATE, SUM(amount) Amount, SUM(tax) Tax,count(*) '# Txns', round(avg(amount),2) as 'Avg' from llr_web.ledger WHERE txtype='$1' AND $2 AND created_at >= '2015-04-02' GROUP BY TXDATE"
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
echo "--- AGGREGATE ---" >> $report_filename
echo "NOTE: MWL ADDS TAX AND AMOUNT TOGETHER FOR FINAL AMOUNT" >> $report_filename
echo "NON CASH TRANSACTIONS FROM MWL" >> $report_filename
echo "select DATE_FORMAT(created_at,'%Y-%m-%d') TXDATE, round(sum(authAmount),2) amount, round(sum(salesTax),2) tax,count(*) txns from llr.transaction WHERE cashsale=0 AND created_at >= '2014-04-02' group by TXDATE" | $mysqlcmd >> $report_filename
echo " " >> $report_filename
                                                     
echo "CASH TRANSACTIONS FROM MWL" >> $report_filename
echo "select DATE_FORMAT(created_at,'%Y-%m-%d') TXDATE, round(sum(authAmount),2) amount, round(sum(salesTax),2) tax,count(*) txns from llr.transaction WHERE cashsale=1 AND created_at >= '2014-04-02' group by TXDATE" | $mysqlcmd >> $report_filename

#echo "select date_format(max(transaction.created_at),'%Y-%m-%d') as activity,user_id,round(sum(authAmount),2) as amount,round(sum(salesTax)) as tax,count(1) as txns,cashsale as is_cash from transaction left join llr_web.ledger on(llr_web.ledger.transactionid=transaction.refNum) where 1 group by cashsale,user_id order by txns ASC" | $mysqlcmd > activity_report.$report_date.tsv
echo "select date_format(transaction.created_at,'%Y-%m-%d') as activity,user_id,round(sum(authAmount),2) as amount,round(sum(salesTax)) as tax,count(1) as txns,cashsale as is_cash from transaction left join llr_web.ledger on(llr_web.ledger.transactionid=transaction.refNum) where user_id > 0 and transaction.created_at BETWEEN '$report_date 00:00:00' AND '$report_date 23:59:59' AND user_id > 0 group by date_format(transaction.created_at,'%Y-%m-%d'),cashsale,user_id order by txns,transaction.created_at ASC" | $mysqlcmd > activity_report.$report_date.tsv

echo "See attached activity report" | mailx -a activity_report.$report_date.tsv -s "Activity report: $report_date" $mailing_list
echo "See attached report" | mailx -a $report_filename -s "End of day report: $report_date" $mailing_list
