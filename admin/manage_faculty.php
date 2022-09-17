<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM faculty where id=".$_GET['id'])->fetch_array();
	foreach($qry as $k =>$v){
		$$k = $v;
	}
}

?>
<style>

</style>

<div class="container-fluid">
	<form action="" id="manage-faculty">
		<div id="msg"></div>
				<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id']:'' ?>" class="form-control">
		<div class="row form-group">
			<div class="col-md-4">
						<label class="control-label">ID No.</label>
						<input type="text" name="id_no" class="form-control" value="<?php echo isset($id_no) ? $id_no:'' ?>" >
						<small><i>Leave this blank if you want to a auto generate ID no.</i></small>
					</div>

					<div class="col-md-4">
				<label class="control-label-stat">Status</label>
				<select name="status" required="" class="custom-select" id="">
					<option <?php echo isset($status) && $status == 'Full-time' ? 'selected' : '' ?>>Full-time</option>
					<option <?php echo isset($status) && $status == 'Part-time' ? 'selected' : '' ?>>Part-time</option>
				</select>
			</div>
		</div>
		


		<div class="row form-group">
			<div class="col-md-4">
				<label class="control-label">Last Name</label>
				<input type="text" name="lastname" class="form-control" value="<?php echo isset($lastname) ? $lastname:'' ?>" required>
			</div>
			<div class="col-md-4">
				<label class="control-label">First Name</label>
				<input type="text" name="firstname" class="form-control" value="<?php echo isset($firstname) ? $firstname:'' ?>" required>
			</div>
			<div class="col-md-4">
				<label class="control-label">Middle Name</label>
				<input type="text" name="middlename" class="form-control" value="<?php echo isset($middlename) ? $middlename:'' ?>">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-4">
				<label class="control-label">Email</label>
				<input type="email" name="email" class="form-control" value="<?php echo isset($email) ? $email:'' ?>" required>
			</div>
			<div class="col-md-4">
				<label class="control-label">Contact #</label>
				<input type="text" name="contact" class="form-control" value="<?php echo isset($contact) ? $contact:'' ?>" required>
			</div>
			<div class="col-md-4">
				<label class="control-label">Gender</label>
				<select name="gender" required="" class="custom-select" id="">
					<option <?php echo isset($gender) && $gender == 'Male' ? 'selected' : '' ?>>Male</option>
					<option <?php echo isset($gender) && $gender == 'Female' ? 'selected' : '' ?>>Female</option>
				</select>
			</div>
		</div>
		<!--edited -->
		<div class="row form-group">
			<div class="col-md-5">
					<label class="control-label">Profession</label>
					<input type="text" name="profession" class="form-control" value="<?php echo isset($profession) ? $profession:'' ?>" required>
			</div>
			<div class="col-md-4">
					<label class="control-label">Assignment</label>
					<input type="text" name="assignment" class="form-control" value="<?php echo isset($assignment) ? $assignment:'' ?>" required>
			</div>
			<div class="col-md-3">
					<label class="control-label">Equivalence</label>
					<input type="text" name="equivalent" class="form-control" value="<?php echo isset($equivalent) ? $equivalent:'' ?>" required>
			</div>
		</div>
		<span> <b>Availability:</b> </span>
		<div class="row form-group">
			
			<div class="col-md-3">
				<label class="control-label">Days from </label>
				<select name="datefrom_id" id="" class="custom-select select2">
							<option value="0">Select</option>
						<?php 
							$dday = $conn->query("SELECT * FROM sday ");
							while($row= $dday->fetch_array()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($datefrom_id) && $datefrom_id == $row['id'] ? 'selected' : '' ?>><?php echo ($row['days']) ?></option>
						<?php endwhile; ?>
						</select> 
			</div>
			<div class="col-md-3">
				<label class="control-label">Days To </label>
				<select name="dateto_id" id="" class="custom-select select2">
							<option value="0">Select</option>
						<?php 
							$dday = $conn->query("SELECT * FROM sday ");
							while($row= $dday->fetch_array()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($dateto_id) && $dateto_id == $row['id'] ? 'selected' : '' ?>><?php echo ($row['days']) ?></option>
						<?php endwhile; ?>
						</select> 
			</div>
			<div class="col-md-3">
						<label for="" class="control-label">Time From</label>
						<input type="time" name="atime_from" id="atime_from" class="form-control" value="<?php echo isset($atime_from) ? $atime_from : '' ?>">
					</div>
					<div class="col-md-3">
						<label for="" class="control-label">Time To</label>
						<input type="time" name="atime_to" id="atime_to" class="form-control" value="<?php echo isset($atime_to) ? $atime_to : '' ?>">
					</div>
		</div>
		
		
		
		<!--edited -->
		<div class="row form-group">
			<div class="col-md-12">
				<label class="control-label">Address</label>
				<textarea name="address" class="form-control"><?php echo isset($address) ? $address : '' ?></textarea>
			</div>
		</div>
	</form>
</div>

<script>
	$('#manage-faculty').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_faculty',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast("Data successfully saved.",'success')
					setTimeout(function(){
						location.reload()
					},1000)
				}else if(resp == 2){
					$('#msg').html('<div class="alert alert-danger">ID No already existed.</div>')
					end_load();
				}
			}
		})
	})
</script>

