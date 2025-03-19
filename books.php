<?php
require_once 'vendor/autoload.php';

$faker = Faker\Factory::create();

// Predefined genres
$genres = [
    'Fiction',
    'Mystery',
    'Science Fiction',
    'Fantasy',
    'Romance',
    'Thriller',
    'Historical',
    'Horror'
];

// Generate 15 books
$books = [];
for ($i = 0; $i < 15; $i++) {
    $books[] = [
        'title' => ucwords($faker->words(rand(3, 6), true)), // More realistic title length
        'author' => $faker->name(),
        'genre' => $faker->randomElement($genres),
        'publication_year' => $faker->numberBetween(1900, 2024),
        'isbn' => $faker->isbn13(),
        'summary' => $faker->text(200) // More controlled summary length
    ];
}

// Display table
?>
<!DOCTYPE html>
<html>
<head>
    <title>Generated Books</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        tr:hover { background-color: #ddd; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <h1>Generated Books</h1>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Year</th>
                <th>ISBN</th>
                <th>Summary</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
            <tr>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td><?= htmlspecialchars($book['genre']) ?></td>
                <td><?= htmlspecialchars($book['publication_year']) ?></td>
                <td><?= htmlspecialchars($book['isbn']) ?></td>
                <td><?= htmlspecialchars($book['summary']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
