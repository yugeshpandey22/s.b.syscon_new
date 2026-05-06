<?php
require_once '../config/database.php';

$slug = $_GET['slug'] ?? null;
if (!$slug) {
    header("Location: blog.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM blogs WHERE slug = ? AND status = 'published'");
$stmt->execute([$slug]);
$blog = $stmt->fetch();

if (!$blog) {
    header("Location: blog.php");
    exit();
}

// Set SEO Variables for head.php
$page_title = ($blog['meta_title'] ?: $blog['title']) . " | S.B. Syscon";
$meta_description = $blog['meta_description'] ?: $blog['summary'];
$meta_keywords = $blog['meta_keywords'];

require_once '../includes/head.php';
require_once '../includes/navbar.php';
?>

<link rel="stylesheet" href="../assets/css/blog.css">

<article class="py-5">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-9">


                <h1 class="display-4 fw-bold mb-3 text-dark"><?php echo htmlspecialchars($blog['title']); ?></h1>
                
                <div class="d-flex align-items-center mb-4 text-muted small">
                    <span class="badge bg-danger me-3 px-3"><?php echo htmlspecialchars($blog['category']); ?></span>
                    <span class="me-3"><i class="fas fa-user-edit me-1"></i> <?php echo htmlspecialchars($blog['author']); ?></span>
                    <span class="me-3"><i class="far fa-calendar-alt me-1"></i> <?php echo date('F d, Y', strtotime($blog['created_at'])); ?></span>
                </div>

                <?php if ($blog['image']): ?>
                    <img src="../<?php echo htmlspecialchars($blog['image']); ?>" class="img-fluid rounded-4 shadow-sm mb-5 w-100" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                <?php endif; ?>

                <div class="blog-details-content">
                    <?php echo $blog['content']; ?>
                </div>

                <hr class="my-5">
                
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="share-box">
                        <span class="fw-bold me-3">Share this post:</span>
                        <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle me-1"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle me-1"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <a href="blog.php" class="btn btn-outline-danger btn-lg px-4 rounded-pill">
                        <i class="fas fa-chevron-left me-2"></i> Back to All Posts
                    </a>
                </div>
            </div>
        </div>
    </div>
</article>

<?php require_once '../includes/footer.php'; ?>
