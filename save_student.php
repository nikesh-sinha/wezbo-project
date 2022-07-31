<?php 

include 'db_connect.php';

extract($_POST);

if(empty($id)){
	
	$data=  " name='".$name."'";
	$data .=  ", class='".$class."'";
	$data .=  ", school='".mysqli_real_escape_string($conn,$school)."'";
	$data .=  ", mobile='".$mobile.",".$alt_mobile."'";
	$data .=  ", address='".mysqli_real_escape_string($conn,$address)."'";
	$data .=  ", email='".$email."'";
	$data .=  ", user_type='".$user_type."'";
	$data .=  ", password='".$password."'";
	$chk = $conn->query("SELECT * FROM users where email = '".$email."' ")->num_rows;
	$countUser = $conn->query("SELECT * FROM `users`; ")->num_rows;
	$countGrp = $conn->query("SELECT * FROM `users` WHERE `class` = '".$class."'; ")->num_rows;
	if($chk > 0){
			echo json_encode(array('status'=>2,'msg'=>'email already exist'));
			exit;
	}
	if($countGrp==0){
		$countGrp = 1;
	}
	// echo $countGrp;
	$insert_user = $conn->query('INSERT INTO users set '.$data);
	// echo $mobile.','.$alt_mobile;

	$grp = ceil($countGrp/50);
	// echo $grp;

	if($insert_user){
		$id = $conn->insert_id;
		$insert_students =$conn->query("INSERT INTO students set user_id = '".$id."', class='".$class."', grp='".$grp."' ");
		$data = [
			'name'=>$name,
			'email'=>$email,
			'group'=>$grp,
		];
		if($insert_students){
			echo json_encode(array('status'=>1,'data'=>$data));
		}
	}
}else{
	$data=  " name='".$name."'";
	$data .=  ", class='".$class."'";
	$data .=  ", school='".mysqli_real_escape_string($conn,$school)."'";
	$data .=  ", mobile='".$mobile.",".$alt_mobile."'";
	$data .=  ", address='".mysqli_real_escape_string($conn,$address)."'";
	$data .=  ", email='".$email."'";
	$data .=  ", user_type='".$user_type."'";
	$data .=  ", password='".$password."'";
	$chk = $conn->query("SELECT * FROM users where email = '".$email."' and id !='".$uid."' ")->num_rows;
	if($chk > 0){
			echo json_encode(array('status'=>2,'msg'=>'email already exist'));
			exit;
	}
	$update_user = $conn->query('UPDATE users set  '.$data.' where id ='.$uid);

	if($update_user){
		$update_students =$conn->query("UPDATE students set class='".$class."' where id = '".$id."' ");
		if($update_students){
			echo json_encode(array('status'=>1));
		}
	}
}