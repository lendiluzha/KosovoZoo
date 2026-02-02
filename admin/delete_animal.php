<?php
require_once __DIR__ . '/../config.php';

// Kontrollo nëse është i loguar dhe është admin
if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit();
}

if (!isAdmin()) {
    header('Location: ../index.php');
    exit();
}

// Merr ID-në e kafshës
$animal_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($animal_id <= 0) {
    header('Location: animals.php?error=ID e kafshës nuk është e vlefshme');
    exit();
}

// Fshi kafshën
$delete = "DELETE FROM animals WHERE id = $animal_id";

if (mysqli_query($conn, $delete)) {
    header('Location: animals.php?success=Kafsha u fshi me sukses!');
    exit();
} else {
    header('Location: animals.php?error=Gabim në fshirje: ' . urlencode(mysqli_error($conn)));
    exit();
}
?>
