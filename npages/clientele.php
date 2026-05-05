<?php
require_once '../includes/head.php';
require_once '../includes/navbar.php';
?>

<!-- AOS for Scroll Animations -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/clientele.css">

<!-- Hero Section -->
<section class="clientele-hero">
    <div class="container">
        <div class="hero-content" data-aos="fade-up">
            <h1 class="animate-char">Our Clientele</h1>
            <p class="animate-char" style="animation-delay: 0.5s;">Trusted by Industry Leaders Across India</p>
        </div>
    </div>
</section>


<!-- Clean Client Grid Layout -->
<section class="client-grid-section">
    <div class="clients-container">
        <!-- Heading Section -->
        <div class="section-heading text-center" data-aos="fade-up">
            <h2>Our Clients</h2>
            <p>
                At S.B. Syscon Pvt. Ltd., our clients are at the core of our mission. We proudly serve dynamic startups and established enterprises across India's industrial landscape.
            </p>
        </div>

        <div class="clients-grid">
            <?php
            // Display ALL images found in the assets/images3 folder
            // Clean grid layout matching the reference design

            for ($i = 1; $i <= 110; $i++) {
                $img_path = "../assets/images3/{$i}.png";
                
                if (file_exists($img_path)) {
            ?>
            <div class="logo-card" data-aos="fade-up" data-aos-delay="<?php echo ($i * 10) % 200; ?>">
                <img src="<?php echo $img_path; ?>" alt="Client Logo <?php echo $i; ?>" loading="lazy">
            </div>
            <?php 
                }
            } 
            ?>
        </div>
    </div>
</section>

<!-- AOS Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>

<?php require_once '../includes/footer.php'; ?>
