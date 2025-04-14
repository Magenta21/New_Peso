<div class="page-header">
    <h1>Employer Management</h1>
    <div class="date-time"></div>
</div>

<div class="employer-management-content">
    <h2>All Employers</h2>
    
    <div style="margin-top: 20px; background: white; border-radius: 5px; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <?php
        // Database connection
        $db = new mysqli('localhost', 'root', '', 'pesoo');
        
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }
        
        // Fetch all employers
        $query = "SELECT id, CONCAT(fname, ' ', lname) as full_name, email, company_name, company_photo 
                 FROM employer 
                 ORDER BY company_name";
        $result = $db->query($query);
        
        if ($result->num_rows > 0) {
            echo '<table class="employer-table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f2f2f2;">
                            <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Company</th>
                            <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Representative</th>
                            <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Email</th>
                            <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
            
            while ($row = $result->fetch_assoc()) {
                echo '<tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 12px; vertical-align: middle;">
                            <div style="display: flex; align-items: center;">
                                <img src="../employer/'.htmlspecialchars($row['company_photo']).'" 
                                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 10px;" 
                                     onerror="this.src=\'default-company.png\'">
                                '.htmlspecialchars($row['company_name']).'
                            </div>
                        </td>
                        <td style="padding: 12px; vertical-align: middle;">'.htmlspecialchars($row['full_name']).'</td>
                        <td style="padding: 12px; vertical-align: middle;">'.htmlspecialchars($row['email']).'</td>
                        <td style="padding: 12px; vertical-align: middle;">
                            <button class="view-docs-btn" 
                                    style="background-color: #3498db; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;"
                                    data-employer-id="'.$row['id'].'">
                                View Documents
                            </button>
                        </td>
                      </tr>';
            }
            
            echo '</tbody></table>';
        } else {
            echo '<p>No employers found.</p>';
        }
        ?>
    </div>
</div>

<!-- Document Verification Modal -->
<div id="documentsModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
    <div class="modal-content" style="background-color: #fefefe; margin: 5% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 800px; border-radius: 5px;">
        <span class="close-modal" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
        <h2 id="modalTitle" style="margin-bottom: 20px;">Documents for <span id="companyName"></span></h2>
        
        <div id="documentsList" style="margin-bottom: 20px;">
            <!-- Documents will be loaded here -->
        </div>
        
        <div id="verificationSection" style="display: none;">
            <h3>Document Verification</h3>
            <textarea id="rejectionComment" style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;" 
                      placeholder="Enter reason for rejection (if applicable)"></textarea>
            
            <div style="display: flex; gap: 10px;">
                <button id="verifyDocBtn" style="background-color: #2ecc71; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer;">
                    Verify Document
                </button>
                <button id="rejectDocBtn" style="background-color: #e74c3c; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer;">
                    Reject Document
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Document ready function
document.addEventListener('DOMContentLoaded', function() {
    // Modal elements
    const modal = document.getElementById('documentsModal');
    const closeBtn = document.querySelector('.close-modal');
    const documentsList = document.getElementById('documentsList');
    const verificationSection = document.getElementById('verificationSection');
    const verifyDocBtn = document.getElementById('verifyDocBtn');
    const rejectDocBtn = document.getElementById('rejectDocBtn');
    const rejectionComment = document.getElementById('rejectionComment');
    const companyNameSpan = document.getElementById('companyName');
    
    let currentEmployerId = null;
    let currentDocId = null;
    
    // Open modal when view documents button is clicked
    document.querySelectorAll('.view-docs-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            currentEmployerId = this.getAttribute('data-employer-id');
            const companyName = this.closest('tr').querySelector('td:first-child').textContent.trim();
            companyNameSpan.textContent = companyName;
            
            // Load documents via AJAX
            fetch('get_documents.php?employer_id=' + currentEmployerId)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        let html = '<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">';
                        html += '<tr style="background-color: #f2f2f2;"><th>Document Type</th><th>Status</th><th>Actions</th></tr>';
                        
                        data.forEach(doc => {
                            const status = doc.is_verified == 1 ? 
                                '<span style="color: green;">Verified</span>' : 
                                (doc.is_verified == 0 ? '<span style="color: red;">Rejected</span>' : '<span style="color: orange;">Pending</span>');
                            
                            html += `<tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 10px;">${doc.document_type}</td>
                                    <td style="padding: 10px;">${status}</td>
                                    <td style="padding: 10px;">
                                        <button class="view-doc-btn" data-doc-id="${doc.id}" data-file="${doc.document_file}" 
                                                style="background-color: #3498db; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">
                                            View
                                        </button>
                                    </td>
                                </tr>`;
                        });
                        
                        html += '</table>';
                        documentsList.innerHTML = html;
                        
                        // Add event listeners to the new view buttons
                        document.querySelectorAll('.view-doc-btn').forEach(docBtn => {
                            docBtn.addEventListener('click', function() {
                                currentDocId = this.getAttribute('data-doc-id');
                                const fileUrl = this.getAttribute('data-file');
                                
                                // Open document in new tab
                                window.open(fileUrl, '_blank');
                                
                                // Show verification section
                                verificationSection.style.display = 'block';
                            });
                        });
                    } else {
                        documentsList.innerHTML = '<p>No documents uploaded yet.</p>';
                        verificationSection.style.display = 'none';
                    }
                });
            
            modal.style.display = 'block';
        });
    });
    
    // Close modal
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
    
    // Verify document
    verifyDocBtn.addEventListener('click', function() {
        if (currentDocId) {
            verifyDocument(currentDocId, 1, '');
        }
    });
    
    // Reject document
    rejectDocBtn.addEventListener('click', function() {
        if (currentDocId) {
            const comment = rejectionComment.value.trim();
            if (comment === '') {
                alert('Please enter a reason for rejection');
                return;
            }
            verifyDocument(currentDocId, 0, comment);
        }
    });
    
    // Function to verify/reject document
    function verifyDocument(docId, status, comment) {
        const formData = new FormData();
        formData.append('doc_id', docId);
        formData.append('status', status);
        formData.append('comment', comment);
        
        fetch('verify_document.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Document status updated successfully');
                // Refresh the documents list
                document.querySelector(`.view-docs-btn[data-employer-id="${currentEmployerId}"]`).click();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
});
</script>