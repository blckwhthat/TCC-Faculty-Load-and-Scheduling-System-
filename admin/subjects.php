<?php include('db_connect.php');?>

<style>
	
</style>
<div class="containe-fluid" id="general_container">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-subject">
				<div class="card shadow">
					<div class="card-header">
						    Course Form
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">

							<div class="form-group">
						<label for="" class="control-label">Course</label>
						<select name="course_id" id="" class="custom-select select2">
							<option value="0">All</option>
						<?php 
							$subject_global = $conn->query("SELECT * FROM courses ");
							while($row= $subject_global->fetch_array()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($course_id) && $course_id == $row['id'] ? 'selected' : '' ?>><?php echo ($row['course']) ?></option>
						<?php endwhile; ?>
						</select> 
					</div>

							<div class="row form-group">
							<div class="col-md-6">
								<label class="control-label">Course No.</label>
								<input type="text" class="form-control" name="CPE1_Code">
							</div><!--CPE1_Code-->
							<div class="col-md-6">
								<label class="control-label">Course Code</label>
								<input type="text" class="form-control" name="CPE1_SUBJ_Code">
							</div>
							</div>
							<!--CPE1_SUBJ_Code-->
							<div class="form-group">
								<label class="control-label">Description</label>
								<textarea class="form-control" cols="30" rows='2' name="CPE1_SUBJ_Descript"></textarea>
							</div><!--CPE1_Course_Descript-->
							<div class="row form-group">
							<div class="col-md-6">
								<label class="control-label">Units</label>
								<input type="text" class="form-control" name="CPE1_Units">
								</div><!--CPE1_Units-->
								<div class="col-md-6">
								<label class="control-label">Lecture</label>
								<input type="text" class="form-control" name="CPE1_Lec">
							</div><!--CPE1_Lec-->
							
							</div>
							<div class="row form-group">
								<div class="col-md-6">
									<label class="control-label">Laboratory</label>
									<input type="text" class="form-control" name="CPE1_Lab">
								</div><!--CPE1_Lab-->
								<div class="col-md-6">
									<label class="control-label">Section</label>
									<input type="text" class="form-control" name="CPE1_Sec">
								</div><!--CPE1_Sec-->
							</div>
							
							

							
							
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="_reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8" style="width: 100%;">
				<div class="tb-tb">
				<div class="card shadow">
					<div class="card-header">
						<b>Course List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover table-responsive">
						<colgroup>
                                    <col width="1%">
                                    <col width="1%">
                                    <col width="5%">
                                    <col width="30%">
                                    <col width="1%">
                                    <col width="1%">
                                    <col width="1%">
                                    <col width="1%">
                                    <col width="10%">
                                    
							</colgroup>
							<thead>
								<tr>
									<th class="text-center">No.</th>
									<th class="text-center">Course No.</th>
									<th class="text-center">Course Code</th>
									<th class="text-center">Description</th>
									<th class="text-center">Units</th>
									<th class="text-center">Lec</th>
									<th class="text-center">Lab</th>
									<th class="text-center">Sec</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$subject = $conn->query("SELECT * FROM subject_global order by id asc");
								while($row=$subject->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center"><?php echo $row['CPE1_Code'] ?></b></td>
									<td class="text-center"><?php echo $row['CPE1_SUBJ_Code'] ?></b></td>
									<td class="text-center"><?php echo $row['CPE1_SUBJ_Descript'] ?></b></td>
									<td class="text-center"><?php echo $row['CPE1_Units'] ?></b></td>
									<td class="text-center"><?php echo $row['CPE1_Lec'] ?></b></td>
									<td class="text-center"><?php echo $row['CPE1_Lab'] ?></b></td>
									<td class="text-center"><?php echo $row['CPE1_Sec'] ?></b></td>
									<td class="text-center">
									<button class="btn btn-sm btn-primary edit_subject" type="button" data-id="<?php echo $row['id'] ?>" data-CPE1_Code="<?php echo $row['CPE1_Code'] ?>" data-CPE1_SUBJ_Code="<?php echo $row['CPE1_SUBJ_Code']?>" data-CPE1_SUBJ_Descript="<?php echo $row['CPE1_SUBJ_Descript'] ?>" data-CPE1_Units="<?php echo $row['CPE1_Units'] ?>" data-CPE1_Lec="<?php echo $row['CPE1_Lec'] ?>" data-CPE1_Lab="<?php echo $row['CPE1_Lab'] ?>" data-CPE1_Sec="<?php echo $row['CPE1_Sec'] ?>">Edit</button>
										<button class="btn btn-sm btn-danger delete_subject" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
</style>
<script>
	function _reset(){
		$('#manage-subject').get(0).reset()
		$('#manage-subject input,#manage-subject textarea').val('')
	}
	$('#manage-subject').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_subject',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
                    alert_toast("Data successfully added",'success')
                    setTimeout(function(){
                        location.reload()
                    },1500)

                }
                if(resp == 2){
                    alert_toast("Data successfully updated",'success')
                    setTimeout(function(){
                        location.reload()
                    },1500)

                }
                if(resp == 3){
                    alert_toast("This subject is already inserted.",'warning')
                    end_load()

                }
			}
		})
	})



	//Here the edit button function Start! 
	$('.edit_subject').click(function(){
		start_load()
		var cat = $('#manage-subject')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='CPE1_Code']").val($(this).attr('data-CPE1_Code'))
		cat.find("[name='CPE1_SUBJ_Code']").val($(this).attr('data-CPE1_SUBJ_Code'))
		cat.find("[name='CPE1_SUBJ_Descript']").val($(this).attr('data-CPE1_SUBJ_Descript'))
		cat.find("[name='CPE1_Units']").val($(this).attr('data-CPE1_Units'))
		cat.find("[name='CPE1_Lec']").val($(this).attr('data-CPE1_Lec'))
		cat.find("[name='CPE1_Lab']").val($(this).attr('data-CPE1_Lab'))
		cat.find("[name='CPE1_Sec']").val($(this).attr('data-CPE1_Sec'))
		end_load()
	})
	$('.delete_subject').click(function(){
		_conf("Are you sure to delete this subject?","delete_subject",[$(this).attr('data-id')])
	})



	//Here the edit and delete function end **
	function delete_subject($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_subject',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	$('table').dataTable()
</script>
<script src="condition.js"></script>