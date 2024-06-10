<?php
    include_once("includes/connection.php");
    require_once "./userfolder/signupMVC/signupContr.php";
    require_once "./userfolder/signupMVC/signupModel.php";
    require_once "userfolder/loginMVC/loginView.php";

    function display_alert() {
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            $message_type = $_SESSION['message_type'];
            echo "<script>alert('$message');</script>";
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
    }
?>

<h3 class="text-center mb-4">Edit Account</h3>
<form action="<?php update_user();?>" method="post">

    <?php display_alert(); ?>   
    <div class="update_section">
        <input type="text" name="first_name" placeholder="Enter First Name" class="update_form">
        <input type="text" name="last_name" placeholder="Enter Last Name" class="update_form">
        <input type="text" name="phone_number" placeholder="Phone Number" class="update_form">
        <input type="text" name="passwrd" placeholder="Enter Password" class="update_form">
        <input type="text" name="con_password" placeholder="Confirm Password" class="update_form">
        <button class="btn text-center" name="update_btn">Update</button>
    </div>
</form>

<?php
// function update_user(){
//     global $conn;
//     if (isset($_GET["edit_account"])){
//         $user_id = $_SESSION['user_id'];
//         $select_query = $conn->prepare("SELECT * FROM site_user WHERE user_id = ?");
//         $select_query->bind_param("i", $user_id);
//         $select_query->execute();
//         $result_query = $select_query->get_result();
//         $row = $result_query->fetch_assoc();
//         $first_name = $row["first_name"];
//         $last_name = $row["last_name"];
//         $phone_number = $row["phone_number"];
//         $pwd = $row["pwd"];
//         $cpwd = $row["cpassword"];

//         if (isset($_POST["update_btn"])){
//             $update_id =$user_id;
//             $first_name = $_POST["first_name"];
//             $last_name = $_POST["last_name"];
//             $phone_number = $_POST["phone_number"];
//             $pwd = $_POST["passwrd"];
//             $cpwd = $_POST["con_password"];

//             //UPDATE QUERY
//             $update_data = $conn->prepare("UPDATE site_user SET user_id = ?, first_name = ?, last_name =  ?, phone_number = ?,
//                                      pwd = ?, cpassword = ?");
//             $update_data->bind_param("isssss", $update_id, $first_name, $last_name, $phone_number, $pwd, $cpwd);
//             $update_data->execute();
//             $result_update_query = $update_data->get_result();
//             if ($result_update_query){
//                 echo '<script>alert("Data updated succesfully")</script>';
//             }
//         }
//     }
// }

function update_user() {
    global $conn;

    if (isset($_GET["edit_account"])) {
        $user_id = $_SESSION['user_id'];

        // Fetch current user data
        $select_query = $conn->prepare("SELECT * FROM site_user WHERE user_id = ?");
        $select_query->bind_param("i", $user_id);
        $select_query->execute();
        $result_query = $select_query->get_result();
        $row = $result_query->fetch_assoc();

        $current_first_name = $row["first_name"];
        $current_last_name = $row["last_name"];
        $current_phone_number = $row["phone_number"];
        $current_pwd = $row["pwd"];
        $current_cpwd = $row["cpassword"];

        if (isset($_POST["update_btn"])) {
            $first_name = $_POST["first_name"] ?: $current_first_name;
            $last_name = $_POST["last_name"] ?: $current_last_name;
            $phone_number = $_POST["phone_number"] ?: $current_phone_number;
            $pwd = $_POST["passwrd"];
            $cpwd = $_POST["con_password"];

            if ($pwd && $pwd !== $cpwd) {
                $_SESSION['message'] = "Passwords do not match.";
                $_SESSION['message_type'] = "error";
                echo '<script>window.location.href = "profile.php?edit_account"</script>';
                // exit();
            }

            if (!is_phone_valid($phone_number)) {
                $_SESSION['message'] = "Invalid phone number format!";
            }

            $hashed_pwd = $pwd ? password_hash($pwd, PASSWORD_DEFAULT) : $current_pwd;

            // Check if the first and last name combination already exists for another user
            $name_check_query = $conn->prepare("SELECT * FROM site_user WHERE first_name = ? AND last_name = ? AND user_id != ?");
            $name_check_query->bind_param("ssi", $first_name, $last_name, $user_id);
            $name_check_query->execute();
            $name_check_result = $name_check_query->get_result();

            if ($name_check_result->num_rows > 0) {
                $_SESSION['message'] = "The name combination is already in use. Please choose different names.";
                $_SESSION['message_type'] = "error";
                echo '<script>window.location.href = "profile.php?edit_account"</script>';
                // exit();
            }

            // UPDATE QUERY
            $update_data = $conn->prepare("UPDATE site_user SET first_name = ?, last_name = ?, phone_number = ?, pwd = ? WHERE user_id = ?");
            $update_data->bind_param("ssssi", $first_name, $last_name, $phone_number, $hashed_pwd, $user_id);

            if ($update_data->execute()) {
                $_SESSION['message'] = "Data updated successfully.";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to update data.";
                $_SESSION['message_type'] = "error";
            }
            echo '<script>window.location.href = "profile.php?"</script>';
        }
    }
}
?>