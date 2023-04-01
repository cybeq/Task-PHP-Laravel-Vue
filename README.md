![img.png](img.png)

#### Warning: This app require database migration and SMTP/POP3/IMAP configuration


````
rename -> .example.env -> .env
then set database and email configuration
````

# Step 1:
## Use Factory
````
php artisan tinker
-> App\Models\Car::factory(20)->create();
-> App\Models\Employee::factory(20)->create();
-> App\Models\Client::factory(20)->create();
-> App\Models\Order::factory(20)->create();
````
---------------

# Step 2:
## Make test
### (You can skip Step1, test includes factory in setup)
````
php artisan test tests/CrudControllerTest.php
````
----------------
# Step 3:
## Use app
````
cd ./vue
$ npm run serve

cd ./laravel
$ php artisan serve
````
#### Then you will be able to run application directly on localhost:8000/
#### or through VUE and Laravel as API on localhost:8080/

_____________________________
_____________________________

----------------------
#### (___ INSTRUCTIONS OF USE ___)
__________________________
1. If you didn't test or use factory, you probably don't have any models. So add after each one to be able to take advantage of the full functionality.
 ----------------------------
2. You can edit all possible data and connections between models in the Client edit section. Other models are also editable, but relations are not edited in them, so as not to double the functionality that already exists. The car is an exception. You can add employees for the car also in this model.