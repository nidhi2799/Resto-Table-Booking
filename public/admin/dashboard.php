<?php
require_once '../config.php';

// Fetch all restaurants from the database
$sql = "SELECT * FROM restaurants";
$result = mysqli_query($link, $sql);

// Check if the query was successful
if ($result) {
    $restaurants = [];
    while ($restaurant = mysqli_fetch_assoc($result)) {
        $restaurants[] = $restaurant;
    }
} else {
    // If the query failed, handle the error
    echo "Error fetching restaurants: " . mysqli_error($link);
    $restaurants = []; // Empty array to avoid errors in the foreach loop
}

// Fetch all reservations from the database
$sql = "SELECT reservations.*, restaurants.name AS restaurant_name FROM reservations 
        JOIN restaurants ON reservations.restaurant_id = restaurants.id
        ORDER BY reservation_date, reservation_time";
$reservations = mysqli_query($link, $sql);

// Check if the query was successful
if (!$reservations) {
    echo "Error fetching reservations: " . mysqli_error($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ensure all cards are the same height */
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Make the image fill the space above the card body */
        .card-img-top {
            object-fit: cover;
            height: 200px; /* Set a fixed height for the images */
        }

        /* Make sure the card body takes up the remaining space */
        .card-body {
            flex-grow: 1;
        }

        /* Ensure card text is limited to a few lines */
        .card-text {
            display: -webkit-box;
            -webkit-line-clamp: 3; /* Limits text to 3 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Admin Dashboard</h1>

        <h2 class="mb-4">Manage Restaurants</h2>
        <a href="add_restaurant.php" class="btn btn-primary mb-4">Add New Restaurant</a>
        <div class="row">
            <?php if (!empty($restaurants)): ?>
                <?php foreach ($restaurants as $restaurant): ?>
                    <div class="col-md-4 d-flex">
                        <div class="card mb-4 w-100">
                            <img src="<?php echo htmlspecialchars($restaurant['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($restaurant['name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($restaurant['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($restaurant['description']); ?></p>
                                <a href="edit_restaurant.php?id=<?php echo $restaurant['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete_restaurant.php?id=<?php echo $restaurant['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this restaurant?');">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No restaurants found.</p>
            <?php endif; ?>
        </div>

        <h2 class="mb-4">Reservation Details</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Restaurant</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Guests</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($reservations): ?>
                    <?php while ($reservation = mysqli_fetch_assoc($reservations)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reservation['restaurant_name']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['customer_email']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['reservation_date']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['reservation_time']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['guests']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No reservations found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="../index.php" class="btn btn-secondary">Back to Home</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
