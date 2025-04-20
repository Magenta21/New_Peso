<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pesoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Get employer_id from URL
$employer_id = intval($_GET['employer_id']);

// Fetch documents for the selected employer
$sql = "SELECT * FROM documents WHERE employer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employer_id);
$stmt->execute();
$result = $stmt->get_result();

echo "
    <h2> Employer Documents </h2>
    <table class='table table-borderless table-hover'>
        <thead>
            <th>Document Name</th>
            <th>Document File</th>
            <th>Verification</th>
            <th>Status</th>
        </thead>
     ";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $docverify = $row['is_verified'];
        
        echo "<tr>
                <td>" . htmlspecialchars($row["document_type"]) . "</td>
                <td><a class='btn btn-primary read-link' href='content/view_document.php?file_path=" . htmlspecialchars($row["document_file"]) . "' target='_blank'>View Document</a></td>
                <td>";

        // Case 1: is_verified is NULL (Pending)
        if (is_null($docverify)) {
            echo "<a class='btn btn-success' href='content/verify_document.php?id=" . $row['id'] . "&employer_id=" . $employer_id . "'>Verify</a>";
            echo "</td><td>
                    <form action='content/em_reject_doc.php' method='post'>
                        <input type='hidden' name='doc_id' value='" . htmlspecialchars($row['id']) . "'>
                        <input type='hidden' name='employer_id' value='" . htmlspecialchars($employer_id) . "'>
                        <input type='text' name='comment' placeholder='Enter comment'>
                        <input class='btn btn-danger' type='submit' name='Reject' value='Reject'>
                    </form>
                  </td>
                  <td style='font-size:1.2em;color: orange;'>Pending</td>";

        // Case 2: is_verified is 'verified'
        } elseif ($docverify == 'verified') {
            echo "<span style='color: green;'>Verified</span></td><td></td>
                  <td style='font-size:1.2em;color: green;'>Verified</td>";

        // Case 3: is_verified is 'updated'
        } elseif ($docverify == 'updated') {
            echo "<a class='btn btn-success' href='content/verify_document.php?id=" . $row['id'] . "&employer_id=" . $employer_id . "'>Verify</a>";
            echo "</td><td>
                    <form action='content/em_reject_doc.php' method='post'>
                        <input type='hidden' name='doc_id' value='" . htmlspecialchars($row['id']) . "'>
                        <input type='hidden' name='employer_id' value='" . htmlspecialchars($employer_id) . "'>
                        <input type='text' name='comment' placeholder='Enter comment'>
                        <input class='btn btn-danger' type='submit' name='Reject' value='Reject'>
                    </form>
                  </td>
                  <td style='font-size:1.2em;color: blue;'>Updated</td>";

        // Case 4: is_verified is 'rejected' or any other value
        } else {
            echo "<span class='disabled-link btn btn-secondary'>Verify</span></td><td></td>
                  <td style='font-size:1.2em;color: red;'>Rejected</td>";
        }

        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No documents found</td></tr>";
}
echo "</table>";

$conn->close();
?>
