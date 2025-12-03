## Project update — Quick summary & how to test

- **What was added in this branch:**
	- Login and registration flows for regular users and admins (role-based).
	- Admin-only middleware protecting `/admin/dashboard` and role redirects (regular → `/books/search`).
	- Placeholder pages for `/books/search` (user) and `/admin/dashboard` (admin).
	- Show-password toggle on login and register forms.
	- Seeder creates a test user and an admin for local development.

- **Test locally (quick commands)** — run from project root:

```powershell
composer install
copy .env.example .env
# edit .env to set DB credentials if needed
php artisan key:generate
php artisan migrate --seed
php artisan serve --host=127.0.0.1 --port=8000
Start-Process "http://127.0.0.1:8000/login"
```

- **Test accounts created by seeder:**
	- Regular user: `test@example.com` / `password`
	- Admin user: `admin@example.test` / `password`

- **Quick verification steps:**
	1. Register a new account at `/register` (you'll be redirected to `/login` with a success message).
	2. Login as regular user → you should land on `/books/search`.
	3. Login as admin → you should land on `/admin/dashboard`.
	4. Use the Logout button on placeholder pages to end the session.

Feel free to pull this branch, run the commands above, and open a PR or report issues.
