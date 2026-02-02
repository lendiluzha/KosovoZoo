<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validim
    if (empty($username) || empty($email) || empty($password)) {
        $error = 'Plotësoni të gjitha fushat!';
    } elseif ($password !== $confirm_password) {
        $error = 'Fjalëkalimet nuk përputhen!';
    } elseif (strlen($password) < 6) {
        $error = 'Fjalëkalimi duhet të jetë së paku 6 karaktere!';
    } else {
        // Pastro input
        $username = cleanInput($username);
        $email = cleanInput($email);
        
        // Kontrollo nëse përdoruesi ekziston
        $check = "SELECT id FROM users WHERE username = '$username' OR email = '$email'";
        $result = mysqli_query($conn, $check);
        
        if ($result === false) {
            $error = 'Gabim në kontrollim: ' . mysqli_error($conn);
        } elseif (mysqli_num_rows($result) > 0) {
            $error = 'Përdoruesi ose emaili ekziston tashmë!';
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Shto përdoruesin
            $insert = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', 'user')";
            
            if (mysqli_query($conn, $insert)) {
                $success = 'Regjistrimi u krye me sukses! Tani mund të hyni.';
                // Pastro formën
                $_POST = [];
            } else {
                $error = 'Gabim në regjistrim: ' . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regjistrohu - KosovoZoo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="hero" style="min-height: 60vh; display: flex; align-items: center; position: relative; z-index: 1;">
        <div class="permbajtje" style="max-width: 500px; margin: 0 auto; position: relative; z-index: 10;">
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); position: relative; z-index: 10;">
                <h2 style="text-align: center; color: var(--green-dark); margin-bottom: 1.5rem;">Krijo Llogari të Re</h2>
                
                <?php if ($error): ?>
                    <div style="background: #ffebee; color: #c62828; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div style="background: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" style="position: relative; z-index: 10;">
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                            Përdoruesi:
                        </label>
                        <input type="text" name="username" required autocomplete="username"
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                               style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; position: relative; z-index: 10; background: white;"
                               placeholder="Shkruani emrin e përdoruesit">
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                            Email:
                        </label>
                        <input type="email" name="email" required autocomplete="email"
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                               style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; position: relative; z-index: 10; background: white;"
                               placeholder="Shkruani email-in">
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                            Fjalëkalimi:
                        </label>
                        <input type="password" name="password" required minlength="6" autocomplete="new-password"
                               style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; position: relative; z-index: 10; background: white;"
                               placeholder="Minimum 6 karaktere">
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                            Konfirmo Fjalëkalimin:
                        </label>
                        <input type="password" name="confirm_password" required minlength="6" autocomplete="new-password"
                               style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; position: relative; z-index: 10; background: white;"
                               placeholder="Rishkruani fjalëkalimin">
                    </div>
                    
                    <button type="submit" class="buton butonkryesor" style="width: 100%; padding: 0.75rem; position: relative; z-index: 10;">
                        Regjistrohu
                    </button>
                </form>
                
                <p style="text-align: center; margin-top: 1.5rem; color: var(--text-medium);">
                    Tashmë keni llogari? <a href="login.php" style="color: var(--green-medium); font-weight: 600;">Hyni këtu</a>
                </p>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>

