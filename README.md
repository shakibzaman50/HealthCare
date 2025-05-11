# Mini Arab Project

Welcome to the Mini Arab project developed by **Shakib Zaman**.

## Project Languages & Tools

- **Laravel** 11
- **PHP** 8.2
- **Composer** 2+
- **Tailwind CSS**
- **Vuexy Dashboard**

## Installation Instructions

1. **Clone the repository:**

   ```bash
   git clone https://shakib@bitbucket.org/betatechco/gift-funnel.git

   ```

2. **Navigate to your project directory:**

   ```bash
   cd your-laravel-project

   ```

3. **Install PHP dependencies:**
   ```bash
   composer install
   ```
4. **Set up environment configuration:**

   ```bash
   cp .env.example .env
   php artisan key:generate

   ```

5. **Edit the .env file to match your database configuration:**

   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password

   ```

6. **Run migrations for a fresh project:**
   ```bash
   php artisan migrate
   ```
7. **Seed the database with necessary data:**

   ```bash
   php artisan db:seed --class=PermissionTableSeeder
   php artisan db:seed --class=CreateAdminUserSeeder

   ```

8. **Install Node.js dependencies and build assets:**
   ```bash
   npm install
   npm run build
   ```
9. **Start the development server:**

   ```bash
   php artisan serve

   ```

10. **Default Login for Superadmin**
    admin@gmail.com/12345678
