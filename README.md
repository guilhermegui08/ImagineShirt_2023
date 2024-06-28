# ImagineShirt_2023

ImagineShirt is a web application designed for an online store that sells customized t-shirts. This project utilizes the Laravel framework to implement a comprehensive e-commerce platform where users can purchase t-shirts with custom or catalog images.

## Table of Contents
- [Objective](#objective)
- [Features](#features)
- [User Roles](#user-roles)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [License](#license)

## Objective
The goal of this project is to create a web application for the ImagineShirt online store. Customers can choose t-shirt designs from the store’s catalog or upload their own images, and ImagineShirt will print and ship the t-shirts.

## Features
- **Product Catalog**: Browse and filter t-shirt images from the catalog.
- **Custom Designs**: Upload custom images for t-shirts.
- **Shopping Cart**: Add, remove, or modify t-shirt items in the shopping cart.
- **User Authentication**: Register and log in to place orders.
- **Order Management**: Create, view, and manage orders with statuses like pending, paid, and closed.
- **Admin Dashboard**: Manage product prices, user accounts, and view sales statistics.
- **Email Notifications**: Automated emails for order status updates.
- **PDF Receipts**: Generate and email PDF receipts for orders.

## User Roles
The application supports four types of users:
1. **Anonymous Users**: Can browse the catalog and manage the shopping cart without logging in.
2. **Customers**: Can log in, manage their accounts, place orders, and view order history.
3. **Staff**: Handle order processing, including marking orders as paid or shipped.
4. **Administrators**: Manage the application, including user accounts, product prices, and viewing business statistics.

## Requirements
- PHP 8.0 or higher
- Laravel 8.x
- MySQL or PostgreSQL
- Composer
- Node.js and npm

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/guilhermegui08/ImagineShirt_2023.git
   cd ImagineShirt_2023

2. Install dependencies:
   ```bash
   composer install
   npm install
   npm run dev


3. Configure environment variables:
   ```bash
   cp .env.example .env
   php artisan key:generate


4. Seed the database (optional):
   ```bash
   php artisan migrate

5. Start the local development server:
   ```bash
   php artisan db:seed


## Usage
1. Start the local development server:
   ```bash
   php artisan serve

2. Access the application in your web browser at `http://localhost:8000`.

## License
This project is licensed under the GPL-3.0 License. See the [LICENSE](LICENSE) file for details.
