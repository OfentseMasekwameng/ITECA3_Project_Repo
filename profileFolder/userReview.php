<?php
include_once("includes/connection.php");
include_once("includes/configSession.inc.php");
include_once("functions/common.php");

// Fetch reviews from the database
function fetch_reviews($conn) {
    // Fetch reviews from the database
    $reviews_query = $conn->prepare("SELECT r.review_id, r.rating, r.review_text, r.review_date, u.first_name, u.last_name FROM website_reviews r JOIN site_user u ON r.user_id = u.user_id ORDER BY r.review_date DESC");
    $reviews_query->execute();
    $reviews_result = $reviews_query->get_result();

    return $reviews_result;
}

// Function to delete a review
function delete_review($conn, $review_id, $user_id) {
    // Prepare the SQL statement to delete the review only if it belongs to the logged-in user
    $delete_query = $conn->prepare("DELETE FROM reviews WHERE review_id = ? AND user_id = ?");
    $delete_query->bind_param("ii", $review_id, $user_id);

    // Execute the query
    if ($delete_query->execute()) {
        // Review deleted successfully
        return true;
    } else {
        // Failed to delete review
        return false;
    }

    // Close the prepared statement
    $delete_query->close();
}

// Check if the delete action is initiated
if (isset($_GET['delete_review']) && isset($_SESSION['user_id'])) {
    // Get the review ID from the URL parameter
    $review_id = $_GET['delete_review'];
    $user_id = $_SESSION['user_id'];

    // Call the delete_review function
    if (delete_review($conn, $review_id, $user_id)) {
        // Review deleted successfully
        echo '<script>alert("Review deleted successfully."); window.location.href = "profile.php";</script>';
    } else {
        // Failed to delete review
        echo '<script>alert("Failed to delete review."); window.location.href = "profile.php";</script>';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        // Redirect to login if user_id is not set
        header("Location: login.php");
        exit();
    }

    $rating = intval($_POST['rating']);
    $review_text = $_POST['review_text'];

    // Insert review into the database
    $stmt = $conn->prepare("INSERT INTO website_reviews (user_id, rating, review_text, review_date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $user_id, $rating, $review_text);

    if ($stmt->execute()) {
        echo '<script>alert("Review submitted successfully."); window.location.href = "profile.php";</script>';
    } else {
        echo '<script>alert("Failed to submit review."); window.location.href = "profile.php";</script>';
    }

    $stmt->close();
}

// Check if the delete action is initiated
if (isset($_GET['delete_review']) && isset($_SESSION['user_id'])) {
    // Get the review ID from the URL parameter
    $review_id = $_GET['delete_review'];
    $user_id = $_SESSION['user_id'];

    // Call the delete_review function
    if (delete_review($conn, $review_id, $user_id)) {
        // Review deleted successfully
        echo '<script>alert("Review deleted successfully."); window.location.href = "profile.php";</script>';
    } else {
        // Failed to delete review
        echo '<script>alert("Failed to delete review."); window.location.href = "profile.php";</script>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leave a Review</title>
    <style>
        /* Add some basic styling */
        .review-form {
            max-width: 500px;
            margin: 0 auto;
            padding: 1em;
            border: 1px solid #ccc;
            border-radius: 1em;
        }
        .review-form div {
            margin-bottom: 1em;
        }
        .review-form label {
            margin-bottom: .5em;
            color: #333333;
        }
        .review-form input, .review-form textarea {
            border: 1px solid #ccc;
            border-radius: 0.5em;
            box-sizing: border-box;
            width: 100%;
            padding: 0.5em;
        }
    </style>
</head>
<body>
    <h1>Product Page</h1>

    <!-- TYPE REVIEWS SECTION -->
    <div class="review-form">
        <h2>Leave a Review</h2>
        <form id="reviewForm" action="" method="post">
            <div>
                <label for="rating">Rating (1-5):</label>
                <input type="number" id="rating" name="rating" min="1" max="5" required>
            </div>
            <div>
                <label for="review_text">Review:</label>
                <textarea id="review_text" name="review_text" rows="4" required placeholder="Leave review"></textarea>
            </div>
            <div>
                <button type="submit" class="btn">Submit Review</button>
            </div>
        </form>
    </div>
    
    <!-- Reviews section -->
    <div class="reviews">
        <?php
        // Fetch and display reviews from the database
        $reviews_result = fetch_reviews($conn); // Assuming you have a function to fetch reviews
            while ($review = $reviews_result->fetch_assoc()) {
                echo '<div class="review">';
                echo '<h3>Review by ' . htmlspecialchars($review['first_name']) . ' ' . htmlspecialchars($review['last_name']) . '</h3>';
                echo '<p>Rating: ' . htmlspecialchars($review['rating']) . '</p>';
                echo '<p>' . htmlspecialchars($review['review_text']) . '</p>';
                echo '<p>Posted on: ' . htmlspecialchars($review['review_date']) . '</p>';
                // Add delete button with review ID as a parameter
                if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $review['user_id']) {
                    echo '<a href="profile.php?delete_review=' . $review['review_id'] . '" onclick="return confirm(\'Are you sure you want to delete this review?\')">Delete</a>';
                }
                echo '<hr class="line">';
                echo '</div>';
            }
        ?>
    </div>

</body>
</html>
