## Project update — Quick summary & how to test

- **What was added in this branch:**
	- **Database Implementation**: Added `books` and `borrowings` tables with relationships.
	- **Admin Dashboard**:
		- Statistics overview (Total Books, Active Loans, Registered Users).
		- List of active borrowed books with "Mark Returned" functionality.
		- "Add New Book" modal to manage inventory.

- **Test locally (quick commands)** — run from project root:

```powershell
composer install
copy .env.example .env
# Edit .env: Set DB_CONNECTION=mysql and create the database 'library_book_borrowing_system' in phpMyAdmin
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
	4. As Admin, add a book using the "+ Add New Book" button, or click "Mark Returned" on existing loans.
	5. Use the Logout button to end the session.

## 🛠 How to Simulate Data (Tinker Guide)

Since the User Interface for borrowing books isn't built yet, you can use **Tinker** to simulate a user borrowing a book to test the Admin Dashboard.

1. Run `php artisan tinker` in your terminal.
2. Paste the following commands one by one:

```php
// 1. Create a dummy user
$user = \App\Models\User::create(['name'=>'John Doe', 'email'=>'john@test.com', 'password'=>bcrypt('password'), 'role'=>'user']);

// 2. Create a dummy book
$book = \App\Models\Book::create(['title'=>'The Great Gatsby', 'author'=>'F. Scott Fitzgerald', 'isbn'=>'9780743273565', 'stock'=>5]);

// 3. Create a borrowing record (John borrows the book)
\App\Models\Borrowing::create([
    'user_id' => $user->id,
    'book_id' => $book->id,
    'borrowed_at' => now(),
    'due_date' => now()->addDays(14),
    'returned_at' => null // null means currently borrowed
]);
```

3. Type `exit` to close Tinker.
4. Refresh the Admin Dashboard to see the new data.

Feel free to pull this branch, run the commands above, and open a PR or report issues.