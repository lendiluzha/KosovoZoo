// Të dhënat e kafshëve me foto dhe lidhje
var animalData = {
    lion: {
        name: 'Luani',
        scientific: 'Panthera leo',
        category: 'Gjitarë',
        image: 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=800',
        link: 'https://sq.wikipedia.org/wiki/Luani',
        description: 'Luani është një nga kafshët më të njohura dhe më të respektuara në botë. Njohur si "mbreti i pyllit", luani është një grabitqar i fuqishëm që jeton në grupe të quajtura "tufa".',
        facts: [
            'Luanët jetojnë në grupe prej 5-30 individësh',
            'Meshkujt mund të peshojnë deri në 250 kg',
            'Luanët mund të vrapojnë me shpejtësi deri në 80 km/h',
            'Jeta mesatare e një luani në natyrë është 10-14 vjet'
        ],
        habitat: 'Luanët jetojnë kryesisht në savanë dhe shkretëtira në Afrikë dhe në një park kombëtar në Indi.',
        status: 'Luanët janë të listuar si "të rrezikuar" në Listën e Kuqe të IUCN.'
    },
    elephant: {
        name: 'Elefanti',
        scientific: 'Loxodonta africana',
        category: 'Gjitarë',
        image: 'https://images.unsplash.com/photo-1517282009859-f000ec3b26fe?w=800',
        link: 'https://sq.wikipedia.org/wiki/Elefanti',
        description: 'Elefanti është kafsha më e madhe tokësore në botë. Ata janë të njohur për inteligjencën e tyre të lartë dhe kujtesën e shkëlqyer.',
        facts: [
            'Elefantët mund të peshojnë deri në 6 ton',
            'Ata kanë kujtesën më të mirë në botën e kafshëve',
            'Elefantët përdorin gjilpërat për të marrë ujë dhe ushqim',
            'Jeta mesatare e një elefanti është 60-70 vjet'
        ],
        habitat: 'Elefantët jetojnë në savanë, pyje dhe shkretëtira në Afrikë dhe Azinë.',
        status: 'Elefantët janë të listuar si "të rrezikuar" për shkak të brakonierimit.'
    },
    panda: {
        name: 'Panda',
        scientific: 'Ailuropoda melanoleuca',
        category: 'Gjitarë',
        image: 'https://images.unsplash.com/photo-1529107386315-e4a2d1c5ba3e?w=800',
        link: 'https://sq.wikipedia.org/wiki/Panda_e_madhe',
        description: 'Panda është një nga kafshët më të dashura në botë. Ata janë simbol i mbrojtjes së kafshëve.',
        facts: [
            'Pandat hanë deri në 20 kg bambu në ditë',
            'Ata kalojnë 12-14 orë në ditë duke ngrënë',
            'Pandat kanë një "gisht të gjashtë" që i ndihmon të mbajnë bambun',
            'Jeta mesatare e një panda është 15-20 vjet'
        ],
        habitat: 'Pandat jetojnë në pyjet e bambut në Kinë.',
        status: 'Pandat janë të listuar si "të rrezikuara" në Listën e Kuqe të IUCN.'
    },
    giraffe: {
        name: 'Gjirafa',
        scientific: 'Giraffa camelopardalis',
        category: 'Gjitarë',
        image: 'https://images.unsplash.com/photo-1525183995014-bd94c0750cd5?w=800',
        link: 'https://sq.wikipedia.org/wiki/Gjirafa',
        description: 'Gjirafa është kafsha më e gjatë në botë, e njohur për qafën e saj të gjatë.',
        facts: [
            'Qafa e një gjirafe mund të jetë deri në 2 metra e gjatë',
            'Gjirafat kanë të njëjtin numër vertebrash si njerëzit (7)',
            'Ata mund të vrapojnë me shpejtësi deri në 56 km/h',
            'Çdo gjirafë ka një model unik të njollave'
        ],
        habitat: 'Gjirafat jetojnë në savanë dhe pyje të hapura në Afrikë.',
        status: 'Gjirafat janë të listuar si "të rrezikuara" në Listën e Kuqe të IUCN.'
    },
    tiger: {
        name: 'Tigri',
        scientific: 'Panthera tigris',
        category: 'Gjitarë',
        image: 'https://images.unsplash.com/photo-1561731216-c3a4d99437d5?w=800',
        link: 'https://sq.wikipedia.org/wiki/Tigri',
        description: 'Tigri është kafsha më e madhe e familjes së maceve dhe një nga grabitqarët më të fuqishëm.',
        facts: [
            'Tigrat mund të peshojnë deri në 300 kg',
            'Çdo tigër ka një model unik vijash',
            'Ata mund të kërcejnë deri në 5 metra në lartësi',
            'Jeta mesatare e një tigri është 10-15 vjet'
        ],
        habitat: 'Tigrat jetojnë në pyje dhe savanë në Azinë.',
        status: 'Tigrat janë të listuar si "të rrezikuar" në Listën e Kuqe të IUCN.'
    },
    bear: {
        name: 'Ariu',
        scientific: 'Ursidae',
        category: 'Gjitarë',
        image: 'https://images.unsplash.com/photo-1544025162-d76694265947?w=800',
        link: 'https://sq.wikipedia.org/wiki/Ariu',
        description: 'Ariu është një kafshë e fuqishme dhe inteligjente që gjendet në shumë pjesë të botës.',
        facts: [
            'Arinjët mund të peshojnë deri në 600 kg',
            'Ata kalojnë në gjumë dimëror për 3-5 muaj',
            'Arinjët kanë një nuhatje shumë të mirë',
            'Jeta mesatare e një ariu është 20-25 vjet'
        ],
        habitat: 'Arinjët jetojnë në pyje, male dhe tundra në të gjithë botën.',
        status: 'Statusi i mbrojtjes së arinjëve varet nga lloji.'
    },
    eagle: {
        name: 'Shqiponja',
        scientific: 'Aquila',
        category: 'Shpendë',
        image: 'https://images.unsplash.com/photo-1544966503-7cc5ac882d5f?w=800',
        link: 'https://sq.wikipedia.org/wiki/Shqiponja',
        description: 'Shqiponja është një zog grabitqar i fuqishëm dhe simbol i lirisë dhe fuqisë.',
        facts: [
            'Shqiponjat mund të fluturojnë me shpejtësi deri në 160 km/h',
            'Ata mund të shohin një lepur nga distanca prej 3 km',
            'Shqiponjat kanë kthetra shumë të mëdha dhe të forta',
            'Jeta mesatare e një shqiponje është 20-30 vjet'
        ],
        habitat: 'Shqiponjat jetojnë në male, pyje dhe zona të hapura në të gjithë botën.',
        status: 'Shumë lloje shqiponjash janë "të rrezikuara" për shkak të humbjes së habitatit.'
    },
    parrot: {
        name: 'Papagalli',
        scientific: 'Psittaciformes',
        category: 'Shpendë',
        image: 'https://images.unsplash.com/photo-1526318896980-cf78c088247c?w=800',
        link: 'https://sq.wikipedia.org/wiki/Papagalli',
        description: 'Papagalli është një zog me ngjyra të bukura dhe aftësi për të folur dhe imituar zëra.',
        facts: [
            'Papagallët mund të jetojnë deri në 80 vjet',
            'Ata kanë aftësi për të folur dhe imituar mbi 100 fjalë',
            'Papagallët janë kafshë shumë sociale',
            'Ata kanë këmbë shumë të forta për të kapur dhe ngjitur'
        ],
        habitat: 'Papagallët jetojnë në pyje tropikale dhe subtropikale në të gjithë botën.',
        status: 'Shumë lloje papagallësh janë "të rrezikuara" për shkak të humbjes së habitatit.'
    },
    flamingo: {
        name: 'Flamingo',
        scientific: 'Phoenicopterus',
        category: 'Shpendë',
        image: 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
        link: 'https://sq.wikipedia.org/wiki/Flamingo',
        description: 'Flamingo është një zog elegant me ngjyrë rozë të bukur dhe qafë të gjatë.',
        facts: [
            'Flamingot kanë ngjyrë rozë për shkak të dietës së tyre',
            'Ata mund të qëndrojnë në një këmbë për orë të tëra',
            'Flamingot jetojnë në tufa prej mijëra individësh',
            'Jeta mesatare e një flamingo është 20-30 vjet'
        ],
        habitat: 'Flamingot jetojnë në liqene kripë dhe lagune në Afrikë, Azinë dhe Amerikë.',
        status: 'Disa lloje flamingosh janë "të rrezikuara" për shkak të humbjes së habitatit.'
    },
    crocodile: {
        name: 'Krokodili',
        scientific: 'Crocodylidae',
        category: 'Zvarranikë',
        image: 'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?w=800',
        link: 'https://sq.wikipedia.org/wiki/Krokodili',
        description: 'Krokodili është një zvarranik i fuqishëm ujor që ka ekzistuar për mbi 200 milion vjet.',
        facts: [
            'Krokodilët mund të jetojnë deri në 70 vjet',
            'Ata mund të mbajnë frymën nën ujë për mbi një orë',
            'Krokodilët kanë forcën më të madhe të kapjes',
            'Ata mund të rriten deri në 6 metra në gjatësi'
        ],
        habitat: 'Krokodilët jetojnë në liqene, lumenj dhe zona ujore në Afrikë, Azinë dhe Amerikë.',
        status: 'Shumë lloje krokodilësh janë "të rrezikuara" për shkak të brakonierimit.'
    },
    snake: {
        name: 'Gjarpëri',
        scientific: 'Serpentes',
        category: 'Zvarranikë',
        image: 'https://images.unsplash.com/photo-1517868673677-0e8e8e3b4a0a?w=800',
        link: 'https://sq.wikipedia.org/wiki/Gjarpëri',
        description: 'Gjarpëri është një zvarranik i gjatë dhe i lëvizshëm që gjendet në pothuajse të gjitha kontinentet.',
        facts: [
            'Gjarpërinjtë mund të jetojnë deri në 30 vjet',
            'Ata nuk kanë këmbë dhe lëvizin duke përdorur muskujt',
            'Gjarpërinjtë mund të hanë pre më të mëdha se kokat e tyre',
            'Shumë gjarpërinj janë helmues, por shumica janë të padëmshme'
        ],
        habitat: 'Gjarpërinjtë jetojnë në shumë mjedise, nga shkretëtirat deri te pyjet tropikale.',
        status: 'Statusi i mbrojtjes së gjarpërinjve varet nga lloji.'
    },
    dolphin: {
        name: 'Delfini',
        scientific: 'Delphinidae',
        category: 'Ujorë',
        image: 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
        link: 'https://sq.wikipedia.org/wiki/Delfini',
        description: 'Delfini është një kafshë inteligjente dhe miqësore që jetojnë në oqeane dhe dete.',
        facts: [
            'Delfinët janë një nga kafshët më inteligjente në botë',
            'Ata përdorin ekolokacion për të naviguar',
            'Delfinët jetojnë në grupe prej 10-30 individësh',
            'Ata mund të notojnë me shpejtësi deri në 60 km/h'
        ],
        habitat: 'Delfinët jetojnë në oqeane dhe dete në të gjithë botën.',
        status: 'Shumë lloje delfinësh janë "të rrezikuara" për shkak të ndotjes dhe peshqimit.'
    }
};

