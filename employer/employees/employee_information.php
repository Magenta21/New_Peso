<?php
  $employee_id= $_GET['id'];
  $employee_id = base64_decode(urldecode($employee_id));
    $employee_id = (int)$employee_id;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Information</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Link to a CSS file -->
</head>
<body>
    <h1>Employee Information Form</h1>
    <form action="process_employee_information.php" method="POST">
        <label for="employee_id">Employee ID:</label>
        <input type="text" id="employee_id" name="employee_id" required>
        <br><br>

        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
        <br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required>
        <br><br>

        <label for="position">Position:</label>
        <input type="text" id="position" name="position" required>
        <br><br>

        <label for="department">Department:</label>
        <input type="text" id="department" name="department" required>
        <br><br>

        <label for="hire_date">Hire Date:</label>
        <input type="date" id="hire_date" name="hire_date" required>
        <br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>