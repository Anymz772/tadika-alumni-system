Tadika Alumni System 🎓

A Laravel web application for managing Tadika alumni data, surveys, and administration.

⚙️ Requirements

Install the following before starting:

XAMPP (PHP 8.2+, Apache, MySQL)

Composer

Node.js & npm

Git

🚀 Quick Setup (Windows + XAMPP)

1. Clone the Project
   git clone https://github.com/Anymz772/tadika-alumni-system.git
   cd tadika-alumni-system

2. Start XAMPP

Open XAMPP Control Panel and start:

Apache

MySQL

3. Install Dependencies
   composer install
   npm install

4. Environment Setup
   cp .env.example .env
   php artisan key:generate

Update .env database config:

DB_DATABASE=tadika_alumni_system
DB_USERNAME=root
DB_PASSWORD=

5. Create Database

Open http://localhost/phpmyadmin

Create database: tadika_alumni_system

6. Run Migrations & Seed Data
   php artisan migrate
   php artisan db:seed

7. Run the Application
   npm run dev
   php artisan serve

Open in browser:
👉 http://localhost:8000

🔐 Default Login (After Seeding)

Admin:
Check database/seeders/AdminUserSeeder.php

Alumni Users:
Check database/seeders/AlumniSeeder.php

🧯 Common Issues

PHP version must be 8.2+

Make sure MySQL is running

Clear cache if error:

php artisan optimize:clear

👨‍💻 Author

Aiman Hakim
https://github.com/Anymz772
