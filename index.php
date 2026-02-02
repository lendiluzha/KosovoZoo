<?php
require_once 'config.php';
$pageTitle = 'KosovoZoo - Kopshti Zoologjik';

// Merr kafshët featured nga databaza
$query = "SELECT * FROM animals WHERE featured = 1 ORDER BY name ASC LIMIT 4";
$result = mysqli_query($conn, $query);
$featured_animals = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $featured_animals[] = $row;
    }
}

include 'includes/header.php';
?>

<section class="hero">
    <div class="hero-slider">
        <div class="slider-container">
            <div class="slide active">
                <img src="https://images.unsplash.com/photo-1547036967-23d11aacaee0?w=1920&h=1080&fit=crop" alt="Kopshti Zoologjik">
                <div class="slide-overlay"></div>
            </div>
            <div class="slide">
                <img src="https://images.unsplash.com/photo-1517282009859-f000ec3b26fe?w=1920&h=1080&fit=crop" alt="Elefanti në Kopsht">
                <div class="slide-overlay"></div>
            </div>
            <div class="slide">
                <img src="https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=1920&h=1080&fit=crop" alt="Luani në Kopsht">
                <div class="slide-overlay"></div>
            </div>
            <div class="slide">
                <img src="https://images.unsplash.com/photo-1525183995014-bd94c0750cd5?w=1920&h=1080&fit=crop" alt="Gjirafa në Kopsht">
                <div class="slide-overlay"></div>
            </div>
        </div>
        <div class="hero-content">
            <div class="permbajtjehero">
                <h2>Mirë se vini në KosovoZoo</h2>
                <p>Eksploroni botën e mrekullueshme të kafshëve dhe eksperiencë unike në natyrë</p>
                <a href="animals.php" class="buton butonkryesor">Eksploro Kafshët</a>
            </div>
        </div>
        <div class="slider-controls">
            <button class="slider-btn prev" onclick="changeSlide(-1)">❮</button>
            <button class="slider-btn next" onclick="changeSlide(1)">❯</button>
        </div>
        <div class="slider-dots">
            <span class="dot active" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
            <span class="dot" onclick="currentSlide(4)"></span>
        </div>
    </div>
</section>

<section class="karakteristika">
    <div class="permbajtje">
        <h2 class="titullseksioni">Çfarë ofrojmë</h2>
        <div class="gridkarakteristika">
            <div class="kartakarakteristike">
                <div class="ikonekarakteristike">🦁</div>
                <h3>Kafshë të Shumta</h3>
                <p>Më shumë se 100 lloje kafshësh nga të gjitha kontinentet</p>
            </div>
            <div class="kartakarakteristike">
                <div class="ikonekarakteristike">🌿</div>
                <h3>Mjedis Natyror</h3>
                <p>Habitete të dizajnuara për të imituar mjedisin natyror të kafshëve</p>
            </div>
            <div class="kartakarakteristike">
                <div class="ikonekarakteristike">👨‍👩‍👧‍👦</div>
                <h3>Edukim dhe Argëtim</h3>
                <p>Programe edukative për të gjitha moshët dhe aktivitete argëtuese</p>
            </div>
            <div class="kartakarakteristike">
                <div class="ikonekarakteristike">🛡️</div>
                <h3>Mbrojtje e Kafshëve</h3>
                <p>Përfshirë në programe mbrojtjeje dhe riprodhimi të kafshëve të rrezikuara</p>
            </div>
        </div>
    </div>
</section>

<section class="kafshetpopullore">
    <div class="permbajtje">
        <h2 class="titullseksioni">Kafshët Tona Më Popullore</h2>
        <?php if (empty($featured_animals)): ?>
            <p style="text-align: center; color: var(--text-medium); padding: 2rem;">
                Nuk ka kafshë të shfaqura për momentin.
            </p>
        <?php else: ?>
            <div class="gridkafshet">
                <?php foreach ($featured_animals as $animal): ?>
                    <div class="kartakafshes">
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
                        <h3><?php echo htmlspecialchars($animal['name']); ?></h3>
                        <p><?php echo htmlspecialchars($animal['description'] ? substr($animal['description'], 0, 50) . '...' : 'Kafshë e mrekullueshme'); ?></p>
                        <button class="buton butondytesor" onclick="showAnimalModalFromIndex(<?php echo $animal['id']; ?>)">Më Shumë</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<section id="kontakt" class="kontakt">
    <div class="permbajtje">
        <h2 class="titullseksioni">Na Kontaktoni</h2>
        <div class="permbajtjekontakt">
            <div class="infokontakt">
                <div class="itemkontakt">
                    <strong>📍 Adresa:</strong>
                    <p>Rruga e Kopshtit Zoologjik, Prishtinë, Kosovë</p>
                </div>
                <div class="itemkontakt">
                    <strong>📞 Telefoni:</strong>
                    <p>+383 44 123 456</p>
                </div>
                <div class="itemkontakt">
                    <strong>✉️ Email:</strong>
                    <p>info@kosovozoo.com</p>
                </div>
                <div class="itemkontakt">
                    <strong>🕐 Orari:</strong>
                    <p>E Hënë - E Dielë: 09:00 - 18:00</p>
                </div>
            </div>
        </div>
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
var featuredAnimalsData = <?php echo json_encode($featured_animals, JSON_UNESCAPED_UNICODE); ?>;

// Merr të gjitha kafshët për modal (nga animals.php)
function loadAllAnimals() {
    // Nëse kemi vetëm featured, përdorim ato
    return featuredAnimalsData;
}

function showAnimalModalFromIndex(animalId) {
    var animals = loadAllAnimals();
    var animal = animals.find(function(a) { return a.id == animalId; });
    if (!animal) {
        // Nëse nuk gjendet në featured, kërko nga server
        fetch('get_animal.php?id=' + animalId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showModal(data.animal);
                } else {
                    alert('Kafsha nuk u gjet!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gabim në ngarkim të të dhënave!');
            });
        return;
    }
    showModal(animal);
}

function showModal(animal) {
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
