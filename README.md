EEC Task

EEC Task (DevKhaledWaleed)
==============

This is a Laravel-based application designed to manage products and pharmacies. The application includes functionality to search for the cheapest pharmacies offering a given product using a custom Artisan command.

Table of Contents
-----------------

*   [Installation](#installation)
*   [Setup](#setup)
*   [Running the Project](#running-the-project)
*   [Using the CLI Command](#using-the-cli-command)
*   [Database Structure](#database-structure)
*   [Project Documentation](#project-documentation)

Installation
------------

### 1\. Clone the Repository

Start by cloning the project to your local machine:


    git clone https://github.com/phoeni2020/eec_task.git
    cd eec_task


### 2\. Install Dependencies

Ensure you have [Composer](https://getcomposer.org/) installed. Run the following command to install all required dependencies:


    composer install


### 3\. Set Up the Environment File

Copy the `.env.example` file to `.env`:


    cp .env.example .env || you can just copy .env.example with normal way ctrl + c then ctrl + v 
    


This file contains environment configurations such as database settings, application keys, etc.

### 4\. Generate Application Key

Laravel requires an application key for encryption. Generate it with:


    php artisan key:generate


Setup
-----

### 1\. Configure Database

Open the `.env` file and configure your database settings:


    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password


Ensure that your database is set up and accessible with the credentials provided.

### 2\. Run Migrations

Run the database migrations to create the necessary tables:


    php artisan migrate


### 3\. Seed the Database (Optional)

Populate the database with sample data by running:


    php artisan db:seed


This will insert sample data for products and pharmacies into the database.

Running the Project
-------------------

### 1\. Start the Development Server

You can start the Laravel development server using:


    php artisan serve


By default, the server will run at `http://127.0.0.1:8000`.

### 2\. Accessing the Application

Once the server is running, you can open your browser and navigate to:


    http://127.0.0.1:8000


This will load the application, where you can interact with the available product data and pharmacies.

Using the CLI Command
---------------------

### 1\. Search Cheapest Pharmacies

To find the cheapest 5 pharmacies for a specific product, use the custom Artisan command:


    php artisan products:search-cheapest {productId}


For example, to search for the cheapest pharmacies for product with ID `22`:


    php artisan products:search-cheapest 22


This will return the 5 cheapest pharmacies for the product with the specified ID in JSON format.

#### Example Output:


    [
        {
            "id": 1,
            "name": "Pharmacy 1",
            "price": 10.99
        },
        {
            "id": 2,
            "name": "Pharmacy 2",
            "price": 12.50
        },
        {
            "id": 3,
            "name": "Pharmacy 3",
            "price": 13.75
        },
        {
            "id": 4,
            "name": "Pharmacy 4",
            "price": 14.00
        },
        {
            "id": 5,
            "name": "Pharmacy 5",
            "price": 15.00
        }
    ]


This command fetches the cheapest 5 pharmacies based on the product ID and outputs them in a clean JSON format.

Database Structure
------------------

### Tables

*   **products**: Stores information about products (title, description, price, quantity).
*   **pharmacies**: Stores pharmacy data (name, address).
*   **product\_pharmacy** (pivot table): Stores the relationship between products and pharmacies, including the price for each product in each pharmacy.

\---

Project Documentation
---------------------

### Models

1.  **Product**: Represents a product in the application. It has a `belongsToMany` relationship with pharmacies through the `product_pharmacy` pivot table.
2.  **Pharmacy**: Represents a pharmacy in the application. It has a `belongsToMany` relationship with products through the `product_pharmacy` pivot table.
3.  **SearchCheapestPharmacies Command**: This custom Artisan command allows you to search for the cheapest pharmacies for a given product. It uses a query to join the `pharmacies` and `product_pharmacy` tables, ordering by price.