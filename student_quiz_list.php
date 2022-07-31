<?php
    include 'db_connect.php';
   include 'auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php') ?>
    <title>Student Quiz List</title>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <?php
            include 'navbar_new.php';
        ?>

        <div class="page-content-wrapper" style="width: 100%;">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h3 class="fs-2 m-0">Quiz list</h3>
                </div>
                <div class = "navbar-nav navbar-right d-md-none d-block" style="float: right;">
					<a href="logout.php" class="text-dark"><i class="fa fa-power-off"></i></a>
				</div>
            </nav>
            <div class="container-fluid tab-content px-4">
			<div class="col-md-12 alert alert-primary">My Quiz List</div>
		<br>
		<div>
			<?php //date_default_timezone_set('Asia/Kolkata');
                                   // echo date("H:i:s"); ?>
			<div class="card-body" style="overflow-x: auto;
                overflow-y: hidden;
                white-space: nowrap;">
				<table class="table table-bordered" id='table'>
					<thead>
						<tr>
							<th>#</th>
							<th>Quiz</th>
							<!-- <th>Score</th> -->
							<th>start time</th>
							<th>end time</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$qry = $conn->query("SELECT * from  quiz_list where id in  (SELECT quiz_id FROM quiz_student_list where user_id ='".$_SESSION['login_id']."' ) order by date_updated desc ");
					$j = 1;
					if($qry->num_rows > 0){
						while($row= $qry->fetch_assoc()){
							$status = $conn->query("SELECT * from history where quiz_id = '".$row['id']."' and user_id ='".$_SESSION['login_id']."' ");
							$hist = $status->fetch_array();
							$dateTime = explode(" ",$row['start_time']);
							$date_arr = explode("-",$dateTime[0]) ;
							$date = '';
							for($i=sizeof($date_arr)-1;$i>=0;$i--){
								// echo $i;
								$date .= $date_arr[$i];
								if($i != 0){
									$date .= '/';
								}
							}
						?>
					<tr>
						<td><?php echo $j++ ?></td>
						<td><?php echo $row['title'] ?></td>
						<!-- <td><?php // echo $status->num_rows > 0 ? $hist['score'].'/'.$hist['total_score'] : 'N/A' ?></td> -->
						<!-- <td><?php // echo $date.' - '.$dateTime[1] ?></td> -->
						<td><?php echo $row['start_time'] ?></td>
						<td><?php echo $row['end_time'] ?></td>
						<td><?php echo $status->num_rows > 0 ? 'Taken' : 'Pending' ?></td>
						<td>
							<center>
							 	<?php if($status->num_rows <= 0): ?>
								<button class="btn btn-sm btn-outline-primary" onclick="answerSheetPage('<?php echo $row['id'] ?>','<?php echo $dateTime[0] ?>','<?php echo $dateTime[1] ?>','<?php echo $row['end_time'] ?>')" > Take Quiz</button>	
							 	<!-- <a class="btn btn-sm btn-outline-primary" href="./answer_sheet.php?id=<?php //echo $row['id']?>"><i class="fa fa-pencil"></i> Take Quiz</a> -->
								<?php else: ?>
								<a class="btn btn-sm btn-outline-primary" href="./view_answer.php?id=<?php echo $row['id']?>"><i class="fa fa-eye"></i> View</a>
								<!-- <a class="btn btn-sm btn-outline-primary disabled" href="#"><i class="fa fa-eye"></i> View</a> -->
								<?php endif; ?>
							</center>
						</td>
					</tr>
					<?php
					}
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
		<div id="redirection">

		</div>
            </div>
        </div>


    </div>

    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function(){
            el.classList.toggle("toggled");
        }
        $('#delete-subject-row').click(function(){
            alert('Do you want to delete this subject');
        });
    </script>
	<script>

	function answerSheetPage(id,date,gtime,limit){
		const d = new Date();
		var todayDate = '';
		const months = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];

		var currentDayDate = d.getDate()<10? '0'+d.getDate():d.getDate()

		todayDate += d.getFullYear()+'-'+months[d.getMonth()]+'-'+currentDayDate;
		var hour = d.getHours();
		var mins = d.getMinutes();
		if(hour < 10){
			hour = '0'+hour;
		}
		if(mins < 10){
			mins = '0'+mins;
		}
		var endTime=limit;
		
		
		
		var currentTime =todayDate+' '+ hour+':'+mins+':'+'00';

		console.log(currentTime<endTime)
		console.log(endTime)
		if(date==todayDate && currentTime<=endTime){
			if(currentTime>=(date+' '+gtime)){
				var url = 'answer_sheet.php?id=' + id;
				var url = 'http://localhost/exam/answer_sheet.php?id=' + id;
				var form = $('<form action="' + url + '" method="post">' +
				'<input type="text" name="time_limit" value="' + endTime + '" />' +
				'<input type="text" name="start_time" value="' + gtime + '" />' +
				'<input type="text" name="end_time" value="' + endTime + '" />' +
				'</form>');
				$('body').append(form);
				form.submit();

			}else{
				alert("Wait for the exam to start... \n Your Exam will be start on date :"+date+" and time :"+gtime);
				// alert(currentTime+'\n'+gtime+'\n'+date);
			}

		}else{
			alert("Check the examination date or time");

		
		}
	}

	$(document).ready(function(){
		$('#table').DataTable();
		$('#new_faculty').click(function(){
			$('#msg').html('')
			$('#manage_faculty .modal-title').html('Add New Faculty')
			$('#manage_faculty #faculty-frm').get(0).reset()
			$('#manage_faculty').modal('show')
		})
		$('.edit_faculty').click(function(){
			var id = $(this).attr('data-id')
			$.ajax({
				url:'./get_faculty.php?id='+id,
				error:err=>console.log(err),
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp)
						$('[name="id"]').val(resp.id)
						$('[name="uid"]').val(resp.uid)
						$('[name="name"]').val(resp.name)
						$('[name="subject"]').val(resp.subject)
						$('[name="username"]').val(resp.username)
						$('[name="password"]').val(resp.password)
						$('#manage_faculty .modal-title').html('Edit Faculty')
						$('#manage_faculty').modal('show')

					}
				}
			})

		})
		$('.remove_faculty').click(function(){
			var id = $(this).attr('data-id')
			var conf = confirm('Are you sure to delete this data.');
			if(conf == true){
				$.ajax({
				url:'./delete_faculty.php?id='+id,
				error:err=>console.log(err),
				success:function(resp){
					if(resp == true)
						location.reload()
				}
			})
			}
		})
		$('#faculty-frm').submit(function(e){
			e.preventDefault();
			$('#faculty-frm [name="submit"]').attr('disabled',true)
			$('#faculty-frm [name="submit"]').html('Saving...')
			$('#msg').html('')

			$.ajax({
				url:'./save_faculty.php',
				method:'POST',
				data:$(this).serialize(),
				error:err=>{
					console.log(err)
					alert('An error occured')
					$('#faculty-frm [name="submit"]').removeAttr('disabled')
					$('#faculty-frm [name="submit"]').html('Save')
				},
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp)
						if(resp.status == 1){
							alert('Data successfully saved');
							location.reload()
						}else{
						$('#msg').html('<div class="alert alert-danger">'+resp.msg+'</div>')

						}
					}
				}
			})
		})
	})
	$(document).ready(function () {
				//Disable cut copy paste
				$('body').bind('cut copy paste', function (e) {
					e.preventDefault();
				});
			
				//Disable mouse right click
				$("body").on("contextmenu",function(e){
					return false;
				});
			});
</script>

</body>
</html>



