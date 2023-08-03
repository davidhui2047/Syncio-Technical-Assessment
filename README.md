# Syncio Technical Assessment

# Instruction
1. Clone the repository to your local
2. Opne the repository
3. Open your terminal
4. Run the following commands
```
cd .\payload-comparison-app\ #move the he project
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
