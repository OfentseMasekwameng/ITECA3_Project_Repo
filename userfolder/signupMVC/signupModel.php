<?php
declare (strict_types=1);

function set_user($conn, $first_name, $last_name, $email, $phone_number, $pwd, $confirmed_password, $user_ip){
    $query = "INSERT INTO site_user (first_name, last_name, email_address, phone_number, pwd, cpassword, user_ip)
     VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    $options = [
        'cost' => 12
    ];
    $hashed_pwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
    $hashed_confirmed_pwd = password_hash($confirmed_password, PASSWORD_BCRYPT, $options);

    $stmt->bind_param("sssssss", $first_name, $last_name, $email, $phone_number, $hashed_pwd, $hashed_confirmed_pwd, $user_ip);
    $stmt->execute();
    $stmt->close();
}


function is_email_registered($conn, $email) {
    $query = "SELECT * FROM site_user WHERE email_address = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->num_rows > 0;
}
?>