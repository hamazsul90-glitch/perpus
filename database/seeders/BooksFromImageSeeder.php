<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BooksFromImageSeeder extends Seeder
{
    public function run()
    {
        $path = database_path('seeders/data/books_from_image.csv');

        if (!file_exists($path)) {
            $this->command->error('CSV file not found: ' . $path);
            return;
        }

        if (($handle = fopen($path, 'r')) !== false) {
            $headers = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($headers, $row);

                $title = trim($data['title'] ?? '');
                $author = trim($data['author'] ?? '');
                $publisher = trim($data['publisher'] ?? '');
                $year = intval($data['year'] ?? 0) ?: null;

                if (!$title) continue;

                Book::create([
                    'title' => Str::limit($title, 255),
                    'author' => Str::limit($author, 255),
                    'publisher' => Str::limit($publisher, 255),
                    'year' => $year,
                    'copies_total' => 1,
                    'copies_available' => 1,
                ]);
            }
            fclose($handle);
        }
    }
}
