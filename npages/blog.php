<?php
require_once '../config/database.php';
require_once '../includes/head.php';
require_once '../includes/navbar.php';

// Fetch published blogs
$stmt = $conn->query("SELECT * FROM blogs WHERE status = 'published' ORDER BY created_at DESC");
$blogs = $stmt->fetchAll();
?>

<link rel="stylesheet" href="../assets/css/blog.css">

<!-- Blog Hero -->
<section class="blog-hero text-white">
    <div class="container">
        <h1 class="display-3 fw-bold mb-3" data-aos="fade-down">Our Insights & News</h1>
        <p class="lead opacity-75" data-aos="fade-up">Stay updated with the latest in industrial technology, automation, and electrical solutions.</p>
    </div>
</section>

<!-- Blog List -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <?php if (empty($blogs)): ?>
        <div class="text-center py-5">
            <i class="fas fa-newspaper fa-4x text-muted mb-4"></i>
            <h3>No blog posts available yet.</h3>
            <p class="text-muted">Check back soon for exciting updates!</p>
            <a href="index.php" class="btn btn-danger mt-3">Back to Home</a>
        </div>
        <?php else: ?>
        <div class="row g-4">
            <?php foreach ($blogs as $blog): ?>
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <article class="blog-card h-100 shadow-sm border-0 position-relative">
                    <a href="blog-details.php?slug=<?php echo $blog['slug']; ?>">
                        <?php if ($blog['image']): ?>
                            <img src="../<?php echo htmlspecialchars($blog['image']); ?>" class="blog-card-img" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                        <?php else: ?>
                            <div class="blog-card-img bg-dark d-flex align-items-center justify-content-center text-white">
                                <i class="fas fa-image fa-3x opacity-25"></i>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($blog['is_featured']): ?>
                            <div class="position-absolute top-0 end-0 m-3 badge bg-danger shadow-sm">
                                <i class="fas fa-star me-1"></i> Featured
                            </div>
                        <?php endif; ?>
                    </a>
                    <div class="card-body p-4">
                        <div class="blog-category mb-2"><?php echo htmlspecialchars($blog['category']); ?></div>
                        <h3 class="blog-title">
                            <a href="blog-details.php?slug=<?php echo $blog['slug']; ?>" class="text-dark text-decoration-none">
                                <?php echo htmlspecialchars($blog['title']); ?>
                            </a>
                        </h3>
                        <p class="blog-summary">
                            <?php echo htmlspecialchars(mb_strimwidth($blog['summary'], 0, 120, "...")); ?>
                        </p>
                        <div class="blog-meta mt-3 d-flex justify-content-between align-items-center">
                            <span><i class="far fa-calendar-alt me-1"></i> <?php echo date('M d, Y', strtotime($blog['created_at'])); ?></span>
                            <a href="blog-details.php?slug=<?php echo $blog['slug']; ?>" class="read-more-btn">
                                Read More <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
