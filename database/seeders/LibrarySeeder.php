<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            [
                'name' => 'Fiction',
                'description' => 'Imaginative literature including novels and short stories',
                'color' => '#3B82F6',
            ],
            [
                'name' => 'Non-Fiction',
                'description' => 'Factual literature based on real events and information',
                'color' => '#10B981',
            ],
            [
                'name' => 'Science',
                'description' => 'Books about scientific topics and discoveries',
                'color' => '#F59E0B',
            ],
            [
                'name' => 'History',
                'description' => 'Books about historical events and periods',
                'color' => '#EF4444',
            ],
            [
                'name' => 'Technology',
                'description' => 'Books about computers, programming, and technology',
                'color' => '#8B5CF6',
            ],
            [
                'name' => 'Self-Help',
                'description' => 'Books for personal development and improvement',
                'color' => '#06B6D4',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Get category IDs
        $fiction = Category::where('name', 'Fiction')->first();
        $nonFiction = Category::where('name', 'Non-Fiction')->first();
        $science = Category::where('name', 'Science')->first();
        $history = Category::where('name', 'History')->first();
        $technology = Category::where('name', 'Technology')->first();
        $selfHelp = Category::where('name', 'Self-Help')->first();

        // Create sample books
        $books = [
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'isbn' => '978-0743273565',
                'publisher' => 'Scribner',
                'publication_year' => 1925,
                'edition' => '1st Edition',
                'genre' => 'Classic Fiction',
                'description' => 'A story of the fabulously wealthy Jay Gatsby and his love for the beautiful Daisy Buchanan.',
                'total_copies' => 3,
                'available_copies' => 3,
                'location' => 'Shelf A, Row 1',
                'call_number' => 'FIC FIT',
                'price' => 12.99,
                'language' => 'English',
                'pages' => 180,
                'format' => 'Paperback',
                'status' => 'Available',
                'category_id' => $fiction->id,
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'isbn' => '978-0446310789',
                'publisher' => 'Grand Central Publishing',
                'publication_year' => 1960,
                'edition' => '1st Edition',
                'genre' => 'Classic Fiction',
                'description' => 'The story of young Scout Finch and her father Atticus in a racially divided Alabama town.',
                'total_copies' => 2,
                'available_copies' => 2,
                'location' => 'Shelf A, Row 2',
                'call_number' => 'FIC LEE',
                'price' => 14.99,
                'language' => 'English',
                'pages' => 281,
                'format' => 'Paperback',
                'status' => 'Available',
                'category_id' => $fiction->id,
            ],
            [
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari',
                'isbn' => '978-0062316097',
                'publisher' => 'Harper',
                'publication_year' => 2015,
                'edition' => '1st Edition',
                'genre' => 'History',
                'description' => 'A groundbreaking narrative of humanity\'s creation and evolution.',
                'total_copies' => 2,
                'available_copies' => 2,
                'location' => 'Shelf B, Row 1',
                'call_number' => 'HIS HAR',
                'price' => 24.99,
                'language' => 'English',
                'pages' => 443,
                'format' => 'Hardcover',
                'status' => 'Available',
                'category_id' => $history->id,
            ],
            [
                'title' => 'The Art of War',
                'author' => 'Sun Tzu',
                'isbn' => '978-0140439199',
                'publisher' => 'Penguin Classics',
                'publication_year' => 500,
                'edition' => '1st Edition',
                'genre' => 'Military Strategy',
                'description' => 'Ancient Chinese text on military strategy and tactics.',
                'total_copies' => 1,
                'available_copies' => 1,
                'location' => 'Shelf C, Row 1',
                'call_number' => 'MIL SUN',
                'price' => 9.99,
                'language' => 'English',
                'pages' => 112,
                'format' => 'Paperback',
                'status' => 'Available',
                'category_id' => $nonFiction->id,
            ],
            [
                'title' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'author' => 'Robert C. Martin',
                'isbn' => '978-0132350884',
                'publisher' => 'Prentice Hall',
                'publication_year' => 2008,
                'edition' => '1st Edition',
                'genre' => 'Programming',
                'description' => 'A guide to writing clean, maintainable code.',
                'total_copies' => 2,
                'available_copies' => 2,
                'location' => 'Shelf D, Row 1',
                'call_number' => 'TEC MAR',
                'price' => 49.99,
                'language' => 'English',
                'pages' => 464,
                'format' => 'Paperback',
                'status' => 'Available',
                'category_id' => $technology->id,
            ],
            [
                'title' => 'The 7 Habits of Highly Effective People',
                'author' => 'Stephen R. Covey',
                'isbn' => '978-0743269513',
                'publisher' => 'Free Press',
                'publication_year' => 1989,
                'edition' => '1st Edition',
                'genre' => 'Self-Help',
                'description' => 'A powerful book about personal and professional effectiveness.',
                'total_copies' => 3,
                'available_copies' => 3,
                'location' => 'Shelf E, Row 1',
                'call_number' => 'SEL COV',
                'price' => 16.99,
                'language' => 'English',
                'pages' => 381,
                'format' => 'Paperback',
                'status' => 'Available',
                'category_id' => $selfHelp->id,
            ],
            [
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'isbn' => '978-0553380163',
                'publisher' => 'Bantam',
                'publication_year' => 1988,
                'edition' => '1st Edition',
                'genre' => 'Physics',
                'description' => 'An exploration of cosmology and the universe.',
                'total_copies' => 1,
                'available_copies' => 1,
                'location' => 'Shelf F, Row 1',
                'call_number' => 'SCI HAW',
                'price' => 18.99,
                'language' => 'English',
                'pages' => 256,
                'format' => 'Paperback',
                'status' => 'Available',
                'category_id' => $science->id,
            ],
        ];

        foreach ($books as $bookData) {
            Book::create($bookData);
        }
    }
}
