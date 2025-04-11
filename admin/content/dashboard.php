<div class="page-header">
    <h1>Dashboard</h1>
    <div class="date-time"></div>
</div>

<div class="dashboard-content">
    <p>Welcome back, <strong><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></strong>!</p>
    <p>Here's a quick overview of your administration panel.</p>
    
    <?php
    // Database connection (adjust credentials as needed)
    $db = new mysqli('localhost', 'root', '', 'pesoo');
    
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    
    // Get counts from database
    $applicant_count = $db->query("SELECT COUNT(*) FROM applicant_profile")->fetch_row()[0];
    $company_count = $db->query("SELECT COUNT(*) FROM employer")->fetch_row()[0];
    $trainee_count = $db->query("SELECT COUNT(*) FROM trainees_profile")->fetch_row()[0];
    
    // Get hiring rate data for the line graph
    $hiring_data = [];
    $result = $db->query("SELECT YEAR(application_date) as year, COUNT(*) as count 
                         FROM applied_job 
                         WHERE status = 'Accepted'
                         GROUP BY YEAR(application_date)");
    while ($row = $result->fetch_assoc()) {
        $hiring_data[$row['year']] = $row['count'];
    }
    
    // Get company hiring data for the bar graph
    $company_hiring = [];
    $result = $db->query("SELECT e.company_name, COUNT(a.id) as hires 
                         FROM applied_job a
                         JOIN employer e ON a.job_posting_id IN (
                             SELECT id FROM job_post WHERE employer_id = e.id
                         )
                         WHERE a.status = 'Accepted'
                         GROUP BY e.company_name
                         ORDER BY hires DESC
                         LIMIT 10");
    while ($row = $result->fetch_assoc()) {
        $company_hiring[$row['company_name']] = $row['hires'];
    }
    ?>
    
    <div class="stats" style="margin-top: 30px; display: flex; flex-wrap: wrap; gap: 20px;">
        <div style="background: #e3f2fd; padding: 20px; border-radius: 5px; flex: 1; min-width: 200px;">
            <h3>Total Applicants</h3>
            <p style="font-size: 24px; font-weight: bold;"><?= number_format($applicant_count) ?></p>
        </div>
        <div style="background: #e8f5e9; padding: 20px; border-radius: 5px; flex: 1; min-width: 200px;">
            <h3>Total Companies</h3>
            <p style="font-size: 24px; font-weight: bold;"><?= number_format($company_count) ?></p>
        </div>
        <div style="background: #fff3e0; padding: 20px; border-radius: 5px; flex: 1; min-width: 200px;">
            <h3>Total Trainees</h3>
            <p style="font-size: 24px; font-weight: bold;"><?= number_format($trainee_count) ?></p>
        </div>
    </div>
    
    <div style="display: flex; gap: 20px; margin-top: 30px;">
        <div style="flex: 1; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <h3>Hiring Rate (Yearly)</h3>
            <canvas id="hiringChart" height="300"></canvas>
        </div>
        
        <div style="flex: 1; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <h3>Top Companies by Hires</h3>
            <canvas id="companyChart" height="300"></canvas>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Hiring Rate Line Chart
    const hiringCtx = document.getElementById('hiringChart').getContext('2d');
    const hiringChart = new Chart(hiringCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_keys($hiring_data)) ?>,
            datasets: [{
                label: 'Hires per Year',
                data: <?= json_encode(array_values($hiring_data)) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Hires'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Year'
                    }
                }
            }
        }
    });

    // Company Hiring Bar Chart
    const companyCtx = document.getElementById('companyChart').getContext('2d');
    const companyChart = new Chart(companyCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_keys($company_hiring)) ?>,
            datasets: [{
                label: 'Number of Hires',
                data: <?= json_encode(array_values($company_hiring)) ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Hires'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Company'
                    },
                    ticks: {
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });
</script>