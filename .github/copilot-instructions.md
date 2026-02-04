# Tadika Alumni System - Coding Instructions

## Project Overview

This is a Laravel-based alumni management system for a kindergarten (tadika). The system allows alumni to submit information via a public survey form, which administrators review and approve to create user accounts. Administrators can then manage alumni profiles through a CRUD interface.

## Architecture & Data Flow

-   **Public Survey Flow**: Alumni submit details via `alumni.register` → stored in `alumni_surveys` table with 'pending' status → admin reviews via `survey.index` → approval creates User + Alumni records with random password
-   **Admin Management**: CRUD operations on alumni via `AlumniController` with search/filter/pagination
-   **Authentication**: Role-based with 'admin' and 'alumni' roles; uses Laravel Breeze
-   **Frontend**: Blade templates with Tailwind CSS + Alpine.js; layouts: `app.blade.php` (authenticated), `public.blade.php` (survey), `cms.blade.php` (admin)

## Key Models & Relationships

-   `User` (role: admin/alumni) ←→ `Alumni` (1:1, user_id FK)
-   `AlumniSurvey` (standalone, no FK; status: pending/approved/rejected)
-   All models use standard Laravel conventions with fillable arrays and relationships

## Critical Workflows

-   **Setup**: Run `composer run setup` (installs deps, copies .env, generates key, migrates DB, npm install/build)
-   **Development**: `composer run dev` (concurrent: artisan serve, queue:listen, pail logs, npm run dev)
-   **Testing**: `php artisan test` (uses PHPUnit with standard Laravel test structure)
-   **Survey Approval**: In `SurveyController@approve`, generates 8-char random password, creates User/Alumni, updates survey status
-   **Search/Filter**: Implemented in `AlumniController@index` and `SurveyController@index` with query string persistence

## Project-Specific Patterns

-   **Role Checks**: Use `$user->isAdmin()` / `isAlumni()` methods instead of direct role comparison
-   **Middleware**: `auth` + `admin` for protected routes; `CheckAdmin` middleware verifies role === 'admin'
-   **Validation**: Strict validation in controllers (e.g., IC number format, year ranges); unique email across users + surveys
-   **Flash Messages**: Use `->with('success', '...')` or `->with('error', '...')` for user feedback
-   **Pagination**: 10 items per page for alumni, 20 for surveys; withQueryString() for filter persistence
-   **File Organization**: Controllers grouped by feature (Admin/, Auth/); views mirrored (admin/, auth/, alumni/, survey/)
-   **Database**: Separate tables for surveys (temporary) vs alumni (approved); no soft deletes
-   **Seeders**: `AdminUserSeeder` creates admin@tadika.edu/admin123; `AlumniSeeder` provides sample data

## Common Tasks

-   **Adding Admin Routes**: Group under `Route::middleware(['auth', 'admin'])` in `routes/web.php`
-   **Creating Forms**: Use Tailwind classes; include CSRF; validate in controller with custom messages
-   **Adding Search**: Follow pattern in `AlumniController@index` - check request params, apply where/like clauses
-   **User Creation**: Always set role; hash passwords; consider email verification
-   **Error Handling**: Redirect back with errors for validation failures; use try/catch for DB operations

## Key Files to Reference

-   `app/Models/User.php` - Role methods and relationships
-   `app/Http/Controllers/SurveyController.php` - Approval workflow logic
-   `routes/web.php` - Route organization and middleware groups
-   `database/migrations/` - Schema understanding (alumni vs alumni_surveys)
-   `resources/views/layouts/app.blade.php` - Base authenticated layout
-   `composer.json` - Scripts for setup/dev workflows</content>
    <parameter name="filePath">c:\xampp\htdocs\tadika-alumni-system\.github\copilot-instructions.md
