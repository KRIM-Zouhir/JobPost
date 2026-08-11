# JobPost

A simple PHP web application providing a frontend and backend for managing posts, user authentication, file uploads and email notifications. The project includes a lightweight custom backend in `backend/`, client views in `frontend/`, and third-party libraries under `vendor/` and `phpmailer/`.

## Key Features

- User authentication (signup, login, password reset)
- Post creation and file uploads
- Presets and user profiles
- Admin pages for managing posts, users and applications
- Email sending via PHPMailer

## Requirements

- PHP 7.4 or newer
- Composer
- A MySQL/MariaDB database (or compatible)
- Web server (Apache, Nginx) or PHP built-in server for local testing

## Quick Setup

1. Clone the repository to your web server document root:

```bash
git git@github.com:KRIM-Zouhir/JobPost.git clone 
cd JobPost
```

2. Install PHP dependencies with Composer:

```bash
composer install
```

3. Configure the application:

- Edit `backend/connect.php` to set your database host, name, username and password.
- Update any mail/SMTP settings used by the project (the project includes a `phpmailer/` folder; search for SMTP configuration or the mail helper in `backend/`).

4. Ensure the `uploads/` directory (and its subfolders) is writable by the web server so file uploads work correctly.

5. Run locally for testing using PHP's built-in server:

```bash
php -S localhost:8000 -t .
```

Then open http://localhost:8000/ in your browser. `index.php` is the app entry point.

## Project Structure (top-level)

- `index.php` — application entry point
- `backend/` — PHP backend scripts (API endpoints, auth, DB connection, helpers)
- `frontend/` — page templates and frontend views
- `assets/` — images, styles and client assets
- `uploads/` — user-uploaded files (must be writable)
- `vendor/` and `phpmailer/` — third-party libraries

## Deployment Notes

- Point your webserver document root to the project root (so `index.php` is served).
- Set appropriate file/directory permissions for `uploads/`.
- Use environment-specific configuration (do not commit credentials to source control).

## Contributing

Contributions are welcome. Please open an issue to discuss major changes, or submit a pull request with a clear description of the change.

## License

No license file is included in this repository. If you intend to publish or share this project, add a `LICENSE` file (for example, MIT) and update this section.

## Support / Contact

If you need help with setup or want feature improvements, open an issue in the repository or contact the project maintainers.
