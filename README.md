Yii 2 Weather App Project
============================

## INSTALLATION
```
git clone https://github.com/lazycoder9/weather_app.git
cd weather_app
composer install
```
Configure database in `config/db.php` (database in config should exist).
After configuring run migration
```
php yii migrate
```
Start the server
```
php yii serve
```
and go to localhost:8080 at browser

### Project's current state
```
- There are weather data only for Tashkent from 1st of May to nowadays
- Request weather data for other cities does not work
```
