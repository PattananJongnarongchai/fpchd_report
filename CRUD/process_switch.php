<?php
session_start();
if (isset($_POST['id_user'], $_POST['us_status'])) {
    
    include ('../connection/connection.php');
    // Update the database
    
    
    $id_user = $_POST['id_user'];
    $us_status = $_POST['us_status'];
    $sql_up = $conn->prepare("UPDATE users SET us_status = '$us_status' WHERE id_user = '$id_user' ");
    $sql_up->execute();

    // Close the database connection
    $conn = null;

    echo 'Success: Database updated successfully!';
} else {
    echo 'Error: Missing parameters!';
}
