<?php

class Server extends \BaseController {

	public function deploy_beta()
	{
		//return "Beta works!";
		SSH::into('beta')->run(array(
			// back up db
			"php artisan down",
			"mysqldump -u root --password='Yr*r,dAv$S?qE8,N' soc_mob > /var/www/html/soc_mob_backup_" . date('Y_m_d_h_m') . ".sql",
			'cd /var/www/html',
			// 'ls -la',
			'git pull',
			//'sudo chmod -R 777 app/storage',
			'composer install --no-dev',
			'php artisan migrate',
			"php artisan up"
		), function($line){
		 
			echo $line.PHP_EOL; // outputs server feedback
		});		//
		exit;
	}

	public function deploy_production()
	{
		//return "Deploying";
		SSH::into('production')->run(array(
			// back up db
			"php artisan down",
			"mysqldump -u root --password='Yr*r,dAv$S?qE8,N' soc_mob > /var/www/html/soc_mob_backup_" . date('Y_m_d_h_m') . ".sql",
			'cd /var/www/html',
			// 'ls -la',
			'git pull',
			//'sudo chmod -R 777 app/storage',
			'composer install --no-dev',
			'php artisan migrate',
			"php artisan up"
		), function($line){
		 
			echo $line.PHP_EOL; // outputs server feedback
		});		//
		exit;
	}

}