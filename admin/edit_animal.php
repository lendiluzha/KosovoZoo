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
$animal = null;

// Merr ID-në e kafshës
$animal_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($animal_id <= 0) {
    header('Location: animals.php?error=ID e kafshës nuk është e vlefshme');
    exit();
}

// Merr të dhënat e kafshës
$query = "SELECT * FROM animals WHERE id = $animal_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    header('Location: animals.php?error=Kafsha nuk u gjet');
    exit();
}

$animal = mysqli_fetch_assoc($result);

// Trajto formën
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    $scientific_name = trim($_POST['scientific_name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');
    $wikipedia_link = trim($_POST['wikipedia_link'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $habitat = trim($_POST['habitat'] ?? '');
    $conservation_status = trim($_POST['conservation_status'] ?? '');
    $facts = trim($_POST['facts'] ?? '');
    $featured = isset($_POST['featured']) ? 1 : 0;
    
    // Validim
    if (empty($name) || empty($category)) {
        $error = 'Emri dhe kategoria janë të detyrueshme!';
    } else {
        // Pastro input
        $name = cleanInput($name);
        $scientific_name = cleanInput($scientific_name);
        $category = cleanInput($category);
        $image_url = cleanInput($image_url);
        $wikipedia_link = cleanInput($wikipedia_link);
        $description = cleanInput($description);
        $habitat = cleanInput($habitat);
        $conservation_status = cleanInput($conservation_status);
        $facts = cleanInput($facts);
        
        // Përditëso kafshën
        $update = "UPDATE animals SET name = '$name', scientific_name = '$scientific_name', category = '$category', 
                   image_url = '$image_url', wikipedia_link = '$wikipedia_link', description = '$description', 
                   habitat = '$habitat', conservation_status = '$conservation_status', facts = '$facts', featured = $featured 
                   WHERE id = $animal_id";
        
        if (mysqli_query($conn, $update)) {
            header('Location: animals.php?success=Kafsha u përditësua me sukses!');
            exit();
        } else {
            $error = 'Gabim në përditësim: ' . mysqli_error($conn);
        }
    }
    
    // Merr të dhënat e përditësuara për formën
    $animal['name'] = $name;
    $animal['scientific_name'] = $scientific_name;
    $animal['category'] = $category;
    $animal['image_url'] = $image_url;
    $animal['wikipedia_link'] = $wikipedia_link;
    $animal['description'] = $description;
    $animal['habitat'] = $habitat;
    $animal['conservation_status'] = $conservation_status;
    $animal['facts'] = $facts;
    $animal['featured'] = $featured;
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ndrysho Kafshë - KosovoZoo</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <?php 
    $pageTitle = 'Ndrysho Kafshë - KosovoZoo';
    $currentUser = getCurrentUser();
    include __DIR__ . '/../includes/header.php'; 
    ?>

    <section class="admin-form-section">
        <div class="permbajtje" style="max-width: 800px; margin: 0 auto;">
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); position: relative; z-index: 1;">
                <h2 style="text-align: center; color: var(--green-dark); margin-bottom: 1.5rem;">Ndrysho Kafshën</h2>
                
                <?php if ($error): ?>
                    <div style="background: #ffebee; color: #c62828; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" style="position: relative; z-index: 10;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                                Emri i Kafshës: <span style="color: red;">*</span>
                            </label>
                            <input type="text" name="name" required
                                   value="<?php echo htmlspecialchars($animal['name']); ?>"
                                   style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; background: white;">
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                                Emri Shkencor:
                            </label>
                            <input type="text" name="scientific_name"
                                   value="<?php echo htmlspecialchars($animal['scientific_name']); ?>"
                                   style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; background: white;">
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                                Kategoria: <span style="color: red;">*</span>
                            </label>
                            <select name="category" required
                                    style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; background: white;">
                                <option value="Gjitarë" <?php echo $animal['category'] == 'Gjitarë' ? 'selected' : ''; ?>>Gjitarë</option>
                                <option value="Shpendë" <?php echo $animal['category'] == 'Shpendë' ? 'selected' : ''; ?>>Shpendë</option>
                                <option value="Zvarranikë" <?php echo $animal['category'] == 'Zvarranikë' ? 'selected' : ''; ?>>Zvarranikë</option>
                                <option value="Ujorë" <?php echo $animal['category'] == 'Ujorë' ? 'selected' : ''; ?>>Ujorë</option>
                            </select>
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                                Statusi i Mbrojtjes:
                            </label>
                            <input type="text" name="conservation_status"
                                   value="<?php echo htmlspecialchars($animal['conservation_status']); ?>"
                                   style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; background: white;">
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                            URL e Fotografisë:
                        </label>
                        <input type="url" name="image_url"
                               value="<?php echo htmlspecialchars($animal['image_url']); ?>"
                               style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; background: white;">
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                            Lidhja e Wikipedia:
                        </label>
                        <input type="url" name="wikipedia_link"
                               value="<?php echo htmlspecialchars($animal['wikipedia_link']); ?>"
                               style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; background: white;">
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                            Përshkrim:
                        </label>
                        <textarea name="description" rows="4"
                                  style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; background: white; resize: vertical;"><?php echo htmlspecialchars($animal['description']); ?></textarea>
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                            Habitat:
                        </label>
                        <textarea name="habitat" rows="3"
                                  style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; background: white; resize: vertical;"><?php echo htmlspecialchars($animal['habitat']); ?></textarea>
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 600;">
                            Fakte (ndani me |):
                        </label>
                        <textarea name="facts" rows="4"
                                  style="width: 100%; padding: 0.75rem; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; background: white; resize: vertical;"><?php echo htmlspecialchars($animal['facts']); ?></textarea>
                        <small style="color: var(--text-medium); font-size: 0.85rem;">Ndani fakte me simbolin | (pipe)</small>
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-dark); font-weight: 600;">
                            <input type="checkbox" name="featured" value="1" <?php echo $animal['featured'] ? 'checked' : ''; ?>>
                            Shfaq në faqen kryesore (Featured)
                        </label>
                    </div>
                    
                    <div style="display: flex; gap: 1rem;">
                        <button type="submit" class="buton butonkryesor" style="flex: 1; padding: 0.75rem; position: relative; z-index: 10;">
                            Përditëso
                        </button>
                        <a href="animals.php" class="buton" style="flex: 1; padding: 0.75rem; text-align: center; text-decoration: none; background: var(--text-medium); color: white; border-radius: 5px; position: relative; z-index: 10;">
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
