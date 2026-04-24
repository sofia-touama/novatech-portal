# NovaTech Portal
A secure, database-driven project management system built with Laravel.

NovaTech Portal is a full-stack web application designed for managing software projects within a company. It provides public project browsing, user authentication, and secure project management features, with a strong focus on clean UI, maintainability, and industry-standard security practices.

---

## Features

### Public Users
- View all projects (title, start date, short description)
- View detailed project information (end date, phase, owner email)
- Search projects by title or start date
- Register for an account

### Registered Users
- Secure login and logout
- Add new projects
- Edit and update their own projects
- View only their own projects in the dashboard

---

## Security Features
NovaTech Portal implements the following security measures:

1. Authentication (Laravel Auth)
2. Authorisation (users can only modify their own projects)
3. CSRF protection (`@csrf` tokens in all forms)
4. Password hashing (Laravel bcrypt hashing)
5. Server-side validation (Form Requests and controller validation)
6. SQL injection protection (Eloquent ORM and query binding)
7. HTML escaping (`{{ }}` Blade syntax)

---

## Project Structure (Key Files)

### Controllers
- `app/Http/Controllers/ProjectsController.php`
- `app/Http/Controllers/AuthController.php`

### Views
- `resources/views/projects/index.blade.php`
- `resources/views/projects/show.blade.php`
- `resources/views/projects/create.blade.php`
- `resources/views/projects/edit.blade.php`
- `resources/views/auth/login.blade.php`
- `resources/views/auth/register.blade.php`
- `resources/views/layouts/app.blade.php`

### Routes
- `routes/web.php`

### Database
- `database/migrations/*`
- `database/seeders/*`
- `aproject.sql` (provided in assessment)

---

## Tech Stack
- Laravel 10  
- PHP 8+  
- MySQL  
- Blade Templates  
- HTML, CSS, JavaScript  
- Custom responsive UI (theme.css)

---

## Test User Credentials
Use the following account to access the system as a registered user:

Email: testuser@novatech.com  
Password: Test1234!

---

## Installation (Local Development)

## Installation (Local Development)

```bash
git clone https://github.com/sofia-touama/novatech-portal.git
cd novatech-portal
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```


---

## Deployment

NovaTech Portal can be deployed using services such as Render, Railway, or 000webhost.

### Deployment Steps (Render Recommended)
1. Push your project to GitHub  
2. Create a Render account  
3. Create a new Web Service and connect your repository  
4. Set:
   - Build Command: `composer install --no-dev`
   - Start Command: `php artisan serve --host 0.0.0.0 --port 10000`
5. Add environment variables from your `.env` file  
6. Create a Render MySQL database and link credentials  
7. Deploy and access your public URL  

---

## License
This project is developed for academic purposes as part of a university assessment.
