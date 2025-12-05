<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $books = [
            ['title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'isbn' => '9780743273565', 'stock' => 5],
            ['title' => '1984', 'author' => 'George Orwell', 'isbn' => '9780451524935', 'stock' => 8],
            ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'isbn' => '9780061120084', 'stock' => 10],
            ['title' => 'Pride and Prejudice', 'author' => 'Jane Austen', 'isbn' => '9781503290563', 'stock' => 7],
            ['title' => 'The Catcher in the Rye', 'author' => 'J.D. Salinger', 'isbn' => '9780316769488', 'stock' => 6],
            ['title' => 'The Hobbit', 'author' => 'J.R.R. Tolkien', 'isbn' => '9780547928227', 'stock' => 9],
            ['title' => 'Fahrenheit 451', 'author' => 'Ray Bradbury', 'isbn' => '9781451673319', 'stock' => 5],
            ['title' => 'Jane Eyre', 'author' => 'Charlotte Brontë', 'isbn' => '9780141441146', 'stock' => 4],
            ['title' => 'Brave New World', 'author' => 'Aldous Huxley', 'isbn' => '9780060850524', 'stock' => 6],
            ['title' => 'Animal Farm', 'author' => 'George Orwell', 'isbn' => '9780451526342', 'stock' => 8],
            ['title' => 'Moby Dick', 'author' => 'Herman Melville', 'isbn' => '9781503280786', 'stock' => 3],
            ['title' => 'The Odyssey', 'author' => 'Homer', 'isbn' => '9780140268867', 'stock' => 4],
            ['title' => 'Crime and Punishment', 'author' => 'Fyodor Dostoevsky', 'isbn' => '9780140449136', 'stock' => 5],
            ['title' => 'Wuthering Heights', 'author' => 'Emily Brontë', 'isbn' => '9780141439556', 'stock' => 4],
            ['title' => 'The Lord of the Rings', 'author' => 'J.R.R. Tolkien', 'isbn' => '9780544003415', 'stock' => 12],
            ['title' => 'Harry Potter and the Sorcerer\'s Stone', 'author' => 'J.K. Rowling', 'isbn' => '9780590353427', 'stock' => 15],
            ['title' => 'Harry Potter and the Chamber of Secrets', 'author' => 'J.K. Rowling', 'isbn' => '9780439064873', 'stock' => 12],
            ['title' => 'Harry Potter and the Prisoner of Azkaban', 'author' => 'J.K. Rowling', 'isbn' => '9780439136365', 'stock' => 10],
            ['title' => 'Harry Potter and the Goblet of Fire', 'author' => 'J.K. Rowling', 'isbn' => '9780439139601', 'stock' => 10],
            ['title' => 'Harry Potter and the Order of the Phoenix', 'author' => 'J.K. Rowling', 'isbn' => '9780439358071', 'stock' => 10],
            ['title' => 'Harry Potter and the Half-Blood Prince', 'author' => 'J.K. Rowling', 'isbn' => '9780439785969', 'stock' => 10],
            ['title' => 'Harry Potter and the Deathly Hallows', 'author' => 'J.K. Rowling', 'isbn' => '9780545010221', 'stock' => 10],
            ['title' => 'The Chronicles of Narnia: The Lion, the Witch and the Wardrobe', 'author' => 'C.S. Lewis', 'isbn' => '9780064471046', 'stock' => 8],
            ['title' => 'The Da Vinci Code', 'author' => 'Dan Brown', 'isbn' => '9780307474278', 'stock' => 7],
            ['title' => 'Angels & Demons', 'author' => 'Dan Brown', 'isbn' => '9780743493468', 'stock' => 7],
            ['title' => 'The Alchemist', 'author' => 'Paulo Coelho', 'isbn' => '9780061122415', 'stock' => 6],
            ['title' => 'The Kite Runner', 'author' => 'Khaled Hosseini', 'isbn' => '9781594631931', 'stock' => 8],
            ['title' => 'Life of Pi', 'author' => 'Yann Martel', 'isbn' => '9780156027328', 'stock' => 5],
            ['title' => 'The Hunger Games', 'author' => 'Suzanne Collins', 'isbn' => '9780439023481', 'stock' => 9],
            ['title' => 'Catching Fire', 'author' => 'Suzanne Collins', 'isbn' => '9780439023498', 'stock' => 9],
            ['title' => 'Mockingjay', 'author' => 'Suzanne Collins', 'isbn' => '9780439023511', 'stock' => 9],
        ];

        $now = now();
        $books = array_map(function($book) use ($now) {
            $book['created_at'] = $now;
            $book['updated_at'] = $now;
            return $book;
        }, $books);

        Book::insert($books);
    }
}
