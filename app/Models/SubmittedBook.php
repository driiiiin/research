<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmittedBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'title',
        'author',
        'isbn',
        'submitted_at',
        'received_at',
        'received_status',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
