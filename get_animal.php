<?php
require_once 'config.php';

header('Content-Type: application/json');

$animal_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($animal_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID e pavlefshme']);
    exit();
}

$query = "SELECT * FROM animals WHERE id = $animal_id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $animal = mysqli_fetch_assoc($result);
    echo json_encode(['success' => true, 'animal' => $animal]);
} else {
    echo json_encode(['success' => false, 'message' => 'Kafsha nuk u gjet']);
}
?>
