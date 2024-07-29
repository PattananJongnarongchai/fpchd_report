<?php
include '../connection/connection.php';

try {
    // Query to count the number of new complaints
    $query = "SELECT COUNT(*) AS total_rows FROM qd_documents WHERE dc_results = '' ";
    $result = $conn->query($query);
    $k = $result->fetch(PDO::FETCH_ASSOC);
    $totalRows = $k['total_rows'];
    echo "$totalRows";
} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
}
