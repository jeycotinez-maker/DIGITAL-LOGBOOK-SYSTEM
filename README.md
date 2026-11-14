# SmartLog — PNPh Digital Logbook

This package contains a Laravel 12 application source tree based on the supplied PNPh SmartLog SRS, system architecture, ERD, flowchart, and frontend starter ZIP.

## Requirements
- PHP 8.2 or newer with PDO MySQL, OpenSSL, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, Fileinfo
- Composer 2
- MySQL 8
- A modern browser

## Install and run (Windows PowerShell)
1. Extract the ZIP to a normal folder, for example `C:\Users\DELL\Downloads\SmartLog-Laravel`.
2. Open that folder in VS Code. **The `artisan` file must be visible in the root.**
3. Install Laravel dependencies:
   ```powershell
   composer install
   ```
4. Create the environment file and app key:
   ```powershell
   Copy-Item .env.example .env
   php artisan key:generate
   ```
5. Create a MySQL database named `smartlog` in MySQL Workbench:
   ```sql
   CREATE DATABASE smartlog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
6. Edit `.env` and set `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` to your MySQL details.
7. Create the tables and demo users:
   ```powershell
   php artisan migrate --seed
   ```
8. Start the app:
   ```powershell
   php artisan serve
   ```
9. Open http://127.0.0.1:8000

## Demo accounts
These are local development-only accounts created by `php artisan db:seed`. Change their passwords before any shared or production use.

| Role | Email / PN ID | Password |
|---|---|---|
| Administrator | admin@smartlog.local | Admin12345! |
| Staff / Social Worker | staff@smartlog.local | Staff12345! |
| Scholar | 202801 or student@smartlog.local | Student12345! |

## Main features in this baseline
- Role-aware login and role-specific dashboards (Scholar, Staff, Administrator)
- Scholar registration and automatic sequential PN ID assignment in `BBBB + two-digit sequence` format
- Time In / Time Out with server timestamps and duplicate open-session protection
- Scholar's own read-only attendance history
- Staff/admin scholar directory and attendance monitoring
- Date-filtered attendance report with CSV export
- Administrator academic year, semester, and update-window settings
- Audit records for registration, attendance actions, and academic settings changes
- Responsive navy-and-white interface

## Important scope and setup notes
- This is a runnable development baseline, not a production deployment. It intentionally does not include Laravel's `vendor` directory; `composer install` downloads the framework and dependencies.
- Configure `SMARTLOG_EMAIL_DOMAIN` in `.env` to the official PNPh email domain after the client confirms it. Leave blank to disable domain restriction during local testing. Email ownership verification is not wired to an outbound mail provider.
- The supplied SRS specifies PDF and Excel exports. This baseline currently provides CSV export only; PDF/XLSX generation needs an approved library and should be added before acceptance.
- The academic update window is configurable and audited, but scholar-side academic update submission/approval screens are not yet implemented.
- Attendance status vocabulary and edge cases (late threshold, overnight sessions, return trips) require PNPh confirmation as stated in the SRS.
- Staff/admin demo accounts are seeded for local testing. Public staff/admin self-registration is deliberately disabled.
- Do not use real scholar personal data in development. Follow PNPh approval and applicable privacy requirements before deployment.
- The supplied original frontend files are retained in `resources/views`/`public` where applicable; the application has been reorganized into Laravel's standard structure.

## Troubleshooting
- `Could not open input file: artisan`: terminal is not in the extracted project root. Run `dir artisan`; if it is missing, open the correct folder.
- `vendor/autoload.php` missing: run `composer install`.
- Database connection error: start MySQL and verify `.env` credentials/database name.
- `APP_KEY` missing: run `php artisan key:generate`.
