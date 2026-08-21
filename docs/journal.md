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

## Sprint 2 Day 2

### Sprint Goal

Implement document upload functionality.

### Completed

- Created document upload API.
- Added file validation.
- Stored uploaded files using Laravel Storage.
- Saved document metadata in PostgreSQL.
- Tested successful uploads.

### Concepts Learned

- PHP temporary upload directory.
- Laravel UploadedFile object.
- Laravel Storage facade.
- Difference between `file_name` and `file_path`.
- Why production systems store files with generated names.

### Interview Learning

- File uploads involve two systems:
  - File Storage
  - Database
- Both must remain consistent.

## Sprint 2 Day 3

### Completed

- Created document listing API.
- Implemented pagination.
- Listed only authenticated user's documents.
- Ordered documents by latest upload.

### Concepts Learned

- latest()
- paginate()
- Why not use Document::all()
- User data isolation
- Query Builder

### Code Review Feedback

- Avoid magic numbers.
- Use relationships where appropriate.
- API responses should eventually use Resources.

## Sprint 2 Day 4

### Completed

- Implemented document details API.
- Used Route Model Binding.
- Added authorization check to prevent access to other users' documents.
- Tested successful and unauthorized access.

### Concepts Learned

- Route Model Binding
- Authentication vs Authorization
- HTTP 403 vs 404
- Debugging API endpoints

## Sprint 2 Day 5

### Sprint Goal

Implement secure document deletion.

### Completed

- Added DELETE /api/documents/{document}.
- Deleted document from storage.
- Deleted database record.
- Prevented unauthorized deletion.

### Concepts Learned

- HTTP DELETE
- Storage facade
- Keeping filesystem and database consistent
- Orphaned files
- Authorization before destructive actions

### Interview Learning

Deleting data from multiple systems (database and filesystem) requires careful ordering because database transactions cannot roll back filesystem changes.

## Sprint 2 Day 6

### Sprint Goal

Implement secure document download.

### Completed

- Added download endpoint for documents.
- Restricted downloads to document owners.
- Verified file existence before download.
- Preserved original filename in download response.

### Concepts Learned

- Storage facade
- Secure file downloads
- Content-Disposition header
- File existence checks
- Storage abstraction

### Interview Learning

Never expose physical storage paths. Use Laravel's Storage abstraction to improve security and make it easy to switch storage providers such as Amazon S3 in the future.

## Sprint 2 Day 7

### Sprint Goal

Refactor document upload validation using Form Requests.

### Completed

- Created `StoreDocumentRequest`.
- Moved validation rules out of the controller.
- Used `$request->validated()` in the controller.
- Verified valid and invalid upload requests.

### Concepts Learned

- Form Requests
- Separation of Concerns
- Single Responsibility Principle (SRP)
- Authorization before validation

### Interview Learning

Form Requests improve maintainability by separating validation and authorization from business logic. They keep controllers focused on application behavior instead of request validation.

## Sprint 2 Day 8

### Sprint Goal

Standardize API responses using Laravel API Resources.

### Completed

- Created `DocumentResource`.
- Refactored document listing, upload, and detail APIs to use resources.
- Hid internal fields such as `user_id` and `file_path`.
- Verified consistent API responses.

### Concepts Learned

- API Resources
- API Contracts
- Data Transformation
- Hiding Internal Implementation Details

### Interview Learning

API Resources decouple the API response from the database schema. This allows the backend to evolve without breaking frontend applications.

## Sprint 3 Day 1

### Sprint Goal

Refactor document upload business logic into a service class.

### Completed

- Created `DocumentService`.
- Moved upload logic from the controller into the service.
- Injected the service using Laravel's dependency injection.
- Verified upload functionality after refactoring.

### Concepts Learned

- Service Classes
- Dependency Injection
- Separation of Concerns
- Reusable Business Logic

### Interview Learning

Controllers should handle HTTP requests and responses, while service classes contain reusable business logic that can be called from controllers, jobs, commands, or other services.

## Sprint 3 Day 2

### Completed

- Added database transaction to document upload.
- Added rollback handling.
- Removed uploaded file if an exception occurs.
- Learned that database transactions do not affect the filesystem.

### Concepts Learned

- Database Transactions
- Atomic Operations
- Exception Handling
- File Cleanup

## Sprint 3 Day 3

### Completed

- Reviewed Laravel 13 exception handling.
- Confirmed API exceptions are rendered as JSON.
- Tested an intentional service exception.
- Verified database rollback.
- Verified uploaded file cleanup.
- Learned why services should throw exceptions instead of returning HTTP responses.
- Reviewed custom exception rendering with GitHub Copilot.

