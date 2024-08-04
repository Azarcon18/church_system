<?php if($_settings->chk_flashdata('success')): ?>
    <?php
// Set the content type to HTML
header('Content-Type: text/html; charset=utf-8');

// Optionally, set the content-disposition to attachment to force a download (remove if not needed)
// header('Content-Disposition: attachment; filename="report.pdf"');

// Include your config file and set the timezone
require_once('../config.php');
date_default_timezone_set('Asia/Manila');
$currentDate = date('D M, Y');

// Prepare the HTML content
?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .item-row {
            margin-bottom: 10px;
        }
        .item-row input {
            width: calc(33.33% - 10px);
            display: inline-block;
        }
    </style>
<div class="container">
	
<header style="text-align: center; margin-bottom: 20px;">
        <img src="../uploads/logo.jpg"style="display: flex; margin: auto; width: 50px; height: 50px; border-radius: 100%;">
        <h3>Church Management System</h3>
        <p>Poblacion, Madridejos, Cebu Philippines</p>
        <p>Report Date: <span id="date"></span></p>
    </header>

<div class="container-fluid">
<?php 
require_once('../config.php'); // Assuming config.php is already included
date_default_timezone_set('Asia/Manila'); // Adjust the timezone as needed
$startOfMonth = date('Y-m-01');
$endOfMonth = date('Y-m-t');

$i = 1;
$qry = $conn->query("SELECT r.*, t.sched_type 
                     FROM `appointment_request` r 
                     INNER JOIN `schedule_type` t ON r.sched_type_id = t.id 
                     WHERE DATE(r.schedule) BETWEEN '$startOfMonth' AND '$endOfMonth' 
                     ORDER BY FIELD(r.status, 0, 1, 2) ASC, unix_timestamp(r.`date_created`) ASC");
?>

    <center><h1 style="font-size: 30px;">Baptismal Form</h1></center>
    <form action="/submit-invoice" method="post">
        <div class="form-group">
            <label for="invoice-date">Schedule Type:</label>
            <input type="text" id="invoice-date" name="invoice_date" required>
        </div>
        
        <div class="form-group">
            <label for="invoice-date">Date Created:</label>
            <input type="date" id="invoice-date" name="invoice_date" required>
        </div>
        <div class="form-group">
            <label for="invoice-date">Schedule Date:</label>
            <input type="date" id="invoice-date" name="invoice_date" required>
        </div>
        <div class="form-group">
            <label for="invoice-date">Fullname:</label>
            <input type="text" id="invoice-date" name="invoice_date" required>
        </div>
        <div class="form-group">
            <label for="invoice-date">Remarks:</label>
            <input type="text" id="invoice-date" name="invoice_date" required>
        </div>
        <div class="form-group">
            <label for="invoice-date">Status:</label>
            <input type="text" id="invoice-date" name="invoice_date" required>
        </div>
    
    </form>

<div class="container-fluid">
    <table class="table table-bordered table-hover table-striped text-sm">
        <colgroup>
            <col width="5%">
            <col width="20%">
            <col width="10%">
            <col width="30%">
            <col width="25%">
            <col width="10%">
        </colgroup>
        <thead>
            <tr>
                <th>#</th>
                <th>Schedule Type</th>
                <th>Date Created</th>
                <th>Schedule Date</th>
                <th>Full Name</th>
                <th>Remarks</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($row = $qry->fetch_assoc()):
            ?>
                <tr>
                    <td class="text-center"><?php echo $i++; ?></td>
                    <td><?php echo $row['sched_type'] ?></td>
                    <td><?php echo date("M d, Y", strtotime($row['date_created'])) ?></td>
                    <td><?php echo date("M d, Y", strtotime($row['schedule'])) ?></td>
                    <td>
                        <?php echo $row['fullname'] ?><br>
                        <small><?php echo $row['contact'] ?></small><br>
                        <small class="truncate" title="<?php echo $row['address'] ?>"><?php echo $row['address'] ?></small>
                    </td>
                    <td>
                        <p class="m-0 truncate"><?php echo $row['remarks'] ?></p>
                    </td>
                    <td class="text-center">
                        <?php if($row['status'] == 1): ?>
                            <span class="badge badge-success">Confirmed</span>
                        <?php elseif($row['status'] == 2): ?>
                            <span class="badge badge-danger">Cancelled</span>
                        <?php else: ?>
                            <span class="badge badge-primary">Pending</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

        </div>


<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
 crossorigin="anonymous"></script>
 
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var currentDate = new Date();
    var options = { year: 'numeric', month: 'long', day: 'numeric' };
    var formattedDate = currentDate.toLocaleDateString('en-US', options);
    document.getElementById('date').innerText = formattedDate;
});

</script>
<script>
        window.onload = function() {
      
        setTimeout(() => {
            window.print();
        }, 2000); // Adjust the timeout as necessary to ensure charts are fully rendered
    };
function fetchPieChartData() {
    fetch('get_piechart.php')
    .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const labels = data.data.map(item => item.label);
                const series = data.data.map(item => item.total);

                const pie_chart_options = {
                    series: series,
                    chart: {
                        type: "donut",
                    },
                    labels: labels,
                    dataLabels: {
                        enabled: false,
                    },
                    colors: [
                        "#0d6efd",
                        "#20c997",
                        "#ffc107",
                        "#d63384",
                        "#6f42c1",
                        "#adb5bd",
                    ],
                };

                const pie_chart = new ApexCharts(
                    document.querySelector("#pie-chart"),
                    pie_chart_options,
                );
                pie_chart.render();
            } else {
                console.error('Error fetching pie chart data:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching pie chart data:', error);
        });
}

fetchPieChartData();

    // Existing code to render the line chart

    function fetchMonthlyAppointments() {
    fetch('fetch_data.php') // Adjust the path to your PHP script
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Prepare data for ApexCharts
                const dates = [];
                const totals = [];
                const currentDate = new Date();
                const month = currentDate.toLocaleString('default', { month: 'long' });
                const year = currentDate.getFullYear();
                const daysInMonth = new Date(year, currentDate.getMonth() + 1, 0).getDate();

                for (let day = 1; day <= daysInMonth; day++) {
                    const dateStr = `${year}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const appointment = data.data.find(a => a.date === dateStr);
                    dates.push(day);
                    totals.push(appointment ? appointment.total : 0);
                }

                // Initialize ApexCharts
                const options = {
                    series: [{
                        name: 'Appointment Requests',
                        data: totals
                    }],
                    chart: {
                        type: 'line',
                        height: 400
                    },
                    xaxis: {
                        categories: dates,
                        title: {
                            text: 'Day of the Month'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'No. of Appointment Requests'
                        }
                    },
                    title: {
                        text: `Appointment Requests for ${month} ${year}`,
                        align: 'center'
                    }
                };

                const chart = new ApexCharts(document.querySelector("#monthly-appointments-chart"), options);
                chart.render();
            } else {
                console.error('Error fetching monthly appointments:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching monthly appointments:', error);
        });
}

// Fetch the monthly appointments data when the page loads
document.addEventListener('DOMContentLoaded', fetchMonthlyAppointments);
</script>


