<?php 

?>
<style>
.cont{
	padding-left: 4%;
	padding-right: 4%;
}
</style>
<div class="containe-fluid cont" id="general_container">
	
	<div class="row">
	<div class="col-md-12">
			
	</div>
	</div>
	<br>
	<div class="row">
		<div class="card col-md-12 shadow " >
			<div class="card-body">
			<button class="btn btn-primary float-right btn-sm mb-3" id="new_user"><i class="fa fa-plus"></i> New user</button>
			<table class="table table-bordered table-condensed table-hover table-responsive" style="width: 100%;">
			<colgroup>
                    <col width="3%">
					<col width="10%">  
					<col width="8%">  
					<col width="5%">  
					<col width="6%">  
					<col width="3%">  
					<col width="5%">                
			</colgroup>
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Name</th>
					<th class="text-center">Username</th>
					<th class="text-center">Type</th>
					<th class="text-center">Program</th>
					<th class="text-center">Rate</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
 					include 'db_connect.php';
 					$type = array("","Admin","Program Head","Alumnus/Alumna");
 					$users = $conn->query("SELECT * FROM users order by name asc");
 					$i = 1;
 					while($row= $users->fetch_assoc()):
				 ?>
				 <tr>
				 	<td class="text-center">
				 		<?php echo $i++ ?>
				 	</td>
				 	<td class="text-center">
				 		<?php echo ucwords($row['name']) ?>
				 	</td>
				 	
				 	<td class="text-center">
				 		<?php echo $row['username'] ?>
				 	</td>
				 	<td class="text-center">
				 		<?php echo $type[$row['type']] ?>
				 	</td>
					 <td class="text-center">
				 		<?php echo $row['program'] ?>
				 	</td>
					 <td class="text-center">
				 		<?php echo $row['Prate'] ?>
				 	</td>
				 	<td>
				 		<center>
								<div class="btn-group">
								  <button type="button" class="btn btn-primary">Action</button>
								  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <span class="sr-only">Toggle Dropdown</span>
								  </button>
								  <div class="dropdown-menu">
								    <a class="dropdown-item edit_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</a>
								    <div class="dropdown-divider"></div>
								    <a class="dropdown-item delete_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Delete</a>
								  </div>
								</div>
								</center>
				 	</td>
				 </tr>
				<?php endwhile; ?>
			</tbody>
		</table>
			</div>
		</div>
	</div>

</div>
<script>
	$('table').dataTable();
$('#new_user').click(function(){
	uni_modal('New User','manage_user.php')
})
$('.edit_user').click(function(){
	uni_modal('Edit User','manage_user.php?id='+$(this).attr('data-id'))
})
$('.delete_user').click(function(){
	_conf("Are you sure to delete this user?","delete_user",[$(this).attr('data-id')])
	
	})
	function delete_user($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				if(resp == 2){
                    alert_toast("This is a Admin account, deleting this account is not available. ",'warning')
                    end_load()
                }
			}
		})
	}
</script>
<script src="condition.js"></script>