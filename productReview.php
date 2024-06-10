<?php
include_once("includes/connection.php");
require_once "includes/configSession.inc.php";
include_once("functions/common.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        // Redirect to login if user_id is not set
        echo '<script>window.location.href = "userfolder/login.php";</script>';
        exit();
    }

    
    $rating = intval($_POST['rating']);
    $review_text = $_POST['review_text'];

    // Insert review into the database
    $stmt = $conn->prepare("INSERT INTO reviews (user_id, product_id, rating, review_text, review_date) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiis", $user_id, $product_id, $rating, $review_text);

    if ($stmt->execute()) {
        echo '<script>alert("Review submitted successfully."); window.location.href = "productDetails.php";</script>';
    } else {
        echo '<script>alert("Failed to submit review."); window.location.href = "productDetails.php";</script>';
    }

    $stmt->close();
}

// Function to fetch reviews from the database
function fetch_reviews($conn) {
    $reviews_query = $conn->prepare("SELECT r.review_id, r.rating, r.review_text, r.review_date, r.user_id, u.first_name, u.last_name FROM reviews r JOIN site_user u ON r.user_id = u.user_id ORDER BY r.review_date DESC");
    $reviews_query->execute();
    return $reviews_query->get_result();
}

// Function to delete a review
function delete_review($conn, $review_id, $user_id) {
    $delete_query = $conn->prepare("DELETE FROM reviews WHERE review_id = ? AND user_id = ?");
    $delete_query->bind_param("ii", $review_id, $user_id);

    if ($delete_query->execute()) {
        return true;
    } else {
        return false;
    }

    $delete_query->close();
}

// Check if the delete action is initiated
if (isset($_GET['delete_review']) && isset($_SESSION['user_id'])) {
    $review_id = $_GET['delete_review'];
    $user_id = $_SESSION['user_id'];

    if (delete_review($conn, $review_id, $user_id)) {
        echo '<script>alert("Review deleted successfully."); window.location.href = "productDetails.php";</script>';
    } else {
        echo '<script>alert("Failed to delete review."); window.location.href = "productDetails.php";</script>';
    }
}
?>


<section class="container section review_section">
    <div class="review_input">
        <h3>Write a Review</h3>
        <form action="" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <label for="rating">Rating:</label>
            <select id="rating" name="rating" required>
                <option value="1">1 - Poor</option>
                <option value="2">2 - Fair</option>
                <option value="3">3 - Good</option>
                <option value="4">4 - Very Good</option>
                <option value="5">5 - Excellent</option>
            </select><br><br>
            <label for="review_text">Review:</label><br>
            <textarea id="review_text" name="review_text" rows="4" cols="50" required placeholder="Write review about the product."></textarea><br><br>
            <button type="submit" class="btn">Submit Review</button>
        </form>
    </div>
    <div class="other_reviews_section">
        <?php
            echo '<div class="reviews">';
            $reviews_result = fetch_reviews($conn);
            while ($review = $reviews_result->fetch_assoc()) {
                echo '<div class="review">';
                echo '<h4>Review by ' . htmlspecialchars($review['first_name']) . ' ' . htmlspecialchars($review['last_name']) . '</h4>';
                echo '<p>Rating: ' . htmlspecialchars($review['rating']) . '</p>';
                echo '<p>' . htmlspecialchars($review['review_text']) . '</p>';
                echo '<p>Posted on: ' . htmlspecialchars($review['review_date']) . '</p>';
                if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $review['user_id']) {
                    echo '<a href="productDetails.php?delete_review=' . $review['review_id'] . '" onclick="return confirm(\'Are you sure you want to delete this review?\')" class="btn">Delete</a>';
                }
                echo '</div>';
                echo '<hr class="line">';
            }
            echo '</div>';
        ?>
    </div>
</section>
