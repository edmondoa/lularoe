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
			'cd /var/www/html',
			'ls -la',
			//'git pull',
			//'sudo chmod -R 777 app/storage',
			//'composer install --no-dev',
			//'php artisan migrate'
		), function($line){
		 
			echo $line.PHP_EOL; // outputs server feedback
		});		//
		exit;
	}

}