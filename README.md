Laravel Application Setup and Local Development



PHP (Recommended version 7.4 or higher)
Composer
MySQL, PostgreSQL, SQLite, or other supported database management system
Node.js and npm (for frontend assets compilation, if required)
Git
Installation Steps
Follow these steps to set up the Laravel application locally:

1. Clone the Repository
Clone the repository from GitHub:


git clone <repository-url>
cd <project-directory>
2. Install Composer Dependencies
Install PHP dependencies using Composer:


composer install

3. Set Up Environment Variables
Duplicate the .env.example file and rename it to .env. Update the database connection and other necessary environment variables in the .env file:


cp .env.example .env

4. Generate Application Key
Generate the application key:

php artisan key:generate

5. Run Migrations
Run database migrations to create the necessary tables:


php artisan migrate

6. Seed the Database (Optional)
If your application includes seeders, run them to populate the database with sample data:

php artisan db:seed

7. Compile Frontend Assets (if applicable)
If your application uses frontend assets like JavaScript and CSS that need to be compiled, run:



8. To generate api token run:

php artisan passport:keys


php artisan serve
