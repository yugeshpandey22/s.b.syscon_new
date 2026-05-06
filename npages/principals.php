<?php
require_once '../config/database.php'; // Added database connection
require_once '../includes/head.php';
require_once '../includes/navbar.php';
?>

<link rel="stylesheet" href="../assets/css/principals.css">

<!-- Page Header -->
<section class="page-header py-5 position-relative">
    <!-- Animated Background Image (Video Style) -->
    <div class="page-header-bg"></div>
    
    <!-- Dark Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.5;"></div>
    
    <!-- Content -->
    <div class="container position-relative z-index-1 h-100 d-flex flex-column justify-content-center align-items-center text-center">
        <h1 class="display-3 fw-bold text-white text-uppercase" style="letter-spacing: 3px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Our Principals</h1>
        <div class="bg-primary mt-3 mb-4 rounded-pill" style="width: 100px; height: 5px;"></div>
        <p class="lead text-white fw-light fs-4" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">Connecting You to Global Engineering Excellence</p>
    </div>
</section>




<section class="certificates-section py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="text-secondary fw-bold display-6">Authorization Certificates</h2>
            <div class="bg-secondary mx-auto mt-2 rounded-pill" style="width: 80px; height: 3px;"></div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php
            try {
                // Fetch certificates
                $stmt = $conn->query("SELECT * FROM certificates");
                $certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Custom Sorting Order
                $orderMap = [
                    'SIEMENS' => 1,
                    'SINOVA' => 2,
                    'INNOMOTICS' => 3,
                    'FLENDER' => 4,
                    'SECURE' => 5,
                    'LAPP' => 6,
                    'ASCO' => 7,
                    'BCH' => 8
                ];

                usort($certificates, function($a, $b) use ($orderMap) {
                    $nameA = strtoupper($a['brand_name']);
                    $nameB = strtoupper($b['brand_name']);
                    
                    // Find priority
                    $pA = 999;
                    $pB = 999;
                    
                    foreach ($orderMap as $key => $val) {
                        if (strpos($nameA, $key) !== false) $pA = $val;
                    }
                    foreach ($orderMap as $key => $val) {
                        if (strpos($nameB, $key) !== false) $pB = $val;
                    }
                    
                    return $pA - $pB;
                });

                if (count($certificates) > 0) {
                    foreach ($certificates as $cert) {
                        $brandName = htmlspecialchars($cert['brand_name']);
                        $logoPath = $cert['brand_logo'];
                        $pdfPath = $cert['certificate_file'];

                        // Fix relative paths
                        if (!empty($logoPath) && strpos($logoPath, 'http') === false && strpos($logoPath, '../') !== 0 && strpos($logoPath, './') !== 0) {
                            $logoPath = '../' . $logoPath;
                        }
                        if (!empty($pdfPath) && strpos($pdfPath, 'http') === false && strpos($pdfPath, '../') !== 0 && strpos($pdfPath, './') !== 0) {
                            $pdfPath = '../' . $pdfPath;
                        }

                        $logoPath = htmlspecialchars($logoPath);
                        $pdfPath = htmlspecialchars($pdfPath);
                        
                        // Specific Logo Overrides for consistency
                        $imgStyle = '';
                        $upperName = strtoupper($brandName);

                        if (strpos($upperName, 'SIEMENS') !== false) {
                            $logoPath = '../assets/images/siemens-logo-2025.png';
                        } elseif (strpos($upperName, 'SINOVA') !== false || strpos($upperName, 'SINOPLUS') !== false) {
                            $logoPath = '../assets/images2/sinoplus.jpg';
                        } elseif (strpos($upperName, 'INNOMOTICS') !== false) {
                            $logoPath = '../assets/images2/innomotics_new.png';
                        } elseif (strpos($upperName, 'FLENDER') !== false) {
                            $logoPath = '../assets/images2/flender_new.png'; // Correct Flender Logo
                        } elseif (strpos($upperName, 'SECURE') !== false) {
                             $logoPath = '../assets/images/secure-logo-large.png'; // Correct Secure Logo
                             $imgStyle = 'style="max-height: 110px;"';
                        } elseif (strpos($upperName, 'LAPP') !== false) {
                            $logoPath = '../assets/images2/lapp_new.png';
                        } elseif (strpos($upperName, 'ASCO') !== false) {
                            $logoPath = '../assets/images2/asco_new.png';
                        } elseif (strpos($upperName, 'BCH') !== false) {
                            $logoPath = '../assets/images2/bch_final.png';
                        }
            ?>
            <div class="col">
                <div class="principal-card">
                    <div class="p-logo-area">
                        <img src="<?php echo $logoPath; ?>" alt="<?php echo $brandName; ?>" class="img-fluid brand-logo" <?php echo $imgStyle; ?>>
                    </div>
                    <a href="<?php echo $pdfPath; ?>" target="_blank" class="btn btn-cert">
                        <i class="fas fa-download mb-1"></i> 
                        <span>Authorization<br>Certificate</span>
                    </a>
                </div>
            </div>
            <?php
                    }
                } else {
                    echo '<div class="col-12"><p class="text-center text-muted">No certificates found.</p></div>';
                }
            } catch(PDOException $e) {
                echo '<div class="col-12"><p class="text-center text-danger">Error loading certificates.</p></div>';
            }
            ?>
        </div>
    </div>

