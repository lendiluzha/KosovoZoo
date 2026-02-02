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
    
    // Butonat për kafshët tani menaxhohen nga animals.php dhe index.php
    // Funksionet për modal-in janë në faqet PHP
    
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

// Parandalon shfaqjen e faqes së vjetër kur përdoruesi klikon Back pas logout
window.addEventListener('pageshow', function (event) {
    // event.persisted është true kur faqja vjen nga bfcache (back/forward cache)
    if (event.persisted) {
        window.location.reload();
    }
});

// Hero Slider Functionality
(function() {
    var currentSlideIndex = 0;
    var slides = [];
    var dots = [];
    var slideInterval = null;

    function initSlider() {
        slides = document.getElementsByClassName('slide');
        dots = document.getElementsByClassName('dot');
        
        if (slides.length === 0) {
            return;
        }
        
        function showSlide(n) {
            if (slides.length === 0) return;
            
            if (n >= slides.length) {
                currentSlideIndex = 0;
            } else if (n < 0) {
                currentSlideIndex = slides.length - 1;
            } else {
                currentSlideIndex = n;
            }
            
            // Hide all slides
            for (var i = 0; i < slides.length; i++) {
                slides[i].classList.remove('active');
                if (dots[i]) {
                    dots[i].classList.remove('active');
                }
            }
            
            // Show current slide
            if (slides[currentSlideIndex]) {
                slides[currentSlideIndex].classList.add('active');
            }
            if (dots[currentSlideIndex]) {
                dots[currentSlideIndex].classList.add('active');
            }
        }

        window.changeSlide = function(n) {
            currentSlideIndex += n;
            if (currentSlideIndex >= slides.length) {
                currentSlideIndex = 0;
            } else if (currentSlideIndex < 0) {
                currentSlideIndex = slides.length - 1;
            }
            showSlide(currentSlideIndex);
        };

        window.currentSlide = function(n) {
            currentSlideIndex = n - 1;
            if (currentSlideIndex < 0) {
                currentSlideIndex = 0;
            } else if (currentSlideIndex >= slides.length) {
                currentSlideIndex = slides.length - 1;
            }
            showSlide(currentSlideIndex);
        };

        function startSlider() {
            if (slideInterval) {
                clearInterval(slideInterval);
            }
            slideInterval = setInterval(function() {
                currentSlideIndex++;
                if (currentSlideIndex >= slides.length) {
                    currentSlideIndex = 0;
                }
                showSlide(currentSlideIndex);
            }, 5000); // Change slide every 5 seconds
        }

        function stopSlider() {
            if (slideInterval) {
                clearInterval(slideInterval);
            }
        }

        // Initialize slider - ensure only first slide is active
        for (var i = 0; i < slides.length; i++) {
            slides[i].classList.remove('active');
            if (dots[i]) {
                dots[i].classList.remove('active');
            }
        }
        
        // Set first slide as active
        if (slides[0]) {
            slides[0].classList.add('active');
        }
        if (dots[0]) {
            dots[0].classList.add('active');
        }
        
        currentSlideIndex = 0;
        showSlide(currentSlideIndex);
        startSlider();
        
        // Pause on hover
        var heroSlider = document.querySelector('.hero-slider');
        if (heroSlider) {
            heroSlider.addEventListener('mouseenter', stopSlider);
            heroSlider.addEventListener('mouseleave', startSlider);
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSlider);
    } else {
        initSlider();
    }
})();