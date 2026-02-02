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

// Trajto mesazhet
if (isset($_GET['success'])) {
    $message = 'Operacioni u krye me sukses!';
    $message_type = 'success';
}
if (isset($_GET['error'])) {
    $message = htmlspecialchars($_GET['error']);
    $message_type = 'error';
}

// Merr të gjitha kafshët
$query = "SELECT * FROM animals ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
$animals = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $animals[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menaxho Kafshët - KosovoZoo</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <?php 
    $pageTitle = 'Menaxho Kafshët - KosovoZoo';
    $currentUser = getCurrentUser();
    include __DIR__ . '/../includes/header.php'; 
    ?>

    <section class="kryefaqe">
        <div class="permbajtje">
            <h1>Menaxho Kafshët</h1>
            <p>Krijoni, ndryshoni ose fshini kafshët nga kopshti zoologjik</p>
        </div>
    </section>

    <section class="seksionkafshet">
        <div class="permbajtje">
            <?php if ($message): ?>
                <div style="background: <?php echo $message_type === 'success' ? '#e8f5e9' : '#ffebee'; ?>; color: <?php echo $message_type === 'success' ? '#2e7d32' : '#c62828'; ?>; padding: 1rem; border-radius: 5px; margin-bottom: 2rem;">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <div style="margin-bottom: 2rem;">
                <a href="add_animal.php" class="buton butonkryesor" style="display: inline-block; text-decoration: none;">
                    + Shto Kafshë të Re
                </a>
            </div>

            <?php if (empty($animals)): ?>
                <p style="text-align: center; color: var(--text-medium); padding: 2rem;">
                    Nuk ka kafshë të regjistruara. Shtoni kafshën e parë!
                </p>
            <?php else: ?>
                <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <h2 style="color: var(--green-dark); margin-bottom: 2rem;">Të Gjitha Kafshët (<?php echo count($animals); ?>)</h2>
                    
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: var(--green-lightest);">
                                    <th style="padding: 1rem; text-align: left; border-bottom: 2px solid var(--green-light);">Foto</th>
                                    <th style="padding: 1rem; text-align: left; border-bottom: 2px solid var(--green-light);">Emri</th>
                                    <th style="padding: 1rem; text-align: left; border-bottom: 2px solid var(--green-light);">Emri Shkencor</th>
                                    <th style="padding: 1rem; text-align: left; border-bottom: 2px solid var(--green-light);">Kategoria</th>
                                    <th style="padding: 1rem; text-align: left; border-bottom: 2px solid var(--green-light);">Featured</th>
                                    <th style="padding: 1rem; text-align: left; border-bottom: 2px solid var(--green-light);">Veprime</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($animals as $animal): ?>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <td style="padding: 1rem;">
                                        <?php if ($animal['image_url']): ?>
                                            <img src="<?php echo htmlspecialchars($animal['image_url']); ?>" alt="<?php echo htmlspecialchars($animal['name']); ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                                        <?php else: ?>
                                            <div style="width: 80px; height: 80px; background: #ddd; border-radius: 5px; display: flex; align-items: center; justify-content: center;">🦁</div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <strong><?php echo htmlspecialchars($animal['name']); ?></strong>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <em><?php echo htmlspecialchars($animal['scientific_name']); ?></em>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <span style="background: var(--green-medium); color: white; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem;">
                                            <?php echo htmlspecialchars($animal['category']); ?>
                                        </span>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <?php if ($animal['featured']): ?>
                                            <span style="color: var(--orange); font-weight: bold;">⭐ Featured</span>
                                        <?php else: ?>
                                            <span style="color: var(--text-medium);">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 0.5rem;">
                                            <a href="edit_animal.php?id=<?php echo $animal['id']; ?>" class="buton" style="padding: 0.5rem 1rem; font-size: 0.9rem; background: var(--green-medium); color: white; text-decoration: none; border-radius: 5px;">✏️ Ndrysho</a>
                                            <a href="delete_animal.php?id=<?php echo $animal['id']; ?>" class="buton" style="padding: 0.5rem 1rem; font-size: 0.9rem; background: #c62828; color: white; text-decoration: none; border-radius: 5px;" onclick="return confirm('A jeni të sigurt që dëshironi të fshini këtë kafshë?');">🗑️ Fshi</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
