<?php
session_start();
include('../admin/config/dbcon.php');

if (isset($_POST['registerbtn'])) {
    $username = $_POST['name'];
    $password = $_POST['password'];
    $cpassword = $_POST['repassword'];

    if ($password === $cpassword) {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Use prepared statement for security
        $stmt = $con->prepare("INSERT INTO admin (name, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            $_SESSION['adminre'] = "Admin Profile Added";
        } else {
            $_SESSION['adminre'] = "Admin Profile Not Added";
        }
        $stmt->close();
    } else {
        $_SESSION['adminre'] = "Password didn't match";
    }
    
    header('location: ../admin/createaccount.php');
    exit();
}


if (isset($_POST['updatebtn'])) {
    $id = $_POST['edit_id'];
    $username = $_POST['edit_name'];
    $password = $_POST['edit_password'];

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statement for security
    $stmt = $con->prepare("UPDATE admin SET name=?, password=? WHERE id=?");
    $stmt->bind_param("ssi", $username, $hashed_password, $id);

    if ($stmt->execute()) {
        $_SESSION['a_success'] = "Your Data is Updated";
        header('location: ../admin/account.php');
    } else {
        $_SESSION['a_success'] = "Your Data is not Updated";
        header('location: ../admin/account.php');
    }
    $stmt->close();
}


if (isset($_POST['delete_btn'])) {
    $id = $_POST['delete_id'];

    $query = "DELETE FROM admin WHERE id='$id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['success'] = "Your data is deleted";
        header('location: ../admin/account.php');
    } else {
        $_SESSION['success'] = "Your data is not deleted";
        header('location: ../admin/account.php');
    }
}

if (isset($_POST['add_plants_btn'])) {
    $pid = $_POST['plantid'];
    $name = $_POST['name'];
    $season = $_POST['season'];
    
    $price = $_POST['price'];
    $instock = $_POST['instock'];
    
    $description = $_POST['description'];

    $image = $_FILES['image']['name'];
    $path = "../uploads";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    $plant_query = "INSERT INTO plants (p_id,p_name,p_image,price,instock,season,description)
    VALUES ('$pid','$name','$image','$price','$instock','$season','$description')";

    $plant_query_run = mysqli_query($con, $plant_query);
    if ($plant_query_run) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $image);
        $_SESSION['addsuccess'] = "Your data is added successfully";
        header('location: ../admin/addplants.php');
    } else {
        $_SESSION['addsuccess'] = "Your data is not added";
        header('location: ../admin/addplants.php');
    }
}

if (isset($_POST['update_plantbtn'])) {
    $id = $_POST['pedit_id'];
    $pid = $_POST['plantid'];
    $name = $_POST['name'];
    $season = $_POST['season'];
    $price = $_POST['price'];
    $instock = $_POST['instock'];
    $description = $_POST['description'];

    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if ($new_image != "") {
        $update_filename = $new_image;
    } else {
        $update_filename = $old_image;
    }

    $path = "../uploads";

    $update_query = "UPDATE plants SET p_id='$pid', p_name='$name',price = '$price',instock='$instock', season='$season', 
    description='$description',
    p_image = '$update_filename' WHERE p_id='$id'";


    $update_query_run = mysqli_query($con, $update_query);

    if ($update_query_run) {
        if ($_FILES['image']['name'] != "") {
            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $new_image);
            if (file_exists("../uploads/" . $old_image)) {
                unlink("../uploads/" . $old_image);
            }
        }
        $_SESSION['success'] = "Your data is updated successfully";
        header('location: ../admin/index.php');
    } else {
        $_SESSION['success'] = "Your data is not updated";
        header('location: ../admin/index.php');
    }
}

if (isset($_POST['delete_plant_btn'])) {
    $delete_plant_id = $_POST['delete_plant_id'];

    $plant_query = "SELECT * FROM plants WHERE p_id='$delete_plant_id'";
    $plant_query_run = mysqli_query($con, $plant_query);
    $plant_data = mysqli_fetch_array($plant_query_run);
    $image = $plant_data['p_image'];

    $delete_query = "DELETE FROM plants WHERE p_id = '$delete_plant_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        if (file_exists("../uploads/" . $image)) {
            unlink("../uploads/" . $image);
        }
        $_SESSION['success'] = "Your data is deleted successfully";
        header('location: ../admin/index.php');
    } else {
        $_SESSION['success'] = "Your data is not deleted";
        header('location: ../admin/index.php');
    }
}
if (isset($_POST['delete_u_btn'])) {
    $delete_u_id = $_POST['delete_u_id'];

    $user_query = "SELECT * FROM user WHERE u_id='$delete_u_id'";
    $user_query_run = mysqli_query($con, $user_query);
    $user_data = mysqli_fetch_array($user_query_run);
    

    $delete_query = "DELETE FROM user WHERE u_id = '$delete_u_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        $_SESSION['u_success'] = "Your data is deleted successfully";
        header('location: ../admin/useraccount.php');
    } else {
        $_SESSION['u_success'] = "Your data is not deleted";
        header('location: ../admin/account.php');
    }
}

if (isset($_POST['delete_order_btn'])) {
    $order_id = $_POST['delete_order_id'];

    $delete_query = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $con->prepare($delete_query);
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        $_SESSION['ord_success'] = "Order deleted successfully";
    } else {
        $_SESSION['ord_success'] = "Order not deleted";
    }
    $stmt->close();

    header('location: ../admin/order.php');
    exit();
}
