<?php

class Server extends \BaseController {

	public function deploy()
	{
		return "Deploying";
		SSH::into('beta')->run(array(
		    'cd /var/www/html',
		    //'ls -la',
		    //'echo $USER',
		    'git reset --hard origin/realtysync',
		    'git pull -f',
		    //'sudo chown -R apache:apache /var/www/html/app',
		    //'sudo chown -R apache:apache /var/www/html/bootstrap',
		    //'sudo chown -R apache:apache /var/www/html/public',
		    //'sudo chmod -R 777 app/storage',
		    //'mysqldump -u realtysync --password="aju3*8YsUrAD&S&s" --no-data realtysync | grep ^DROP | mysql -u realtysync  --password="aju3*8YsUrAD&S&s" realtysync',
		    //'composer install',
		    //'php artisan migrate:refresh --seed --env=production --force'
		    //'php artisan migrate --force',
		    'php artisan migrate:refresh --force',
		    'php artisan db:seed --force',
		), function($line){
		 
		    echo $line.PHP_EOL; // outputs server feedback
		});		//
	}

}