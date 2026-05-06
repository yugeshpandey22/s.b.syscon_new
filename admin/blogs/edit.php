<?php
// admin/blogs/edit.php
require_once '../includes/auth.php';
require_once '../../config/database.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: manage.php");
    exit();
}

// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->execute([$id]);
$blog = $stmt->fetch();

if (!$blog) {
    header("Location: manage.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $slug = $_POST['slug'] ?: strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    $category = $_POST['category'];
    $summary = $_POST['summary'];
    $content = $_POST['content'];
    $status = $_POST['status'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $author = $_POST['author'] ?: 'Admin';
    
    $image_path = $blog['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../../assets/images/blog/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $file_name = time() . '_' . $slug . '.' . $file_ext;
        $target_file = $upload_dir . $file_name;
        
        require_once '../../includes/image_helper.php';
        
        if (compressImage($_FILES['image']['tmp_name'], $target_file, 75, 1200)) {
            // Delete old image if exists
            if ($image_path && file_exists('../../' . $image_path)) {
                unlink('../../' . $image_path);
            }
            $image_path = 'assets/images/blog/' . $file_name;
        }
    }

    try {
        $stmt = $conn->prepare("UPDATE blogs SET title = ?, slug = ?, category = ?, summary = ?, content = ?, image = ?, author = ?, status = ?, meta_title = ?, meta_description = ?, meta_keywords = ?, is_featured = ? WHERE id = ?");
        $stmt->execute([$title, $slug, $category, $summary, $content, $image_path, $author, $status, $meta_title, $meta_description, $meta_keywords, $is_featured, $id]);
        header("Location: manage.php?msg=updated");
        exit();
    } catch (PDOException $e) {
        $error = "Error updating blog: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Blog Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable { min-height: 400px; }
        .form-section { background: #fff; border-radius: 8px; padding: 25px; margin-bottom: 25px; border: 1px solid #dee2e6; }
        .section-title { font-size: 1rem; font-weight: 700; color: #333; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        label { font-weight: 600; font-size: 0.9rem; color: #555; }
        .form-control:focus, .form-select:focus { border-color: #0d6efd; box-shadow: none; }
        .current-img { border: 1px solid #eee; padding: 5px; border-radius: 4px; max-width: 100%; height: auto; margin-bottom: 15px; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Edit Blog Post</h2>
        <a href="manage.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to Blogs</a>
    </div>

    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <!-- Basic Information -->
        <div class="form-section shadow-sm">
            <div class="section-title text-uppercase small text-muted">Blog Content</div>
            
            <div class="mb-3">
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($blog['title']); ?>" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                    <input type="text" name="slug" class="form-control" value="<?php echo htmlspecialchars($blog['slug']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category" class="form-select" required>
                        <option value="Industrial" <?php echo ($blog['category'] == 'Industrial') ? 'selected' : ''; ?>>Industrial</option>
                        <option value="Automation" <?php echo ($blog['category'] == 'Automation') ? 'selected' : ''; ?>>Automation</option>
                        <option value="Electrical" <?php echo ($blog['category'] == 'Electrical') ? 'selected' : ''; ?>>Electrical</option>
                        <option value="Success Stories" <?php echo ($blog['category'] == 'Success Stories') ? 'selected' : ''; ?>>Success Stories</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Short Summary</label>
                <textarea name="summary" class="form-control" rows="2"><?php echo htmlspecialchars($blog['summary']); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Content <span class="text-danger">*</span></label>
                <textarea id="content" name="content" class="form-control"><?php echo htmlspecialchars($blog['content']); ?></textarea>
            </div>
        </div>

        <!-- Media & Settings -->
        <div class="row">
            <div class="col-lg-8">
                <div class="form-section shadow-sm">
                    <div class="section-title text-uppercase small text-muted">SEO Settings</div>
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="<?php echo htmlspecialchars($blog['meta_title'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3"><?php echo htmlspecialchars($blog['meta_description'] ?? ''); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control" value="<?php echo htmlspecialchars($blog['meta_keywords'] ?? ''); ?>">
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-section shadow-sm">
                    <div class="section-title text-uppercase small text-muted">Publishing</div>
                    <div class="mb-3">
                        <label class="form-label d-block">Featured Image</label>
                        <?php if ($blog['image']): ?>
                            <img src="../../<?php echo htmlspecialchars($blog['image']); ?>" class="current-img mb-2 shadow-sm">
                        <?php endif; ?>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted d-block mt-1">Upload new to replace current image.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="published" <?php echo ($blog['status'] == 'published') ? 'selected' : ''; ?>>Published</option>
                            <option value="draft" <?php echo ($blog['status'] == 'draft') ? 'selected' : ''; ?>>Draft</option>
                        </select>
                    </div>
                    <div class="mb-3 form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" <?php echo ($blog['is_featured']) ? 'checked' : ''; ?>>
                        <label class="form-check-label ms-2" for="is_featured">Mark as Featured</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Author Name</label>
                        <input type="text" name="author" class="form-control" value="<?php echo htmlspecialchars($blog['author']); ?>">
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold"><i class="fas fa-sync-alt me-2"></i> Update Blog Post</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    // Initialize CKEditor
    let blogEditor;
    ClassicEditor
        .create(document.querySelector('#content'))
        .then(editor => {
            blogEditor = editor;
        })
        .catch(error => {
            console.error(error);
        });

    // Ensure textarea is updated before form submit
    document.querySelector('form').addEventListener('submit', function(e) {
        if (blogEditor) {
            const data = blogEditor.getData();
            document.querySelector('#content').value = data;
        }
    });
</script>
</body>
</html>
