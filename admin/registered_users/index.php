<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Registered Users</h3>
		<div class="card-tools">
			
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-bordered table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<col width="10%">
					<col width="25%">
					<col width="30%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Username</th>
						<th>Email</th>
						<th>Address</th>
						<th>Phone #</th>
						<th>Date Created</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$qry = $conn->query("SELECT * from `registered_users`  order by unix_timestamp(`date_created`) asc ");
					while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $row['name'] ?></td>
							<td><?php echo $row['user_name'] ?></td>
							<td><?php echo $row['email'] ?></td>
							<td><?php echo $row['address'] ?></td>
							<td><?php echo $row['phone_no'] ?></td>
							<td><?php echo $row['date_created'] ?></td>
							<td class="text-center">
								<button class="btn btn-danger btn-sm delete-user" data-id="<?php echo $row['id'] ?>">Delete</button>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.table th, .table td').addClass("py-1 px-1 align-middle");
		$('.table').dataTable();
		
		$('.delete-user').click(function(){
			var id = $(this).attr('data-id');
			if(confirm("Are you sure you want to delete this user?")) {
				$.ajax({
					url: 'delete_user.php',
					method: 'POST',
					data: { id: id },
					success: function(response) {
						if(response == 1) {
							alert_toast("User successfully deleted",'success');
							location.reload();
						} else {
							alert_toast("An error occurred while deleting the user",'danger');
						}
					}
				});
			}
		});
	})
</script>
