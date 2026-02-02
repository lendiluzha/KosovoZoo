<?php
require_once 'config.php';
$pageTitle = 'Kafshët - KosovoZoo';

// Merr të gjitha kafshët nga databaza
$query = "SELECT * FROM animals ORDER BY name ASC";
$result = mysqli_query($conn, $query);
$animals = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $animals[] = $row;
    }
}

include 'includes/header.php';
?>

<section class="kryefaqe">
    <div class="permbajtje">
        <h1>Kafshët Tona</h1>
        <p>Eksploroni diversitetin e mrekullueshëm të kafshëve në KosovoZoo</p>
    </div>
</section>

<section class="seksionkafshet">
    <div class="permbajtje">
        <?php if (empty($animals)): ?>
            <p style="text-align: center; color: var(--text-medium); padding: 2rem;">
                Nuk ka kafshë të regjistruara për momentin.
            </p>
        <?php else: ?>
            <div class="gridkafshet">
                <?php foreach ($animals as $animal): 
                    $facts_array = !empty($animal['facts']) ? explode('|', $animal['facts']) : [];
                ?>
                    <div class="kartakafshes" data-category="<?php echo strtolower($animal['category']); ?>" data-animal-id="<?php echo $animal['id']; ?>">
                        <?php if ($animal['wikipedia_link']): ?>
                            <a href="<?php echo htmlspecialchars($animal['wikipedia_link']); ?>" target="_blank" class="imazhkafshes">
                        <?php else: ?>
                            <div class="imazhkafshes">
                        <?php endif; ?>
                            <?php if ($animal['image_url']): ?>
                                <img src="<?php echo htmlspecialchars($animal['image_url']); ?>" alt="<?php echo htmlspecialchars($animal['name']); ?>" style="width:100%;height:200px;object-fit:cover;">
                            <?php else: ?>
                                <div style="width:100%;height:200px;background:#ddd;display:flex;align-items:center;justify-content:center;font-size:3rem;">🦁</div>
                            <?php endif; ?>
                        <?php if ($animal['wikipedia_link']): ?>
                            </a>
                        <?php else: ?>
                            </div>
                        <?php endif; ?>
                        <div class="infokafshes">
                            <h3><?php echo htmlspecialchars($animal['name']); ?></h3>
                            <p class="kategorikafshes"><?php echo htmlspecialchars($animal['category']); ?></p>
                            <?php if ($animal['description']): ?>
                                <p class="pershkrimkafshes"><?php echo htmlspecialchars(substr($animal['description'], 0, 100)) . (strlen($animal['description']) > 100 ? '...' : ''); ?></p>
                            <?php endif; ?>
                            <button class="buton butondytesor" onclick="showAnimalModal(<?php echo $animal['id']; ?>)">Shiko Detajet</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<div id="animalModal" class="modal">
    <div class="permbajtjemodal">
        <span class="mbyllmodal" onclick="closeAnimalModal()">&times;</span>
        <div class="trupmodal">
            <div class="imazhmodal" id="modalImage"></div>
            <h2 id="modalName"></h2>
            <p class="shkencormodal" id="modalScientific"></p>
            <p class="kategorimodal" id="modalCategory"></p>
            <div class="pershkrimmodal">
                <h3>Përshkrim</h3>
                <p id="modalDescription"></p>
            </div>
            <div class="faktemodal">
                <h3>Fakte Interesante</h3>
                <ul id="modalFacts"></ul>
            </div>
            <div class="habitatmodal">
                <h3>Habitat</h3>
                <p id="modalHabitat"></p>
            </div>
            <div class="statusmodal">
                <h3>Statusi i Mbrojtjes</h3>
                <p id="modalStatus"></p>
            </div>
        </div>
    </div>
</div>

<script>
// Të dhënat e kafshëve nga PHP
var animalsData = <?php echo json_encode($animals, JSON_UNESCAPED_UNICODE); ?>;

function showAnimalModal(animalId) {
    var animal = animalsData.find(function(a) { return a.id == animalId; });
    if (!animal) return;
    
    var modal = document.getElementById('animalModal');
    var modalImage = document.getElementById('modalImage');
    var modalName = document.getElementById('modalName');
    var modalScientific = document.getElementById('modalScientific');
    var modalCategory = document.getElementById('modalCategory');
    var modalDescription = document.getElementById('modalDescription');
    var modalFacts = document.getElementById('modalFacts');
    var modalHabitat = document.getElementById('modalHabitat');
    var modalStatus = document.getElementById('modalStatus');
    
    // Set image
    if (animal.image_url) {
        modalImage.innerHTML = '<img src="' + animal.image_url + '" alt="' + animal.name + '" style="width:100%;height:300px;object-fit:cover;">';
    } else {
        modalImage.innerHTML = '<div style="width:100%;height:300px;background:#ddd;display:flex;align-items:center;justify-content:center;font-size:5rem;">🦁</div>';
    }
    
    modalName.textContent = animal.name;
    modalScientific.textContent = animal.scientific_name || '';
    modalCategory.textContent = animal.category;
    modalDescription.textContent = animal.description || 'Nuk ka përshkrim të disponueshëm.';
    modalHabitat.textContent = animal.habitat || 'Nuk ka informacion për habitat.';
    modalStatus.textContent = animal.conservation_status || 'Nuk ka informacion për statusin e mbrojtjes.';
    
    // Set facts
    modalFacts.innerHTML = '';
    if (animal.facts) {
        var facts = animal.facts.split('|');
        facts.forEach(function(fact) {
            if (fact.trim()) {
                var li = document.createElement('li');
                li.textContent = fact.trim();
                modalFacts.appendChild(li);
            }
        });
    }
    
    if (modalFacts.children.length === 0) {
        var li = document.createElement('li');
        li.textContent = 'Nuk ka fakte të disponueshme.';
        modalFacts.appendChild(li);
    }
    
    modal.style.display = 'block';
}

function closeAnimalModal() {
    document.getElementById('animalModal').style.display = 'none';
}

// Mbyll modal kur klikohet jashtë
window.onclick = function(event) {
    var modal = document.getElementById('animalModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>

<?php include 'includes/footer.php'; ?>
