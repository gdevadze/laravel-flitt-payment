# Laravel Flitt Payment Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/devadze/laravel-flitt-payment)](https://packagist.org/packages/devadze/laravel-flitt-payment)
[![Total Downloads](https://img.shields.io/packagist/dt/devadze/laravel-flitt-payment)](https://packagist.org/packages/devadze/laravel-flitt-payment)

A simple and elegant Laravel package for integrating the [Flitt Payment Gateway](https://flitt.com) into your Laravel application.

---

## 🚀 Features

- Seamless Flitt payment integration
- Clean fluent API via Facade (`Flitt::setAmount(...)->redirect()`)
- Automatic signature generation
- Callback URL handling
- Configurable merchant settings
- Extendable via service class, trait, and contract

---

## 📦 Installation

Install the package via Composer:

You can install the package via composer:

```bash
composer require devadze/laravel-flitt-payment
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Devadze\FlittPayment\FlittPaymentServiceProvider"
```

Once published, the configuration file will be available at:
```bash
config/flitt.php
```

And run migrations:
```bash
php artisan migrate
```

## Environment Variables
Add the following variables to your `.env` file to configure the package:

```dotenv
FLITT_MERCHANT_ID=your_merchant_id
FLITT_SECRET_KEY=your_secret_key
FLITT_RESPONSE_URL=https://yourdomain.ge
FLITT_CALLBACK_URL=https://yourdomain.ge/flitt/callback # Used only if custom callback is needed
```

## Usage

### Usage Example: Simple Payment Processing

To initiate a payment, use the `FlittPayment` facade to set the order details and redirect:

```php
use Devadze\FlittPayment\Facades\FlittPayment;

$response = FlittPayment::setOrderDesc('ბალანსის შევსება')->setAmount(5)->redirect();

return redirect($response['checkout_url']);
```

## Callback Handling

The package handles callback behavior automatically. When a payment is processed, it will send a POST request to your callback URL with the payment details.

Example: Registering a Listener for Flitt Payment Updates
Add the following code to your event listener:

```php
namespace App\Listeners;

use Devadze\FlittPayment\Events\PaymentReceived;
use Illuminate\Support\Facades\Log;

class HandleFlittPayment
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentReceived $event): void
    {
        // implement your login code

        Log::info('Flitt payment callback received', $event->response); # you can remove it
    }
}
```

### Setting Up the Event Listener
Setting Up the Event Listener
To handle transaction status updates efficiently, you need to register an event listener that listens for the HandleFlittPayment event triggered by the package.

Generating the Listener Automatically
You can generate the event listener using the Artisan command:

```bash
php artisan make:listener HandleFlittPayment --event=\Devadze\FlittPayment\Events\PaymentReceived
```

This command will create a listener class at `app/Listeners/HandleFlittPayment.php`, which you can customize to handle the event logic.

This approach provides flexibility by allowing dynamic event registrations at runtime without modifying the EventServiceProvider. 

For more details on event handling in Laravel, refer to the official [documentation](https://laravel.com/docs/12.x/events#event-discovery).
   
