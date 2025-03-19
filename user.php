<?php
require 'vendor/autoload.php';

use Faker\Factory;

// Create Faker instance
$faker = Factory::create();

// Function to generate secure password
function generateSecurePassword($length = 10) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $password;
}

// Generate 10 user accounts
$users = [];
for ($i = 0; $i < 10; $i++) {
    // Generate email and derive username from it
    $email = $faker->email();
    $username = strtolower(explode('@', $email)[0]);
    
    // Generate random password and hash it
    $rawPassword = generateSecurePassword(12);
    $hashedPassword = hash('sha256', $rawPassword);
    
    $users[] = [
        'user_id' => $faker->uuid(),
        'full_name' => $faker->name(),
        'email' => $email,
        'username' => $username,
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
    <title>User Accounts Database</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .password-cell { max-width: 200px; overflow: hidden; text-overflow: ellipsis; }
        .uuid-cell { max-width: 150px; overflow: hidden; text-overflow: ellipsis; }
    </style>
</head>
<body>
    <div class="container-fluid my-5">
        <h1 class="text-center mb-4">Generated User Accounts</h1>
        
        <div class="table-responsive">
            <table class="table table-hover table-striped table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>UUID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Raw Password</th>
                        <th>Hashed Password (SHA-256)</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="uuid-cell"><code><?= htmlspecialchars($user['user_id']) ?></code></td>
                        <td><?= htmlspecialchars($user['full_name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><code><?= htmlspecialchars($user['username']) ?></code></td>
                        <td><code><?= htmlspecialchars($user['password']['raw']) ?></code></td>
                        <td class="password-cell"><code><?= htmlspecialchars($user['password']['hashed']) ?></code></td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="text-center mt-4">
            <p class="text-muted"><small>Note: Raw passwords are shown for demonstration purposes only. In a real application, only hashed passwords should be stored.</small></p>
            <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-primary">Generate New Users</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
