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

// Merr ID-në e përdoruesit
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($user_id <= 0) {
    header('Location: dashboard.php?error=ID e përdoruesit nuk është e vlefshme');
    exit();
}

// Kontrollo nëse admini po përpiqet të fshijë vetveten
if ($user_id == $_SESSION['user_id']) {
    header('Location: dashboard.php?error=Nuk mund ta fshini vetveten!');
    exit();
}

// Merr të dhënat e përdoruesit për konfirmim
$query = "SELECT id, username, email FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    header('Location: dashboard.php?error=Përdoruesi nuk u gjet');
    exit();
}

$user = mysqli_fetch_assoc($result);

// Fshi përdoruesin
$delete = "DELETE FROM users WHERE id = $user_id";

if (mysqli_query($conn, $delete)) {
    header('Location: dashboard.php?success=Përdoruesi u fshi me sukses!');
    exit();
} else {
    header('Location: dashboard.php?error=Gabim në fshirje: ' . urlencode(mysqli_error($conn)));
    exit();
}
?>
