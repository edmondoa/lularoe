#! /bin/bash
#@daily /var/www/html/maintenance.sh
# Parent backup directory
backup_parent_dir="/var/www/db_backup/"

# MySQL settings
mysql_user="root"
mysql_password="Yr*r,dAv$S?qE8,N"
database="soc_mob"
 
# Create backup directory and set permissions
backup_date=`date +%Y_%m_%d_%H_%M_%p`
backup_dir="${backup_parent_dir}${backup_date}"
echo "Backup directory: ${backup_dir}"
mkdir -p "${backup_dir}"
chmod 755 "${backup_dir}"

# Backup and compress each database
mysqldump ${additional_mysqldump_params} --user=${mysql_user}  --password='Yr*r,dAv$S?qE8,N' ${database} | gzip > "${backup_dir}/${database}.gz"
 
#delete old files
<<<<<<< HEAD
find "${backup_parent_dir}" -maxdepth 1 -type d -mtime +7 -exec rm -f {} \;
=======
find "${backup_parent_dir}" -maxdepth 1 -type d -mtime +7 -exec rm -Rf {} \;
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
