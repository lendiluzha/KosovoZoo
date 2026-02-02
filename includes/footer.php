<?php
// Përcakto path-in bazë bazuar në ku ndodhet faqja aktuale
$current_dir = dirname($_SERVER['PHP_SELF']);
$base_path = ($current_dir == '/admin' || strpos($current_dir, '/admin') !== false) ? '../' : '';
?>
    <footer class="fund">
        <div class="permbajtje">
            <div class="permbajtjefund">
                <div class="seksionfund">
                    <h3>KosovoZoo</h3>
                    <p>Kopshti zoologjik më i madh në Kosovë, i dedikuar mbrojtjes dhe edukimit.</p>
                </div>
                <div class="seksionfund">
                    <h4>Linqe të Shpejta</h4>
                    <ul>
                        <li><a href="<?php echo $base_path; ?>index.php">Faqja Kryesore</a></li>
                        <li><a href="<?php echo $base_path; ?>about.php">Rreth Nesh</a></li>
                        <li><a href="<?php echo $base_path; ?>animals.php">Kafshët</a></li>
                        <li><a href="<?php echo $base_path; ?>contact.php">Kontakt</a></li>
                    </ul>
                </div>
                <div class="seksionfund">
                    <h4>Na Ndiqni</h4>
                    <div class="linqesociale">
                        <a href="#">Facebook</a>
                        <a href="#">Instagram</a>
                        <a href="#">Twitter</a>
                    </div>
                </div>
            </div>
            <div class="fundposhtem">
                <p>&copy; <?php echo date('Y'); ?> KosovoZoo. Të gjitha të drejtat e rezervuara.</p>
            </div>
        </div>
    </footer>

    <script src="<?php echo $base_path; ?>script.js?v=<?php echo time(); ?>"></script>
</body>
</html>