</section>


<!-- Our Principals List Section -->
<section class="principals-list-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5 mw-800 mx-auto">
            <h2 class="text-danger fw-bold display-6 mb-3">Our Principals</h2>
            <div class="bg-danger mx-auto mt-2 rounded-pill mb-4" style="width: 80px; height: 3px;"></div>
            <p class="text-muted lead fs-6">
                At S.B. Syscon Pvt. Ltd., we are proud to be Authorised Channel Partners for some of the most respected and trusted global brands in the industrial sector. These long-standing associations reflect our commitment to delivering world-class quality, technical excellence, and dependable service to our customers.
            </p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
            <!-- Brand 1: Siemens -->
            <div class="col">
                <div class="tilt-card-principal h-100 bg-white">
                    <div class="card-content">
                        <i class="fas fa-bolt fa-3x text-danger mb-4 transform-3d"></i>
                        <h5 class="fw-bold text-dark lh-base transform-3d">Siemens – Low Voltage Switchgear and Control Products</h5>
                    </div>
                </div>
            </div>

            <!-- Brand 2: Sinoplus -->
            <div class="col">
                <div class="tilt-card-principal h-100 bg-white">
                    <div class="card-content">
                        <i class="fas fa-microchip fa-3x text-danger mb-4 transform-3d"></i>
                        <h5 class="fw-bold text-dark lh-base transform-3d">SINOPLUS – Switchgears <br><small class="text-muted fw-normal">(Formerly Sinova)</small></h5>
                    </div>
                </div>
            </div>

            <!-- Brand 3: Innomotics -->
            <div class="col">
                <div class="tilt-card-principal h-100 bg-white">
                    <div class="card-content">
                        <i class="fas fa-industry fa-3x text-danger mb-4 transform-3d"></i>
                        <h5 class="fw-bold text-dark lh-base transform-3d">Innomotics – Industrial Motors <br><small class="text-muted fw-normal">(formerly Siemens Motors)</small></h5>
                    </div>
                </div>
            </div>

            <!-- Brand 4: Flender -->
            <div class="col">
                <div class="tilt-card-principal h-100 bg-white">
                    <div class="card-content">
                        <i class="fas fa-cogs fa-3x text-danger mb-4 transform-3d"></i>
                        <h5 class="fw-bold text-dark lh-base transform-3d">Flender – Heavy-Duty Gearboxes and Couplings</h5>
                    </div>
                </div>
            </div>

            <!-- Brand 5: Secure -->
            <div class="col">
                <div class="tilt-card-principal h-100 bg-white">
                    <div class="card-content">
                        <i class="fas fa-battery-full fa-3x text-danger mb-4 transform-3d"></i>
                        <h5 class="fw-bold text-dark lh-base transform-3d">Secure Meters – Energy Management and Metering Solutions</h5>
                    </div>
                </div>
            </div>

            <!-- Brand 6: BCH -->
            <div class="col">
                <div class="tilt-card-principal h-100 bg-white">
                    <div class="card-content">
                        <i class="fas fa-box fa-3x text-danger mb-4 transform-3d"></i>
                        <h5 class="fw-bold text-dark lh-base transform-3d">BCH Electric – Industrial Products and Enclosures</h5>
                    </div>
                </div>
            </div>

            <!-- Brand 7: ASCO -->
            <div class="col">
                <div class="tilt-card-principal h-100 bg-white">
                    <div class="card-content">
                        <i class="fas fa-power-off fa-3x text-danger mb-4 transform-3d"></i>
                        <h5 class="fw-bold text-dark lh-base transform-3d">ASCO (Schneider Electric) – Automatic Transfer Switches and Power Switching Solutions</h5>
                    </div>
                </div>
            </div>

            <!-- Brand 8: Lapp -->
            <div class="col">
                <div class="tilt-card-principal h-100 bg-white">
                    <div class="card-content">
                        <i class="fas fa-plug fa-3x text-danger mb-4 transform-3d"></i>
                        <h5 class="fw-bold text-dark lh-base transform-3d">Lapp Cables – High Performance Wires and Cables for Industrial Applications</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mw-800 mx-auto">
            <p class="text-dark fs-6">
                Through these collaborations, we act as a vital link between world-class manufacturers and our wide customer base, ensuring that end users receive genuine products, expert support, and unmatched reliability.
            </p>
        </div>
    </div>
</section>

<!-- 3D Animation Scripts & Styles -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Universal 3D Tilt Script
        const cards = document.querySelectorAll(".tilt-card-principal");

        cards.forEach(card => {
            card.addEventListener("mousemove", (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                // Sensitivity - Higher number = less tilt
                const rotateX = ((y - centerY) / centerY) * -10; 
                const rotateY = ((x - centerX) / centerX) * 10;

                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
            });

            card.addEventListener("mouseleave", () => {
                card.style.transform = "perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)";
            });
        });
    });
</script>



<?php require_once '../includes/footer.php'; ?>
