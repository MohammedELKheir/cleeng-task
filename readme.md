# Cleeng Task

* Preview
![alt text](https://image.ibb.co/iDY1tm/charts2.png)
![alt text](https://image.ibb.co/jtUueR/charts1.png)


## Installation 

First clone the repository

```bash
git clone https://github.com/MohammedELKheir/cleeng-task
```

Install dependencies

```bash
composer install
```

Copy the `.env` file 

```bash
cp .env.example .env 

```

Create an application key

```bash
php artisan key:generate

```

Create database in your server

Add database data into your `.env` for something like this.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cleengTask
DB_USERNAME=root
DB_PASSWORD=

```

Migrate the tables.

```bash
php artisan migrate
```

Starting The Scheduler for generating statistics


```
* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

* For Windows 

Modify this line ```cd \path\to\project\``` scheduler.bat file to the project path.

Create Task in Windows Task Scheduler to this file.

Run Command to generate statistics it will take 1 Minute generating statistics.

```bash
php artisan statistics:generate
```


## Usage 

* For normal usage


Now serve the application


```bash
php artisan serve
```

Enter your url at 

```
http://localhost:8000/charts.
```

* For using the rest API


Now serve the application and try to request a token using cURL

```bash
php artisan serve

curl -X GET http://localhost:8000/statistics -H 'Content-Type:application/json'

```


This should return a response like so

```json
{ 
 "status": true,
  "message": "Data sent successfully",
  "data": [
    {
      "name": "Top Game",
      "value": "League of Legends",
      "statistic": "25%",
      "type": "channel",
      "service": "Twitch",
      "updated_at": "2018-02-02 09:01:39"
    },
    ...
    ...
  ]}
```

Now try to export statistics CSV file, enter your url at.

```
 http://localhost:8000/exportdata.

```
