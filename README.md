# Syncio Technical Assessment
A Laravel application that compares the difference between posted payloads using session

# Decription
The application provides an endpoint that allows users to post payloads to the application. The application will store the first payload that users posted into a session variable, and then prompt the users to enter the second payload. Once the users post the second payload to the application, the application will store the second payload in another session variable. After that, the application will start the comparison for the two session variable, store the difference in a message variable, unset both session variables to avoid memory issues and then return the message variable.

# Limitation 
As the application is using the session to handle the posted payload, the application will not be able to handle too many requests at the same time due to memory limation. The application is only designed for comparing one product difference before and after once at a time.  

# Instruction
1. Clone the repository to your local
2. Opne the repository
3. Open your terminal
4. Run the following commands
```
cd .\payload-comparison-app\ #move to the project
composer install #imstall package
```
5. Rename .env.example to .env
6. Run the following commands
```
php artisan key:generate #generate encrption key
php artisan test #run test cases
php artisan serve --port=8080 #run application 
```
7. Open POSTMAN
8. Enter the following endpoint and select post method
```
localhost:8080/api/compare-payloads
```
9. Put the payload in the body and send it to the endpoint to test it

# Other thought
Given that the actual scenario may be related to 10k products updated at once,
I would say it could be an architecture question (database replication and load-balancing)

Let’s say we have a payload with 100k products (product before update).
I would extract the data from the payload and store it in a table.
For example, 
I will create a table called Products, the Products table will have columns:
product_id, 
title, 
description, 
images (store the whole images field as there would not be too many images for one product), and 
variants (store the whole variants field as there would not be too many variants for one product).


After two minutes, let’s say we have another payload with 10k products (product after update).
My approach would be to divide the payload into a number of x (number of the instance for database replication) payloads, let's assume x = 5, and
each payload would have 2k products.
I will then write 5 queries for each payload to do comparisons in the database.
The load balancer should assign one query to one database instance.

This approach will make the whole product update comparison process x time fast which is 5 in the above example.

