<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>S2K SEP</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <?php include('header.php') ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <style>
            
            ul li{
                margin-top: -5px;
                margin-bottom: -5px;
            }
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
            label{
                font-size: 14px;
            }
            @media screen and (max-width:450px) {
                .whatsapp-contact{
                    width: 60px;
                    height: 60px;
                    margin: 15px;
                }
            }
        </style>
    <body>
        <?php //header('location:login.php') ?>
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
       
       <div class="modal" tabindex="-1" id="registration-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-success">Registration Succesfull</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="registration-success">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="dismiss-modal">OK</button>
                    </div>
                </div>
            </div>
		</div> 

        <div class="container-fluid">
        <div class="row justify-content-center g-3">
            <div class="col-lg-7 m-1">
                <div class="card border-outline" style="font-family: Times New Roman, Times, serif; ;">
                    <span class="mx-3 mt-3"><i class="fas fa-info-circle"></i> <b>Read all the Instructions :-</b></span>
                    <div class="card-body">
                        <ol>
                            <li><span>Read all the instructions, and <a href="#register">scroll down to register</a> </span></li><br>
                            <li> You can apply for Step2Knowledge Student Enrichment Examination - 2021 (S2KSEE - 2021) 'ONLINE' only through the official website of Step2Knowledge (<a href="https://exam.step2knowledge.co.in">https://exam.step2knowledge.co.in</a>)</li><br>
                            <li> Registration for S2KSEE - 2021 is free and no fee will be charged in any stage of the Examination.</li><br>
                            <li> During online form filling, candidate will be required to choose password. Candidate is advised to record/remember their password for all future logins.</li><br>
                            <li> For subsequent logins, candidate will be able to login directly with their respective email address and the chosen password.</li><br>
                            <li> In case a candidate (wishes to change)/(forgets) his/her password, they are requested to contact us through the WhatsApp icon present below on the Login Page.</li><br>
                            <li> Candidates are advised to note down the Application number printed on the computer generated confirmation page.</li><br>
                            <li> Two candidates cannot register with the same email address. E-mail address for each candidate must be unique.</li><br>
                            <li> Candidates must ensure that their email address and mobile number to be registered in their online Application Form are their own, as relevant/important information/communication will be sent by us through e-mail on the registered e-mail address and/or through SMS on registered mobile number only.</li><br>
                            <li> No calls will be made from our end regarding exams before the declaration of exam results. Any information to be communicated will be sent through e-mail or SMS only.</li><br>
                        </ol>
                        <span><input type="checkbox" id="check" name="check"> <label for="check"> Checking this you are accepting all the terms and conditions of Step2Knowledge Exam Portal</label></span><br>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-4" id="register">
                <div class="card">
                    <div class="card-body">
                        <form id="#student-frm">
                        <center><h3 class="bg-light p-2">Register</h3></center>
                        <div id="msg"></div>
                        <input type="hidden" name="id" />
						<input type="hidden" name="uid" />
						<input type="hidden" name="user_type" value = '3' />
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="name" id="name-input" placeholder="name@example.com" required>
                                    <label for="name-input">Name *</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="class-input" name="class" aria-label="Floating label select example" required>
                                        <option value="choose class" selected>Choose</option>
                                        <option value="6">Class 6</option>
                                        <option value="7">Class 7</option>
                                        <option value="8">Class 8</option>
                                        <option value="9">Class 9</option>
                                        <option value="10">Class 10</option>
                                        <option value="11">Class 11</option>
                                        <option value="12">Class 12</option>
                                    </select>    
                                    <label for="class-input">Class *</label>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="school" id="school-input" placeholder="name@example.com" required>
                                    <label for="school-input">School *</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="mobile-input" name="mobile" placeholder="mob no., alternate mob no." required>
                                    <label for="mobile-input">Mobile No. *</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="alt-mobile-input" name="alt_mobile" placeholder="mob no., alternate mob no.">
                                    <label for="alt-mobile-input">Alt. Mobile No.</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="address,ditrict,state" id="address-input" name="address" required></textarea>
                                    <label for="address-input">Address *</label>
                                </div>
                            </div>
                        </div>
                        <h6><u>Credentials</u></h6>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email-input" name="email" placeholder="name@example.com" required>
                                    <label for="email-input">Email</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="pass" name="password" required>
                                    <label for="pass">Password</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="cpass" name="cpassword" required>
                                    <label for="cpass">Confirm Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button id="submit" name="submit" class="btn btn-danger">Register</button>
                            <center><span>OR</span></center>
                            <button class="btn btn-primary" type="button" onclick="loginRedirect()">Login</button>
                        </div>
                        </form>    
                    </div>
                </div>
            </div>
        </div>
       
        </div>

        <a href="http://api.whatsapp.com/send?phone=919114144667" target="_blank"><img src="image/whatsapp.png" class="whatsapp-contact"></a>
        <footer class="bg-light" style="height: 50px;">
            <center>powered by step2knowledge</center>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script>
            function loginRedirect(){
                console.log($('#check').is(":checked"))
                if($('#check').is(":checked")){
                    
                }
                window.location.href = "http://localhost/exam/login.php";
                // window.location.href = "http://exam.step2knowledge.co.in/login.php";
            }
            $('form').submit(function(e){
                e.preventDefault();
                // alert($('#pass').val()+"hii"+);
                $('#student-frm [name="submit"]').attr('disabled',true)
                $('#student-frm [name="submit"]').html('Saving...')
                $('#msg').html('')

                if(!$('#check').is(":checked")){
                    alert("please accept the terms and condtions");
                    // window.location.href = "http://localhost/quiz2/quiz/#register";
                    // window.location.href = "http://exam.step2knowledge.co.in/#register";
                }else{

                    if($('#pass').val()==$('#cpass').val()){
                        $.ajax({
                        url:'./save_student.php',
                        method:'POST',
                        data:$(this).serialize(),
                        error:err=>{
                            console.log(err)
                            alert('An error occured'+err)
                            $('#student-frm [name="submit"]').removeAttr('disabled')
                            $('#student-frm [name="submit"]').html('Save')
                        },
                        dataType : 'json',
                        success:function(resp){
                            console.log(resp)
                            if(typeof resp != undefined){
                                if(resp.status == 1){
                                    // alert('Data successfully saved');
                                    $('#registration-success').html("<center>Thanks for Registration "+resp.data.name+"<center><br>"+
                                    "<p>Applicant no : "+resp.data.applicant_no+"</p>"+
                                    "<p>Group No : "+resp.data.group+"</p>"+
                                    "<p>We have send the details to "+resp.data.email+"</p><p>If you are not getting mail then contact us...</p>")
                                    
                                    $('#registration-modal').modal('show')
                                }else{
                                $('#msg').html('<div class="alert alert-danger">'+resp.msg+'</div>')

                                }
                            }
                        }
                    })
                    }else{
                        $('#msg').html('<div class="alert alert-danger">password not matched</div>')
                    }
                }
                
            });
            $("#dismiss-modal").click(function(){
                location.reload();
            });
        </script>
    </body>
    
</html>