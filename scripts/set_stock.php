<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;

Book::query()->update(['copies_total' => 10, 'copies_available' => 10]);
echo "Updated book stocks to 10\n";
