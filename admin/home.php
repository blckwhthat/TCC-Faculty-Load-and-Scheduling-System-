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
<body>
<div class="containe-fluid hom " id="general_container">
	<div class="row mt-3 ml-1 mr-1">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="divider">
                    <?php echo "Welcome back ". $_SESSION['login_name']."!"  ?>
                    <hr>
                    </div>
            
			<!-- Table Panel -->
			<div class="col-md-12" style="width: 100%;">
				<div class="card">
					<div class="card-header text-center">
						<b>Faculty Load</b>
					</div>
					<div class="card-body">
                    
						<table class="table table-bordered table-condensed table-hover table-responsive">
                            <colgroup>
                                    <col width="3%">
                                    <col width="7%">
                                    <col width="15%">
                                    <col width="18%">
                                    <col width="10%">
                                    <col width="10%">
                                    <col width="5%">
                                    <col width="25%">
                                    <col width="5%">
                                    <col width="5%">
							</colgroup>
							<thead>
								<tr>
									<th class="text-center">ID</th>
									<th class="text-center">Faculty ID</th>
									<th class="text-center">Instructor</th>
                                    <th class="text-center">Profession</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Assignment</th>
                                    <th class="text-center">= (Hours)</th>
                                    <th class="text-center">Availability</th>
                                    <th class="text-center">Load (Hours)</th>
                                    <th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
                                <?php


                            $qry = $conn->query("SELECT id FROM faculty");
                            $x = strtotime('3 hours');
                            $check_tb = mysqli_num_rows($qry);
                        if($check_tb>0){
                            $qry = $conn->query("SELECT  *,concat(lastname,', ',firstname,' ',middlename) as name FROM faculty");	
                            $days = array("SU","M","T","W","TH","F","S");
                            while ($row = $qry->fetch_assoc()){
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $row["id"];?></td>
                                    <td class="text-center"><?php echo $row["id_no"];?></td>
                                    <td class="text-center"><?php echo $row["name"];?></td>
                                    <td class="text-center"><?php echo $row["profession"];?></td>
                                    <td class="text-center"><?php echo $row["status"] ;?></td>
                                    <td class="text-center"><?php echo $row["assignment"];?></td>
                                    <td class="text-center"><?php echo $row["equivalent"];?></td>
                                    <td class="text-center"><?php echo $days[$row['datefrom_id']].' - '.$days[$row['dateto_id']].' / '.date('h:i A', strtotime($row['atime_from']))."-".date('h:i A', strtotime($row['atime_to']))?></td>
                                    <td class="text-center"><?php echo $row["Tload"] ;?></td>
                                    <td class="text-center"> <a href="index.php?page=schedule" class = "btn btn-primary btn-sm" ><i class="far fa-eye"></i>   View</a></td>
                                    
                    <?php }}?>
                    </table>
                    </div>
                </div>
            </div>      			
        </div>
    </div>
</div>   
</body>


 
<script>
	$('#manage-records').submit(function(e){
        e.preventDefault()
        start_load()
        $.ajax({
            url:'ajax.php?action=save_track',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                resp=JSON.parse(resp)
                if(resp.status==1){
                    alert_toast("Data successfully saved",'success')
                    setTimeout(function(){
                        location.reload()
                    },800)

                }
                
            }
        })
    })
    $('#tracking_id').on('keypress',function(e){
        if(e.which == 13){
            get_person()
        }
    })
    $('#check').on('click',function(e){
            get_person()
    })
    function get_person(){
            start_load()
        $.ajax({
                url:'ajax.php?action=get_pdetails',
                method:"POST",
                data:{tracking_id : $('#tracking_id').val()},
                success:function(resp){
                    if(resp){
                        resp = JSON.parse(resp)
                        if(resp.status == 1){
                            $('#name').html(resp.name)
                            $('#address').html(resp.address)
                            $('[name="person_id"]').val(resp.id)
                            $('#details').show()
                            end_load()

                        }else if(resp.status == 2){
                            alert_toast("Unknow tracking id.",'danger');
                            end_load();
                        }
                    }
                }
            })
    }
    $('table').dataTable()
</script>
<script src="condition.js"></script>
