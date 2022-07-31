<?php 
include 'db_connect.php';
extract($_POST);
$insert = array();
// print_r(count($user_id));

foreach($user_id as $val){
	// print_r($val);

	$chk = explode("_",$val);

	// print_r(sizeof($chk));

	// print_r($chk);

	if(sizeof($chk)==1){
		if($val == 'all'){

			$query=$conn->query('SELECT * FROM users where user_type = 3 ');
			while($row=$query->fetch_assoc()){
				// echo $row['id'];
				$insert[]=$conn->query("INSERT INTO quiz_student_list set quiz_id = $qid, user_id = ".$row['id']);
			}

		}else {
			// echo $val.'<br>';
			$insert[]=$conn->query("INSERT INTO quiz_student_list set quiz_id = $qid, user_id = ".$val);
		}
	}

	if(sizeof($chk)==2){
		if($val == '6_8'){

			$query=$conn->query('SELECT * FROM `users` WHERE `user_type`= 3 AND `class` BETWEEN 6 AND 8 ');
			while($row=$query->fetch_assoc()){
					// echo $row['id'];
				$insert[]=$conn->query("INSERT INTO quiz_student_list set quiz_id = $qid, user_id = ".$row['id']);
			}
	
		}else if($val == '9_10'){
	
			$query=$conn->query('SELECT * FROM `users` WHERE `user_type`= 3 AND (`class` = 9 OR `class`=10)');
			while($row=$query->fetch_assoc()){
					// echo $row['id'];
				$insert[]=$conn->query("INSERT INTO quiz_student_list set quiz_id = $qid, user_id = ".$row['id']);
			}
	
		}else{
	
			$query=$conn->query('SELECT * FROM `users` WHERE `user_type`= 3 AND (`class` = 11 OR `class`=12)');
				while($row=$query->fetch_assoc()){
						// echo $row['id'];
					$insert[]=$conn->query("INSERT INTO quiz_student_list set quiz_id = $qid, user_id = ".$row['id']);
				}
		}
	}

	if (sizeof($chk)==3) {
		$query=$conn->query("SELECT * FROM `students` WHERE `grp` = ".$chk[2]." AND `class` BETWEEN ".$chk[0]." AND ".$chk[1]);
		while($row=$query->fetch_assoc()){
			$insert[]=$conn->query("INSERT INTO quiz_student_list set quiz_id = $qid, user_id = ".$row['user_id']);

		}
	}

	
}
	if(count($insert)>0){
		echo 1;
	}else{
		echo 2;
	}


// if($user_id[0]=='all'){
// 	$query=$conn->query('SELECT * FROM users where user_type = 3 ');
// 	while($row=$query->fetch_assoc()){
// 		// echo $row['id'];
// 		// $insert[]=$conn->query("INSERT INTO quiz_student_list set quiz_id = $qid, user_id = ".$row['id']);
// 	}
// 	if(count($insert)>0){
// 		echo 1;
// 	}
// }else if($user_id[0]=='all' || $user_id[0]=='all' ){

// }else{
// 	foreach($user_id as $val){
// 		$insert[]=$conn->query("INSERT INTO quiz_student_list set quiz_id = $qid, user_id = ".$val);
// 		echo $val;
// 	}
// 	if(count($user_id) == count($insert)){
// 		echo 1;
// 	}
// }



// if(count($user_id) > 0){
// 	echo 1;
// }