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
