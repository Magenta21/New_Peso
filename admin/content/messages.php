<?php
// Database connection
require_once '../db.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_news'])) {
        // Create news
        $title = $_POST['title'];
        $description = $_POST['description'];
        $content = $_POST['content'];
        $schedule_date = $_POST['schedule_date'];
        $status = $_POST['status'];
        
        // Handle image upload
        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/news/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $imageName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $image = 'uploads/news/' . $imageName;
            }
        }
        
        $stmt = $conn->prepare("INSERT INTO news (title, image, description, content, schedule_date, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $title, $image, $description, $content, $schedule_date, $status);
        $stmt->execute();
        $success = "News created successfully!";
    }
    
    if (isset($_POST['update_news'])) {
        // Update news
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $content = $_POST['content'];
        $schedule_date = $_POST['schedule_date'];
        $status = $_POST['status'];
        
        // Handle image update
        $image = $_POST['current_image'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/news/';
            $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $imageName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Delete old image if exists
                if ($image && file_exists("../$image")) {
                    unlink("../$image");
                }
                $image = 'uploads/news/' . $imageName;
            }
        }
        
        $stmt = $conn->prepare("UPDATE news SET title=?, image=?, description=?, content=?, schedule_date=?, status=?, updated_at=NOW() WHERE id=?");
        $stmt->bind_param("ssssssi", $title, $image, $description, $content, $schedule_date, $status, $id);
        $stmt->execute();
        $success = "News updated successfully!";
    }
    
    if (isset($_POST['delete_news'])) {
        // Delete news
        $id = $_POST['id'];
        
        // First get image path to delete file
        $stmt = $conn->prepare("SELECT image FROM news WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $news = $result->fetch_assoc();
        
        if ($news['image'] && file_exists("../".$news['image'])) {
            unlink("../".$news['image']);
        }
        
        $stmt = $conn->prepare("DELETE FROM news WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $success = "News deleted successfully!";
    }
}

// Get all news for listing
$news = [];
$result = $conn->query("SELECT * FROM news ORDER BY schedule_date DESC, created_at DESC");
if ($result) {
    $news = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<div class="page-header">
    <h1>News Management</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNewsModal">
        <i class="fas fa-plus"></i> Add News
    </button>
</div>

<?php if (isset($success)): ?>
<div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Scheduled Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($news as $item): ?>
            <tr>
                <td>
                    <?php if ($item['image']): ?>
                    <img src="../<?= htmlspecialchars($item['image']) ?>" alt="News Image" style="max-width: 100px; max-height: 60px;">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($item['title']) ?></td>
                <td><?= htmlspecialchars(substr($item['description'], 0, 50)) ?>...</td>
                <td><?= $item['schedule_date'] ? date('M d, Y', strtotime($item['schedule_date'])) : 'Not scheduled' ?></td>
                <td>
                    <span class="badge bg-<?= 
                        $item['status'] === 'published' ? 'success' : 
                        ($item['status'] === 'draft' ? 'warning' : 'secondary') 
                    ?>">
                        <?= ucfirst($item['status']) ?>
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-primary edit-news" data-id="<?= $item['id'] ?>">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <button type="submit" name="delete_news" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Create News Modal -->
<div class="modal fade" id="createNewsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New News</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Short Description</label>
                        <textarea class="form-control" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea class="form-control" name="content" rows="6"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Schedule Date</label>
                            <input type="date" class="form-control" name="schedule_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="create_news" class="btn btn-primary">Save News</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit News Modal -->
<div class="modal fade" id="editNewsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit News</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_id">
                <input type="hidden" name="current_image" id="edit_current_image">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" id="edit_title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        <div id="edit_image_preview" class="mt-2"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Short Description</label>
                        <textarea class="form-control" name="description" id="edit_description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea class="form-control" name="content" id="edit_content" rows="6"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Schedule Date</label>
                            <input type="date" class="form-control" name="schedule_date" id="edit_schedule_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" id="edit_status">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update_news" class="btn btn-primary">Update News</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Handle edit button clicks
document.querySelectorAll('.edit-news').forEach(button => {
    button.addEventListener('click', async function() {
        const id = this.getAttribute('data-id');
        
        try {
            const response = await fetch(`content/get_news.php?id=${id}`);
            const newsItem = await response.json();
            
            // Populate the edit form
            document.getElementById('edit_id').value = newsItem.id;
            document.getElementById('edit_title').value = newsItem.title;
            document.getElementById('edit_description').value = newsItem.description;
            document.getElementById('edit_content').value = newsItem.content;
            document.getElementById('edit_schedule_date').value = newsItem.schedule_date;
            document.getElementById('edit_status').value = newsItem.status;
            document.getElementById('edit_current_image').value = newsItem.image;
            
            // Show image preview if exists
            const previewDiv = document.getElementById('edit_image_preview');
            previewDiv.innerHTML = '';
            if (newsItem.image) {
                previewDiv.innerHTML = `
                    <p>Current Image:</p>
                    <img src="../${newsItem.image}" alt="Current Image" style="max-width: 200px;">
                `;
            }
            
            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('editNewsModal'));
            modal.show();
        } catch (error) {
            console.error('Error fetching news:', error);
            alert('Failed to load news data');
        }
    });
});
</script>