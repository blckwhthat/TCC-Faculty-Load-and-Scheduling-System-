<?php 
session_start(); 
include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM schedules where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
}
?>
<style>
	
	
</style>
<div class="container-fluid">
	<form action="" id="manage-schedule">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="col-lg-16">
			<div class="row">
				<div class="col-md-6">
					<!--this condition is for the information of data error on the system** -->
					<div class="form-group">
						<div class="form-check">
						  <input class="form-check-input" type="checkbox" value="0" id="options" name="options" <?php echo isset($option_phead) && $option_phead == 1 ? '' : 'unchecked' ?>>
						  <label class="form-check-label" for="type">
						   	<i>Click if Faculty is a Program Head</i> 
						  </label>
						</div>
					</div>
					<div class="form-group options-inc" style="display: none;">
					<label for="" class="control-label">Options</label>
						<select name="option_phead_id" id="" class="custom-select select2">
							<option value="0">Select</option>
						<?php 
							$options = $conn->query("SELECT * FROM opt_phead");
							while($row= $options->fetch_array()):
						?>
							<option value="<?php echo $row['id'] ?>"<?php echo isset($option_phead_id) && $option_phead_id == $row['id'] ? 'selected' : '' ?>><?php echo ($row['options']) ?></option>
						<?php endwhile; ?>
						</select> 
					</div>
					<div class="form-group">
						<label for="" class="control-label">Faculty</label>
						<select name="faculty_id" id="" class="custom-select select2">
							<option value="0">Select</option>
						<?php 
							$faculty = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM faculty order by concat(lastname,', ',firstname,' ',middlename) asc");
							while($row= $faculty->fetch_array()):
						?>
							<option value="<?php echo $row['id'] ?>"<?php echo isset($row['faculty_id']) && $row['faculty_id'] == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
						<?php endwhile; ?>
						</select> 
					</div>


					<div class="form-group"> <?php //start here ** ?>
                        <label for="" class="control-label">Program</label>
                        <select name="Csub_id" id="" class="custom-select select2 ">
                        <?php 

                            $course = $conn->query("SELECT users.id, users.program, courses.id, courses.course FROM users,courses WHERE users.id = '" .$_SESSION['login_id']. "'"."AND courses.id = users.program");
                            while($row= $course->fetch_array()):;
                        ?>
                        <option value="<?php echo $row['id'] ?>"<?php echo isset($row['Csub_id']) && $row['Csub_id'] == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['course']) ?></option>
                        <?php endwhile; ?>
                        </select>
                    </div> <?php //end here ** ?>

					<div class="form-group">
						<label for="" class="control-label">Year and Section</label>
						<select name="yr_sec" id="" class="custom-select select2">
							<option value="0">Select</option>
						<?php 
							$sections = $conn->query("SELECT * FROM sections ");
							while($row= $sections->fetch_array()):
						?>
							<option value="<?php echo $row['section'] ?>" <?php echo isset($row['yr_sec']) && $row['yr_sec'] == $row['section'] ? 'selected' : '' ?>><?php echo ($row['section']) ?></option>
						<?php endwhile; ?>
						</select>

					</div>

					<div class="form-group">
						<label for="" class="control-label">Semester</label>
						<select name="sem_id" id="" class="custom-select select2">
							
						<?php 
							$semester = $conn->query("SELECT * FROM semester ");
							while($row= $semester->fetch_array()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($sem_id) && $sem_id == $row['id'] ? 'selected' : '' ?>><?php echo ($row['semval']) ?></option>
						<?php endwhile; ?>
						</select> 
					</div>

					
					<?php if ($_SESSION['login_id'] == "1"){?>

					<?php //start here ** ?>
					<div class="form-group">
						<label for="" class="control-label">Subject</label>
						<select name="title" id="" class="custom-select select2">
							<option value="0">Select</option>
						<?php 
							$subject_global = $conn->query("SELECT * FROM subject_global ");
							while($row= $subject_global->fetch_array()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($title) && $title == $row['id'] ? 'selected' : '' ?>><?php echo ($row['CPE1_SUBJ_Descript']) ?></option>
						<?php endwhile; ?>
						</select> 
					</div>

					<?php          }
						else {?>
					<div class="form-group">
						<label for="" class="control-label">Subject</label>
						<select name="title" id="" class="custom-select select2">
							<option value="0">Select</option>
						<?php 
							$subject_global = $conn->query("SELECT users.id, users.program,subject_global.course_id, subject_global.CPE1_SUBJ_Descript,subject_global.id FROM subject_global,users WHERE users.id = '".$_SESSION['login_id'] ."'". "AND users.program = subject_global.course_id ");
							while($row= $subject_global->fetch_array()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($title) && $title == $row['id'] ? 'selected' : '' ?>><?php echo ($row['CPE1_SUBJ_Descript']) ?></option>
						<?php endwhile; ?>
						</select> 
					</div><?php }//end here ** ?>


					<div class="form-group">
						<label for="" class="control-label">Schedule Type</label>
						<select name="schedule_type" id="" class="custom-select">
							<option value="1" <?php echo isset($schedule_type) && $schedule_type == 1 ? 'selected' : ''  ?>>Class</option>
							<option value="2" <?php echo isset($schedule_type) && $schedule_type == 2 ? 'selected' : ''  ?>>Meeting</option>
							<option value="3" <?php echo isset($schedule_type) && $schedule_type == 3 ? 'selected' : ''  ?>>Others</option>
						</select>
					</div>

					


					<div class="form-group">
						<label for="" class="control-label">Description</label>
						<textarea class="form-control" name="description" cols="30" rows="3"><?php echo isset($description) ? $description : '' ?></textarea>
					</div>
			

					<div class="form-group">
						<div class="form-check">
						  <input class="form-check-input" type="checkbox" value="1" id="is_repeating" name="is_repeating" <?php echo isset($is_repeating) && $is_repeating != 1 ? '' : 'checked' ?>>
						  <label class="form-check-label" for="type">
						   	Weekly Schedule
						  </label>
						</div>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group for-repeating">
					
						<label for="" class="control-label">Days</label>
						<select name="D_counter" id="" class="custom-select select2">
							<option value="0">Select</option>
						<?php 
							$dday = $conn->query("SELECT * FROM sday ");
							while($row= $dday->fetch_array()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($D_counter) && $D_counter == $row['id'] ? 'selected' : '' ?>><?php echo ($row['days']) ?></option>
						<?php endwhile; ?>
						</select> 
					
					</div>
					<div class="form-group for-repeating">
						<label for="" class="control-label">Month From</label>
						<input type="month" name="month_from" id="month_from" class="form-control" value="<?php echo isset($start) ? date("Y-m",strtotime($start)) : '' ?>">
					</div>
					<div class="form-group for-repeating">
						<label for="" class="control-label">Month To</label>
						<input type="month" name="month_to" id="month_to" class="form-control" value="<?php echo isset($end) ? date("Y-m",strtotime($end)) : '' ?>">
					</div>
					<div class="form-group for-nonrepeating" style="display: none">
						<label for="" class="control-label">Schedule Date</label>
						<input type="date" name="schedule_date" id="schedule_date" class="form-control" value="<?php echo isset($schedule_date) ? $schedule_date : '' ?>">
					</div>
					<div class="form-group">
						<label for="" class="control-label">Time From</label>
						<input type="time" name="time_from" id="time_from" class="form-control" value="<?php echo isset($time_from) ? $time_from : '' ?>">
					</div>
					<div class="form-group">
						<label for="" class="control-label">Time To</label>
						<input type="time" name="time_to" id="time_to" class="form-control" value="<?php echo isset($time_to) ? $time_to : '' ?>">
					</div>

					

					<div class="form-group">
						<label for="" class="control-label">Location</label>
						<select name="location" id="" class="custom-select select2">
							<option value="0">Select</option>
						<?php 
							$rooms_org = $conn->query("SELECT *, concat(room,' ',descript) as room_name FROM rooms_org ");
							while($row= $rooms_org->fetch_array()):
						?>
							<option value="<?php echo $row['room'] ?>" <?php echo isset($location) && $location == $row['room_name'] ?>><?php echo $row['room_name'] ?></option>
						<?php endwhile; ?>
						</select> 
					</div>
				</div>
			</div>
		</div>
	</form>
				

</div>
<div class="imgF" style="display: none " id="img-clone">
			<span class="rem badge badge-primary" onclick="rem_func($(this))"><i class="fa fa-times"></i></span>
	</div>
<script>
	if('<?php echo isset($id) ? 1 : 0 ?>' == 1){
		if($('#is_repeating').prop('checked') == true){
			$('.for-repeating').show()
			$('.for-nonrepeating').hide()
		}else{
			$('.for-repeating').hide()
			$('.for-nonrepeating').show()
		}
	}
	$('#is_repeating').change(function(){
		if($(this).prop('checked') == true){
			$('.for-repeating').show()
			$('.for-nonrepeating').hide()
		}else{
			$('.for-repeating').hide()
			$('.for-nonrepeating').show()
		}
	})
	if('<?php echo isset($id) ? 1 : 0 ?>' == 1){
		if($('#options').prop('unchecked') == true){
			$('.options-inc').hide()
		}else{
			$('.options-inc').hide()	
		}
	}
	$('#options').change(function(){
		if($(this).prop('checked') == true){
			$('.options-inc').show()
			
		}else{
			$('.options-inc').hide()
			
		}
	})
	$('.select2').select2({
		placeholder:'Please Select Here',
		width:'100%'
	})
	$('#manage-schedule').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_schedule',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast("Saving schedule.... ",'success')
					setTimeout(function(){
						setTimeout(function(){
							location.reload()
							alert_toast("Schedule save successfully",'success')
						},1500)
					},2500)
				}
				if (resp == 2){
					alert_toast("Time schedule is already taken.",'danger')
					end_load()
				}
				if (resp == 3){
					alert_toast("Room is already taken.",'danger')
					end_load()
				}
				
			}
		})
	})
	
</script>
