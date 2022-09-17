<?php
include '../load/admin/db_connect.php';
require_once('fpdf.php');

$pdf = new FPDF('P','mm','A4');
            
 
            $name = $_GET['faculty'];
            $hhrate = $_GET['rate'];
            $month_s = $_GET['month_start'];
            $month_e = $_GET['month_end'];
            $year_s = $_GET['year_start'];
            $year_e = $_GET['year_end'];
            $semester = $_GET['semester'];

            
            $pdf->SetMargins(10, 10, 10);
            $pdf->AddPage();
            //header
            $pdf->Image('img/tanauanlogo.png',10,10,-300);
            $pdf->SetFont('Arial','B',10);
            $pdf->SetX(45);
            $pdf->Cell(200,5,"Republic of the Philippines",0,1,'L');
            $pdf->SetX(45);
            $pdf->Cell(200,5,"Province of Batangas",0,1,'L');
            $pdf->SetX(45);
            $pdf->Cell(200,5,"CITY OF TANAUAN",0,1,'L');
            $pdf->Ln();
            $pdf->SetFont('Arial','B',13);
            $pdf->SetX(45);
            $pdf->Cell(220,5,"TANAUAN CITY COLLEGE",0,1,'L');
            $pdf->SetFont('Arial','B',12);
            $pdf->SetX(45);
            $pdf->Cell(200,5,"TANAUANCityofColors",0,1,'L');
            $pdf->Image('img/mabinilogo.jpg',120,10,-250);
            $pdf->Image('img/tcclogo.png',164,10,-245);
            //break;
            $pdf->Ln();
            $pdf->SetX(5);
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(200,4,"E-mail: tanauancitycollege@gmail.com   Tel. No.: (043) 702 6979; (043) 706 6961; (043) 706 3934",0,1,'C');
            $pdf->SetX(5);
            $pdf->Cell(200,4,"URL:  https://www.facebook.com/pages/Tanauan-City-College/554034167997845",0,1,'C');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(5,55,205,55);
            $pdf->SetLineWidth(0.2);
            $pdf->Line(5,56,205,56);
            //header end
            //body
            $pdf->Ln(5);
            $pdf->SetX(5);
            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(200,4,"TEACHING ASSIGNMENT OF COLLEGE FACULTY",0,1,'C');
            $pdf->Ln(12);
            $pdf->SetX(10);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(200,4,"Name:",0,0,'L');
            //name here
            $faculty=$conn->query("SELECT concat(lastname,', ',firstname,' ',middlename) as name from faculty where id=$name order by concat(lastname,', ',firstname,' ',middlename) ");
			while($row=$faculty->fetch_assoc())
            {
                $pdf->SetX(25);
                $str=$row['name'];
                $str = strtoupper($str);
                $pdf->Cell(200,4,$str,0,0,'L');
            }
            $pdf->Ln(7);
            $pdf->SetX(10);
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(200,4,"You are assigned to teach the following course/s as faculty member of the College Department during the ".$semester,0,1,'L');
            //$pdf->SetX(10);
            $pdf->Cell(200,4,"of Academic Year ".$year_s."-".$year_e. " from ".date('F d, Y', strtotime($month_s))." to ".date('F d, Y', strtotime($month_e)).".",0,1,'L'); 
           //inclusive
            $inc_total = $conn->query("SELECT SUM(th) as total_inc FROM schedules WHERE faculty_id = $name AND option_phead_id =1");
            while($row=$inc_total->fetch_assoc())
            {
                $pdf->Ln(4);
                $pdf->SetX(10);
                $pdf->SetFont('Arial','B',11);
                $pdf->Cell(20,5,"INCLUSIVE: ".$row['total_inc']." HOURS",0,0,'L');
                $pdf->Ln(4);
            }
            $pdf->Ln(5);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(20,5,"SUBCODE",1,0,'C');
            $pdf->Cell(10,5,"SEC",1,0,'C');
            $pdf->Cell(50,5,"DESCRIPTION",1,0,'C');
            $pdf->Cell(25,5,"PROGRAM",1,0,'C');
            $pdf->Cell(15,5,"ROOM",1,0,'C');
            $pdf->Cell(15,5,"DAY",1,0,'C');
            $pdf->Cell(29,5,"TIME",1,0,'C');    
            $pdf->Cell(13,5,"UNIT",1,0,'C');
            $pdf->Cell(13,5,"HRS",1,1,'C');
            $res=$conn->query("SELECT schedules.option_phead_id, schedules.title, subject_global.CPE1_SUBJ_Code, subject_global.CPE1_Sec, subject_global.CPE1_SUBJ_Descript, courses.course, courses.id, schedules.Csub_id, schedules.yr_sec, schedules.D_counter, schedules.time_from, schedules.time_to, subject_global.CPE1_Units, schedules.th, schedules.location FROM schedules, subject_global, courses where  faculty_id = $name AND schedules.title = subject_global.id AND courses.id = schedules.Csub_id AND option_phead_id = 1");
            $days = array("SU","M","T","W","TH","F","S");
            while($row=$res->fetch_assoc())
            {
                    $pdf->SetFont('Arial','',7.5);
                    $pdf->Cell(20,5,$row['CPE1_SUBJ_Code'],1,0,'C');
                    $pdf->Cell(10,5,$row['CPE1_Sec'],1,0,'C');
                    $pdf->Cell(50,5,$row['CPE1_SUBJ_Descript'],1,0,'C');
                    $pdf->Cell(25,5,$row['course']."-".$row['yr_sec'],1,0,'C');
                    $pdf->Cell(15,5,$row['location'],1,0,'C');
                    $pdf->Cell(15,5,$days[$row['D_counter']],1,0,'C');
                    $pdf->Cell(29,5,date('h:i A', strtotime($row['time_from']))."-".date('h:i A', strtotime($row['time_to'])),1,0,'C');
                    $pdf->Cell(13,5,$row['CPE1_Units'],1,0,'C');
                    $pdf->Cell(13,5,$row['th'],1,1,'C');
            }
            //exploded
            $pdf->Ln(4);
            $pdf->SetX(10);
            $pdf->SetFont('Arial','B',11);
            $pdf->Cell(20,5,"OVERLOAD",0,0,'L');
            $pdf->Ln(4);
            $pdf->Ln(5);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(20,5,"SUBCODE",1,0,'C');
            $pdf->Cell(10,5,"SEC",1,0,'C');
            $pdf->Cell(50,5,"DESCRIPTION",1,0,'C');
            $pdf->Cell(25,5,"PROGRAM",1,0,'C');
            $pdf->Cell(15,5,"ROOM",1,0,'C');
            $pdf->Cell(15,5,"DAY",1,0,'C');
            $pdf->Cell(29,5,"TIME",1,0,'C');
            $pdf->Cell(13,5,"UNIT",1,0,'C');
            $pdf->Cell(13,5,"HRS",1,1,'C');
            $res=$conn->query("SELECT schedules.option_phead_id, schedules.title, subject_global.CPE1_SUBJ_Code, subject_global.CPE1_Sec, subject_global.CPE1_SUBJ_Descript, courses.course, courses.id, schedules.Csub_id, schedules.yr_sec, schedules.D_counter, schedules.time_from, schedules.time_to, subject_global.CPE1_Units, schedules.th, schedules.location FROM schedules, subject_global, courses where  faculty_id = $name AND schedules.title = subject_global.id AND courses.id = schedules.Csub_id AND option_phead_id = 2 ");
            $days = array("SU","M","T","W","TH","F","S");
            while($row=$res->fetch_assoc())
            {
                    $pdf->SetFont('Arial','',7.5);
                    $pdf->Cell(20,5,$row['CPE1_SUBJ_Code'],1,0,'C');
                    $pdf->Cell(10,5,$row['CPE1_Sec'],1,0,'C');
                    $pdf->Cell(50,5,$row['CPE1_SUBJ_Descript'],1,0,'C');
                    $pdf->Cell(25,5,$row['course']."-".$row['yr_sec'],1,0,'C');
                    $pdf->Cell(15,5,$row['location'],1,0,'C');
                    $pdf->Cell(15,5,$days[$row['D_counter']],1,0,'C');
                    $pdf->Cell(29,5,date('h:i A', strtotime($row['time_from']))."-".date('h:i A', strtotime($row['time_to'])),1,0,'C');
                    $pdf->Cell(13,5,$row['CPE1_Units'],1,0,'C');
                    $pdf->Cell(13,5,$row['th'],1,1,'C');
            }
            
            $pdf->SetFont('Arial','',10);   
            $pdf->Ln(5);
            $pdf->Cell(100,4,"Total Number of Hours in a Week: ",0,0,'L');
            //TOTAL NUMBER OF HOURS HERE
            $total_hours=$conn->query("SELECT Tload from faculty where id = $name");
            while($row=$total_hours->fetch_assoc())
            {
                $pdf->SetFont('Arial','B',10);
                $pdf->SetX(65);
                $pdf->Cell(20,4,$row['Tload']." HOURS",0,0,'L');
            }
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(100,4,"Hourly Rate: ",0,0,'C');
            $totalrate=$conn->query("SELECT rate from hour_rate where id = $hhrate");
            
            while($row=$totalrate->fetch_array())
            {
                $pdf->SetFont('Arial','B',10);
                $pdf->SetX(145);
                setlocale(LC_MONETARY,"en_PH");
                $pdf->Cell(20,4,"P ".number_format($row['rate']).".00",0,1,'L');
            }
            //TOTAL RATE
            $pdf->SetFont('Arial','',10);
            $pdf->Ln(4);
            $pdf->SetX(10);
            $pdf->Cell(200,4,"These assignments include the attendance to faculty meetings, seminars, conferences and other academic and non-aca ",0,1,'L');
            $pdf->SetX(10);
            $pdf->Cell(200,4,"demic-related school activities.",0,1,'L');
            $pdf->Ln(4);
            $pdf->SetX(10);
            $pdf->Cell(200,4,"NOTE: The assigned faculty member agreed to complete the semester, and promptly submit the necessary documents a",0,1,'L');
            $pdf->SetX(10);
            $pdf->Cell(200,4,"nd comply with all the requirements in accordance with the College policy. Failure on the part of the faculty to observe his",0,1,'L');
            $pdf->SetX(10);
            $pdf->Cell(200,4,"/her responsibility is a legal ground not to be given any teaching load or shall give the automatic right to the Administration",0,1,'L');
            $pdf->SetX(10);
            $pdf->Cell(200,4,"to withdraw this/these teaching load(s).",0,1,'L');
            
            $pdf->Ln(7);
            $pdf->SetX(10);
            $pdf->Cell(100,4,"Recommending Approval:",0,1,'L');
            $pdf->Ln(7);
            $pdf->SetX(10);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,4,"DR. JOEVELL P. JOVELLANO, CSAS",0,1,'L');
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(100,4,"Vice-President for Academic Affairs",0,1,'L');
            $pdf->Ln(7);
            $pdf->SetX(10);
            $pdf->Cell(100,4,"Approved:",0,1,'L');
            $pdf->Ln(7);
            $pdf->SetX(10);
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(100,4,"MR. MICHAEL E. LIRIO, CPA, MMPA",0,1,'L');
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(100,4,"President / College Administrator",0,1,'L');
            
            $pdf->Ln(10);
            $pdf->SetX(10);
            $pdf->Cell(100,4,"Conforme: _____________________________________________",0,0,'L');
            $pdf->Cell(100,4,"Date: ___________________________",0,1,'C');
            
            $pdf->Output();
        
        
?>