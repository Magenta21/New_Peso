<?php
// Database connection
$db = new mysqli('localhost', 'root', '', 'pesoo');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>

<div class="page-header">
    <h1>Training Management</h1>
    <div class="date-time"></div>
</div>

<div class="training-management-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Training Programs</h2>
        <button id="createModuleBtn" class="btn-primary" style="padding: 10px 15px;">
            <i class="fas fa-plus"></i> Create New Module
        </button>
    </div>
    
    <div class="training-cards" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        <?php
        // Training programs data
        $trainings = [
            [
                'name' => 'Computer Literacy',
                'icon' => 'fas fa-laptop-code',
                'color' => '#3498db',
                'table' => 'computer_lit'
            ],
            [
                'name' => 'Dressmaking',
                'icon' => 'fas fa-tshirt',
                'color' => '#e74c3c',
                'table' => 'dressmaking'
            ],
            [
                'name' => 'Hilot Wellness',
                'icon' => 'fas fa-spa',
                'color' => '#2ecc71',
                'table' => 'hilot_wellness'
            ],
            [
                'name' => 'Welding',
                'icon' => 'fas fa-tools',
                'color' => '#f39c12',
                'table' => 'welding'
            ]
        ];
        
        foreach ($trainings as $training) {
            // Count trainees for this training
            $trainee_count = $db->query("SELECT COUNT(DISTINCT trainees_id) FROM {$training['table']}")->fetch_row()[0];
            
            echo '<div class="training-card" style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden;">
                    <div class="training-header" style="background: '.$training['color'].'; padding: 15px; color: white; display: flex; align-items: center;">
                        <i class="'.$training['icon'].'" style="font-size: 24px; margin-right: 10px;"></i>
                        <h3 style="margin: 0;">'.$training['name'].'</h3>
                    </div>
                    <div class="training-body" style="padding: 20px;">
                        <p style="margin-bottom: 15px;"><strong>Enrolled Trainees:</strong> '.$trainee_count.'</p>
                        <div style="display: flex; gap: 10px;">
                            <a href="#" class="view-trainees-btn" data-training="'.$training['table'].'" 
                               style="background-color: '.$training['color'].'; color: white; text-decoration: none; padding: 8px 12px; border-radius: 4px; text-align: center; flex: 1;">
                                View Trainees
                            </a>
                            <a href="#" class="view-modules-btn" data-training="'.$training['table'].'" 
                               style="background-color: #2c3e50; color: white; text-decoration: none; padding: 8px 12px; border-radius: 4px; text-align: center; flex: 1;">
                                View Modules
                            </a>
                        </div>
                    </div>
                  </div>';
        }
        ?>
    </div>
    
    <!-- Dynamic content will load here -->
    <div id="dynamic-content" style="margin-top: 30px;"></div>
</div>

<!-- Create Module Modal -->
<div id="createModuleModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
    <div class="modal-content" style="background-color: #fefefe; margin: 5% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 600px; border-radius: 5px;">
        <span class="close-modal" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
        <h2 style="margin-bottom: 20px;">Create New Training Module</h2>
        
        <form id="moduleForm" method="POST" enctype="multipart/form-data" style="display: grid; gap: 15px;">
            <input type="hidden" id="trainingType" name="training_type">
            <input type="hidden" id="moduleId" name="module_id">
            
            <div>
                <label for="moduleName" style="display: block; margin-bottom: 5px; font-weight: bold;">Module Name</label>
                <input type="text" id="moduleName" name="module_name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            
            <div>
                <label for="moduleFile" style="display: block; margin-bottom: 5px; font-weight: bold;">Module File</label>
                <input type="file" id="moduleFile" name="module_file" accept=".pdf,.doc,.docx,.ppt,.pptx" style="width: 100%;">
                <p style="font-size: 12px; color: #666;">Accepted formats: PDF, DOC, DOCX, PPT, PPTX</p>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" class="btn-secondary cancel-btn" style="padding: 10px 15px;">
                    Cancel
                </button>
                <button type="submit" class="btn-primary" style="padding: 10px 15px;">
                    Save Module
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal elements
    const modal = document.getElementById('createModuleModal');
    const createBtn = document.getElementById('createModuleBtn');
    const closeBtn = document.querySelector('.close-modal');
    const cancelBtn = document.querySelector('.cancel-btn');
    
    // Open modal when create button is clicked
    createBtn.addEventListener('click', function() {
        document.getElementById('moduleForm').reset();
        document.getElementById('moduleId').value = '';
        document.getElementById('modalTitle').textContent = 'Create New Module';
        modal.style.display = 'block';
    });
    
    // Close modal
    function closeModal() {
        modal.style.display = 'none';
    }
    
    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            closeModal();
        }
    });
    
    // View Trainees
    document.querySelectorAll('.view-trainees-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const training = this.getAttribute('data-training');
            
            fetch('content/get_trainees.php?training=' + training)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('dynamic-content').innerHTML = data;
                    document.getElementById('dynamic-content').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('dynamic-content').innerHTML = 
                        '<div class="alert" style="padding: 15px; background-color: #f8d7da; color: #721c24; border-radius: 4px;">Error loading trainees</div>';
                    document.getElementById('dynamic-content').style.display = 'block';
                });
        });
    });
    
    // View Modules
    document.querySelectorAll('.view-modules-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const training = this.getAttribute('data-training');
            document.getElementById('trainingType').value = training;
            
            fetch('content/get_modules.php?training=' + training)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('dynamic-content').innerHTML = data;
                    document.getElementById('dynamic-content').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('dynamic-content').innerHTML = 
                        '<div class="alert" style="padding: 15px; background-color: #f8d7da; color: #721c24; border-radius: 4px;">Error loading modules</div>';
                    document.getElementById('dynamic-content').style.display = 'block';
                });
        });
    });
    
    // Form submission
    document.getElementById('moduleForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        submitBtn.disabled = true;
        
        fetch('content/save_module.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Module saved successfully!');
                closeModal();
                // Refresh the modules list
                const trainingType = document.getElementById('trainingType').value;
                document.querySelector(`.view-modules-btn[data-training="${trainingType}"]`).click();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
    
    // Function to edit module
    window.editModule = function(moduleId, trainingType) {
        document.getElementById('trainingType').value = trainingType;
        document.getElementById('moduleId').value = moduleId;
        document.getElementById('modalTitle').textContent = 'Edit Module';
        
        fetch('content/get_module.php?id=' + moduleId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('moduleName').value = data.module.module_name;
                    modal.style.display = 'block';
                } else {
                    alert('Error: ' + data.message);
                }
            });
    };
    
    // Function to delete module
    window.deleteModule = function(moduleId) {
        if (confirm('Are you sure you want to delete this module?')) {
            fetch('content/delete_module.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + moduleId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Module deleted successfully');
                    // Refresh the current view
                    const activeBtn = document.querySelector('.view-modules-btn.active');
                    if (activeBtn) {
                        activeBtn.click();
                    }
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }
    };
});
</script>