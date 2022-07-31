<!DOCTYPE html>
<html lang="en">
<head>
	</head>
	<?php include('header.php') ?>
	<?php include('auth.php') ?>
	<?php include('db_connect.php') ?>
	<title>Quiz List</title>

	<?php 
	$qry = $conn->query("SELECT * FROM quiz_list where id = ".$_GET['id'])->fetch_array();

	?>
</head>
<body>
	<?php include('nav_bar.php') ?>
	
	<div class="container m-4 mx-auto">
		<div class="col-md-12 alert alert-primary"><?php echo $qry['title'] ?></div>
		<button class="btn btn-primary bt-sm" id="new_question"><i class="fa fa-plus"></i>	Add Question</button>
		<button class="btn btn-primary bt-sm" id="new_student"><i class="fa fa-plus"></i>	Add Student</button>
		<br>
		<br>
		<div class="card col-md-6 mr-4" style="float:left">
			<div class="card-header">
				Questions
			</div>
			<div class="card-body">
				<ul class="list-group">
				<?php
					$qry = $conn->query("SELECT * FROM questions where qid = ".$_GET['id']." order by order_by asc");
					while($row=$qry->fetch_array()){
						?>
						<li class="list-group-item text-dark"><?php echo $row['question'] ?><br>
							<center>
								<button class="btn btn-sm btn-outline-primary edit_question" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-edit"></i></button>
								<button class="btn btn-sm btn-outline-danger remove_question" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-trash"></i></button>
							</center>
						</li>
				<?php
					}
				?>
				</ul>
		</div>
	</div>
	<div class="card col-md-5" style="float:left">
			<div class="card-header">
				Students
			</div>
			<div class="card-body">
				<ul class="list-group">
				<?php
					$qry = $conn->query("SELECT u.*,q.id as qid FROM users u left join quiz_student_list q on u.id = q.user_id where q.quiz_id = ".$_GET['id']." order by u.name asc");
					while($row=$qry->fetch_array()){
						?>
						<li class="list-group-item text-dark"><?php echo ucwords($row['name']) ?>
								<button class="btn btn-sm btn-outline-danger remove_student pull-right" data-id="<?php echo $row['id']?>" data-qid='<?php echo $row['qid'] ?>' type="button"><i class="fa fa-trash"></i></button>
						</li>
				<?php
					}
				?>
				</ul>
		</div>
	</div>
	<div class="modal fade" id="manage_question" tabindex="-1" role="dialog" >
				<div class="modal-dialog modal-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							
							<h4 class="modal-title" id="myModallabel">Add New Question</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<form id='question-frm' enctype="multipart/form-data" >
							<div class ="modal-body">
								<div id="msg"></div>
								<div class="form-group">
									<label>Question</label>
									<input type="hidden" name="qid" value="<?php echo $_GET['id'] ?>" />
									<input type="hidden" name="id" />
									<input type="file" id="question_img" name="question_img">
									<textarea rows='3' name="question" required="required" class="form-control" ></textarea>
								</div>
									<label>Options:</label>

								<div class="form-group">
									<input type="file" name="option_img0">
									<textarea rows="2" name ="question_opt[0]"  class="form-control" ></textarea>
									<span>
									<label><input type="radio" name="is_right[0]" class="is_right" value="1"> <small>Question Answer</small></label>
									</span>
									<br>
									<input type="file" name="option_img1">
									<textarea rows="2" name ="question_opt[1]"  class="form-control" ></textarea>
									<label><input type="radio" name="is_right[1]" class="is_right" value="1"> <small>Question Answer</small></label>
									<br>
									<input type="file" name="option_img2">
									<textarea rows="2" name ="question_opt[2]"  class="form-control" ></textarea>
									<label><input type="radio" name="is_right[2]" class="is_right" value="1"> <small>Question Answer</small></label>
									<br>
									<input type="file" name="option_img3">
									<textarea rows="2" name ="question_opt[3]"  class="form-control" ></textarea>
									<label><input type="radio" name="is_right[3]" class="is_right" value="1"> <small>Question Answer</small></label>
								</div>
								
							</div>
							<div class="modal-footer">
								<button  class="btn btn-primary" name="save"><span class="glyphicon glyphicon-save"></span> Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal fade" id="manage_student" tabindex="-1" role="dialog" >
				<div class="modal-dialog modal-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							
							<h4 class="modal-title" id="myModallabel">Add New Student/s</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<form id='student-frm'>
							<div class ="modal-body">
								<div id="msg"></div>
								<div class="form-group">
									<label>Student/s</label>
									<br>
									<input type="hidden" name="qid" value="<?php echo $_GET['id'] ?>" />
									<select rows='10' name="user_id[]" id="user" required="required" multiple class="form-control select2" style="width: 100% !important">
									<?php 
									$student = $conn->query('SELECT u.*,s.class as ls FROM users u left join students s on u.id = s.user_id where u.user_type = 3 ');
									// $group = $conn->query()
									$a_grp = 0;
									$b_grp = 0;
									$c_grp = 0; 
									?>
										<option value="all">All</option>
										<?php 
									// while($row=$student->fetch_assoc()){ 
										
										// if($row['ls']=='6' || $row['ls']=='7' || $row['ls']=='8'){
										// 	$a_grp++;
										// } 
										// if($row['ls']=='9' || $row['ls']=='10'){
										// 	$b_grp++;
										// } 
										// if($row['ls']=='11' || $row['ls']=='12'){
										// 	$c_grp++;
										// } 
									// } 
									?>
									<option value="6_8">A(6-8)</option>
									<option value="9_10">B(9-10)</option>
									<option value="11_12">C(11-12)</option>
									<?php 
										while($row = $student->fetch_assoc()){
												
											if($row['ls']=='6' || $row['ls']=='7' || $row['ls']=='8'){
												$a_grp++;
											} 
											if($row['ls']=='9' || $row['ls']=='10'){
												$b_grp++;
											} 
											if($row['ls']=='11' || $row['ls']=='12'){
												$c_grp++;
											} 
											?><option value="<?php echo $row['id'] ?>"><?php echo $row['name'].' '.$row['ls'] ?></option><?php
											
											
										}
										for($i=0; $i<ceil($a_grp/50); $i++){ ?>
											<option value="6_8_<?php echo $i+1; ?>">A(6-8) Grp-<?php echo $i+1; ?></option>
										<?php }
										for($i=0; $i<ceil($b_grp/50); $i++){	?>
											<option value="9_10_<?php echo $i+1; ?>">B(9-10) Grp-<?php echo $i+1; ?></option>
										<?php }
										for($i=0; $i<ceil($c_grp/50); $i++){	?>
											<option value="11_12_<?php echo $i+1; ?>">C(11-12) Grp-<?php echo $i+1; ?></option>
										<?php } 
										
										
									?>
									</select>

								</div>
								
								
							</div>
							<div class="modal-footer">
								<button  class="btn btn-primary" name="save"><span class="glyphicon glyphicon-save"></span> Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
