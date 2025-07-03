<?php
// Database connection
require_once '../db.php';

// Check if Twilio is properly installed and configured
$twilioConfigPath = '../config/twilio.php';
if (!file_exists($twilioConfigPath)) {
    die("Twilio configuration file not found at $twilioConfigPath");
}

// Load Twilio configuration
$twilioConfig = include $twilioConfigPath;

// Verify Twilio configuration
if (!isset($twilioConfig['account_sid'], $twilioConfig['auth_token'], $twilioConfig['twilio_number'])) {
    die("Invalid Twilio configuration. Please check config/twilio.php");
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
        // Verify Twilio SDK is available
        if (!class_exists('Twilio\Rest\Client')) {
            error_log("Twilio SDK not found. Please run 'composer require twilio/sdk'");
        } else {
            sendTwilioSMS(
                $applicant['phone'],
                $applicant['service_type'],
                $applicant['first_name'],
                $applicant['last_name'],
                $twilioConfig
            );
        }
    }

    // Redirect to avoid form resubmission
    echo '<meta http-equiv="refresh" content="0;url=admin_home.php?page=service_applications&tab=' . urlencode($_GET['tab'] ?? 'tupad') . '">';
    exit;
}

/**
 * Send SMS using Twilio
 */
function sendTwilioSMS($phoneNumber, $serviceType, $firstName, $lastName, $config)
{
    // Clean and format phone number
    $phoneNumber = formatPhoneNumber($phoneNumber);

    try {
        $client = new Twilio\Rest\Client($config['account_sid'], $config['auth_token']);

        // Customize your message here
        $messageBody = "Dear $firstName $lastName,\n\n";
        $messageBody .= "Your $serviceType application has been APPROVED.\n";
        $messageBody .= "Please visit PESO Office within 3 working days.\n";
        $messageBody .= "Bring valid ID and this message for verification.\n\n";
        $messageBody .= "For inquiries: (02) 123-4567";

        $message = $client->messages->create(
            $phoneNumber, // Recipient
            [
                'from' => $config['twilio_number'],
                'body' => $messageBody
            ]
        );

        // Log successful sending
        logSMS($phoneNumber, $message->sid, 'Success');
    } catch (Exception $e) {
        // Log errors
        logSMS($phoneNumber, '', 'Failed: ' . $e->getMessage());
    }
}

/**
 * Format phone number for Twilio
 */
function formatPhoneNumber($phoneNumber)
{
    // Remove all non-numeric characters
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    // Format for Philippines (adjust for your country)
    if (strlen($phoneNumber) === 10 && $phoneNumber[0] === '0') {
        return '+63' . substr($phoneNumber, 1);
    }
    if (strlen($phoneNumber) === 11 && substr($phoneNumber, 0, 2) === '09') {
        return '+63' . substr($phoneNumber, 1);
    }
    if (strlen($phoneNumber) === 12 && substr($phoneNumber, 0, 3) === '639') {
        return '+' . $phoneNumber;
    }

    return $phoneNumber; // Return as-is if doesn't match expected formats
}

/**
 * Log SMS sending attempts
 */
function logSMS($phoneNumber, $messageId, $status)
{
    $logDir = '../logs';
    if (!file_exists($logDir)) {
        mkdir($logDir, 0755, true);
    }

    $logEntry = sprintf(
        "[%s] Number: %s | Status: %s | Message ID: %s\n",
        date('Y-m-d H:i:s'),
        $phoneNumber,
        $status,
        $messageId
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

<!-- Rest of your HTML remains exactly the same -->


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