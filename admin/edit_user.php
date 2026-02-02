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

$error = '';
$success = '';
$user = null;

// Merr ID-në e përdoruesit
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($user_id <= 0) {
    header('Location: dashboard.php?error=ID e përdoruesit nuk është e vlefshme');
    exit();
}

// Merr të dhënat e përdoruesit
$query = "SELECT id, username, email, role FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    header('Location: dashboard.php?error=Përdoruesi nuk u gjet');
    exit();
}

$user = mysqli_fetch_assoc($result);

// Trajto formën
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'user';
    $new_password = $_POST['new_password'] ?? '';
    
    // Validim
    if (empty($username) || empty($email)) {
        $error = 'Plotësoni të gjitha fushat e detyrueshme!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email-i nuk është i vlefshëm!';
    } elseif (!in_array($role, ['admin', 'user'])) {
        $error = 'Roli nuk është i vlefshëm!';
    } else {
        // Pastro input
        $username = cleanInput($username);
        $email = cleanInput($email);
        
        // Kontrollo nëse username ose email ekzistojnë për përdorues të tjerë
        $check = "SELECT id FROM users WHERE (username = '$username' OR email = '$email') AND id != $user_id";
        $check_result = mysqli_query($conn, $check);
        
        if ($check_result === false) {
            $error = 'Gabim në kontrollim: ' . mysqli_error($conn);
        } elseif (mysqli_num_rows($check_result) > 0) {
            $error = 'Përdoruesi ose emaili ekziston tashmë për një përdorues tjetër!';
        } else {
            // Përditëso përdoruesin
            if (!empty($new_password)) {
                if (strlen($new_password) < 6) {
                    $error = 'Fjalëkalimi duhet të jetë së paku 6 karaktere!';
                } else {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update = "UPDATE users SET username = '$username', email = '$email', role = '$role', password = '$hashed_password' WHERE id = $user_id";
                }
            } else {
                $update = "UPDATE users SET username = '$username', email = '$email', role = '$role' WHERE id = $user_id";
            }
            
            if (!isset($error) || empty($error)) {
                if (mysqli_query($conn, $update)) {
                    header('Location: dashboard.php?success=Përdoruesi u përditësua me sukses!');
                    exit();
                } else {
                    $error = 'Gabim në përditësim: ' . mysqli_error($conn);
                }
            }
        }
    }
    
    // Merr të dhënat e përditësuara për formën
    $user['username'] = $username;
    $user['email'] = $email;
    $user['role'] = $role;
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ndrysho Përdoruesin - KosovoZoo</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <?php 
    $pageTitle = 'Ndrysho Përdoruesin - KosovoZoo';
    $currentUser = getCurrentUser();
    include __DIR__ . '/../includes/header.php'; 
    ?>

    <section class="hero" style="min-height: 60vh; display: flex; align-items: center; position: relative; z-index: 1;">
        <div class="permbajtje" style="max-width: 600px; margin: 0 auto; position: relative; z-index: 10;">
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); position: relative; z-index: 10;">
                <h2 style="text-align: center; color: var(--green-dark); margin-bottom: 1.5rem;">Ndrysho Përdoruesin</h2>
                
                <?php if ($error): ?>
                    <div style="background: #ffebee; color: #c62828; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" style="position: relative; z-index: 10;">
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                            Përdoruesi:
                        </label>
                        <input type="text" name="username" required autocomplete="username"
                               value="<?php echo htmlspecialchars($user['username']); ?>"
                               style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; position: relative; z-index: 10; background: white;"
                               placeholder="Shkruani emrin e përdoruesit">
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                            Email:
                        </label>
                        <input type="email" name="email" required autocomplete="email"
                               value="<?php echo htmlspecialchars($user['email']); ?>"
                               style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; position: relative; z-index: 10; background: white;"
                               placeholder="Shkruani email-in">
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                            Roli:
                        </label>
                        <select name="role" required
                                style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; position: relative; z-index: 10; background: white;">
                            <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Përdorues</option>
                            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrator</option>
                        </select>
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                            Fjalëkalimi i Ri (lëreni bosh për të mos e ndryshuar):
                        </label>
                        <input type="password" name="new_password" autocomplete="new-password"
                               style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; position: relative; z-index: 10; background: white;"
                               placeholder="Shkruani fjalëkalimin e ri (opsionale)">
                        <small style="color: var(--text-medium); font-size: 0.85rem;">Lëreni bosh nëse nuk dëshironi të ndryshoni fjalëkalimin</small>
                    </div>
                    
                    <div style="display: flex; gap: 1rem;">
                        <button type="submit" class="buton butonkryesor" style="flex: 1; padding: 0.75rem; position: relative; z-index: 10;">
                            Përditëso
                        </button>
                        <a href="dashboard.php" class="buton" style="flex: 1; padding: 0.75rem; text-align: center; text-decoration: none; background: var(--text-medium); color: white; border-radius: 5px; position: relative; z-index: 10;">
                            Anulo
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
