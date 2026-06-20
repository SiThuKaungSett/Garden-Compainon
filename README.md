# Garden Companion

Garden Companion is a PHP and MySQL web application for browsing plant seeds, viewing plant details, collecting user feedback, managing a shopping cart, and handling basic admin management for plants, users, orders, and feedback.

The project is designed to run locally with XAMPP.

## Features

- Browse plant seeds by season
- View plant details, descriptions, prices, and images
- Search plants from the navigation bar
- Register and log in as a customer
- Add plants to a shopping cart
- Place checkout orders with payment method options
- Submit and display customer feedback
- Admin dashboard for managing plants, users, orders, and feedback
- Image upload support for plant records

## Tech Stack

- PHP
- MySQL
- HTML, CSS, JavaScript
- XAMPP / Apache
- Boxicons, Font Awesome, Remix Icon

## Project Structure

```text
GardenCompanion/
|-- admin/                 # Admin dashboard pages and admin-only assets
|   |-- assets/
|   |   |-- css/
|   |   `-- js/
|   |-- config/            # Database connection
|   `-- includes/          # Admin layout includes
|-- assets/                # Public website static files
|   |-- css/
|   |-- images/
|   |-- js/
|   `-- logo/
|-- database/              # SQL database dump
|-- functions/             # Authentication and plant handling logic
|-- includes/              # Public site header, footer, navbar
|-- storage/               # Local storage/log output
|-- uploads/               # Uploaded plant/product images
|-- index.php              # Home page
|-- plants.php             # Plant listing page
|-- moredetail.php         # Plant detail page
|-- cart.php               # Shopping cart page
|-- feedback.php           # Feedback page
`-- adlogin.php            # Login/register page
```

## Setup

1. Install and start XAMPP.

2. Start Apache and MySQL from the XAMPP Control Panel.

3. Place this project inside your XAMPP `htdocs` folder:

```text
C:\xampp\htdocs\GardenCompanion
```

4. Create a MySQL database named:

```text
mygardendb
```

5. Import the SQL file:

```text
database/mygardendb.sql
```

You can import it using phpMyAdmin:

- Open `http://localhost/phpmyadmin`
- Create/select the `mygardendb` database
- Open the Import tab
- Choose `database/mygardendb.sql`
- Run the import

6. Check the database connection in:

```text
admin/config/dbcon.php
```

Default local settings are:

```php
$host = "localhost";
$username = "root";
$password = "";
$database = "mygardendb";
```

7. Open the site:

```text
http://localhost/GardenCompanion/
```

Admin dashboard:

```text
http://localhost/GardenCompanion/admin/
```

## Git Notes

Static files are organized into `assets/` and `admin/assets/` so the repository is easier to maintain.

The `.gitignore` file excludes local logs, environment files, and editor/OS files. Uploaded images in `uploads/` are currently kept in the repository because the sample plant data may reference them.

## Description

Garden Companion helps users find seasonal plant seeds and manage a simple online plant shopping flow. It includes a customer-facing storefront with search, details, cart, checkout, and feedback pages, plus an admin dashboard for maintaining plant inventory, customer accounts, orders, and reviews.
