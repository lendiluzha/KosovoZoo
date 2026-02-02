# KosovoZoo - Backend Setup

## Instalimi i Databazës

1. Hapni phpMyAdmin ose MySQL command line
2. Importoni file-in `database.sql`
3. Ose ekzekutoni komandat SQL manualisht

## Konfigurimi

Hapni `config.php` dhe përditësoni:
- `$db_host` - hosti i databazës (zakonisht 'localhost')
- `$db_user` - përdoruesi i databazës (zakonisht 'root')
- `$db_pass` - fjalëkalimi i databazës (zakonisht bosh për XAMPP)
- `$db_name` - emri i databazës ('zoo')

## Kredencialet Default

Pas instalimit, mund të hyni si administrator:
- **Përdoruesi**: admin
- **Fjalëkalimi**: admin123

## Struktura

- `config.php` - Konfigurimi dhe funksionet e databazës
- `login.php` - Faqja e hyrjes
- `signup.php` - Faqja e regjistrimit
- `logout.php` - Dalja nga sistemi
- `admin/dashboard.php` - Dashboard për administratorin

## Funksionaliteti

1. **Regjistrim**: Përdoruesit e rinj mund të regjistrohen
2. **Hyrje**: Përdoruesit ekzistues mund të hynë
3. **Role**: Ka dy role - 'admin' dhe 'user'
4. **Dashboard**: Administratori shikon të gjithë përdoruesit

## Siguria

- Fjalëkalimet hash-ohen me `password_hash()`
- Session management për autentifikim
- Kontroll i roleve për qasje në dashboard

