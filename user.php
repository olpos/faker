<?php
require 'vendor/autoload.php';

use Faker\Factory;

// Create Faker instance with Philippines locale
$faker = Factory::create('en_PH');

// Function to generate secure password
function generateSecurePassword($length = 10) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $password;
}

// Generate 5 user accounts
$users = [];
for ($i = 0; $i < 5; $i++) {
    $email = $faker->email();
    $username = strtolower(explode('@', $email)[0]);
    
    $rawPassword = generateSecurePassword(12);
    $hashedPassword = hash('sha256', $rawPassword);
    
    $users[] = [
        'user_id' => $faker->uuid(),
        'full_name' => $faker->name(),
        'birthdate' => $faker->date('Y-m-d', '-18 years'),
        'phone' => '+63 ' . substr($faker->phoneNumber, 1), // Convert 09XX to +63 9XX format
        'email' => $email,
        'username' => $username,
        'address' => $faker->streetAddress . ', ' . 
                    $faker->city . ', ' . 
                    $faker->province,
        'job_title' => $faker->jobTitle,
        'password' => [
            'raw' => $rawPassword,
            'hashed' => $hashedPassword
        ],
        'created_at' => $faker->dateTimeBetween('-2 years')->format('Y-m-d H:i:s')
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filipino User Profiles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .password-cell { max-width: 200px; overflow: hidden; text-overflow: ellipsis; }
        .uuid-cell { max-width: 150px; overflow: hidden; text-overflow: ellipsis; }
        .address-cell { max-width: 300px; }
    </style>
</head>
<body>
    <div class="container-fluid my-5">
        <h1 class="text-center mb-4">Generated Filipino User Profiles</h1>
        
        <div class="table-responsive">
            <table class="table table-hover table-striped table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>UUID</th>
                        <th>Full Name</th>
                        <th>Birthdate</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Job Title</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="uuid-cell"><code><?= htmlspecialchars($user['user_id']) ?></code></td>
                        <td><?= htmlspecialchars($user['full_name']) ?></td>
                        <td><?= htmlspecialchars($user['birthdate']) ?></td>
                        <td><code><?= htmlspecialchars($user['phone']) ?></code></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td class="address-cell"><?= htmlspecialchars($user['address']) ?></td>
                        <td><?= htmlspecialchars($user['job_title']) ?></td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="text-center mt-4">
            <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-primary">Generate New Profiles</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
