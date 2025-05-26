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
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// Function to generate and download Excel report
if (isset($_POST['download_applicant_report'])) {
    // Create new Spreadsheet
    $spreadsheet = new Spreadsheet();   
    
    // Remove default sheet (we'll create our own)
    $spreadsheet->removeSheetByIndex(0);
    
    // Database connection
    $conn = new mysqli("localhost", "root", "", "pesoo");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get applicant data grouped by company
    $query = "SELECT 
                aj.id, 
                aj.applicant_id, 
                aj.job_posting_id, 
                aj.application_date, 
                aj.status, 
                aj.job,
                ap.fname, 
                ap.lname, 
                ap.email, 
                ap.contact_no,
                jp.company_name,
                jp.job_title
              FROM applied_job aj
              JOIN applicant_profile ap ON aj.applicant_id = ap.id
              JOIN job_post jp ON aj.job_posting_id = jp.id
              ORDER BY jp.company_name, ap.lname, ap.fname";
    
    $result = $conn->query($query);
    
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    // Group data by company
    $companies = [];
    while ($row = $result->fetch_assoc()) {
        $companyName = $row['company_name'];
        if (!isset($companies[$companyName])) {
            $companies[$companyName] = [];
        }
        $companies[$companyName][] = $row;
    }

    // Create a worksheet for each company
    foreach ($companies as $companyName => $applicants) {
        // Add new worksheet
        $sheet = new Worksheet($spreadsheet, substr($companyName, 0, 31));
        $spreadsheet->addSheet($sheet);
        $spreadsheet->setActiveSheetIndexByName(substr($companyName, 0, 31));
        $sheet = $spreadsheet->getActiveSheet();

        // Set company header
        $sheet->setCellValue('A1', 'Company: ' . $companyName);
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true);

        // Set column headers
        $headers = [
            'A' => 'Applicant Name',
            'B' => 'Email',
            'C' => 'Contact No',
            'D' => 'Job Applied',
            'E' => 'Application Date',
            'F' => 'Status'
        ];

        $rowNum = 3;
        foreach ($headers as $col => $header) {
            $sheet->setCellValue($col . $rowNum, $header);
        }

        // Style headers
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DDDDDD']]
        ];
        $sheet->getStyle('A3:F3')->applyFromArray($headerStyle);

        // Add applicant data
        $rowNum = 4;
        foreach ($applicants as $applicant) {
            $sheet->setCellValue('A' . $rowNum, $applicant['lname'] . ', ' . $applicant['fname']);
            $sheet->setCellValue('B' . $rowNum, $applicant['email']);
            $sheet->setCellValue('C' . $rowNum, $applicant['contact_no']);
            $sheet->setCellValue('D' . $rowNum, $applicant['job_title']);
            $sheet->setCellValue('E' . $rowNum, $applicant['application_date']);
            $sheet->setCellValue('F' . $rowNum, $applicant['status']);
            $rowNum++;
        }

        // Auto-size columns
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }

    // Set first sheet as active
    $spreadsheet->setActiveSheetIndex(0);

    // Save and download
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="applicant_report_by_company.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
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