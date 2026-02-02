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

$message = '';
$message_type = '';

// Trajto mesazhet nga edit/delete
if (isset($_GET['success'])) {
    $message = 'Operacioni u krye me sukses!';
    $message_type = 'success';
}
if (isset($_GET['error'])) {
    $message = htmlspecialchars($_GET['error']);
    $message_type = 'error';
}

// Merr të gjithë përdoruesit
$query = "SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
$users = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}

// Numëro përdoruesit
$total_users = count($users);
$total_admins = 0;
$total_regular = 0;
foreach ($users as $user) {
    if ($user['role'] === 'admin') {
        $total_admins++;
    } else {
        $total_regular++;
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - KosovoZoo</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <?php 
    $pageTitle = 'Dashboard - KosovoZoo';
    $currentUser = getCurrentUser();
    include __DIR__ . '/../includes/header.php'; 
    ?>

    <section class="kryefaqe">
        <div class="permbajtje">
            <h1>Dashboard Administratori</h1>
            <p>Mirë se vini, <?php echo htmlspecialchars($currentUser['username']); ?>!</p>
            <div style="margin-top: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="animals.php" class="buton butonkryesor" style="text-decoration: none; display: inline-block;">
                    🦁 Menaxho Kafshët
                </a>
            </div>
        </div>
    </section>

    <section class="seksionkafshet">
        <div class="permbajtje">
            <!-- Statistika -->
            <div class="gridstatistika" style="margin-bottom: 3rem;">
                <div class="kartastatistike">
                    <div class="numerstatistike"><?php echo $total_users; ?></div>
                    <div class="etiketestatistike">Total Përdorues</div>
                </div>
                <div class="kartastatistike">
                    <div class="numerstatistike"><?php echo $total_admins; ?></div>
                    <div class="etiketestatistike">Administratorë</div>
                </div>
                <div class="kartastatistike">
                    <div class="numerstatistike"><?php echo $total_regular; ?></div>
                    <div class="etiketestatistike">Përdorues të Thjeshtë</div>
                </div>
            </div>

            <!-- Lista e përdoruesve -->
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <h2 style="color: var(--green-dark); margin-bottom: 2rem;">Të Gjithë Përdoruesit</h2>
                
                <?php if ($message): ?>
                    <div style="background: <?php echo $message_type === 'success' ? '#e8f5e9' : '#ffebee'; ?>; color: <?php echo $message_type === 'success' ? '#2e7d32' : '#c62828'; ?>; padding: 1rem; border-radius: 5px; margin-bottom: 1.5rem;">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (empty($users)): ?>
                    <p style="text-align: center; color: var(--text-medium); padding: 2rem;">
                        Nuk ka përdorues të regjistruar.
                    </p>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: var(--green-lightest);">
                                    <th style="padding: 1rem; text-align: left; border-bottom: 2px solid var(--green-light);">ID</th>
                                    <th style="padding: 1rem; text-align: left; border-bottom: 2px solid var(--green-light);">Përdoruesi</th>
                                    <th style="padding: 1rem; text-align: left; border-bottom: 2px solid var(--green-light);">Email</th>
                                    <th style="padding: 1rem; text-align: left; border-bottom: 2px solid var(--green-light);">Roli</th>
                                    <th style="padding: 1rem; text-align: left; border-bottom: 2px solid var(--green-light);">Data e Regjistrimit</th>
                                    <th style="padding: 1rem; text-align: left; border-bottom: 2px solid var(--green-light);">Veprime</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <td style="padding: 1rem;"><?php echo $user['id']; ?></td>
                                    <td style="padding: 1rem;">
                                        <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                                        <?php if ($user['id'] == $_SESSION['user_id']): ?>
                                            <span style="color: var(--green-medium); font-size: 0.85rem; margin-left: 0.5rem;">(Ju)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1rem;"><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td style="padding: 1rem;">
                                        <span style="background: <?php echo $user['role'] === 'admin' ? 'var(--orange)' : 'var(--green-medium)'; ?>; color: white; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem;">
                                            <?php echo $user['role'] === 'admin' ? 'Administrator' : 'Përdorues'; ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <?php echo date('d.m.Y H:i', strtotime($user['created_at'])); ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 0.5rem;">
                                            <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="buton" style="padding: 0.5rem 1rem; font-size: 0.9rem; background: var(--green-medium); color: white; text-decoration: none; border-radius: 5px;">✏️ Ndrysho</a>
                                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="buton" style="padding: 0.5rem 1rem; font-size: 0.9rem; background: #c62828; color: white; text-decoration: none; border-radius: 5px;" onclick="return confirm('A jeni të sigurt që dëshironi të fshini këtë përdorues?');">🗑️ Fshi</a>
                                            <?php else: ?>
                                                <span style="padding: 0.5rem 1rem; font-size: 0.9rem; background: #ccc; color: #666; border-radius: 5px; cursor: not-allowed;">🗑️ Fshi</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>

