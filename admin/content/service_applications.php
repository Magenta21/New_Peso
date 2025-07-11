<?php
// Database connection
require_once '../db.php';

// Load ClickSend configuration
$clicksendConfigPath = '../config/clicksend.php';
if (!file_exists($clicksendConfigPath)) {
    die("ClickSend configuration file not found at $clicksendConfigPath");
}

$clicksendConfig = include $clicksendConfigPath;

// Verify ClickSend configuration
if (!isset($clicksendConfig['username'], $clicksendConfig['api_key'], $clicksendConfig['sender_name'])) {
    die("Invalid ClickSend configuration. Please check config/clicksend.php");
}

// Get the current tab (default to tupad)
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'tupad';
$valid_tabs = ['tupad', 'livelihood', 'spes'];
if (!in_array($tab, $valid_tabs)) {
    $tab = 'tupad';
}

// Handle accept/reject actions
if (isset($_POST['action']) && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $status = ($_POST['action'] === 'accept') ? 'Approved' : 'Rejected';

    // First get applicant details before updating
    $stmt = $conn->prepare("SELECT * FROM service_applications WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $applicant = $result->fetch_assoc();
    $stmt->close();

    // Update status
    $stmt = $conn->prepare("UPDATE service_applications SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();

    // Send SMS if accepted
    if ($_POST['action'] === 'accept') {
        sendClickSendSMS(
            $applicant['phone'],
            $applicant['service_type'],
            $applicant['first_name'],
            $applicant['last_name'],
            $clicksendConfig
        );
    }

    // Redirect to avoid form resubmission
    echo '<meta http-equiv="refresh" content="0;url=admin_home.php?page=service_applications&tab=' . urlencode($_GET['tab'] ?? 'tupad') . '">';
    exit;
}

/**
 * Send SMS using ClickSend
 */
function sendClickSendSMS($phoneNumber, $serviceType, $firstName, $lastName, $config)
{
    // Clean phone number (remove all non-numeric characters)
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    // Format for Philippines (ClickSend expects 09... or +63... format)
    if (strlen($phoneNumber) === 10 && $phoneNumber[0] === '0') {
        $phoneNumber = '63' . substr($phoneNumber, 1);
    } elseif (strlen($phoneNumber) === 11 && substr($phoneNumber, 0, 2) === '09') {
        $phoneNumber = '63' . substr($phoneNumber, 1);
    }

    // Prepare message
    $message = "Hi $firstName $lastName! Your $serviceType application has been approved. ";
    $message .= "Please visit our office for next steps. Thank you!";

    // Prepare API request
    $url = 'https://rest.clicksend.com/v3/sms/send';
    $data = [
        'messages' => [
            [
                'source' => 'php',
                'from' => $config['sender_name'],
                'body' => $message,
                'to' => $phoneNumber
            ]
        ]
    ];

    // Send request using cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode($config['username'] . ':' . $config['api_key'])
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Log the result
    logSMS($phoneNumber, $httpCode, $response);
}

/**
 * Log SMS sending attempts
 */
function logSMS($phoneNumber, $statusCode, $response)
{
    $logDir = '../logs';
    if (!file_exists($logDir)) {
        mkdir($logDir, 0755, true);
    }

    $logEntry = sprintf(
        "[%s] Number: %s | Status: %d | Response: %s\n",
        date('Y-m-d H:i:s'),
        $phoneNumber,
        $statusCode,
        $response
    );

    file_put_contents($logDir . '/sms.log', $logEntry, FILE_APPEND);
}

// Get applications for the current tab
$stmt = $conn->prepare("SELECT * FROM service_applications WHERE service_type = ? ORDER BY application_date DESC");
$service_name = ucfirst($tab);
$stmt->bind_param("s", $service_name);
$stmt->execute();
$result = $stmt->get_result();
$applications = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<!-- The rest of your HTML remains exactly the same -->

<div class="page-header">
    <h1><i class="fas fa-file-signature"></i> Service Applications</h1>
    <span class="date-time"></span>
</div>

<div class="mb-4">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link <?= $tab === 'tupad' ? 'active' : '' ?>" href="?page=service_applications&tab=tupad">TUPAD</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $tab === 'livelihood' ? 'active' : '' ?>" href="?page=service_applications&tab=livelihood">Livelihood</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $tab === 'spes' ? 'active' : '' ?>" href="?page=service_applications&tab=spes">SPES</a>
        </li>
    </ul>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Application Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($applications)): ?>
                <tr>
                    <td colspan="6" class="text-center">No applications found</td>
                </tr>
            <?php else: ?>
                <?php foreach ($applications as $app): ?>
                    <tr>
                        <td><?= htmlspecialchars($app['id']) ?></td>
                        <td>
                            <?= htmlspecialchars($app['last_name']) ?>, <?= htmlspecialchars($app['first_name']) ?>
                            <?= !empty($app['middle_name']) ? ' ' . htmlspecialchars(substr($app['middle_name'], 0, 1)) . '.' : '' ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($app['email']) ?><br>
                            <?= htmlspecialchars($app['phone']) ?>
                        </td>
                        <td><?= date('M d, Y h:i A', strtotime($app['application_date'])) ?></td>
                        <td>
                            <span class="badge bg-<?=
                                                    $app['status'] === 'Approved' ? 'success' : ($app['status'] === 'Rejected' ? 'danger' : 'warning')
                                                    ?>">
                                <?= htmlspecialchars($app['status']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($app['status'] === 'Pending'): ?>
                                <form method="post" style="display: inline-block;">
                                    <input type="hidden" name="id" value="<?= $app['id'] ?>">
                                    <button type="submit" name="action" value="accept" class="btn btn-sm btn-success">
                                        <i class="fas fa-check"></i> Accept
                                    </button>
                                </form>
                                <form method="post" style="display: inline-block;">
                                    <input type="hidden" name="id" value="<?= $app['id'] ?>">
                                    <button type="submit" name="action" value="reject" class="btn btn-sm btn-danger">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </form>
                            <?php endif; ?>
                            <button class="btn btn-sm btn-primary view-details" data-bs-toggle="modal" data-bs-target="#detailsModal"
                                data-app='<?= htmlspecialchars(json_encode($app), ENT_QUOTES, 'UTF-8') ?>'>
                                <i class="fas fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Application Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalDetailsContent">
                <!-- Content will be loaded via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Handle view details button
    document.querySelectorAll('.view-details').forEach(button => {
        button.addEventListener('click', function() {
            const app = JSON.parse(this.getAttribute('data-app'));
            const modalContent = document.getElementById('modalDetailsContent');

            // Format the application details
            const html = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Personal Information</h6>
                    <p><strong>Name:</strong> ${app.last_name}, ${app.first_name} ${app.middle_name || ''}</p>
                    <p><strong>Birthdate:</strong> ${new Date(app.birthdate).toLocaleDateString()}</p>
                    <p><strong>Gender:</strong> ${app.gender}</p>
                </div>
                <div class="col-md-6">
                    <h6>Contact Information</h6>
                    <p><strong>Address:</strong> ${app.address}</p>
                    <p><strong>Email:</strong> ${app.email}</p>
                    <p><strong>Phone:</strong> ${app.phone}</p>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <h6>Identification</h6>
                    <p><strong>ID Type:</strong> ${app.id_type}</p>
                    <p><strong>ID Number:</strong> ${app.id_number}</p>
                </div>
                <div class="col-md-6">
                    <h6>Application Details</h6>
                    <p><strong>Service Type:</strong> ${app.service_type}</p>
                    <p><strong>Status:</strong> <span class="badge bg-${app.status === 'Approved' ? 'success' : (app.status === 'Rejected' ? 'danger' : 'warning')}">${app.status}</span></p>
                    <p><strong>Applied On:</strong> ${new Date(app.application_date).toLocaleString()}</p>
                </div>
            </div>
            <div class="mt-3">
                <h6>Purpose</h6>
                <p>${app.purpose}</p>
            </div>
        `;

            modalContent.innerHTML = html;
        });
    });
</script>