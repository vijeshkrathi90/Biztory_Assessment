<p align="center">
    <a href="javascript:void(0)" target="_blank">
        <img src="https://s3-ap-southeast-1.amazonaws.com/biztory-wordpress-img/wp-content/uploads/2019/09/11005849/biztory_logo.png" width="400" alt="Laravel Logo">
    </a>
</p>

## Laravel Installation Guide:

- Prerequisites:
    - PHP v8.1
    - Composer v2.6.6
    - MySQL v8.0.35
For this assessment I used these prerequisites settings. All this setup is already in use for existing project whom I used to work.

## Steps:
    - Clone the Git Repository:
        - git clone https://github.com/vijeshkrathi90/Biztory_Assessment.git

    - Change Directory:
        - cd Bitzory_Assessment

    - Install/Update Dependencies:
        - If found composer.lock file in root then update else install the dependencies:
            - Composer update (Any of them according)
            - Composer install 

    - Copy .env.example to .env
        -cp .env.example .env

    - Configure your .env file with the appropriate database connection details.
    - Generate Application Key:
        - php artisan key:generate

    - Run Migrations with seeding the data:
        - php artian migrate:fresh --seed 
            -- This seeder is based on factory might be sometime occurs error try again due to ID conflicts according to .

    - Clear Caches (Config, Routes, complied)
        - php artisan op:cl
        
    - Start Development Server:
        - php artisan serve
        -Your Laravel application should now be running at http://localhost:8000

    - Rest API's:
        - php artisan passport:install
    
    - Run Tests:
        - php artisan test
        This command will perform all the existing test.

    - API End Points:
        - BASE URL: **http://127.0.0.1:8000/api/v1**
        - Listing: GET {BASE_URL}/sales 
        
    Please find POSTMAN collection in the root under name of assessment.
    
    
# GraphQL API Documentation

## Overview

This GraphQL API provides access to sales data, allowing users to retrieve daily total sales within a given date range, filtered by payment status and payee ID.

## Accessing GraphQL Playground

1. Start the Laravel development server:

   ```bash
   php artisan serve

2. Open your browser and navigate to http://127.0.0.1:8000/graphql-playground

## Queries
DailyTotalSalesQuery
Retrieve the total sales amount for each day within a specified date range.

Query Example:

```Execute GraphQL-Playground
query {
  DailyTotalSalesQuery(
    startDate: "2023-01-01",
    endDate: "2024-01-31",
    paymentStatus: 1,
    payeeId: 2
  )
}

## Query Parameters:
    - startDate (String): The start date of the date range (format: "YYYY-MM-DD").
    - endDate (String): The end date of the date range (format: "YYYY-MM-DD").
    - paymentStatus (Int): Filter sales by payment status (optional).
    - payeeId (Int): Filter sales by payee ID (optional).
## Query Response:
The response will include the total sales amount for each day within the specified date range.

##How to Use
1. Open the GraphQL Playground in your browser.
2. Copy and paste the provided example query into the Playground.
3. Modify the query parameters as needed.
4. Press the "Play" button to execute the query.
5. Review the results in the "Response" panel.
        
