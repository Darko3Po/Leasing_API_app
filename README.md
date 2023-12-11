# Project dev-darko

## 

This project is implemented using 
PHP 8.1 
Laravel 10.10. 
MySQL Database

The project provides API routes for device registration, obtaining device information, and updating leasing data for specific devices.

## Installation

1. Clone this repository to your local system.

2. Install dependencies using Composer:

   composer install

3. Create an .env file based on .env.example and configure it with the appropriate database settings and other configurations.

4. Generate the application key: php artisan key:generate

5. Run migrations to create the necessary database tables: php artisan migrate

6. Start the development server: php artisan serve

7. The application will be available at http://localhost:8000


## API Routes


   Device Registration

   Method: POST
   Route: /device/register
   Controller Method: DeviceController::register
   Description: Registers a device and assigns it a unique API key. It can also associate an activation code with the device.


   Device Information

   Method: GET
   Route: /device/info/{id}
   Controller Method: DeviceController::info
   Description: Retrieves information about a specific device based on its ID.


   Update Leasing Data

   Method: POST
   Route: /leasing/update/{id}
   Controller Method: DeviceController::update
   Description: Updates leasing data for a specific device.


   Authentication Check
   Method: GET
   Route: /user
   Description: Checks user authentication (uses Sanctum).



## Controller DeviceController.php

   This controller contains methods for registration, obtaining information, and updating devices.


   register Method
   Registers a device and assigns it a unique API key.
   Allows for the association of an activation code with the device.


   info Method
   Returns information about a device based on its ID.


   update Method
   Updates leasing data for a device.
   Please replace the comments in the code with the appropriate implementations and add any necessary validation and logic.