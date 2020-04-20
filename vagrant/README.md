# Pizza Test API Vagrant container

Vagrant contains:
1. Ubuntu 16.04
2. MySql 8
3. php 7.4 + xdebug 
4. nginx 1.12.2

## Install
1. Install [Vagrant](https://www.vagrantup.com/)
2. Install [VirtualBox](https://www.virtualbox.org)
3. For Windows need to install vagrant plugin install vagrant-winnfsd
4. Change params in .env file for vagrant
5. run:
```
vagrant up
```

## Using 
Database Mysql 192.168.83.137, логин/пароль pizza/pizza

After load Vargant API is on address
- http://api.pizza.local 

For su - password root
sudo works without password

