// if($month>6)
        // {
        //     $subject_details = DB::select("select s.division,s.sub_allotment_id,c.course_name,c.course_code,c.term_id,s.contact_head from course_map as c join subject_allotment as s on c.course_code=s.course_code and c.term_id=s.term_id where s.e_id= '$eid' and s.term_id like '$year%' and s.term_id%2=1");
        // }
        // else
        // {
        //     $subject_details = DB::select("select s.division,s.sub_allotment_id,c.course_name,c.course_code,c.term_id,s.contact_head from course_map as c join subject_allotment as s on c.course_code=s.course_code and c.term_id=s.term_id where s.e_id= '$eid' and s.term_id like '$year%' and s.term_id%2=0");
        // }





          // if($month>6)
        // {
        //     $subject_details = DB::select("select s.division,s.sub_allotment_id,c.course_name,c.course_code,c.term_id,s.contact_head from course_map as c join subject_allotment as s on c.course_code=s.course_code and c.term_id=s.term_id where s.e_id= '$eid' and s.term_id like '$year%' and s.term_id%2=1");
        // }
        // else
        // {
        //     $subject_details = DB::select("select s.division,s.sub_allotment_id,c.course_name,c.course_code,c.term_id,s.contact_head from course_map as c join subject_allotment as s on c.course_code=s.course_code and c.term_id=s.term_id where s.e_id= '$eid' and s.term_id like '$year%' and s.term_id%2=0");
        // }




         public function getSubjectReport(Request $sub_allotment_id){

    	$result =  DB::select('CALL GetSubjectTotalReport('.$sub_allotment_id.')');

    	$dates = DB::select('Select uid, date, contact_head_meeting_index, attendance from attendance_record where sub_allotment_id = '.$sub_allotment_id.' order by uid, date, contact_head_meeting_index asc');

        foreach($result as $res){
            $curr_uid = $res->UID;
            foreach($dates as $date){
                if($date->uid == $curr_uid)
                    $res->dates[$date->date][] = $date->attendance;
            }
        }
    	// for ($i=0; $i < count($result); $i++) { 



    	// 	$temp = (object)((array)$result[$i]);
    	// 	$curr_uid = (array)$result[$i]->UID;

    	// 	while ($dates[$j]->uid == $curr_uid) {
    	// 		$temp[$dates[$j]->date][] = $dates[$j]->attendance;
    	// 		$j++;
    	// 	}
        //     $temp->dates[] = "Sample";
        //     $temp->dates[] = "Sample2";
        //     $sampArr[] = $temp;
            
    			
    	// 	// $result[$i] = (object)$temp;
    		
    	// }

    	return $result;
 }
    
	public function excel() {
        
        return $result = $this->getSubjectReport();

        
        // $user = DB::table('student')->where('FirstName', 'Jeffie')->first();

        // echo $user->UID;
    

    // $result =  DB::select('CALL GetSubjectTotalReport
    //  ('.$sub_allotment_id->get('id').')');

    //  $dates = DB::select('Select uid, date, contact_head_meeting_index,
    // attendance from attendance_record where sub_allotment_id ='
    // .$sub_allotment_id->get('id').' order by
    //  uid, date, contact_head_meeting_index asc'); 

    // 	$j = 0;

    // 	for ($i=0; $i < count($result); $i++) { 

    // 		$temp = (array)$result[$i];
    // 		$curr_uid = $temp["UID"];

    // 		while ($dates[$j]->uid == $curr_uid) {
    // 			$temp[$dates[$j]->date][] = $dates[$j]->attendance;
    // 			$j++;
    // 		}
    			
    // 		$result[$i] = (object)$temp;
	// 	}
     
    
    // Initialize the array which will be passed into the Excel
    // generator.
    //$resultArray = []; 

    // Define the Excel spreadsheet headers
    //$resultArray[] = ['u_id', 'First name','Last name','present ','Total','date'];

    // Convert each member of the returned collection into an array,
    // and append it to the payments array.
//    foreach ($resultArray as $result1) {
//          $resultArray[] = $result1;
//      }

    // Generate and return the spreadsheet
    // \Excel::create('student', function($excel) {

    //     // Set the spreadsheet title, creator, and description
    //     $excel->setTitle('Student');
    //     $excel->setCreator('Laravel')->setCompany('WJ Gilmore, LLC');
    //     $excel->setDescription('Attendance');

    //     // Build the spreadsheet, passing in the payments array
    //     $excel->sheet('sheet1', function($sheet) use ($result) {
    //         $sheet->fromArray($result, null, 'A1', false, false);
    //     });

    // })->download('xlsx');
    // return $result;
    // }
    }


    ------------
    query


    $query  = Student::where(1)->get();

        // return view('faculty.StudentAttendance.index')->with('StudentList', $StudentList)->with('StudentName',$StudentName)->with('Attendance',$Attendance);     
        $eid='464';
        //$year=date("y");
        $year = 16;
        $month=date("m");

        $StudentList = array();
        $Attendance = array();
        $StudentName = collect();
        foreach($SubjectAllotment as $SubAllot){
            if($month > 6){
                if(strpos($SubAllot->term_id , $year) !== false && (substr($SubAllot->term_id, -2) % 2 == 1)){
                    $List = StudentList::where('term_id', $SubAllot->term_id)->where('division', $SubAllot->division)->get();
                    foreach($List as $list){
                        $Name = StudentList::find($list->student_allotment_uid)->student()->first()->LastName;
                        $StudentName->push($Name);
                        $StudentAttendance = AttendanceRecord::where('sub_allotment_id', $list->student_allotment_uid)->get();
                        array_push($Attendance, $StudentAttendance);
                    }
                    // return $Attendance;
                    array_push($StudentList, $List);
                }
            }
            else{
                if(strpos($SubAllot->term_id , $year) !== false && (substr($SubAllot->term_id, -2) % 2 == 0)){
                    $List = StudentList::where('term_id', $SubAllot->term_id)->where('division', $SubAllot->division)->get();
                    foreach($List as $list){
                        $Name = StudentList::find($list->student_allotment_uid)->student()->first()->LastName;
                        $StudentName->push($Name);
                        $StudentAttendance = AttendanceRecord::where('sub_allotment_id', $list->student_allotment_uid)->get();
                        array_push($Attendance, $StudentAttendance);
                    }
                    // return $Attendance;
                    array_push($StudentList, $List);
                }
            }
        }