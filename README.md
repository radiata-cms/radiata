Radiata CMS Project
===============================
Freeware [Yii2](www.yiiframework.com)-based CMS

Demo version (refreshes each hour):
Frontend: http://radiata.endeavour.com.ua
Backend: http://admin.radiata.endeavour.com.ua
Email: developer@site.dev
Password: developer^^

####Features:
* Yii2 advanced template
* Multi language
* Twitter bootstrap framework (backend)
* AdminLTE theme (backend)
* Separate domain for frontend and backend

####Installation:
* git init
* git clone https://github.com/radiata-cms/radiata.git
* composer global require "fxp/composer-asset-plugin:~1.1.0"
* composer install
* php ./init (choose prod environment)
* DB init: 
* * create database radiata character set utf8;
* * grant all on radiata.* to 'radiata'@'localhost' identified by 'radiata^^';
* fill config files
* ./yii migrate --interactive=0
* ./yii install
* ./yii install/fill-data (initial demo-data)

####Nginx backend virtual host additional config:
		location ^~ /uploads/ {
            if (-f $document_root/../../frontend/web$uri) {
                rewrite  ^(.*)$ http://your-site.com$uri last; break;
            }
        }
		location ^~ /images/ {
            if (-f $document_root/../../frontend/web$uri) {
                rewrite  ^(.*)$ http://your-site.com$uri last; break;
            }
        }
