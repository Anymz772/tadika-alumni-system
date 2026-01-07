Tadika Alumni System 🎓

A Laravel web application for managing Tadika alumni data, surveys, and administration.

⚙️ Requirements

Install the following before starting:

### Prerequisites

-   **XAMPP** (includes Apache, MySQL, PHP) - Download and install from [apachefriends.org](https://www.apachefriends.org/)
-   **Composer** - PHP dependency manager, download from [getcomposer.org](https://getcomposer.org/)
-   **Node.js and npm** - JavaScript runtime and package manager, download from [nodejs.org](https://nodejs.org/)
-   **Git** - For cloning the repository

### Step-by-Step Setup Guide

1. **Clone the Repository**

    ```
    git clone https://github.com/Anymz772/tadika-alumni-system.git
    cd tadika-alumni-system
    ```

2. **Start XAMPP Services**

    - Open XAMPP Control Panel
    - Start Apache and MySQL modules

3. **Install PHP Dependencies**

    ```
    composer install
    ```

4. **Install Node.js Dependencies**

    ```
    npm install
    ```

5. **Configure Environment**

    ```
    cp .env.example .env
    ```

    Edit the `.env` file and update the database configuration:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=tadika_alumni_system
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6. **Generate Application Key**

    ```
    php artisan key:generate
    ```

7. **Create the Database**

    - Open phpMyAdmin (usually at http://localhost/phpmyadmin)
    - Create a new database named `tadika_alumni_system`

8. **Run Database Migrations**

    ```
    php artisan migrate
    ```

9. **Create Storage Link (Important for file uploads)**

    ```
    php artisan storage:link
    ```

    **Note for cPanel/Shared Hosting**: If the above command doesn't work (symlinks disabled), manually copy the contents of `storage/app/public/` to `public/storage/` using your hosting file manager or FTP.

10. **Seed the Database (Optional - Adds sample data)**

    ```
    php artisan db:seed
    ```

11. **Build Frontend Assets**

    ```
    npm run build
    ```

    Or for development with hot reloading:

    ```
    npm run dev
    ```

12. **Start the Application**

    ```
    php artisan serve
    ```

    The application will be accessible at http://localhost:8000

    **Alternative: Use the built-in development script** (runs server, queue worker, logs, and Vite concurrently):

    ```
    composer run dev
    ```

### Accessing the Application

-   Main application: http://localhost:8000 (when using `php artisan serve`)
-   If running via XAMPP Apache directly: http://localhost/tadika-alumni-system

### Default Login Credentials (after seeding)

-   **Admin User**: Check the `AdminUserSeeder.php` for details (likely email: admin@example.com, password: password)
-   **Alumni Users**: Check the `AlumniSeeder.php` for sample alumni accounts

### Troubleshooting

-   Ensure PHP version is 8.2 or higher
-   Make sure MySQL is running and accessible
-   If port 8000 is in use, specify a different port: `php artisan serve --port=8001`
-   Clear cache if issues occur: `php artisan config:clear && php artisan cache:clear`

This should get the application running locally for development and testing..]
