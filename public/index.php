<?php
require_once 'config.php';

// Fetch all restaurants from the database
$sql = "SELECT * FROM restaurants";
$result = mysqli_query($link, $sql);

$restaurants = [];
while ($restaurant = mysqli_fetch_assoc($result)) {
    $restaurants[] = $restaurant;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Booking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ensure the card body and images are of equal height */
        .card-img-top {
            height: 200px;
            object-fit: cover;
            /* Ensures images fit the box without distortion */
        }

        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            /* Flexbox ensures equal space distribution */
        }

        .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Set a fixed width and height for the card */
        .col-md-4 {
            max-width: 300px;
            margin-bottom: 20px;
        }

        /* Ensure that the description text is aligned and doesn't overflow */
        .card-text {
            text-align: center;
            flex-grow: 1;
        }

        /* Ensure button stays aligned at the bottom */
        .btn-primary {
            margin-top: auto;
        }
    </style>

</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Book a Table at Our Restaurants</h1>
        <div class="row justify-content-center">
            <?php foreach ($restaurants as $restaurant): ?>
            <div class="col-md-4 d-flex">
                <div class="card">
                    <img src="<?php echo htmlspecialchars($restaurant['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($restaurant['name']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($restaurant['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($restaurant['description']); ?></p>
                        <a href="booking.php?restaurant_id=<?php echo $restaurant['id']; ?>" class="btn btn-primary">Book a Table</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Admin Dashboard Button -->
        <div class="mt-4">
            <a href="admin/dashboard.php" class="btn btn-secondary">Admin Dashboard</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
