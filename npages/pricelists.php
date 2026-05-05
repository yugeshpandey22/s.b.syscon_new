<?php
require_once '../includes/head.php';
require_once '../includes/navbar.php';
?> 

<!-- AOS For Animations -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<!-- Hero Section with Custom Background -->
<section class="pricelist-hero d-flex align-items-center justify-content-center text-center text-white animate-bg-pulse" style="background: url('../assets/images/pricelist_new_banner.jpg') no-repeat center center; background-size: cover; min-height: 400px; position: relative;">
    <!-- Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7));"></div>
    
    <div class="container position-relative" style="z-index: 2;" data-aos="zoom-in">
        <h1 class="display-3 fw-bold text-uppercase mb-4" style="font-family: 'Impact', sans-serif; letter-spacing: 2px; text-shadow: 0 5px 15px rgba(0,0,0,0.8);">DOWNLOAD ALL PRICE LISTS !</h1>
        
        <!-- PDF Icon Styled to match reference -->
        <div class="d-inline-block mt-2">
             <i class="fas fa-file-pdf text-danger bg-white rounded shadow-lg" style="font-size: 6rem; padding: 10px 20px;"></i>
             <div class="mt-2 text-white fw-bold">PDF</div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="../assets/css/pricelists.css">

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>


<section class="py-5 bg-light">
    <div class="container">
        <!-- Section Header -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <span class="text-danger fw-bold text-uppercase ls-2">Documentation</span>
                <h2 class="display-6 fw-bold mt-2">Product Price Lists</h2>
                <div class="bg-danger mx-auto mt-3" style="width: 60px; height: 3px;"></div>
                <p class="text-muted mt-3">Access and download the latest official price lists from our principals.</p>
            </div>
        </div>

        <?php
        require_once '../config/database.php';

        // Fetch data
        $sql = "SELECT p.id, p.name, p.logo, pl.title, pl.file_path 
                FROM principals p 
                LEFT JOIN price_lists pl ON p.id = pl.principal_id 
                ORDER BY p.id ASC";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $principals = [];
        foreach ($results as $row) {
            // Fix for SINOVA and INNOMOTICS logos
            if (stripos($row['name'], 'SINOVA') !== false) {
                $row['logo'] = '../assets/images2/sinoplus.jpg';
            }
            if (stripos($row['name'], 'INNOMOTICS') !== false) {
                $row['logo'] = '../assets/images2/innomotics.png';
            }

            // Fix relative paths
            if (!empty($row['logo']) && strpos($row['logo'], 'http') === false && strpos($row['logo'], '../') !== 0 && strpos($row['logo'], './') !== 0) {
                $row['logo'] = '../' . $row['logo'];
            }

            if (!isset($principals[$row['id']])) {
                $principals[$row['id']] = [
                    'name' => $row['name'],
                    'logo' => $row['logo'],
                    'lists' => []
                ];
            }
            if ($row['title']) {
                $filePath = $row['file_path'];
                if (strpos($filePath, 'http') === false && strpos($filePath, '../') !== 0 && strpos($filePath, './') !== 0) {
                    $filePath = '../' . $filePath;
                }
                $principals[$row['id']]['lists'][] = [
                    'title' => $row['title'],
                    'file_path' => $filePath
                ];
            }
        }
        ?>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php if(empty($principals)): ?>
                    <div class="text-center py-5">
                        <div class="display-1 text-muted mb-3 opacity-25"><i class="fas fa-folder-open"></i></div>
                        <h4 class="text-muted">No price lists available.</h4>
                    </div>
                <?php else: ?>
                    
                    <?php foreach($principals as $p): ?>
                    <div class="principal-card d-flex" data-aos="fade-up" data-aos-duration="800">
                        <!-- Left: Brand Identity -->
                        <div class="brand-section">
                            <?php if(!empty($p['logo'])): ?>
                                <img src="<?php echo htmlspecialchars($p['logo']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" class="img-fluid" style="max-height: 120px; max-width: 280px;">
                            <?php else: ?>
                                <h4 class="mb-0 fw-bold text-dark"><?php echo htmlspecialchars($p['name']); ?></h4>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Right: Actionable Items -->
                        <div class="pdf-section">
                            <div class="d-flex flex-wrap gap-3 w-100 justify-content-start">
                                <?php if(empty($p['lists'])): ?>
                                    <span class="text-muted small fst-italic"><i class="fas fa-info-circle me-1"></i> Coming Soon</span>
                                <?php else: ?>
                                    <?php foreach($p['lists'] as $list): ?>
                                        <a href="<?php echo htmlspecialchars($list['file_path']); ?>" target="_blank" class="pdf-btn shadow-sm">
                                            <i class="fas fa-file-pdf pdf-icon"></i>
                                            <span><?php echo htmlspecialchars($list['title']); ?></span>
                                            <i class="fas fa-download ms-auto small opacity-50"></i>
                                        </a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