### Interview Learning

Generic RuntimeException handling can be dangerous because unrelated application failures may receive the same error response. Specific application exceptions provide better control and clearer error handling.

## Sprint 3 Day 4

### Completed

- Added Laravel logging to DocumentService.
- Added success logging after database commit.
- Added failure logging for upload exceptions.
- Verified success and failure logs.
- Learned safe logging practices.
- Avoided logging sensitive information such as tokens, passwords, and raw request data.
- Reviewed logging implementation using GitHub Copilot.

### Concepts Learned

- Laravel Log facade
- Log levels
- Production logging
- Safe diagnostic information
- Logging after transaction commit

## Sprint 3 Day 5

### Completed

- Created `ProcessDocument` queue job.
- Passed the `Document` model to the queued job.
- Added document processing logic inside the job's `handle()` method.
- Configured the project to use the database queue connection.
- Dispatched `ProcessDocument` after the document database transaction was committed.
- Verified that the job was stored in the `jobs` table.
- Started the Laravel queue worker using `php artisan queue:work`.
- Verified that the worker processed the queued job successfully.
- Verified that the processing log appeared in `storage/logs/laravel.log`.
- Investigated a failed queue job using Laravel's `failed_jobs` table.
- Fixed the missing `Log` facade import in `ProcessDocument`.

### Concepts Learned

- Laravel queue jobs
- `ShouldQueue`
- `dispatch()`
- `queue:work`
- Database queue driver
- `jobs` table
- `failed_jobs` table
- Queue workers
- Background processing
- Difference between `sync` and `database` queue connections
- Passing Eloquent models to queued jobs

### Interview Learning

- `dispatch()` places a job onto the queue.
- `queue:work` starts a worker that processes queued jobs.
- With the database driver, queued jobs are stored in the `jobs` table.
- `sync` executes jobs immediately in the current request instead of processing them in the background.

## Sprint 3 Day 6

### Completed

- Learned how Laravel handles failed queue jobs.
- Tested `php artisan queue:failed`.
- Learned how to retry a failed job using `php artisan queue:retry`.
- Added `$tries = 3` to `ProcessDocument`.
- Added `$backoff = 10` seconds.
- Performed a controlled job failure test.
- Verified the job was attempted 3 times.
- Verified approximately 10 seconds between retry attempts.
- Verified the failed job was eventually stored in `failed_jobs`.
- Learned the difference between temporary and permanent job failures.
- Learned that queue workers may need to be restarted after code changes.

### Concepts Learned

- Failed queue jobs
- `failed_jobs`
- `queue:failed`
- `queue:retry`
- `$tries`
- `$backoff`
- Automatic job retries
- Temporary vs permanent failures
- Long-running queue workers

## Sprint 3 Day 7

### Completed

- Added and tested the `failed()` method in `ProcessDocument`.
- Verified that `failed()` runs after all configured retry attempts are exhausted.
- Logged permanent job failures safely.
- Tested a permanently failing queued job.
- Restored the job to normal successful processing.
- Learned why queued jobs can execute more than once.
- Learned the concept of idempotency.
- Learned why retries can create duplicate records or side effects if a job is not idempotent.

### Concepts Learned

- `failed()` method
- Permanent queue failure
- Job retry lifecycle
- Idempotency
- Duplicate processing
- Safe retry design

## Sprint 3 Day 8

### Completed

- Added document processing status tracking.
- Added `status` column to documents.
- Added `status` to Document model fillable fields.
- Implemented processing lifecycle:
  uploaded → processing → processed.
- Added protection against reprocessing an already processed document.
- Connected `failed()` to document status.
- Implemented failure lifecycle:
  uploaded → processing → failed.
- Tested successful document processing.
- Tested processing failure with 3 retries.
- Verified permanent failure updates document status to `failed`.
- Learned about race conditions when multiple workers process the same document.

### Concepts Learned

- Job idempotency
- Processing state tracking
- Job status lifecycle
- Race conditions
- Permanent failure handling
- Retry + status interaction

## Sprint 3 Day 9

### Completed

- Learned about race conditions in queued jobs.
- Identified the problem with separate status checks and updates.
- Replaced the separate check/update with an atomic conditional update.
- Ensured only one worker can claim a document from `uploaded` to `processing`.
- Tested the normal document processing flow successfully.
- Learned about the stale `processing` state when a worker crashes.
- Learned why idempotency requires more than a simple status check.

### Concepts Learned

- Race conditions
- Atomic conditional updates
- Concurrent queue workers
- Document claiming
- Stale processing state
- Locks and leases
- Retry safety
