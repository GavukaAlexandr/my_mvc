LAUNCH

restore the database dump from mymvc_dump.sql
````
mysql -u USER -pPASSWORD DATABASE < /path/to/mymvc_dump.sql
````

configure Config/DbConfig.php

Apache config

````
Listen 80
<VirtualHost *:80>
	ServerName mymvc    
	ServerAlias www.mymvc
DocumentRoot "/home/alex/www/my_mvc"
<Directory /home/alex/www/my_mvc>
        AllowOverride None
	Require all granted
        Allow from All


        <IfModule mod_rewrite.c>
            Options -MultiViews
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*)$ index.php [QSA,L]
        </IfModule>
    </Directory>    

    # Other directives here
</VirtualHost>
````
