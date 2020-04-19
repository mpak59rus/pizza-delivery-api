#!/usr/bin/env bash

source /app/vagrant/provision/common.sh

#== Import script args ==

timezone=$(echo "$1")

#== Provision script ==

info "Provision-script user: `whoami`"

export DEBIAN_FRONTEND=noninteractive

info "Configure timezone"
timedatectl set-timezone ${timezone} --no-ask-password

info "Update OS software"
apt-get update
apt-get upgrade -y
echo "Done!"

info "Install additional software"
apt-get install -y unzip nginx php.xdebug mc git curl build-essential python dos2unix
echo "Done!"

info "Install newest PHP 7.4 and dependencies"
sudo apt-get update
sudo apt -y install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install -y php7.4-{bcmath,bz2,cli,curl,mysql,gd,intl,json,mbstring,soap,sqlite3,xml,zip,xdebug,fpm}
echo "Done!"

info "Configure NGINX"
sed -i 's/user www-data/user vagrant/g' /etc/nginx/nginx.conf
echo "Done!"

info "Enabling site configuration"
ln -s /app/vagrant/nginx/app.conf /etc/nginx/sites-enabled/app.conf
echo "Done!"

info "Install composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
echo "Done!"

info "Configure PHP-FPM"
sed -i 's/user = www-data/user = vagrant/g' /etc/php/7.4/fpm/pool.d/www.conf
sed -i 's/group = www-data/group = vagrant/g' /etc/php/7.4/fpm/pool.d/www.conf
sed -i 's/owner = www-data/owner = vagrant/g' /etc/php/7.4/fpm/pool.d/www.conf
cat << EOF > /etc/php/7.4/mods-available/xdebug.ini
zend_extension=xdebug.so
xdebug.default_enable=1
xdebug.remote_enable=1
xdebug.remote_connect_back=1
xdebug.remote_port=9000
xdebug.remote_autostart=1
xdebug.remote_host=192.168.83.1
xdebug.idekey=PHPSTORM
EOF
cat << EOF > /etc/environment
PHP_IDE_CONFIG="serverName=BackendLocal"
EOF
echo "Done!"
