<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Our Cause</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Support Our Cause</h1>
    <form action="process_donation.php" method="POST">
        <label for="name">
            <i class="fas fa-user"></i> Name:
        </label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">
            <i class="fas fa-envelope"></i> Email:
        </label>
        <input type="email" id="email" name="email" required><br>

        <label for="amount">
            <i class="fas fa-dollar-sign"></i> Donation Amount:
        </label>
        <input type="number" id="amount" name="amount" min="1" step="1" required><br>

        <button type="submit">
            <i class="fas fa-donate"></i> Donate Now
        </button>
    </form>
</body>
</html>
