<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Headers për të parandaluar cache-in gjatë zhvillimit
if (!headers_sent()) {
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
}

// Konfigurimi i databazës
// Përdor emrin real të databazës tënde: 'zoo'
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'zoo';

// Lidhja me databazën
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Kontrollo lidhjen
if (!$conn) {
    die("Lidhja dështoi: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, "utf8mb4");

// Fillo session
session_start();

// Funksion për të kontrolluar nëse përdoruesi është i loguar
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Funksion për të kontrolluar nëse është admin
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Funksion për të kërkuar përdoruesin aktual
function getCurrentUser() {
    global $conn;
    if (!isLoggedIn()) {
        return null;
    }
    $user_id = (int)$_SESSION['user_id'];
    $query = "SELECT id, username, email, role FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// Funksion për të pastruar input
function cleanInput($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}

