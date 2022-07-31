<?php
	include 'db_connect.php';
   	include 'auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php') ?>
    <title>Students</title>
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
                    <h3 class="fs-2 m-0">Student List</h3>
                </div>
                <div class = "navbar-nav navbar-right d-md-none d-block" style="float: right;">
					<a href="logout.php" class="text-dark"><i class="fa fa-power-off"></i></a>
				</div>
            </nav>
            <div class="container-fluid tab-content px-4">
			<div class="col-md-12 alert alert-primary">Student List</div>
				<button class="btn btn-primary bt-sm" id="new_student"><i class="fa fa-plus"></i>	Add New</button>
				<br>
				<div class="card mt-4">
					<div class="card-body">
						<table class="table table-bordered" id='table'>
							<colgroup>
								<col width="10%">
								<col width="30%">
								<col width="20%">
								<col width="20%">
							</colgroup>
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Class</th>
									<th>Contact</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$qry = $conn->query("SELECT s.*,u.name,u.mobile from students s left join users u  on s.user_id = u.id order by u.name asc ");
							$i = 1;
							if($qry->num_rows > 0){
								while($row= $qry->fetch_assoc()){
								?>
							<tr>
								<td><?php echo $i++ ?></td>
								<td><?php echo $row['name'] ?></td>
								<td><?php echo $row['class'] ?></td>
								<td><?php echo $row['mobile'] ?></td>
								<td>
									<center>
									<button class="btn btn-sm btn-outline-primary edit_student" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-edit"></i> Edit</button>
									<button class="btn btn-sm btn-outline-danger remove_student" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-trash"></i> Delete</button>
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
				<!-- mondal -->
				<div class="modal fade" id="manage_student" tabindex="-1" role="dialog" >
				<div class="modal-dialog modal-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							
							<h4 class="modal-title" id="myModallabel">Add New student</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<form id='student-frm'>
							<div class ="modal-body">
								<div id="msg"></div>
								<div class="form-group">
									<label>Name</label>
									<input type="hidden" name="id" />
									<input type="hidden" name="uid" />
									<input type="hidden" name="user_type" value = '3' />
									<input type="text" name="name" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Class</label>
									<input type="text" name ="class" required="" class="form-control" />
								</div>
								<div class="form-group">
									<label>School</label>
									<input type="text" name ="school" required="" class="form-control" />
								</div>
								<div class="form-group">
									<label>Mobile no.</label>
									<input type="text" name ="mobile" required="" class="form-control" />
								</div>
								<div class="form-group">
									<!-- <label>Alt Mobile no.</label> -->
									<input type="hidden" name ="alt_mobile"  class="form-control" />
								</div>
								<div class="form-group">
									<!-- <label>Address</label> -->
									<input type="hidden" name ="address" value="" class="form-control" />
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="text" name ="email" id="emailInput" required="" class="form-control"/>
								</div>
								<div class="form-group">
									<label>Password</label>
									<input type="password" name="password" required="required" class="form-control" />
								</div>
							</div>
							<div class="modal-footer">
								<button  class="btn btn-primary" name="save"><span class="glyphicon glyphicon-save"></span> Save</button>
							</div>
						</form>
					</div>
				</div>
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
        
    </script>
	<script>
	$(document).ready(function(){
		$('#table').DataTable();
		$('#new_student').click(function(){
			$('#msg').html('')
			$('#manage_student .modal-title').html('Add New student')
			$('#manage_student #student-frm').get(0).reset()
			$('#manage_student').modal('show')
		})
		$('.edit_student').click(function(){
			var id = $(this).attr('data-id')
			$.ajax({
				url:'./get_student.php?id='+id,
				error:err=>console.log(err),
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp)
						$('[name="id"]').val(resp.id)
						$('[name="uid"]').val(resp.uid)
						$('[name="name"]').val(resp.name)
						$('[name="class"]').val(resp.class)
						$('[name="school"]').val(resp.school)
						$('[name="mobile"]').val(resp.mobile)
						// $('#emailInput').setAttribute('readonly', true);
						$('#emailInput').attr('readonly', true);
						$('[name="email"]').val(resp.email)
						$('[name="password"]').val(resp.password)
						$('#manage_student .modal-title').html('Edit Student')
						$('#manage_student').modal('show')

					}
				}
			})

		})
		$('.remove_student').click(function(){
			var id = $(this).attr('data-id')
			var conf = confirm('Are you sure to delete this data.');
			if(conf == true){
				$.ajax({
				url:'./delete_student.php?id='+id,
				error:err=>console.log(err),
				success:function(resp){
					if(resp == true)
						location.reload()
				}
			})
			}
		})
		$('#student-frm').submit(function(e){
			e.preventDefault();
			$('#student-frm [name="submit"]').attr('disabled',true)
			$('#student-frm [name="submit"]').html('Saving...')
			$('#msg').html('')

			$.ajax({
				url:'./save_student.php',
				method:'POST',
				data:$(this).serialize(),
				error:err=>{
					console.log(err)
					alert('An error occured')
					$('#student-frm [name="submit"]').removeAttr('disabled')
					$('#student-frm [name="submit"]').html('Save')
				},
				success:function(resp){
					if(typeof resp != undefined){
						resp = JSON.parse(resp)
						if(resp.status == 1){
							alert('Data successfully saved');
							// $('#registration-modal').show();
							location.reload()
						}else{
						$('#msg').html('<div class="alert alert-danger">'+resp.msg+'</div>')

						}
					}
				}
			})
		})
	})
</script>

</body>
</html>





