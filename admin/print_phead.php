<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('../admin/db_connect.php');
ob_start();
ob_end_flush();
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <title>Manage Report</title>

<?php include('./header.php'); ?>

</head>
<body style="height: 133vh;background-color: #f0f0f0f0;">

<?php include './topbar.php' ?>
<
   <div align="center" class="container mt-5 ">
   <h5 align="center" class="title-rep" style="margin-top: 80px;">Faculty Load (Program Head) Report</h5><br>
   
</div>
<br>
<style>
</style>
<!--form-->
	<div class="container wew">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card mb-3 noprint">
					<div class="card-header noprint" style="margin-top: -50px;">
   						<center><b>Result</b></center>
					</div>
					<div class="card-body shadow">
   						<form action="../generate_phead.php" method="GET" class="noprint" target="_blank">
						   
   							<div class="row">  
   								<div class="col-md-4 form-group">
								   		<label for="" class="control-label">Choose Faculty Name</label>	
										<select name="faculty" id="" class="custom-select select2">
											<option value='0'>Select</option>
										<?php 
											$teacher = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM faculty order by concat(lastname,', ',firstname,' ',middlename) asc");
											while($row= $teacher->fetch_array()):
										?>
											<option name="faculty_name" id="faculty_name" value="<?php echo $row['id'] ?>" <?php echo isset($faculty_id) && $faculty_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
										<?php endwhile; ?>
										</select>
								</div>

								<div class="col-md-2 form-group">
								   		<label for="" class="control-label">Choose Hourly Rate</label>	
										<select name="rate" id="" class="custom-select select2" required>
											<option value='0'>Select</option>
										<?php 
											$h_rate = $conn->query("SELECT id, rate as hrate FROM hour_rate");
											while($row= $h_rate->fetch_array()):
										?>
											<option name="" id="" value="<?php echo $row['id'] ?>"><?php echo $row['hrate'] ?></option>
										<?php endwhile; ?>
										</select>
								</div>
								
								<div class="form-group for-month col-md-3">
									<label for="" class="control-label">Month from</label>
									<input type="date" name="month_start" id="month_from" class="form-control" value="<?php echo  date("f-d-Y",strtotime($month_to))?>" required>
								</div>
								<div class="form-group acad_year col-md-3">
									<label for="" class="control-label">Month to</label>
									<input type="date" name="month_end" id="month_from" class="form-control" value="<?php echo  date("f-d-Y",strtotime($month_to))?>" required>
								</div>
								
								<div class="col-md-4 form-group">
								   		<label for="" class="control-label">Choose Semester</label>	
										<select name="semester" id="" class="custom-select select2" required>
											<option value='0'>Select</option>
											<option name="" id="" value="First Semester"> First Semester</option>
											<option name="" id="" value="Second Semester"> Second Semester</option>
											<option name="" id="" value="Summer Class"> Summer Class</option>
										
										</select>
								</div>

								<div class="form-group acad_year col-md-2">
									<label for="" class="control-label">Academic Year from</label>
									<input type="text" name="year_start" id="year_start" class="form-control" value="" required>
								</div>
								<div class="form-group acad_year col-md-2">
									<label for="" class="control-label">to</label>
									<input type="text" name="year_end" id="year_end" class="form-control" value="" required>
								</div>
								
								<div class=" col-md-2 form-group option_one" align="left">
								<label for="" class="control-label">Generate PDF</label>			
									<button type="submit" name="submit" id="submit"class="btn btn-primary btn-block">Generate</button>
								</div>
						
								<div class=" col-md-2 form-group" align="left">
								<label for="" class="control-label">Undo</label>	
									<a href="index.php?page=home" type="submit" class="btn btn-danger btn-block ">Cancel</a>
								</div>
								
							</div>
						</form>
					</div>	
				</div>
				<!--endform-->
				<!--table-->
				
			</div>
		</div>
	</div>
	


    
</body>
<?php include 'footer.php' ?>
</html>