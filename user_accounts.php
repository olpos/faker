<?php
require_once 'vendor/autoload.php';

use Faker\Factory;

$faker = Factory::create();

// Create array to store user accounts
$users = [];

// Generate 10 fake user accounts
for ($i = 0; $i < 10; $i++) {
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    $email = $faker->email;
    $username = strtolower(explode('@', $email)[0]);
    $plainPassword = $faker->password(8);

    $users[] = [
        'user_id' => $faker->uuid,
        'full_name' => "$firstName $lastName",
        'email' => $email,
        'username' => $username,
        'password' => hash('sha256', $plainPassword),
        'created_at' => $faker->dateTimeBetween('-2 years')->format('Y-m-d H:i:s')
    ];
}

// Display the data in an HTML table
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Accounts</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Generated User Accounts</h2>
    <table>
        <tr>
            <th>User ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Username</th>
            <th>Password (SHA-256)</th>
            <th>Created At</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['user_id']) ?></td>
            <td><?= htmlspecialchars($user['full_name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['password']) ?></td>
            <td><?= htmlspecialchars($user['created_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
