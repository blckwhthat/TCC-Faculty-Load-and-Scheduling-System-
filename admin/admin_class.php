<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		
			extract($_POST);		
			$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".md5($password)."' ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'password' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				} 
					return 1;
			}else{
				return 3;
			}
	}
	function login_faculty(){
		
		extract($_POST);		
		$qry = $this->db->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM faculty where id_no = '".$id_no."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			return 1;
		}else{
			return 3;
		}
}
	function login2(){
		
			extract($_POST);
			if(isset($email))
				$username = $email;
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			if($_SESSION['login_alumnus_id'] > 0){
				$bio = $this->db->query("SELECT * FROM alumnus_bio where id = ".$_SESSION['login_alumnus_id']);
				if($bio->num_rows > 0){
					foreach ($bio->fetch_array() as $key => $value) {
						if($key != 'passwors' && !is_numeric($key))
							$_SESSION['bio'][$key] = $value;
					}
				}
			}
			if($_SESSION['bio']['status'] != 1){
					foreach ($_SESSION as $key => $value) {
						unset($_SESSION[$key]);
					}
					return 2 ;
					exit;
				}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = '$type' ";
		$data .= ", program = '$program'"; //add this variable
		$data .= ", Prate = '$Prate'";//add this variable

		$chk = $this->db->query("SELECT * FROM users where username = '$username' and id !='$id' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
		else{
			if(empty($id)){
				$save = $this->db->query("INSERT INTO users set ".$data);
			}else{
				$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
			}
			if($save){
				return 1;
			}
		}}

		function delete_user(){
			extract($_POST);
			if($_SESSION['login_id'] == "1" ){
				return 2;
				exit();
				}
			else{
				$delete = $this->db->query("DELETE FROM users where id = ".$id);
					if($delete)
					return 1;
				}}
	function signup(){
		extract($_POST);
		$data = " name = '".$firstname.' '.$lastname."' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$uid = $this->db->insert_id;
			$data = '';
			foreach($_POST as $k => $v){
				if($k =='password')
					continue;
				if(empty($data) && !is_numeric($k) )
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
			if($_FILES['img']['tmp_name'] != ''){
							$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
							$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
							$data .= ", avatar = '$fname' ";

			}
			$save_alumni = $this->db->query("INSERT INTO alumnus_bio set $data ");
			if($data){
				$aid = $this->db->insert_id;
				$this->db->query("UPDATE users set alumnus_id = $aid where id = $uid ");
				$login = $this->login2();
				if($login)
				return 1;
			}
		}
	}
	function update_account(){
		extract($_POST);
		$data = " name = '".$firstname.' '.$lastname."' ";
		$data .= ", username = '$email' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' and id != '{$_SESSION['login_id']}' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("UPDATE users set $data where id = '{$_SESSION['login_id']}' ");
		if($save){
			$data = '';
			foreach($_POST as $k => $v){
				if($k =='password')
					continue;
				if(empty($data) && !is_numeric($k) )
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
			if($_FILES['img']['tmp_name'] != ''){
							$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
							$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
							$data .= ", avatar = '$fname' ";

			}
			$save_alumni = $this->db->query("UPDATE alumnus_bio set $data where id = '{$_SESSION['bio']['id']}' ");
			if($data){
				foreach ($_SESSION as $key => $value) {
					unset($_SESSION[$key]);
				}
				$login = $this->login2();
				if($login)
				return 1;
			}
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['settings'][$key] = $value;
		}

			return 1;
				}
	}

	
	function save_course(){
		extract($_POST);
		$data = " course = '$course' ";
		$data .= ", description = '$description' ";
			if(empty($id)){
				$save = $this->db->query("INSERT INTO courses set $data");
			}else{
				$save = $this->db->query("UPDATE courses set $data where id = $id");
			}
		if($save)
			return 1;
	}
	function delete_course(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM courses where id = ".$id);
		if($delete){
			return 1;
		}
	}
	//rooms
	function save_room(){
		extract($_POST);
		$data = " room = '$rooms' ";
		$data .= ", descript = '$description' ";
			if(empty($id)){
				$save = $this->db->query("INSERT INTO rooms_org set $data");
			}else{
				$save = $this->db->query("UPDATE rooms_org set $data where id = $id");
			}
		if($save)
			return 1;
	}
	function delete_room(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM rooms_org where id = ".$id);
		if($delete){
			return 1;
		}
	}
	//endroom
	function save_subject(){
        extract($_POST);
        $data = "CPE1_Code = '$CPE1_Code' ";
        $data .= ",CPE1_SUBJ_Code = '$CPE1_SUBJ_Code' ";
        $data .= ",CPE1_SUBJ_Descript = '$CPE1_SUBJ_Descript' ";
        $data .= ",CPE1_Units = '$CPE1_Units' ";
        $data .= ",CPE1_Lec = '$CPE1_Lec' ";
        $data .= ",CPE1_Lab = '$CPE1_Lab' ";
        $data .= ",CPE1_Sec = '$CPE1_Sec' ";
        $data .= ",course_id = '$course_id' ";

        $chk_subject = $this->db->query("SELECT CPE1_SUBJ_Descript FROM subject_global WHERE CPE1_SUBJ_Descript = '$CPE1_SUBJ_Descript' AND CPE1_SUBJ_Code = '$CPE1_SUBJ_Code' ")->num_rows;

        if($chk_subject >= 1){
            return 3;
            exit();

        }
        else{
            if(empty($id)){
                $save = $this->db->query("INSERT INTO subject_global set $data");
                return 1;
            }else{
                $save = $this->db->query("UPDATE subject_global set $data where id = $id");
                return 2;
            }
    }}
//edit function is ongoing edit



	function delete_subject(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM subject_global where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_faculty(){
		extract($_POST);
		$data = '';
		foreach($_POST as $k=> $v){
			if(!empty($v)){
				if($k !='id'){
					if(empty($data))
					$data .= " $k='{$v}' ";
					else
					$data .= ", $k='{$v}' ";
				}
			}
		}
			if(empty($id_no)){
				$i = 1;
				while($i == 1){
					$rand = mt_rand(1,99999999);
					$rand =sprintf("%'08d",$rand);
					$chk = $this->db->query("SELECT * FROM faculty where id_no = '$rand' ")->num_rows;
					if($chk <= 0){
						$data .= ", id_no='$rand' ";
						$i = 0;
					}
				}
			}

		if(empty($id)){
			if(!empty($id_no)){
				$chk = $this->db->query("SELECT * FROM faculty where id_no = '$id_no' ")->num_rows;
				if($chk > 0){
					return 2;
					exit;
				}
			}
			$save = $this->db->query("INSERT INTO faculty set $data ");
		}else{
			if(!empty($id_no)){
				$chk = $this->db->query("SELECT * FROM faculty where id_no = '$id_no' and id != $id ")->num_rows;
				if($chk > 0){
					return 2;
					exit;
				}
			}
			$save = $this->db->query("UPDATE faculty set $data where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_faculty(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM faculty where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_schedule(){
		extract($_POST);
		$data = " faculty_id = '$faculty_id' ";
		$data .= ", title = '$title' ";
		$data .= ", schedule_type = '$schedule_type' ";
		$data .= ", description = '$description' ";
		$data .= ", location = '$location' ";
		$data .= ", Csub_id = '$Csub_id' ";
		$data .= ", sem_id = '$sem_id'";
		$data .= ", yr_sec = '$yr_sec'";
		
		
		
		if(isset($is_repeating)){
			$data .= ", is_repeating = '$is_repeating' ";
			$rdata = array('start'=>$month_from.'-01','end'=>(date('Y-m-d',strtotime($month_to .'-01 +1 month - 1 day '))));
			$data .= ", repeating_data = '".json_encode($rdata)."' ";
			$data .= ", D_counter = '$D_counter' ";
			
		}else{
			$data .= ", is_repeating = 0 ";
			$data .= ", schedule_date = '$schedule_date' ";
		}
		if(isset($option_phead_id))
		{
			$data .= ", option_phead_id = '$option_phead_id' ";
		}
		$data .= ", time_from = '$time_from'";
		$data .= ", time_to = '$time_to'";
		$d = 3600;
		$data .= ", th = '".abs((strtotime($time_from)-strtotime($time_to))/$d)."'";
		//edit here start for condition
		
		$chk_id = $this->db->query("SELECT * FROM schedules where id !='$id' ")->num_rows;
		if($chk_id > 0){
			$chk_faculty = $this->db->query("SELECT faculty_id FROM schedules where faculty_id = '$faculty_id' ")->num_rows;
			if ($chk_faculty > 0 ){
				$chk_day = $this->db->query("SELECT * FROM schedules where D_counter = '$D_counter' ")->num_rows;
				if ($chk_day > 0 ){
					$chk_time = $this->db->query("SELECT time_from,time_to FROM schedules where faculty_id = '$faculty_id'")->fetch_assoc();
					if ($chk_time['time_from'] <= $time_from && $time_to <= $chk_time ['time_to'] or $time_from <= $chk_time['time_to'] && $chk_time['time_to'] <= $time_to or $time_from <= $chk_time['time_from'] && $chk_time['time_from'] <= $time_to ){
						//error msg when the faculty time schedule is same to itself
						return 2;
					}
					else{//check time else** &&&&& here where the room will check ||>>
						$chk_room = $this->db->query("SELECT location FROM schedules WHERE location ='$location' ")->num_rows;
						if($chk_room > 0){
							$chk_Rsched =  $this->db->query("SELECT time_from,time_to FROM schedules where location = '$location' ")->fetch_assoc();
							if ($chk_Rsched['time_from'] <= $time_from && $time_to <= $chk_Rsched ['time_to'] or $time_from <= $chk_Rsched['time_to'] && $chk_Rsched['time_to'] <= $time_to or $time_from <= $chk_Rsched['time_from'] && $chk_Rsched['time_from'] <= $time_to){
								//if the result have same time in 1 room it will show an error here!
										return 3;
										
							}
							else{//checking the time availability
									//then it will save the schedule**
									if(empty($id)){
										$save = $this->db->query("INSERT INTO schedules set ".$data);
										$save = $this->db->query("UPDATE faculty set Tload = (SELECT SUM(th) from schedules where schedules.faculty_id ='$faculty_id') where faculty.id = '$faculty_id'" );}
									else{
										$save = $this->db->query("UPDATE schedules set ".$data." where id=".$id);}
									if($save)
										return 1;
										
							}}
						else{//check the availability of room***
								// then the schedule will successful insterted
								if(empty($id)){
									$save = $this->db->query("INSERT INTO schedules set ".$data);
									$save = $this->db->query("UPDATE faculty set Tload = (SELECT SUM(th) from schedules where schedules.faculty_id ='$faculty_id') where faculty.id = '$faculty_id'" );}
								else{
									$save = $this->db->query("UPDATE schedules set ".$data." where id=".$id);}
								if($save)
									return 1;
							}}}
				else{//check day else**
					$chk_room = $this->db->query("SELECT location FROM schedules WHERE location ='$location' ")->num_rows;
						if($chk_room > 0){
							$chk_Rsched =  $this->db->query("SELECT time_from,time_to FROM schedules where location = '$location' ")->fetch_assoc();
							if ($chk_Rsched['time_from'] <= $time_from && $time_to <= $chk_Rsched ['time_to'] or $time_from <= $chk_Rsched['time_to'] && $chk_Rsched['time_to'] <= $time_to or $time_from <= $chk_Rsched['time_from'] && $chk_Rsched['time_from'] <= $time_to){
								//if the result have same time in 1 room it will show an error here!
										return 3;
										
							}
							else{//checking the time availability if the work sched day is not same
									//else it will save the schedule because its available **
									if(empty($id)){
										$save = $this->db->query("INSERT INTO schedules set ".$data);
										$save = $this->db->query("UPDATE faculty set Tload = (SELECT SUM(th) from schedules where schedules.faculty_id ='$faculty_id') where faculty.id = '$faculty_id'" );}
									else{
										$save = $this->db->query("UPDATE schedules set ".$data." where id=".$id);}
									if($save)
										return 1;
										
							}}
						else{//check the availability of room***
								// then the schedule will successful insterted
								if(empty($id)){
									$save = $this->db->query("INSERT INTO schedules set ".$data);
									$save = $this->db->query("UPDATE faculty set Tload = (SELECT SUM(th) from schedules where schedules.faculty_id ='$faculty_id') where faculty.id = '$faculty_id'" );}
								else{
									$save = $this->db->query("UPDATE schedules set ".$data." where id=".$id);}
								if($save)
									return 1;
							}}}
			else{//check faculty else**
			$chk_day = $this->db->query("SELECT * FROM schedules where D_counter = '$D_counter' ")->num_rows;
			if ($chk_day > 0 ){
				$chk_room = $this->db->query("SELECT location FROM schedules WHERE location ='$location' ")->num_rows;
				if($chk_room > 0){
					$chk_Rsched =  $this->db->query("SELECT time_from,time_to FROM schedules where location = '$location' ")->fetch_assoc();
					if ($chk_Rsched['time_from'] <= $time_from && $time_to <= $chk_Rsched ['time_to'] or $time_from <= $chk_Rsched['time_to'] && $chk_Rsched['time_to'] <= $time_to or $time_from <= $chk_Rsched['time_from'] && $chk_Rsched['time_from'] <= $time_to){
						//if the result have same time in 1 room it will show an error here!
								return 3;
								
					}
					else{//checking the time availability if the faculty is not same
							//then it will save the schedule because its available **
							if(empty($id)){
								$save = $this->db->query("INSERT INTO schedules set ".$data);
								$save = $this->db->query("UPDATE faculty set Tload = (SELECT SUM(th) from schedules where schedules.faculty_id ='$faculty_id') where faculty.id = '$faculty_id'" );	 }
							else{
								$save = $this->db->query("UPDATE schedules set ".$data." where id=".$id);}
							if($save)
								return 1;
								
				}}
				else{//check the availability of room***
					if(empty($id)){
						$save = $this->db->query("INSERT INTO schedules set ".$data);
						$save = $this->db->query("UPDATE faculty set Tload = (SELECT SUM(th) from schedules where schedules.faculty_id ='$faculty_id') where faculty.id = '$faculty_id'" );}
					else{
						$save = $this->db->query("UPDATE schedules set ".$data." where id=".$id);}
					if($save)
						return 1;
				}

			}
			else{
				if($chk_room > 0){
					$chk_Rsched =  $this->db->query("SELECT time_from,time_to FROM schedules where location = '$location' ")->fetch_assoc();
					if ($chk_Rsched['time_from'] <= $time_from && $time_to <= $chk_Rsched ['time_to'] or $time_from <= $chk_Rsched['time_to'] && $chk_Rsched['time_to'] <= $time_to or $time_from <= $chk_Rsched['time_from'] && $chk_Rsched['time_from'] <= $time_to){
						//if the result have same time in 1 room it will show an error here!
								return 3;
								
					}
					else{//checking the time availability if the faculty is not same
							//then it will save the schedule because its available **
							if(empty($id)){
								$save = $this->db->query("INSERT INTO schedules set ".$data);
								$save = $this->db->query("UPDATE faculty set Tload = (SELECT SUM(th) from schedules where schedules.faculty_id ='$faculty_id') where faculty.id = '$faculty_id'" );	 }
							else{
								$save = $this->db->query("UPDATE schedules set ".$data." where id=".$id);}
							if($save)
								return 1;
								
				}}
				else{//check the availability of room***
					if(empty($id)){
						$save = $this->db->query("INSERT INTO schedules set ".$data);
						$save = $this->db->query("UPDATE faculty set Tload = (SELECT SUM(th) from schedules where schedules.faculty_id ='$faculty_id') where faculty.id = '$faculty_id'" );}
					else{
						$save = $this->db->query("UPDATE schedules set ".$data." where id=".$id);}
					if($save)
						return 1;
				}}}}

		else{ //** else of chk_id
			if(empty($id)){
				$save = $this->db->query("INSERT INTO schedules set ".$data);
				$save = $this->db->query("UPDATE faculty set Tload = (SELECT SUM(th) from schedules where schedules.faculty_id ='$faculty_id') where faculty.id = '$faculty_id'" );}
			else{
				$save = $this->db->query("UPDATE schedules set ".$data." where id=".$id);}
			if($save)
				return 1;
				}}
		//end here....
		
		
	function delete_schedule(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM schedules where id = ".$id);
		if($delete){
			return 1;
		}}

	function get_schecdule(){
		extract($_POST);
		$data = array();
		$qry = $this->db->query("SELECT *,subject_global.id, subject_global.CPE1_SUBJ_Descript,schedules.id,schedules.title,schedules.description,schedules.D_counter,schedules.time_from,schedules.time_to FROM subject_global,schedules where schedules.faculty_id = 0 or schedules.faculty_id = $faculty_id and subject_global.id = schedules.title");
		while($row=$qry->fetch_assoc()){
			if($row['is_repeating'] == 1){
				$rdata = json_decode($row['repeating_data']);
				foreach($rdata as $k =>$v){
					$row[$k] = $v;
				}
			}
			$data[] = $row;
		}
			return json_encode($data);
	}
	function delete_forum(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM forum_topics where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_comment(){
		extract($_POST);
		$data = " comment = '".htmlentities(str_replace("'","&#x2019;",$comment))."' ";

		if(empty($id)){
			$data .= ", topic_id = '$topic_id' ";
			$data .= ", user_id = '{$_SESSION['login_id']}' ";
			$save = $this->db->query("INSERT INTO forum_comments set ".$data);
		}else{
			$save = $this->db->query("UPDATE forum_comments set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_comment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM forum_comments where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_event(){
		extract($_POST);
		$data = " title = '$title' ";
		$data .= ", schedule = '$schedule' ";
		$data .= ", content = '".htmlentities(str_replace("'","&#x2019;",$content))."' ";
		if($_FILES['banner']['tmp_name'] != ''){
						$_FILES['banner']['name'] = str_replace(array("(",")"," "), '', $_FILES['banner']['name']);
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['banner']['name'];
						$move = move_uploaded_file($_FILES['banner']['tmp_name'],'assets/uploads/'. $fname);
					$data .= ", banner = '$fname' ";

		}
		if(empty($id)){

			$save = $this->db->query("INSERT INTO events set ".$data);
		}else{
			$save = $this->db->query("UPDATE events set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_event(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM events where id = ".$id);
		if($delete){
			return 1;
		}
	}
	
	function participate(){
		extract($_POST);
		$data = " event_id = '$event_id' ";
		$data .= ", user_id = '{$_SESSION['login_id']}' ";
		$commit = $this->db->query("INSERT INTO event_commits set $data ");
		if($commit)
			return 1;

	}
}