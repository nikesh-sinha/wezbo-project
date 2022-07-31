<?php 

include 'db_connect.php';
extract($_POST);


if(empty($id)){
	// $last_order = $conn->query("SELECT * FROM questions where qid = $qid order by order_by desc limit 1")->fetch_array()['order_by'];
	// $order_by = $last_order > 0 ? $last_order + 1 : 0;
	$data = 'question = "'.mysqli_real_escape_string($conn,$question).'" ';
	// $data .= ', order_by = "'.$order_by.'" ';
	$data .= ', order_by = "0" ';
	$data .= ', qid = "'.$qid.'" ';
	// echo $last_order;

	if(isset($_FILES["question_img"])){

		$targetDir = "image_question/";
		$fileName = basename($_FILES["question_img"]["name"]);
		$targetFilePath = $targetDir . $fileName;
		$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
		$rndno = rand(0,10000);
		$newName = 'que_'.time()."_".$rndno.'.'.$fileType;

		$data .= ', question_img = "'.$newName.'"';

		// echo json_encode($data);
		if(move_uploaded_file($_FILES["question_img"]["tmp_name"],"image_question/".$newName)){
			$insert_question = $conn->query("INSERT INTO questions set ".$data);
		}
	}else{
		$insert_question = $conn->query("INSERT INTO questions set ".$data);
		// echo 1;
	}
	
	if($insert_question){

		$question_id = $conn->insert_id;
		$insert = array();

		// print_r($question_opt);
		// print_r($is_right);

		// print_r($_FILES['option_img']);
		$newName = array();

		for($i = 0 ; $i < count($question_opt);$i++){
			// $is_right = isset($is_right[$i]) ? $is_right[$i] : 0;
			if(isset($_FILES['option_img'.(string)$i])){
				$opt_img = $_FILES['option_img'.(string)$i];
				// print_r($_FILES['option_img'.(string)$i]['name']);
				$targetDir = "image_answer/";
				$fileName = basename($_FILES['option_img'.(string)$i]['name']);
				$targetFilePath = $targetDir . $fileName;
				$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
				$rndno = rand(0,10000);
				$newName[$i] = 'ans_'.time()."_".$rndno.'.'.$fileType;
				// print_r($_FILES['option_img'.(string)$i]['tmp_name'].'->'.$newName[$i]);
				if(move_uploaded_file($_FILES['option_img'.(string)$i]['tmp_name'],'image_answer/'.$newName[$i])){
					$insert[] = $conn->query("INSERT INTO question_opt set question_id = $question_id, option_txt = '".$question_opt[$i]."',`is_right` = '".$is_right[$i]."',`option_img` = '".$newName[$i]."'");
				}
			}else{
				$insert[] = $conn->query("INSERT INTO question_opt set question_id = $question_id, option_txt = '".$question_opt[$i]."',`is_right` = '".$is_right[$i]."' ");
			}
				
		}
		if(count($insert) == 4){
			echo 1;
		}else{
			$delete = $conn->query("DELETE FROM questions where id =".$question_id);
			$delete2 = $conn->query("DELETE FROM question_opt where question_id =".$question_id);
			echo 2;
			
		}

	}
}else{

		$data = 'question = "'.$question.'" ';
		$data .= ', qid = "'.$qid.'" ';
		$update = $conn->query("UPDATE questions set ".$data." where id = ".$id);
		if($update){
			$delete= $conn->query("DELETE FROM question_opt where question_id =".$id);
			$insert = array();
			for($i = 0 ; $i < count($question_opt);$i++){
				// $answer = isset($is_right[$i]) ? 1 : 0;
				$insert[] = $conn->query("INSERT INTO question_opt set question_id = $id, option_txt = '".$question_opt[$i]."',`is_right` = '".$is_right[$i]."'");
				// echo "INSERT INTO question_opt set question_id = $id, option_txt = '".$question_opt[$i]."',`is_right` = $answer <br>";
				
			}
			if(count($insert) == 4){
				echo 1;
			}else{
				$delete = $conn->query("DELETE FROM questions where id =".$id);
				$delete2 = $conn->query("DELETE FROM question_opt where question_id =".$id);
				echo 2;
				
			}

			}
	}
?>