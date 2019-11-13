# README #

This README contains steps necessary to get your application up and running.

### System Requirments ###

* Visual Studio Code w/ Docker Plugin
* Docker Desktop (https://www.docker.com/products/docker-desktop)

### What is this repository for? ###

* Docker container for local dev of CYBE website
* 1.0
* [Learn Markdown](https://bitbucket.org/tutorials/markdowndemo)

### Steps to get Docker instace running ###
1. You will need access to the cybe-website Git repository:
    
    1. Clone down the cybergrx-website repository:
    
        $ git clone git@github.com:CyberGRX/cybergrx-website.git
	
    1. Obtain the MySQL database dump, and the uploads folder.
        1. You can download the MySQL database, and the uploads files from within the Wordpress admin on production. You may create a backup to obtain the latest data if the available backups are outdated. 

            https://www.cybergrx.com/wp-admin/options-general.php?page=updraftplus

        1. Put the downloaded database dump into the folder: docker-local/initdb.d
        1. Put the downloaded uploads into the folder: www/wp-content/uploads

1. Edit the docker-local/configs/15-xdebug.ini file.
    1. Get your machines IP address and set the IP for the setting xdebug.remote_host into the 15-xdebug.ini file. You can use ipconfig command from your windows host to see the IP of "Ethernet adapter Local Area Connection"

        To get IP address in windows command prompt run:

            $ ipconfig /all 

        and locate the Ethernet adapter Ethernet section value "IPv4 address"

1. Add an entry within your hosts file to map
   "cybergrx.local" to 127.0.0.1

1. Navigate to docker-local folder via terminal

1. Execute:
	$  docker-compose up -d --build --force-recreate

    or

	$ docker-compose build --force-rm 

    which will build, force remove intermediate containers, and startup the containers. You only do this to rebuild the docker image. 

1. Once you've built the docker images, you can bring up the container using:

	$ docker-compose up
	
1. Open browser and access site using either:
	- http://cybergrx.local/ (for HTTP access)
	- https://cybergrx.local/ (for HTTPS access)

    NOTE:
	- Make sure no other services are binding to ports 80 and 443
	  such as IIS otherwise you will receive an error when running "docker-compose up"

### xDebug in VSCode ###

    Install the PHP Debug vscode extension
        - https://marketplace.visualstudio.com/items?itemName=felixfbecker.php-debug
    1. Install PHP 5.6 and XDebug onto your local machine for the correct version of PHP (5.6)
        - Install PHP 5.6 through IIS Management Studio (may also include Microsoft Drivers 3.2 for PHP v5.6 for SQL Server in IIS, Windows Cache Extension 1.3 for PHP 5.6, PHP 5.6.31, PHP Manager for IIS)
        - https://xdebug.org/download.php 
    1. Allow inbound traffic to port 9000 on host machine

### Tips ###

    To have the docker instance correctly handle internal cybergrx.local 
    requests (ex. cURL), edit the /etc/hosts file in the docker instance and add the following line:
    127.0.0.1   cybergrx.local



