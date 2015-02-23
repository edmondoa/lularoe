#!/usr/bin/env bash

#update packages list
sudo apt-get update

#mysql
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password password2'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password password2'

#base packages
sudo apt-get install -y vim curl python-software-properties

#update packages list
sudo apt-get update

#php
sudo add-apt-repository -y ppa:ondrej/php5

#update packages list
sudo apt-get update

#php packages
sudo apt-get install -y php5 apache2 libapache2-mod-php5 php5-curl php5-gd php5-mcrypt mysql-server-5.5 php5-mysql git-core

#phpmyadmin
sudo apt-get update
sudo apt-get install phpmyadmin
sudo php5enmod mcrypt
# sudo nano /etc/apache2/apache2.conf
# Add this line
# Include /etc/phpmyadmin/apache.conf


#xdebug
sudo apt-get install -y php5-xdebug
cat << EOF | sudo tee -a /etc/php5/mods-available/xdebug.ini
xdebug.scream=1
xdebug.cli_color=1
xdebug.show_local_vars=1
EOF

#enable mod-rewrite
sudo a2enmod rewrite

#set document root to public id directory | update as needed
sudo rm -rf /var/www/html
sudo ln -fs /vagrant/public /var/www/html

#turn on php errors
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php5/apache2/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php5/apache2/php.ini

#restart apache
sudo service apache2 restart

#composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

######################
# Laravel specific
######################

#set permissions for laravel storage folder
chmod -R o+w /vagrant/app/storage

#install dependencies
#composer install

