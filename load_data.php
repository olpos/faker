<?php
require_once 'vendor/autoload.php';

// Database connection
$host = 'localhost';
$dbname = 'fake_data_db';
$username = 'root'; // Change this if necessary
$password = 'root'; // Change this if necessary

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to database successfully!<br>";

    $faker = Faker\Factory::create('fil_PH'); // Use Philippine locale

    // Insert Offices (50 rows)
    echo "Inserting Offices...<br>";
    for ($i = 0; $i < 50; $i++) {
        $stmt = $pdo->prepare("INSERT INTO Office (name, contactnum, email, address, city, country, postal)
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $faker->company,
            $faker->numerify('+63 9## ### ####'),
            $faker->companyEmail,
            $faker->streetAddress,
            $faker->city,
            'Philippines',
            $faker->postcode
        ]);
    }

    // Fetch all office IDs for FK reference
    $officeIDs = $pdo->query("SELECT id FROM Office")->fetchAll(PDO::FETCH_COLUMN);

    // Insert Employees (200 rows)
    echo "Inserting Employees...<br>";
    for ($i = 0; $i < 200; $i++) {
        $stmt = $pdo->prepare("INSERT INTO Employee (lastname, firstname, office_id, address)
                               VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $faker->lastName,
            $faker->firstName,
            $faker->randomElement($officeIDs),
            $faker->address
        ]);
    }

    // Fetch all employee IDs for FK reference
    $employeeIDs = $pdo->query("SELECT id FROM Employee")->fetchAll(PDO::FETCH_COLUMN);

    // Insert Transactions (500 rows)
    echo "Inserting Transactions...<br>";
    for ($i = 0; $i < 500; $i++) {
        $stmt = $pdo->prepare("INSERT INTO TransactionLog (employee_id, office_id, datelog, action, remarks, documentcode)
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $faker->randomElement($employeeIDs),
            $faker->randomElement($officeIDs),
            $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d H:i:s'), // No future dates
            $faker->randomElement(['Created', 'Updated', 'Deleted', 'Approved', 'Rejected']),
            $faker->sentence,
            $faker->bothify('DOC-#######')
        ]);
    }

    echo "Fake data inserted successfully!";
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

?>
