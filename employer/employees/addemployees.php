<?php
include '../db.php';
$employerid = $_SESSION['employer_id'];

// Check if the employer is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: employer_login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Employee</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color:rgb(255, 255, 255);
    }
    .form-container {
      margin-top: 50px;
      padding: 30px;
      background: #ffffff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      margin-bottom: 30px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 form-container">
      <h2 class="text-center">Add Employee</h2>
      <form action="employees/addprocess.php" method="post">
        <input type="hidden" name="employer_id" value="<?php echo $employerid; ?>">

        <div class="form-group">
          <label for="fname">First Name:</label>
          <input type="text" class="form-control" id="fname" name="fname" required>
        </div>

        <div class="form-group">
          <label for="mname">Middle Name:</label>
          <input type="text" class="form-control" id="mname" name="mname">
        </div>

        <div class="form-group">
          <label for="lname">Last Name:</label>
          <input type="text" class="form-control" id="lname" name="lname" required>
        </div>

        <div class="form-group">
          <label for="gender">Gender:</label>
          <select id="gender" name="gender" class="form-control" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
           
          </select>
        </div>

        <div class="form-group">
          <label for="contact">Contact:</label>
          <input type="text" class="form-control" id="contact" name="contact" required>
        </div>

        <div class="form-group">
          <label for="bday">Birthday:</label>
          <input type="date" class="form-control" id="bday" name="bday" required>
        </div>

        <div class="form-group">
          <label for="address">Address:</label>
          <input type="text" class="form-control" id="address" name="address" required>
        </div>

        <div class="form-group">
          <label for="position">Position:</label>
          <input type="text" class="form-control" id="position" name="position" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Add Employee</button>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
