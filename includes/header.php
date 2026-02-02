<?php
if (!isset($pageTitle)) {
    $pageTitle = 'KosovoZoo';
}

// Përcakto path-in bazë bazuar në ku ndodhet faqja aktuale
$current_dir = dirname($_SERVER['PHP_SELF']);
$base_path = ($current_dir == '/admin' || strpos($current_dir, '/admin') !== false) ? '../' : '';
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="<?php echo $base_path; ?>styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <header class="krye">
        <div class="permbajtje">
            <div class="logo">
                <h1><a href="<?php echo $base_path; ?>index.php" style="color:inherit;text-decoration:none;">🦁 KosovoZoo</a></h1>
            </div>
            <nav class="navigim">
                <ul>
                    <li><a href="<?php echo $base_path; ?>index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Faqja Kryesore</a></li>
                    <li><a href="<?php echo $base_path; ?>about.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">Rreth Nesh</a></li>
                    <li><a href="<?php echo $base_path; ?>animals.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'animals.php' ? 'active' : ''; ?>">Kafshët</a></li>
                    <li><a href="<?php echo $base_path; ?>contact.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">Kontakt</a></li>
                    <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
                        <?php 
                        $currentUser = function_exists('getCurrentUser') ? getCurrentUser() : null;
                        if ($currentUser && function_exists('isAdmin') && isAdmin()): 
                        ?>
                            <li><a href="<?php echo $base_path; ?>admin/dashboard.php">Dashboard</a></li>
                        <?php endif; ?>
                        <?php if ($currentUser): ?>
                            <li><a href="<?php echo $base_path; ?>logout.php">Dil (<?php echo htmlspecialchars($currentUser['username']); ?>)</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo $base_path; ?>logout.php">Dil</a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li><a href="<?php echo $base_path; ?>login.php">Hyr</a></li>
                        <li><a href="<?php echo $base_path; ?>signup.php">Regjistrohu</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            <div class="menumobile">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>

