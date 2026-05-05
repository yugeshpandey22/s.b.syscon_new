<?php
require_once '../config/database.php';
require_once '../includes/head.php';
require_once '../includes/navbar.php';
?>

<!-- AOS already included in footer -->

<link rel="stylesheet" href="../assets/css/achievements.css">

<!-- Hero Slideshow Section -->
<section class="achievements-hero">
    <div class="hero-slideshow">
        <div class="hero-slide active"></div>
        <div class="hero-slide"></div>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 data-aos="fade-right" data-aos-duration="1500"> Achievements</h1>
    </div>
</section>

<!-- Hall of Fame Grid -->
<section class="hall-of-fame">
    <div class="achievements-container">
        
        <div class="section-title" data-aos="fade-down">
            <div style="text-align: center;">
                <h2>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Our Achievements
                </h2>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-5">
            <?php
            // Auto-Import Logic (Self-Healing)
            try {
                // Check if table is empty
                $checkStmt = $conn->query("SELECT COUNT(*) FROM achievements");
                if ($checkStmt->fetchColumn() == 0) {
                    $imagesDir = __DIR__ . '/../assets/images2';
                    if (is_dir($imagesDir)) {
                        $files = scandir($imagesDir);
                        foreach ($files as $file) {
                            if ($file === '.' || $file === '..') continue;
                            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                $relativePath = '../assets/images2/' . $file;
                                $title = ucwords(str_replace(['_', '-'], ' ', pathinfo($file, PATHINFO_FILENAME)));
                                $insert = $conn->prepare("INSERT INTO achievements (image_path, title, description) VALUES (?, ?, ?)");
                                $insert->execute([$relativePath, $title, 'Recognized Excellence']);
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                // Silent fail or log
            }

            // Fetch Achievements from Database
            try {
                $stmt = $conn->query("SELECT * FROM achievements ORDER BY created_at DESC");
                $achievements = $stmt->fetchAll();


                if (count($achievements) > 0) {
                    foreach ($achievements as $row) {
                        $img_path = $row['image_path'];
                        // Fix path if it doesn't have '../' prefix and is relative
                        if (strpos($img_path, 'http') === false && strpos($img_path, '../') !== 0 && strpos($img_path, './') !== 0) {
                            $img_path = '../' . $img_path;
                        }
                        $title = !empty($row['title']) ? htmlspecialchars($row['title']) : 'Recognition for Excellence & Innovation';
            ?>
            <div class="col">
                <div class="award-card" data-aos="fade-up">
                    <span class="outer-light"></span>
                    <span class="outer-light"></span>
                    <span class="outer-light"></span>
                    <span class="outer-light"></span>
                    
                    <div class="award-frame">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <img src="<?php echo $img_path; ?>" alt="<?php echo $title; ?>" loading="lazy">
                    </div>
                    <div class="award-details p-3">
                        <p class="mb-2" style="text-transform: uppercase; font-weight: 800; font-size: 1rem; color: #fff; letter-spacing: 0.5px; line-height: 1.2;">
                            <?php echo $title; ?>
                        </p>
                        <?php if(!empty($row['description'])): ?>
                            <div style="color: #ffd700; font-size: 0.85rem; font-weight: 500; line-height: 1.4; border-top: 1px solid rgba(255,215,0,0.2); padding-top: 8px;">
                                <?php echo nl2br(htmlspecialchars($row['description'])); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
                    }
                } else {
                    echo '<div class="col-12"><p class="text-white text-center">No achievements added yet.</p></div>';
                }
            } catch(PDOException $e) {
                echo '<p class="text-white">Error loading data.</p>';
            }
            ?>
        </div>
    </div>
</section>

<!-- AOS Script handled globally -->
<!-- Vanilla Tilt 3D Effect -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.0/vanilla-tilt.min.js"></script>

<script>
    // AOS init is global now


    // Initialize 3D Tilt on Cards only on Desktop
    if (window.innerWidth > 768) {
        VanillaTilt.init(document.querySelectorAll(".award-card"), {
            max: 15,            // Max tilt angle
            speed: 400,         // Speed of the enter/exit transition
            glare: true,        // Turn on "glare" effect
            "max-glare": 0.3,   // Opacity of glare
            scale: 1.05         // Slight zoom on hover
        });
    }

    // Slideshow Script
    const slides = document.querySelectorAll('.hero-slide');
    let currentSlide = 0;
    const slideInterval = 5000;

    function nextSlide() {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }

    if(slides.length > 0) {
        setInterval(nextSlide, slideInterval);
    }
</script>

<?php require_once '../includes/footer.php'; ?>
