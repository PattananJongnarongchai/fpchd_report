<?php
session_start();

include "../connection/connection.php";

// Ensure that the 'id' parameter is set in the GET request
if (isset($_GET['id'])) {
    $id = $_GET["id"];
    echo $id;
    // exit();

    // Include the database connection file

    // Use prepared statement to avoid SQL injection
    $sql = "DELETE FROM doc_types WHERE id_dt='$id'";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id, PDO::PARAM_INT); // Use PDO::PARAM_INT for integer type
    $stmt->execute();
    $_SESSION["dc_dl"] = "01";

    header('Location: ../setting');
}
