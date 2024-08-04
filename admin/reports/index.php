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
<div class="card card-outline card-primary">
	<div class="card-header">
		
	</div>
	<div class="card-body">
		
      


<div class="row mt">
          <div class="col-md-4">
            <div class="card bg-light" style="height: 500px;">
                    <div class="card-header">
                        <h3 class="card-title">Total Appointment Requests by Type</h3>
                        <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                             <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> 
                            </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> 
                        </div>
                    </div> <!-- /.card-header -->
                        <div class="card-body"> <!--begin::Row-->
                            <div class="row">
                                <div class="col-12" >
                            <div id="pie-chart"></div>
                        </div> <!-- /.col -->
                    </div> <!--end::Row-->
                </div>
            </div>
          </div>
                <div class="col-md-8">
                     <div class="card bg-light" style="height: 500px;">
                            <div class="card-header ">
                                <h3 class="card-title">Daily Appointment Requests</h3> 
                            </div>
                            <div class="card-body">
                                <div class="position-relative mb-4">
                            <div id="monthly-appointments-chart"></div>
                        </div>
                    </div>
                </div> 
          

</div>
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
                <th>Action</th>
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
                    <td><div class="card-tools">
			<a href="?page=reports/print_report" class="btn btn-flat btn-primary"><span class="fas fa-print"></span> Print Report</a>
		</div></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

        </div>


<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
 crossorigin="anonymous"></script>
<script>
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


