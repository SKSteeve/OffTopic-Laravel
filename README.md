# OffTopic-Laravel
Currently working on

This is CRUD project with Laravel using:
   **jQuery**,**AJAX**,**PHP**,**MySQL** **...**


#
## **Download and setup on your computer**

### 0. You need to have:
   * **Git**
   * **Composer**
   * **Laravel**
   * **PHP 7+**
   * **Running MySQL & (Apache)**
#
### 1. Create empty folder in your **localhost directory**.
### 2. Open the folder with cmd and execute:
   * **git clone https://github.com/SKSteeve/OffTopic-Laravel.git**
   * **cd OffTopic-Laravel/OffTopic**
   * **composer install**
   * **php artisan storage:link**
   * **cp .env.example .env**
   * **php artisan key:generate**
### 3. Create an empty database for the project.
   * you can use **phpMyAdmin**, **HeidiSQL** or other tool
   * use **utf8_general_ci**
### 4. Open CRUD/.env file and fill:
   * **APP_NAME**=OffTopic

   * **DB_CONNECTION**=mysql
   * **DB_HOST**=127.0.0.1
   * **DB_DATABASE**=< the name of the database you created >
   * **DB_USERNAME**=< your username >
   * **DB_PASSWORD**=< your password >
### 5. To Migrate and Seed the database execute:
   * **php artisan migrate:fresh --seed**
### 6. Now type in the browser the url:
   * **localhost/**< the folder you created at step 1 >**/OffTopic-Laravel/OffTopic/public**
### 7. Test:
   Log as admin
   * email -> **remzi@da.com**
   * password -> **password**
   
   Log as user
   * email -> **marti-parti@gmail.com**
   * password -> **password**
