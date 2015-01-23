<?php

class Server extends \BaseController {

	public function deploy_beta()
	{
		//return "Beta works!";
		SSH::into('beta')->run(array(
			'cd /var/www/html',
			'ls -la',
			//'echo $HOSTNAME',
			'git checkout develop',
			'git reset --hard origin/develop',
			'git pull -f',
			//'sudo chmod -R 777 app/storage',
			//'mysqldump -u  --password="" --no-data  | grep ^DROP | mysql -u   --password="" database',
			'composer install',
			//'php artisan migrate:refresh --seed --env=beta --force'
			//'php artisan migrate --force',
			//'php artisan migrate:refresh --force',
			//'php artisan db:seed --force',
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
			'cd /var/www/html',
			"php artisan down",
			"mysqldump -u root --password='Yr*r,dAv" . '$' . "S?qE8,N' soc_mob > /var/www/html/soc_mob_backup_" . date('Y_m_d_h_m') . ".sql",
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