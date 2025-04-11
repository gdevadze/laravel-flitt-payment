# Laravel Flitt Payment Package

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
FLITT_SECRET=your_secret_key
FLITT_CALLBACK_URL=https://yourdomain.ge/flitt/callback
FLITT_RESPONSE_URL=https://yourdomain.ge
```

## Usage

### Usage Example: Simple Payment Processing

To initiate a payment, use the `FlittPayment` facade to set the order details and redirect:

```php
use Devadze\FlittPayment\Facades\FlittPayment;

FlittPayment::setOrderDesc('ბალანსის შევსება')->setAmount(5)->redirect();
```
