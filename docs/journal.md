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

## Sprint 1 Day 4

### Learned

- Authentication flow in Laravel.
- Laravel Sanctum token authentication.
- User model traits.
- Password verification using Hash::check().
- API token generation.

### Created

- User login endpoint.
- Sanctum authentication tokens.
- Login API testing.

### Problem Solved

- Fixed createToken() error by adding HasApiTokens trait to User model.

## Sprint 1 Day 5

### Learned

- Sanctum authentication middleware.
- Bearer token authentication.
- Protected API routes.
- How Laravel identifies users from tokens.

### Created

- GET /api/profile endpoint.
- Protected user profile API.

### Debugging

- Fixed authentication issue caused by using an old token.

## Sprint 1 Day 6

### Learned

- API logout flow.
- Token revocation using Laravel Sanctum.
- Current authenticated token handling.

### Created

- Logout API endpoint.
- Token deletion functionality.

### Tested

- Logout success.
- Old token rejection after logout.

## Sprint 2 Day 1

### Sprint Goal

Build the foundation for the Document Management module.

### Completed

- Created `documents` table migration.
- Added foreign key relationship with `users`.
- Created `Document` model.
- Configured mass assignable (`$fillable`) attributes.
- Added `User -> hasMany(Document)` relationship.
- Added `Document -> belongsTo(User)` relationship.

### Concepts Learned

- One-to-Many relationships in Eloquent.
- `foreignId()->constrained()->cascadeOnDelete()`.
- Difference between model relationships and query execution.

### Interview Learning

- Why pagination is preferred over loading thousands of records.
- Difference between `$user->documents` and `$user->documents()`.
