## Instructions

1. composer update
2. Create a database
3. rename .env.example to .env
4. set database name in .env file
5. Add your smtp details for sending email
6. Run "php artisan migrate"
7. Run "php artisan db:seed" for admin user. User name is sridhars151@gmail.com and password is 123456
8. Enable the redish cache
9. Run "php artisan queue:listen" to send email queue
