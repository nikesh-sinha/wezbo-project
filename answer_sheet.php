<?php 
 if(!$_SERVER['REQUEST_METHOD']=='POST'){
	// header("Location: http://localhost/quiz2/quiz/student_quiz_list.php");
	header("Location: http://exam.step2knowledge.co.in/student_quiz_list.php");
	exit;
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php') ?>
	<?php include('auth.php') ?>
	<?php include('db_connect.php') ?>
	<?php 
	$quiz = $conn->query("SELECT * FROM quiz_list where id =".$_GET['id']." order by RAND()")->fetch_array();
	?>
    <title>Answer Sheet</title>
</head>
<body>
	<style>
		li.answer{
			cursor: pointer;
		}
		li.answer:hover{
			background: #00c4ff3d;
		}
		li.answer input:checked{
			background: #00c4ff3d;
		}
		.question_scroll{
			height: 40px;
			display: flex;
			position: fixed;  
			background-color: forestgreen;
			bottom:0;
			right:0;
			box-shadow: 0px 0px 8px #8ccdff;
			margin-right: 30px;
			margin-bottom: 30px;
			z-index: 9;
		}
		.question_scroll select{
			width: 50px;
		}
		@media screen and (max-width:640px) {
			.question_scroll{
				height: 40px;
				margin-right: 20px;
				margin-bottom: 20px;
			}
			.question_scroll select{
			/* padding: 10px; */
			width: 40px;
		}
		}
	</style>
    <div class="d-flex" id="wrapper">
        <?php
            include 'navbar_new.php';
			$q_arr = array();
        ?>
		
        <div class="page-content-wrapper" style="width: 100%;">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h3 class="fs-2 m-0">AnswerSheet</h3>
                </div>
                <div class = "navbar-nav navbar-right d-none" style="float: right;">
					<a href="logout.php" class="text-dark"><i class="fa fa-power-off"></i></a>
				</div>
            </nav>
            <div class="container-fluid tab-content px-4">
				<div class="col-md-12 alert alert-primary">
					<div class="row justify-content-between">
						<div class="col-auto">
							<span><?php echo $quiz['title'] ?> | <?php echo $quiz['qpoints'] .' Points Each Question' ?></span>
						</div>
						<div class="col-auto ">
							<!-- <span class="text-danger">END TIME:<?php //echo $_POST['end_time'];?></span>  -->
						</div>
						<div class="col-auto text-danger">
							<!-- <span class="text-danger">END TIME:<?php //echo $_POST['end_time'];?></span> | -->
							<!-- TIME LEFT :<span><?php //echo $_POST['time_limit'];?></span> -->
							TIME LEFT : <span id="time-left"></span>
						</div>
					</div>
					
					
				</div>
				<br>
					<form action="" id="answer-sheet">
						<input type="hidden" name="user_id" value="<?php echo $_SESSION['login_id'] ?>">
						<input type="hidden" name="quiz_id" value="<?php echo $quiz['id'] ?>">
						<input type="hidden" name="qpoints" value="<?php echo $quiz['qpoints'] ?>">
						<?php
						$question = $conn->query("SELECT * FROM questions where qid = '".$quiz['id']."' order by order_by asc ");
						$i = 1 ;
						while($row =$question->fetch_assoc()){
							$q_arr[$i] = $i;
							$opt = $conn->query("SELECT * FROM question_opt where question_id = '".$row['id']."' order by RAND() ");
						?>

					<ul class="q-items list-group mt-4 mb-4" id="que_<?php echo $i; ?>">
						<li class="q-field list-group-item">
							<strong class="text-dark"><?php echo ($i++). '. '; ?> <?php echo $row['question'] ?></strong><br>
							<?php if($row['question_img']!=""){?>
								<img src="http://localhost/exam/image_question/<?php echo $row['question_img']?>" style="min-width:50%; min-height:100px; max-width:100%; max-height:300px;">
								<!-- <img src="http://exam.step2knowledge.co.in/image_question/<?php //echo $row['question_img']?>" style="min-width:50%; min-height:100px; max-width:100%; max-height:300px;"> -->
							<?php } ?>	
							<input type="hidden" name="question_id[<?php echo $row['id'] ?>]" value="<?php echo $row['id'] ?>">
							<br>
							<ul class='list-group mt-4 mb-4'>
							<?php while($orow = $opt->fetch_assoc()){ ?>

								<li class="answer list-group-item text-dark">
									<label><input type="radio" name="option_id[<?php echo $row['id'] ?>]" value="<?php echo $orow['id'] ?>"> <?php echo $orow['option_txt'] ?></label>
									<br>
									<?php if($orow['option_img']!=""){?>
										<img src="http://localhost/exam/image_answer/<?php echo $orow['option_img']?>" style="min-width:30%; min-height:100px; max-width:50%; max-height:200px;">
										<!-- <img src="http://exam.step2knowledge.co.in/image_answer/<?php //echo $orow['option_img']?>" style="min-width:30%; min-height:100px; max-width:50%; max-height:200px;"> -->
									<?php } ?>		
								</li>
							<?php } ?>

							</ul>

						</li>
					</ul>

					<?php } ?>
					<button class="btn btn-right btn-primary" style="margin-bottom: 50px;" onclick="submitAnswer()">Submit</button>
					</form>
            
			</div>
        </div>

    </div>
	<!-- <div class="question_scroll">
		<?php // echo sizeof($q_arr);?>
		<div class="text-center bg-primary p-2">
			<span style="color: white;">SCROLL TO</span>
		</div>
		<select class="form-select" aria-label="Default select example" id="question_scroll">
			<?php //for($i=1;$i<=sizeof($q_arr);$i++){?>
				<option value="<?php //echo $q_arr[$i]; ?>"><?php //echo $q_arr[$i]; ?></option>
			<?php //} ?>
		</select>
	</div> -->

    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function(){
            el.classList.toggle("toggled");
        }
        $("#question_scroll").change(function(){
			// console.log($("#question_scroll").val())
			var q_no = $("#question_scroll").val();
			// window.location.replace("http://localhost/quiz2/quiz/answer_sheet.php?id=<?php echo $quiz['id'] ?>#que_"+q_no)
			window.location.replace("http://exam.step2knowledge.co.in/answer_sheet.php?id=<?php echo $quiz['id'] ?>#que_"+q_no)
		});
    </script>
	<script>

		
			$('#answer-sheet').submit(function(e){
					e.preventDefault()
					$('#answer-sheet [type="submit"]').attr('disabled',true)
					$('#answer-sheet [type="submit"]').html('Saving...')
					$.ajax({
						url:'submit_answer.php',
						method:'POST',
						data:$(this).serialize(),
						error:err=>console.log(err),
						success:function(resp){
							if(typeof resp != undefined){
								resp = JSON.parse(resp)
								// console.log(resp);
								if(resp.status == 1){
									alert('You have sucessfully completed the quiz.')
									// location.replace('view_answer.php?id=<?php //echo $_GET['id'] ?>');
									location.replace('student_quiz_list.php')
								}
							}
						}
					})
				})
		
			$(document).ready(function(){
				$('.answer').each(function(){
				$(this).click(function(){
					$(this).find('input[type="radio"]').prop('checked',true)
					// $(this).css('background','#00c4ff3d')
					// $(this).siblings('li').css('background','white')
				})


				})
				
			})

		</script>
		<!-- auto submit -->
		<script type="text/javascript">
			window.onload=function(){

				const d = new Date();

				// var myTime = new Date('2021-09-03 14:00:00').getTime();
				var myTime = new Date('<?php echo $quiz['end_time']; ?>');

				var x = setInterval(function() {

				// Get todays date and time
				var now = new Date().getTime();

				// Find the distance between now an the count down date
				var distance = myTime - now;

				// Time calculations for days, hours, minutes and seconds
				var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
				var seconds = Math.floor((distance % (1000 * 60)) / 1000);

				// Output the result in an element with id="demo"

				// console.log(hours+'h :'+minutes+'m :'+seconds+'s')
				$('#time-left').html(hours+'h :'+minutes+'m :'+seconds+'s')

				// If the count down is over, write some text 
				if (distance <= 0) {
					clearInterval(x);
					alert("Time is over!!! Your response is submitted...")
					$('#answer-sheet').submit();
					// document.getElementById("demo").innerHTML = "EXPIRED";
					
				}
				}, 1000);
			}
		</script>
		<!-- user anti-cheat security -->
		<script type="text/javascript">
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
			$(window).focus(function() {
				//do something
				console.log('change1');
			});

			$(window).blur(function() {
				//do something
				console.log('change2');
				$('#answer-sheet').get(0).reset();
			});
		</script>

</body>
</html>




