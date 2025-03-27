                    <div id="we" class="tab-content" style="display:none;">
                        <div class="card mb-4">
                            <div class="card-header">Work Experience (Limit to 10-year period)</div>
                            <div class="card-body">
                                <form action="process/save_data.php" method="POST" enctype="multipart/form-data">
                                            <!-- Training Container -->
                                            <div id="training-container">
                                                <div class="row mb-4">
                                                    <div class="col-md-12">
                                                        <h4>Technical/Vocational and Other Training</h4>
                                                    </div>
                                                </div>
                                            <?php if (($result_work_exp->num_rows > 0)): ?>
                                                <?php while ($row_work_exp = $result_work_exp->fetch_assoc()): ?>
                                                    <div class="row mb-4 mt-4">
                                                    <!-- Training Name -->
                                                        <div class="col-md-3">
                                                            <input type="hidden" name="existing_company[]" value="<?php echo htmlspecialchars($row_work_exp['company_name']); ?>">
                                                        </div>
                                                    <!-- Start and End Date -->
                                                        <div class="col-md-3">
                                                            <input type="hidden" name="existing_address[]" value="<?php echo htmlspecialchars($row_work_exp['address']); ?>">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="hidden" name="existing_position[]" value="<?php echo htmlspecialchars($row_work_exp['position']); ?>">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="hidden" name="existing_status[]" value="<?php echo htmlspecialchars($row_work_exp['status']); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="row-mb-4">
                                                    <!-- Institution -->
                                                        <div class="col-md-4">
                                                            <input type="hidden" name="existing_start_date[]" value="<?php echo htmlspecialchars($row_work_exp['started_date']); ?>">
                                                        </div>
                                                    <!-- Certificate Upload -->
                                                        <div class="col-md-6 mt-4">
                                                            <input type="hidden" name="existing_end_date[]" value="<?php echo htmlspecialchars($row_work_exp['termination_date']); ?>">
                                                        </div>
                                                        <div class="col-md-6 mt-4">
                                                            <input type="hidden" name="existing_status[]" value="<?php echo htmlspecialchars($row_work_exp['status']); ?>">
                                                        </div>
                                                    </div>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                            <!-- No training records found, show an empty row for new input -->
                                            <?php endif; ?>
                                        </div>
                                                
                                        <!-- Button to Add Another Training Set -->
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <button type="button" class="btn btn-primary" onclick="addWorkExperienceGroup()">Add Another Work Experience Set</button>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>

            //training information
            function addWorkExperienceGroup() {
                // Get the training container where rows are added
                const container = document.getElementById('work-experience-container');

                // Create a new div element for the row
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'mb-4');

                // Set the inner HTML of the new row
                newRow.innerHTML = `
                    <!-- Training Name -->
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="company[]" placeholder="Company Name">
                    </div>
                    <!-- Start and End Date -->
                    <div class="col-md-3 text-center">
                        <input type="text" class="form-control" name="address[]" placeholder="Address">
                    </div>
                    <div class="col-md-1 text-center">
                        <input type="text" class="form-control" name="position[]" placeholder="Position">
                    </div>
                    <div class="col-md-3 text-center">
                        <input type="date" class="form-control" name="start_date[]">
                    </div>
                    <!-- Institution -->
                    <div class="col-md-4">
                        <input type="date" class="form-control" name="end_date[]">
                    </div>
                    <!-- Certificate Upload -->
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="status[]" placeholder="Status">
                    </div>
                    <!-- Remove Button -->
                    <div class="col-md-1 text-center">
                        <button type="button" class="btn btn-danger" onclick="removeWorkExperienceGroup(this)">Remove</button>
                    </div>
                `;

                // Append the newly created row to the container
                container.appendChild(newRow);
            }

            // Function to remove a training row when the remove button is clicked
            function removeTrainingGroup(button) {
                // Find the parent row of the clicked remove button and remove it
                button.closest('.row').remove();
            }