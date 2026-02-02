<?php
require_once 'config.php';

$error = '';

// Nëse është i loguar, ridrejto
if (isLoggedIn()) {
    if (isAdmin()) {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: index.php');
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Plotësoni të gjitha fushat!';
    } else {
        // Pastro input
        $username = cleanInput($username);
        
        // Kërko përdoruesin
        $query = "SELECT * FROM users WHERE username = '$username' OR email = '$username'";
        $result = mysqli_query($conn, $query);
        
        if ($result === false) {
            $error = 'Gabim në kërkim: ' . mysqli_error($conn);
        } elseif (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Kontrollo password
            if (password_verify($password, $user['password'])) {
                // Vendos session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                // Ridrejto sipas rolit
                if ($user['role'] === 'admin') {
                    header('Location: admin/dashboard.php');
                } else {
                    header('Location: index.php');
                }
                exit();
            } else {
                $error = 'Fjalëkalimi është i gabuar!';
            }
        } else {
            $error = 'Përdoruesi nuk ekziston!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hyrje - KosovoZoo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="hero" style="min-height: 60vh; display: flex; align-items: center; position: relative; z-index: 1;">
        <div class="permbajtje" style="max-width: 500px; margin: 0 auto; position: relative; z-index: 10;">
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); position: relative; z-index: 10;">
                <h2 style="text-align: center; color: var(--green-dark); margin-bottom: 1.5rem;">Hyr në Llogari</h2>
                
                <?php if ($error): ?>
                    <div style="background: #ffebee; color: #c62828; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" style="position: relative; z-index: 10;">
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                            Përdoruesi ose Email:
                        </label>
                        <input type="text" name="username" required autocomplete="username"
                               style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; position: relative; z-index: 10; background: white;"
                               placeholder="Shkruani përdoruesin ose email">
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                            Fjalëkalimi:
                        </label>
                        <input type="password" name="password" required autocomplete="current-password"
                               style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; position: relative; z-index: 10; background: white;"
                               placeholder="Shkruani fjalëkalimin">
                    </div>
                    
                    <button type="submit" class="buton butonkryesor" style="width: 100%; padding: 0.75rem; position: relative; z-index: 10;">
                        Hyr
                    </button>
                </form>
                
                <p style="text-align: center; margin-top: 1.5rem; color: var(--text-medium);">
                    Nuk keni llogari? <a href="signup.php" style="color: var(--green-medium); font-weight: 600;">Regjistrohu këtu</a>
                </p>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>

