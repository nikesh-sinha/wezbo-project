
<!DOCTYPE html>
<html>
	<head>
		<?php include('header.php') ?>
        <?php 
        session_start();
        if(isset($_SESSION['login_id'])){
            header('Location:home.php');
        }
        ?>
		<title>Login</title>
        <style>
        .whatsapp-contact{
                width: 80px; 
                height: 80px; 
                position:fixed; 
                right:0; 
                bottom:0; 
                z-index: 9; 
                margin:40px;
                cursor: pointer;
            }
            @media screen and (max-width:450px) {
                .whatsapp-contact{
                    width: 60px;
                    height: 60px;
                    margin: 15px;
                }
            }
    </style>
	</head>

	<body id='login-body' class="bg-light">
        <header class="bg-light mb-3">
                <center><h2><u>Step2Knowledge Exam Portal</u></h2></center>
                <center><h5>under SEP(Student-Enrichment-Program)</h5></center>
            <nav class="navbar navbar-light">
                <div class="container-fluid d-flex justify-content-center">
                    <a href="index.php" class="m-2">Home</a>
                    <a href="login.php" class="m-2">Login</a>
                </div>
            </nav>
       </header>
        
        <div class="container">
            
                <div class="row">
                    <div class="col-md-5 col-md-4 mx-auto mt-2 mb-4">
                        <div class="card">
                            <div class="text-center mt-4 mx-auto">
                                <h3 class="he3-responsives text-dark"><u>Login</u></h3>
                            </div>
                            <form id="login-frm" class="m-4">
                                <div class="form-group mt-3">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control">
                                </div> 
                                <div class="form-group text-right">
                                    <button class="btn btn-primary btn-block mt-4" name="submit">Login</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            
        </div>

        <a href="http://api.whatsapp.com/send?phone=919114144667" target="_blank"><img src="image/whatsapp.png" class="whatsapp-contact"></a>

        <footer class="bg-light" style="height: 50px;">
            <center>powered by step2knowledge</center>
        </footer>

		</body>

        <script>
            $(document).ready(function(){
                $('#login-frm').submit(function(e){
                    e.preventDefault()
                    $('#login-frm button').attr('disable',true)
                    $('#login-frm button').html('Please wait...')

                    $.ajax({
                        url:'./login_auth.php',
                        method:'POST',
                        data:$(this).serialize(),
                        error:err=>{
                            console.log(err)
                            alert('An error occured');
                            $('#login-frm button').removeAttr('disable')
                            $('#login-frm button').html('Login')
                        },
                        success:function(resp){
                            console.log(resp)
                            if(resp == 1){
                                location.replace('home.php')
                            }else{
                                alert("Incorrect username or password.")
                                $('#login-frm button').removeAttr('disable')
                                $('#login-frm button').html('Login')
                            }
                        }
                    })

                })
            })
        </script>
</html>