<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM users where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-user" >	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input required type="password" name="password" id="password" class="form-control" value="" required>
			<?php if(isset($meta['id'])): ?>
			<small><i>Insert your password.</i></small>
		<?php endif; ?>
		</div>
		<?php if(isset($meta['type']) && $meta['type'] == 3): ?>
			<input type="hidden" name="type" value="3">
		<?php else: ?>
			<?php //add start here  >>>>>> ?>
		<div class="form-group">
					<label for="" class="control-label">Program</label>
					<select name="program" id="" class="custom-select select2">
						<option value="0">Select</option>
					<?php 
						$course = $conn->query("SELECT * FROM courses ");
						while($row= $course->fetch_array()):
					?>
						<option value="<?php echo $row['id'] ?>" <?php echo isset($row['program']) && $row['program'] == $row['course'] ? 'selected' : '' ?>><?php echo ($row['course']) ?></option>
					<?php endwhile; ?>
					</select> 
			</div>

			<div class="form-group">
					<label for="" class="control-label">Rate</label>
					<select name="Prate" id="" class="custom-select select2">
						<option value="0">Select</option>
					<?php 
						$Prate = $conn->query("SELECT * FROM hour_rate ");
						while($row= $Prate->fetch_array()):
					?>
						<option value="<?php echo $row['rate'] ?>" <?php echo isset($row['Prate']) && $row['Prate'] == $row['rate'] ? 'selected' : '' ?>><?php echo ($row['rate']) ?></option>
					<?php endwhile; ?>
					</select> 
				</div>
		<?php //add end here  >>>>>> ?>
		<?php if(!isset($_GET['mtype'])): ?>
		<div class="form-group">
			<label for="type">User Type</label>
			<select name="type" id="type" class="custom-select">
				<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Admin</option>
				<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>Program Head</option>
			</select>
		</div>
		<?php endif; ?>
		<?php endif; ?>
		

	</form>
</div>
<script>
	
	$('#manage-user').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=save_user',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
				else{
					$('#msg').html('<div class="alert alert-danger">user already exist!</div>')
					end_load()
				}
			}
		})
	})

</script>