// Hap dritaren me informacion për kafshën
function openAnimalModal(animalId) {
    var animal = animalData[animalId];
    if (!animal) return;
    
    // Vendos informacionin në dritare
    var modalImage = document.getElementById('modalImage');
    modalImage.innerHTML = '<a href="' + animal.link + '" target="_blank"><img src="' + animal.image + '" alt="' + animal.name + '" style="width:100%;border-radius:10px;"></a>';
    
    document.getElementById('modalName').textContent = animal.name;
    document.getElementById('modalScientific').textContent = animal.scientific;
    document.getElementById('modalCategory').textContent = animal.category;
    document.getElementById('modalDescription').textContent = animal.description;
    document.getElementById('modalHabitat').textContent = animal.habitat;
    document.getElementById('modalStatus').textContent = animal.status;
    
    // Shto faktet
    var factsList = document.getElementById('modalFacts');
    factsList.innerHTML = '';
    for (var i = 0; i < animal.facts.length; i++) {
        var li = document.createElement('li');
        li.textContent = animal.facts[i];
        factsList.appendChild(li);
    }
    
    // Shfaq dritaren
    document.getElementById('animalModal').style.display = 'block';
}

// Mbyll dritaren
function closeAnimalModal() {
    document.getElementById('animalModal').style.display = 'none';
}

