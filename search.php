<?php
include('admin/config/dbcon.php'); // Ensure you have a database connection

$q = isset($_GET['q']) ? $_GET['q'] : '';

if (!empty($q)) {
    $sql = "SELECT p_id, p_name, p_image FROM plants WHERE p_name LIKE '%$q%' LIMIT 5";
    $result = mysqli_query($con, $sql);

    $searchResults = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $searchResults[] = [
            "p_id" => $row["p_id"],  // Ensure p_id is sent
            "name" => $row["p_name"],
            "image" => $row["p_image"]
        ];
    }

    echo json_encode($searchResults);
}
?>
