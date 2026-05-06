<?php
// admin/blogs/add.php
require_once '../includes/auth.php';
require_once '../../config/database.php';

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
    
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../../assets/images/blog/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $file_name = time() . '_' . $slug . '.' . $file_ext;
        $target_file = $upload_dir . $file_name;
        
        require_once '../../includes/image_helper.php';
        
        if (compressImage($_FILES['image']['tmp_name'], $target_file, 75, 1200)) {
            $image_path = 'assets/images/blog/' . $file_name;
        }
    }

    try {
        $stmt = $conn->prepare("INSERT INTO blogs (title, slug, category, summary, content, image, author, status, meta_title, meta_description, meta_keywords, is_featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $slug, $category, $summary, $content, $image_path, $author, $status, $meta_title, $meta_description, $meta_keywords, $is_featured]);
        header("Location: manage.php?msg=added");
        exit();
    } catch (PDOException $e) {
        $error = "Error adding blog: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Blog Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable { min-height: 400px; }
        .form-section { background: #fff; border-radius: 8px; padding: 25px; margin-bottom: 25px; border: 1px solid #dee2e6; }
        .section-title { font-size: 1rem; font-weight: 700; color: #333; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        label { font-weight: 600; font-size: 0.9rem; color: #555; }
        .form-control:focus, .form-select:focus { border-color: #0d6efd; box-shadow: none; }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Create New Blog Post</h2>
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
                <input type="text" name="title" class="form-control" placeholder="Enter blog title" required id="title-input">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                    <input type="text" name="slug" class="form-control" placeholder="auto-generated-from-title" id="slug-input">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category" class="form-select" required>
                        <option value="">Select Category</option>
                        <option value="Industrial">Industrial</option>
                        <option value="Automation">Automation</option>
                        <option value="Electrical">Electrical</option>
                        <option value="Success Stories">Success Stories</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Short Summary</label>
                <textarea name="summary" class="form-control" rows="2" placeholder="Short description for listing page"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Content <span class="text-danger">*</span></label>
                <textarea id="content" name="content" class="form-control"></textarea>
            </div>
        </div>

        <!-- Media & Settings -->
        <div class="row">
            <div class="col-lg-8">
                <div class="form-section shadow-sm">
                    <div class="section-title text-uppercase small text-muted">SEO Settings</div>
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" placeholder="SEO Title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3" placeholder="SEO Meta Description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control" placeholder="Keyword 1, Keyword 2, Keyword 3">
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-section shadow-sm">
                    <div class="section-title text-uppercase small text-muted">Publishing</div>
                    <div class="mb-3">
                        <label class="form-label">Featured Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                    <div class="mb-3 form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured">
                        <label class="form-check-label ms-2" for="is_featured">Mark as Featured</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Author Name</label>
                        <input type="text" name="author" class="form-control" value="Admin">
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold"><i class="fas fa-save me-2"></i> Create Blog Post</button>
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

    // Auto-generate slug from title
    document.getElementById('title-input').addEventListener('input', function() {
        let title = this.value;
        let slug = title.toLowerCase()
                        .trim()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/[\s_-]+/g, '-')
                        .replace(/^-+|-+$/g, '');
        document.getElementById('slug-input').value = slug;
    });
</script>
</body>
</html>