// Kur faqja të ngarkohet, vendos ngjarjet
document.addEventListener('DOMContentLoaded', function() {
    // Menyja mobile
    var menumobile = document.querySelector('.menumobile');
    var navigim = document.querySelector('.navigim');
    
    if (menumobile) {
        menumobile.onclick = function() {
            navigim.classList.toggle('active');
            menumobile.classList.toggle('active');
        };
    }
    
    // Butonat për kafshët
    var buttons = document.querySelectorAll('[data-animal]');
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].onclick = function() {
            var animalId = this.getAttribute('data-animal');
            openAnimalModal(animalId);
        };
    }
    
    // Butoni për mbyllje
    var closeBtn = document.querySelector('.mbyllmodal');
    if (closeBtn) {
        closeBtn.onclick = closeAnimalModal;
    }
    
    // Mbyll kur klikohet jashtë
    var modal = document.getElementById('animalModal');
    if (modal) {
        window.onclick = function(event) {
            if (event.target === modal) {
                closeAnimalModal();
            }
        };
    }
    
    // Lëvizje e butë për lidhjet
    var anchors = document.querySelectorAll('a[href^="#"]');
    for (var j = 0; j < anchors.length; j++) {
        anchors[j].onclick = function(e) {
            e.preventDefault();
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        };
    }
});
