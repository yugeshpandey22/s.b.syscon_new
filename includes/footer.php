<footer class="main-footer">
    
    <?php if (basename($_SERVER['PHP_SELF']) == 'index.php'): ?>
    <!-- MEMBERSHIPS SECTION -->
    <section class="py-5 bg-white border-bottom mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 text-center text-lg-start mb-4 mb-lg-0">
                    <h3 class="fw-bold text-dark m-0" style="font-size: 1.5rem; letter-spacing: 1px;">STRATEGIC PARTNERS</h3>
                </div>
                
                <div class="col-lg-9">
                    <div class="row g-4 justify-content-center">
                        <?php for($i=1; $i<=4; $i++): ?>
                        <div class="col-6 col-lg-3">
                            <div class="card membership-card p-3 h-100">
                                <img src="../assets/images2/cer<?php echo $i; ?>.jpg" alt="Partner" class="img-fluid" style="height: 120px; object-fit: contain;">
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <link rel="stylesheet" href="../assets/css/footer.css">

    <!-- Main Footer Content -->
    <div class="container pb-5">
        <div class="row gy-5">
            <!-- Company Info -->
            <div class="col-lg-4">
                <a href="index.php" class="d-inline-block mb-4">
                    <img src="../assets/images2/headerlogo.png" alt="S.B. Syscon" style="max-height: 80px; filter: brightness(1.1); background: rgba(255,255,255,0.9); padding: 8px; border-radius: 8px;">
                </a>
                <p class="text-white-50 mb-4 pe-lg-5" style="line-height: 1.8;">
                    Leading innovation in industrial technology and automation with a commitment to excellence and global standards.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Navigation -->
            <div class="col-lg-2 col-md-4 col-6">
                <h6 class="footer-heading">Company</h6>
                <ul class="list-unstyled">
                    <li class="mb-3"><a href="index.php" class="footer-link">Home</a></li>
                    <li class="mb-3"><a href="about.php" class="footer-link">About Us</a></li>
                    <li class="mb-3"><a href="journey.php" class="footer-link">Our Journey</a></li>
                    <li class="mb-3"><a href="principals.php" class="footer-link">Principals</a></li>
                </ul>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-4 col-6">
                <h6 class="footer-heading">Services</h6>
                <ul class="list-unstyled">
                    <li class="mb-3"><a href="#" class="footer-link">Exports</a></li>
                    <li class="mb-3"><a href="#" class="footer-link">Clientele</a></li>
                    <li class="mb-3"><a href="pricelists.php" class="footer-link">Price List</a></li>
                    <li class="mb-3"><a href="contact.php" class="footer-link">Contact Us</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-4 col-md-4">
                <h6 class="footer-heading">Get In Touch</h6>
                
                <div class="contact-info-item">
                    <div class="contact-icon-box">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <p class="text-white mb-0 fw-bold">Address</p>
                        <p class="text-white-50 small mb-0">1D-45A, NIT Faridabad, Haryana, India-121001</p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="contact-icon-box">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <p class="text-white mb-0 fw-bold">Call Us</p>
                        <p class="text-white-50 small mb-0">+91 9899598900, +91 9899598955</p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="contact-icon-box">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <p class="text-white mb-0 fw-bold">Email</p>
                        <p class="text-white-50 small mb-0">info@sbsyscon.in</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright Bar -->
    <div class="copyright-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="text-white-50 small mb-0">
                        &copy; 2025 <span class="text-white fw-bold">S.B. Syscon Pvt. Ltd.</span> All Rights Reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <p class="text-white-50 small mb-0">
                        Crafted with excellence by <span class="text-danger fw-bold">MINEIB</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<!-- AOS Animation JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1000,
    easing: 'ease-in-out',
    once: true, // Animation happens once per scroll-down
    mirror: false,
    offset: 50
  });
</script>
<script src="../assets/js/main.js"></script>

<!-- MAGIC CURSOR ELEMENTS -->
<div class="cursor-dot" data-cursor-dot></div>
<div class="cursor-outline" data-cursor-outline></div>


<script>
    // Magic Cursor Script
    const cursorDot = document.querySelector('[data-cursor-dot]');
    const cursorOutline = document.querySelector('[data-cursor-outline]');

    // Hide initially
    cursorDot.style.opacity = "0";
    cursorOutline.style.opacity = "0";

    window.addEventListener("mousemove", function(e) {
        const posX = e.clientX;
        const posY = e.clientY;

        // Show on first move
        cursorDot.style.opacity = "1";
        cursorOutline.style.opacity = "1";

        // Dot follows instantly
        cursorDot.style.left = `${posX}px`;
        cursorDot.style.top = `${posY}px`;

        // Outline follows with smooth lag
        cursorOutline.animate({
            left: `${posX}px`,
            top: `${posY}px`
        }, { duration: 400, fill: "forwards" });
    });

    // Add Hover Effect on Links & Buttons
    function applyCursorHover() {
        const hoverElements = document.querySelectorAll('a, button, .btn, .card, img, .hover-target');
        hoverElements.forEach(el => {
            el.addEventListener('mouseenter', () => document.body.classList.add('hovering'));
            el.addEventListener('mouseleave', () => document.body.classList.remove('hovering'));
        });
    }
    
    applyCursorHover();
    
    // Re-apply for dynamic content if needed
    document.addEventListener('DOMNodeInserted', applyCursorHover);
</script>

</body>
</html>
