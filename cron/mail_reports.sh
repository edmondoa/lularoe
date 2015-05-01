################################################################
report_dir="reports/orders/"
report_date=$(date "+%Y-%m-%d" -d "-1 days")

rollupfile="reports/orders/$report_date.rollup.csv"
receiptfile="reports/orders/$report_date.receipts.csv"
#mailing_list="mfrederico@gmail.com,ammon@lularoe.com,austin@lularoe.com,acampbell@controlpad.com"
mailing_list="mfrederico@gmail.com,m.fred@cyberteknix.com"
################################################################

mkdir -p $report_dir
php inventory_report.php 1 $report_dir
echo "See attached report" | mutt -s "End of day orders: $report_date" -x -a $rollupfile $receiptfile -- $mailing_list
