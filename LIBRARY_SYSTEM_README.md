# Library Management System

A comprehensive library management system built with Laravel and Tailwind CSS. This system provides complete book management, borrowing functionality, and category organization.

## Features

### 📚 Book Management
- **Add New Books**: Comprehensive form with all necessary book details
- **Book Listing**: Search and filter books by title, author, ISBN, category, and status
- **Book Details**: View complete book information including borrowing history
- **Edit Books**: Update book information and inventory
- **Delete Books**: Remove books from the system

### 📖 Book Information Fields
- **Basic Info**: Title, Author, ISBN, Publisher, Publication Year, Edition
- **Additional Info**: Genre, Language, Pages, Format, Price
- **Inventory**: Total Copies, Available Copies, Location, Call Number, Status
- **Description**: Detailed book description
- **Category**: Organize books by categories

### 🏷️ Category Management
- **Create Categories**: Add new book categories with descriptions
- **Color Coding**: Assign colors to categories for easy identification
- **Hierarchical Categories**: Support for parent-child category relationships
- **Category Examples**: Built-in suggestions for common categories

### 📋 Borrowing System
- **Borrow Books**: Complete borrowing process with user selection
- **Due Date Management**: Automatic 14-day default due date
- **Borrowing Rules**: Clear guidelines displayed during borrowing
- **Return Books**: Mark books as returned
- **Status Tracking**: Track borrowed, returned, overdue, and lost books

### 📊 Dashboard
- **Statistics**: Total books, categories, borrowed books, overdue books
- **Recent Activity**: Latest books added and recent borrowings
- **Quick Actions**: Easy access to common tasks
- **Visual Indicators**: Color-coded status badges

## Database Structure

### Books Table
- `id` - Primary key
- `title` - Book title
- `author` - Book author
- `isbn` - International Standard Book Number
- `publisher` - Publishing company
- `publication_year` - Year of publication
- `edition` - Book edition
- `genre` - Book genre
- `description` - Book description
- `total_copies` - Total number of copies
- `available_copies` - Available copies for borrowing
- `location` - Physical location in library
- `call_number` - Library call number
- `price` - Book price
- `language` - Book language
- `pages` - Number of pages
- `format` - Book format (Hardcover, Paperback, E-book, Audiobook)
- `status` - Book status (Available, Maintenance, Lost, Reserved)
- `category_id` - Foreign key to categories table

### Categories Table
- `id` - Primary key
- `name` - Category name
- `description` - Category description
- `color` - Hex color code for category
- `parent_id` - Parent category ID for hierarchical categories

### Borrowings Table
- `id` - Primary key
- `book_id` - Foreign key to books table
- `user_id` - Foreign key to users table
- `borrowed_at` - When the book was borrowed
- `due_date` - When the book is due
- `returned_at` - When the book was returned
- `status` - Borrowing status (Borrowed, Returned, Overdue, Lost)
- `notes` - Additional notes

## Setup Instructions

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Seed the Database
```bash
php artisan db:seed
```

This will create:
- Sample categories (Fiction, Non-Fiction, Science, History, Technology, Self-Help)
- Sample books with complete information
- Test user account

### 3. Access the System
- Navigate to `/library` to access the main dashboard
- Use the navigation menu to access different sections

## Usage Guide

### Adding a New Book
1. Navigate to Library → Books
2. Click "Add New Book"
3. Fill in the comprehensive form with book details
4. Submit to add the book to the system

### Borrowing a Book
1. Navigate to Library → Borrowings
2. Click "Add New Borrowing"
3. Select the book and user
4. Set the due date (defaults to 14 days)
5. Add any notes and submit

### Managing Categories
1. Navigate to Library → Categories
2. Click "Add New Category"
3. Enter category name, description, and color
4. Optionally select a parent category for subcategories

### Searching Books
1. Navigate to Library → Books
2. Use the search form to filter by:
   - Title, Author, or ISBN
   - Category
   - Status
3. Results are displayed in a paginated table

## Form Features

### Book Entry Form
- **Organized Sections**: Basic Info, Additional Info, Inventory, Description
- **Validation**: Comprehensive validation for all fields
- **User-Friendly**: Clear labels, placeholders, and help text
- **Responsive**: Works on desktop and mobile devices

### Borrowing Form
- **Smart Selection**: Only shows available books
- **User Selection**: Dropdown with user names and emails
- **Default Values**: Automatic due date calculation
- **Rules Display**: Clear borrowing guidelines

### Category Form
- **Color Picker**: Visual color selection with hex input sync
- **Hierarchical**: Support for parent-child relationships
- **Examples**: Built-in category suggestions
- **Validation**: Unique category names

## Technical Features

### Laravel Features Used
- **Eloquent ORM**: For database relationships
- **Resource Controllers**: Full CRUD operations
- **Form Validation**: Comprehensive input validation
- **Route Model Binding**: Automatic model resolution
- **Pagination**: Built-in pagination for large datasets

### Frontend Features
- **Tailwind CSS**: Modern, responsive design
- **Blade Components**: Reusable UI components
- **JavaScript**: Interactive color picker and form validation
- **Responsive Design**: Mobile-friendly interface

### Security Features
- **Authentication**: All routes protected by auth middleware
- **CSRF Protection**: All forms include CSRF tokens
- **Input Validation**: Server-side validation for all inputs
- **SQL Injection Protection**: Eloquent ORM protection

## Customization

### Adding New Book Fields
1. Add the field to the `books` table migration
2. Update the `Book` model's `$fillable` array
3. Add the field to the create/edit forms
4. Update validation rules in the controller

### Adding New Categories
1. Use the category management interface
2. Or add directly to the `categories` table
3. Categories are automatically available in book forms

### Modifying Borrowing Rules
1. Edit the borrowing form view
2. Update the controller validation rules
3. Modify the default due date calculation

## Support

For questions or issues with the library system:
1. Check the Laravel documentation
2. Review the code comments
3. Test with the sample data provided

## Sample Data Included

The seeder creates sample data including:
- **6 Categories**: Fiction, Non-Fiction, Science, History, Technology, Self-Help
- **7 Books**: Classic literature, programming books, self-help, and more
- **Complete Information**: All books have full details for testing

This provides a complete working example of the library system functionality. 

## API Endpoints

### Get All Books (with Category)
- **Endpoint:** `GET /api/books`
- **Description:** Returns a JSON array of all encoded books, including their category information. Useful for integration with external systems.
- **Response Example:**
```json
[
  {
    "id": 1,
    "title": "Book Title",
    "author": "Author Name",
    "isbn": "1234567890",
    "publisher": "Publisher Name",
    "publication_year": 2024,
    "edition": "1st",
    "genre": "Fiction",
    "description": "Book description...",
    "total_copies": 10,
    "available_copies": 5,
    "location": "Shelf A",
    "call_number": "QA123 .B66 2024",
    "price": "100.00",
    "language": "English",
    "pages": 300,
    "format": "Hardcover",
    "status": "Available",
    "category_id": 2,
    "created_at": "2024-07-08T12:00:00.000000Z",
    "updated_at": "2024-07-08T12:00:00.000000Z",
    "category": {
      "id": 2,
      "name": "Science",
      "description": "Science books",
      "color": "#00ff00",
      "parent_id": null,
      "created_at": "2024-07-08T12:00:00.000000Z",
      "updated_at": "2024-07-08T12:00:00.000000Z"
    }
  },
  // ... more books ...
]
``` 