</body>
<script>
	$(document).ready(function(){
		$(".select2").select2({
			placeholder:"Select here",
			width:'resolve'
		});
		$('#table').DataTable();
		$('#new_question').click(function(){
			$('#msg').html('')
			$('#manage_question .modal-title').html('Add New Question')
			$('#manage_question #question-frm').get(0).reset()
			$('#manage_question').modal('show')
		})
		$('#new_student').click(function(){
			$('#msg').html('')
			$('#manage_student').modal('show')
		})
		$('.edit_question').click(function(){
			var id = $(this).attr('data-id')
			$.ajax({
				url:'./get_question.php?id='+id,
				error:err=>console.log(err),
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp)
						$('[name="id"]').val(resp.qdata.id)
						$('[name="question"]').val(resp.qdata.question)
						Object.keys(resp.odata).map(k=>{
							var data = resp.odata[k]
							$('[name="question_opt['+k+']"]').val(data.option_txt);
							if(data.is_right == 1)
							$('[name="is_right['+k+']"]').prop('checked',true);
						})
						$('#manage_question .modal-title').html('Edit Question')
						$('#manage_question').modal('show')

					}
				}
			})

		})
		$('.is_right').each(function(){
			$(this).click(function(){
				$('.is_right').prop('checked',false);
				$(this).prop('checked',true);
			})
		})
		$('.remove_question').click(function(){
			var id = $(this).attr('data-id')
			var conf = confirm('Are you sure to delete this data.');
			if(conf == true){
				$.ajax({
				url:'./delete_question.php?id='+id,
				error:err=>console.log(err),
				success:function(resp){
					if(resp == true)
						location.reload()
				}
			})
			}
		})
		$('.remove_student').click(function(){
			var qid = $(this).attr('data-qid')
			var conf = confirm('Are you sure to delete this data.');
			if(conf == true){
				$.ajax({
				url:'./delete_quiz_student.php?qid='+qid,
				error:err=>console.log(err),
				success:function(resp){
					if(resp == true)
						location.reload()
				}
			})
			}
		})
		$('#question-frm').submit(function(e){
			e.preventDefault();
			$('#question-frm [name="submit"]').attr('disabled',true)
			$('#question-frm [name="submit"]').html('Saving...')
			$('#msg').html('')

			var fd = new FormData();
			var file_data = $('#question_img').prop('files')[0];

				console.log(file_data);
				fd.append('id',$('[name="id"]').val());
				fd.append('question_img',file_data);
				fd.append('question', $('[name="question"]').val());
				fd.append('qid',$('[name="qid"]').val())

				for(var i=0;i<4;i++){
					fd.append('question_opt['+i+']',$('[name="question_opt['+i+']"]').val())
					if($('[name="is_right['+i+']"]:checked').val()){
						fd.append('is_right['+i+']',$('[name="is_right['+i+']"]:checked').val())
					}else{
						fd.append('is_right['+i+']','0')
					}
					fd.append('option_img'+i,$('[name="option_img'+i+'"]').prop('files')[0])
				}

				

			$.ajax({
				url:'./save_question.php',
				method:'POST',
				cache:false,
				dataType:'script',
				contentType:false,
				processData:false,
				data: fd,
				error:err=>{
					console.log(err)
					alert('An error occured')
					$('#quiz-frm [name="submit"]').removeAttr('disabled')
					$('#quiz-frm [name="submit"]').html('Save')
				},
				success:function(resp){
						// console.log(resp);
						if(resp == 1){
							alert('Data successfully saved');
							location.reload()
						}
				}
			})
		})
		$('#student-frm').submit(function(e){
			e.preventDefault();
			$('#student-frm [name="submit"]').attr('disabled',true)
			$('#student-frm [name="submit"]').html('Saving...')
			$('#msg').html('')

			$.ajax({
				url:'./quiz_student.php',
				method:'POST',
				data:$(this).serialize(),
				error:err=>{
					console.log(err)
					alert('An error occured')
					$('#quiz-frm [name="submit"]').removeAttr('disabled')
					$('#quiz-frm [name="submit"]').html('Save')
				},
				success:function(resp){
						// console.log(resp);
						// document.write(resp)
						if(resp == 1){
							alert('Data successfully saved');
							location.reload()
						}
						
				}
			})
		})
	})
</script>
</html>