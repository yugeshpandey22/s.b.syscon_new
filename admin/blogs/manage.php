<?php
// admin/blogs/manage.php
require_once '../includes/auth.php';
require_once '../../config/database.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Optional: Delete image file from server too if needed
    $stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage.php?msg=deleted");
    exit();
}

try {
    $stmt = $conn->query("SELECT * FROM blogs ORDER BY created_at DESC");
    $blogs = $stmt->fetchAll();
} catch (PDOException $e) {
    if ($e->getCode() == '42S02' || strpos($e->getMessage(), '1146') !== false) {
        $createSql = "CREATE TABLE IF NOT EXISTS blogs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            category VARCHAR(100),
            summary TEXT,
            content TEXT NOT NULL,
            image VARCHAR(255),
            author VARCHAR(100) DEFAULT 'Admin',
            status ENUM('draft', 'published') DEFAULT 'published',
            meta_title VARCHAR(255),
            meta_description TEXT,
            meta_keywords TEXT,
            is_featured TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        
        $conn->exec($createSql);
        $blogs = [];
    } else {
        throw $e;
    }
}

// Ensure columns exist (Migration)
$columns_to_add = [
    'category' => "VARCHAR(100) AFTER slug",
    'meta_title' => "VARCHAR(255) AFTER status",
    'meta_description' => "TEXT AFTER meta_title",
    'meta_keywords' => "TEXT AFTER meta_description",
    'is_featured' => "TINYINT(1) DEFAULT 0 AFTER meta_keywords"
];

foreach ($columns_to_add as $col => $definition) {
    try {
        $conn->query("SELECT $col FROM blogs LIMIT 1");
    } catch (Exception $e) {
        try {
            $conn->exec("ALTER TABLE blogs ADD COLUMN $col $definition");
        } catch (Exception $e2) {
            // Ignore if already exists (secondary check)
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Blogs - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .blog-img { width: 80px; height: 50px; object-fit: cover; border-radius: 4px; }
        .badge-published { background-color: #28a745; }
        .badge-draft { background-color: #ffc107; color: #000; }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
        <h2 class="m-0"><i class="fas fa-blog text-danger me-2"></i> Manage Blogs</h2>
        <div>
            <a href="add.php" class="btn btn-success me-2"><i class="fas fa-plus"></i> Add New Post</a>
            <a href="../dashboard.php" class="btn btn-secondary">Dashboard</a>
        </div>
    </div>

    <?php if(isset($_GET['msg']) && $_GET['msg']=='deleted'): ?>
        <div class="alert alert-success alert-dismissible fade show">
            Blog deleted successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Created</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($blogs)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No blog posts found. Click "Add New Post" to start.</td>
                    </tr>
                    <?php endif; ?>
                    <?php foreach ($blogs as $blog): ?>
                    <tr>
                        <td class="ps-3"><?php echo $blog['id']; ?></td>
                        <td>
                            <?php if ($blog['image']): ?>
                                <img src="../../<?php echo htmlspecialchars($blog['image']); ?>" class="blog-img">
                            <?php else: ?>
                                <div class="blog-img bg-secondary d-flex align-items-center justify-content-center text-white small">No Image</div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="fw-bold"><?php echo htmlspecialchars($blog['title']); ?></div>
                            <small class="text-muted"><?php echo htmlspecialchars($blog['slug']); ?></small>
                        </td>
                        <td><?php echo htmlspecialchars($blog['author']); ?></td>
                        <td>
                            <span class="badge badge-<?php echo $blog['status']; ?>">
                                <?php echo ucfirst($blog['status']); ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <?php if ($blog['is_featured']): ?>
                                <i class="fas fa-star text-warning" title="Featured"></i>
                            <?php else: ?>
                                <i class="far fa-star text-muted"></i>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date('M d, Y', strtotime($blog['created_at'])); ?></td>
                        <td class="text-end pe-3">
                            <a href="edit.php?id=<?php echo $blog['id']; ?>" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></a>
                            <a href="manage.php?delete=<?php echo $blog['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this post?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
