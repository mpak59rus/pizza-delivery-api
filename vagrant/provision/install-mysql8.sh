#!/usr/bin/env bash

source /app/vagrant/provision/common.sh

echo "Installing Dependencies..."
export DEBIAN_FRONTEND="noninteractive";
sudo apt-get update
sudo apt-get install -y debconf-utils vim curl
sudo debconf-set-selections <<< 'mysql-apt-config mysql-apt-config/select-server select mysql-8.0'
wget https://dev.mysql.com/get/mysql-apt-config_0.8.10-1_all.deb
sudo -E dpkg -i mysql-apt-config_0.8.10-1_all.deb
cd /tmp && curl -OL https://dev.mysql.com/get/mysql-apt-config_0.8.10-1_all.deb && dpkg -i mysql-apt-config*
sudo apt-key adv --recv-keys --keyserver pgp.mit.edu 5072E1F5
sudo apt-get update

# Install MySQL 8
echo "Installing MySQL 8..."
sudo debconf-set-selections <<< 'mysql-community-server mysql-community-server/re-root-pass password root'
sudo debconf-set-selections <<< 'myvsql-community-server mysql-community-server/root-pass password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
sudo -E apt-get -y install mysql-server

# Override any existing bind-address to be 0.0.0.0 to accept connections from host
echo "Updating my.cnf..."
sudo sed -i "s/^bind-address/#bind-address/" /etc/mysql/my.cnf
echo "[mysqld]" | sudo tee -a /etc/mysql/my.cnf
echo "bind-address=0.0.0.0" | sudo tee -a /etc/mysql/my.cnf
echo "default-time-zone='+00:00'" | sudo tee -a /etc/mysql/my.cnf
echo "default_authentication_plugin = mysql_native_password" | sudo tee -a /etc/mysql/my.cnf

echo "Granting root access via any IP..."
MYSQL_PWD=root mysql -u root -e "CREATE USER 'root'@'%' IDENTIFIED BY 'root'; GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION; FLUSH PRIVILEGES; SET GLOBAL max_connect_errors=10000;"

info "Initailize databases for MySQL"
MYSQL_PWD=root mysql -uroot <<< "CREATE DATABASE pizza CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
echo "Done!"

info "Create MySQL pizza user"
#user pizza
MYSQL_PWD=root mysql -uroot <<< "CREATE USER 'pizza'@'localhost' IDENTIFIED BY 'pizza';"
MYSQL_PWD=root mysql -uroot <<< "CREATE USER 'pizza'@'%' IDENTIFIED BY 'pizza';"
MYSQL_PWD=root mysql -uroot <<< "GRANT ALL PRIVILEGES ON *.* TO 'pizza'@'localhost';"
MYSQL_PWD=root mysql -uroot <<< "GRANT ALL PRIVILEGES ON *.* TO 'pizza'@'%';"
MYSQL_PWD=root mysql -uroot <<< "FLUSH PRIVILEGES"
echo "Done!"

echo "Granting pizza access with mysql_native_password"
MYSQL_PWD=root mysql -u root -e "ALTER USER 'pizza'@'%' IDENTIFIED WITH mysql_native_password BY 'pizza'; FLUSH PRIVILEGES;";

# Start MySQL server
echo "Restarting MySQL..."
sudo service mysql restart

echo "Provisioning Complete"
