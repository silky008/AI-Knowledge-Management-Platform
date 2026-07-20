## Sprint 0 Completed

### Achievements

- Installed Laravel 13 application.
- Configured PHP extensions required by Laravel.
- Connected Laravel with PostgreSQL 18.
- Created project database.
- Completed initial Laravel migrations.
- Configured Git workflow.

### Technical Problems Solved

1. Composer failed because OpenSSL extension was disabled.
2. Laravel installation failed because fileinfo extension was missing.
3. PostgreSQL connection failed because PDO PostgreSQL extension was missing.
4. Laravel cache table issue fixed through migrations.
5. mbstring extension enabled for Laravel console tools.

### Important Learnings

- Composer validates PHP platform requirements.
- PHP extensions control framework capabilities.
- Laravel uses .env for environment-specific configuration.
- Sensitive configuration should never be committed.
- Database migrations create application structure.

### Engineering Practices Learned

- Debugging by reading error messages.
- Checking environment before changing code.
- Reviewing Git changes before commit.
- Protecting secrets with .gitignore.

## Sprint 1 Day 1

### Learned

- Laravel request starts from public/index.php.
- Routes define application URLs.
- Controllers contain application logic.
- Artisan can generate Laravel classes.

### Created

- First custom route.
- First controller.
- User management controller foundation.

## Sprint 1 Day 2

### Learned

- Models represent database tables.
- Migrations define database changes.
- User extends Authenticatable because Laravel authentication requires extra user behavior.
- Passwords are stored as hashes.

### Created

- User status column.
- User database documentation.
- First database migration.

## Sprint 1 Day 3

### Learned

- API routes are used for JSON communication.
- Installed Laravel Sanctum for API authentication.
- Created REST endpoint for user registration.
- Used Laravel validation.
- Stored passwords securely using hashing.

### Created

- AuthController.
- POST /api/register endpoint.
- REST Client API test.
