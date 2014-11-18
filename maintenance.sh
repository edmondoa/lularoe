#! /bin/bash
#@daily /var/www/html/maintenance.sh
# Parent backup directory
backup_parent_dir="/var/www/db_backup/"

# MySQL settings
mysql_user="root"
mysql_password="Yr*r,dAv$S?qE8,N"
 
# Create backup directory and set permissions
backup_date=`date +%Y_%m_%d_%H_%M_%p`
backup_dir="${backup_parent_dir}${backup_date}"
single_quote="'"
echo "Backup directory: ${backup_dir}"
echo --password="$single_quote$mysql_password$single_quote"
mkdir -p "${backup_dir}"
chmod 755 "${backup_dir}"

# Get MySQL databases
mysql_databases=`echo 'show databases' | mysql --user=${mysql_user} --password="$mysql_password" -B | sed /^Database$/d`
 
# Backup and compress each database
for database in $mysql_databases
do
  if [ "${database}" == "information_schema" ] || [ "${database}" == "performance_schema" ]; then
        additional_mysqldump_params="--skip-lock-tables"
  else
        additional_mysqldump_params=""
  fi
  echo "Creating backup of \"${database}\" database"
  mysqldump ${additional_mysqldump_params} --user=${mysql_user} --password="$mysql_password" ${database} | gzip > "${backup_dir}/${database}.gz"
  chmod 775 "${backup_dir}/${database}.gz"
done

find "${backup_parent_dir}" -maxdepth 1 -type d -mtime +7 -exec rm -f {} \;