<?php
declare (strict_types=1);

// function get_user($conn, $email){
//     $query = "SELECT * FROM site_user  WHERE email_address = ?";
//     $stmt = $conn->prepare($query);
//     $stmt->bind_param("s",  $email);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     return $result;
// }

function get_user($conn, $email){
    // Prepare the query
    $query = "SELECT * FROM site_user WHERE email_address = ?";
    $stmt = $conn->prepare($query);
    
    // Check if the preparation was successful
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    
    // Bind the parameter
    $stmt->bind_param("s", $email);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Check if the result is valid
    if ($result === false) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }
    
    // Fetch the user data as an associative array
    $user = $result->fetch_assoc();
    
    // Free result set
    $result->free();
    
    // Close the statement
    $stmt->close();
    
    // Return the user data
    return $user;
}
