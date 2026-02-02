-- Krijo databazën
CREATE DATABASE IF NOT EXISTS zoo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE zoo;

-- Tabela për përdoruesit
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Shto admin default (password: admin123)
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@kosovozoo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Tabela për kafshët
CREATE TABLE IF NOT EXISTS animals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    scientific_name VARCHAR(150),
    category VARCHAR(50) NOT NULL,
    image_url VARCHAR(500),
    wikipedia_link VARCHAR(500),
    description TEXT,
    habitat TEXT,
    conservation_status VARCHAR(100),
    facts TEXT,
    featured BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Shto disa kafshë default
INSERT INTO animals (name, scientific_name, category, image_url, wikipedia_link, description, habitat, conservation_status, facts, featured) VALUES
('Luani', 'Panthera leo', 'Gjitarë', 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=800', 'https://sq.wikipedia.org/wiki/Luani', 'Luani është një nga kafshët më të njohura dhe më të respektuara në botë. Njohur si "mbreti i pyllit", luani është një grabitqar i fuqishëm që jeton në grupe të quajtura "tufa".', 'Luanët jetojnë kryesisht në savanë dhe shkretëtira në Afrikë dhe në një park kombëtar në Indi.', 'Të rrezikuar', 'Luanët jetojnë në grupe prej 5-30 individësh|Meshkujt mund të peshojnë deri në 250 kg|Luanët mund të vrapojnë me shpejtësi deri në 80 km/h|Jeta mesatare e një luani në natyrë është 10-14 vjet', 1),
('Elefanti', 'Loxodonta africana', 'Gjitarë', 'https://images.unsplash.com/photo-1517282009859-f000ec3b26fe?w=800', 'https://sq.wikipedia.org/wiki/Elefanti', 'Elefanti është kafsha më e madhe tokësore në botë. Ata janë të njohur për inteligjencën e tyre të lartë dhe kujtesën e shkëlqyer.', 'Elefantët jetojnë në savanë, pyje dhe shkretëtira në Afrikë dhe Azinë.', 'Të rrezikuar', 'Elefantët mund të peshojnë deri në 6 ton|Ata kanë kujtesën më të mirë në botën e kafshëve|Elefantët përdorin gjilpërat për të marrë ujë dhe ushqim|Jeta mesatare e një elefanti është 60-70 vjet', 1),
('Panda', 'Ailuropoda melanoleuca', 'Gjitarë', 'https://images.unsplash.com/photo-1529107386315-e4a2d1c5ba3e?w=800', 'https://sq.wikipedia.org/wiki/Panda_e_madhe', 'Panda është një nga kafshët më të dashura në botë. Ata janë simbol i mbrojtjes së kafshëve.', 'Pandat jetojnë në pyjet e bambut në Kinë.', 'Të rrezikuara', 'Pandat hanë deri në 20 kg bambu në ditë|Ata kalojnë 12-14 orë në ditë duke ngrënë|Pandat kanë një "gisht të gjashtë" që i ndihmon të mbajnë bambun|Jeta mesatare e një panda është 15-20 vjet', 1),
('Gjirafa', 'Giraffa camelopardalis', 'Gjitarë', 'https://images.unsplash.com/photo-1525183995014-bd94c0750cd5?w=800', 'https://sq.wikipedia.org/wiki/Gjirafa', 'Gjirafa është kafsha më e gjatë në botë, e njohur për qafën e saj të gjatë.', 'Gjirafat jetojnë në savanë dhe pyje të hapura në Afrikë.', 'Të rrezikuara', 'Qafa e një gjirafe mund të jetë deri në 2 metra e gjatë|Gjirafat kanë të njëjtin numër vertebrash si njerëzit (7)|Ata mund të vrapojnë me shpejtësi deri në 56 km/h|Çdo gjirafë ka një model unik të njollave', 1),
('Tigri', 'Panthera tigris', 'Gjitarë', 'https://images.unsplash.com/photo-1561731216-c3a4d99437d5?w=800', 'https://sq.wikipedia.org/wiki/Tigri', 'Tigri është kafsha më e madhe e familjes së maceve dhe një nga grabitqarët më të fuqishëm.', 'Tigrat jetojnë në pyje dhe savanë në Azinë.', 'Të rrezikuar', 'Tigrat mund të peshojnë deri në 300 kg|Çdo tigër ka një model unik vijash|Ata mund të kërcejnë deri në 5 metra në lartësi|Jeta mesatare e një tigri është 10-15 vjet', 0),
('Ariu', 'Ursidae', 'Gjitarë', 'https://images.unsplash.com/photo-1544025162-d76694265947?w=800', 'https://sq.wikipedia.org/wiki/Ariu', 'Ariu është një kafshë e fuqishme dhe inteligjente që gjendet në shumë pjesë të botës.', 'Arinjët jetojnë në pyje, male dhe tundra në të gjithë botën.', 'Varësisht nga lloji', 'Arinjët mund të peshojnë deri në 600 kg|Ata kalojnë në gjumë dimëror për 3-5 muaj|Arinjët kanë një nuhatje shumë të mirë|Jeta mesatare e një ariu është 20-25 vjet', 0),
('Shqiponja', 'Aquila', 'Shpendë', 'https://images.unsplash.com/photo-1544966503-7cc5ac882d5f?w=800', 'https://sq.wikipedia.org/wiki/Shqiponja', 'Shqiponja është një zog grabitqar i fuqishëm, simbol i lirisë dhe fuqisë.', 'Shqiponjat jetojnë në male dhe zona të hapura në të gjithë botën.', 'Varësisht nga lloji', 'Shqiponjat mund të fluturojnë me shpejtësi deri në 320 km/h|Ata kanë shikim shumë të mprehtë|Shqiponjat mund të jetojnë deri në 30 vjet|Ata ndërtojnë fole shumë të mëdha', 0),
('Papagalli', 'Psittaciformes', 'Shpendë', 'https://images.unsplash.com/photo-1526318896980-cf78c088247c?w=800', 'https://sq.wikipedia.org/wiki/Papagalli', 'Papagalli është një zog me ngjyra të bukura dhe aftësi për të folur.', 'Papagallët jetojnë në zona tropikale dhe subtropikale.', 'Varësisht nga lloji', 'Papagallët mund të imitojnë zërat e njerëzve|Ata kanë kujtesë të shkëlqyer|Papagallët jetojnë në grupe|Jeta mesatare e një papagalli është 20-80 vjet', 0),
('Krokodili', 'Crocodylidae', 'Zvarranikë', 'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?w=800', 'https://sq.wikipedia.org/wiki/Krokodili', 'Krokodili është një zvarranik i fuqishëm ujor, një nga kafshët më të vjetra.', 'Krokodilët jetojnë në lumenj, liqene dhe zona ujore në zona tropikale.', 'Varësisht nga lloji', 'Krokodilët mund të jetojnë deri në 70 vjet|Ata mund të mbajnë frymën nën ujë për deri në 1 orë|Krokodilët kanë forcë shumë të madhe në nofullat|Ata janë kafshë shumë të vjetra (200 milion vjet)', 0),
('Delfini', 'Delphinidae', 'Ujorë', 'https://images.unsplash.com/photo-1583212292454-1fe6229603b7?w=800', 'https://sq.wikipedia.org/wiki/Delfini', 'Delfini është një kafshë inteligjente dhe miqësore, e njohur për lojën.', 'Delfinët jetojnë në oqeane dhe dete në të gjithë botën.', 'Varësisht nga lloji', 'Delfinët janë shumë inteligjentë|Ata përdorin ekolokacion|Delfinët jetojnë në grupe të quajtura "tufa"|Ata mund të komunikojnë me zëra kompleks', 0);