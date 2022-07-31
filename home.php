<?php
    include 'db_connect.php';
   include 'auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php') ?>
    <title>Home</title>
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
<body>
    <div class="d-flex" id="wrapper">
        <?php
            include 'navbar_new.php';
        ?>

        <div class="page-content-wrapper" style="width: 100%;">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h3 class="fs-2 m-0">Dashboard</h3>
                </div>
                <div class = "navbar-nav navbar-right d-md-none d-block" style="float: right;">
					<a href="logout.php" class="text-dark"><i class="fa fa-power-off"></i></a>
				</div>
            </nav>
            <div class="container-fluid tab-content ">
            <h5>Hi, <?php echo $name;?></h5>
            <h6>Read all the <a href="#">guidelines</a> before giving the exam</h6>
        <div class="col-md-6 mx-auto mt-4">
            <div class="card-body" style="overflow-x: auto;
                overflow-y: hidden;
                white-space: nowrap;" >
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th>Quiz</th>
                        <!-- <th>Items</th> -->
                        <th>Date</th>
                        <th>Time</th>
                        <?php if($_SESSION['login_user_type'] == 3): ?>
                        <th>Status</th>
                        <?php else: ?>
                        <th>Had Taken</th>
                        <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $where = '';
                            if($_SESSION['login_user_type'] == 2){
                                $where = " where u.id = ".$_SESSION['login_id']." ";
                            }
                            if($_SESSION['login_user_type'] == 3){
                                $where = " where q.id in (SELECT quiz_id from quiz_student_list where user_id = '".$_SESSION['login_id']."') ";
                            }
                            $qry = $conn->query("SELECT q.*,u.name as fname from quiz_list q left join users u on q.user_id = u.id ".$where." order by q.title asc ");
                                // print_r($qry->fetch_assoc());
                                while($row= $qry->fetch_assoc()){
                                    $items = $conn->query("SELECT count(id) as item_count from questions where qid = '".$row['id']."' ")->fetch_array()['item_count'];
                                    // print_r($row);
                                    $dateTime = explode(" ",$row['date_updated']);
                                    // print_r($dateTime);
                                    $swhere ='';
                                     if($_SESSION['login_user_type'] == 3)
                                        $swhere= ' and user_id = '.$_SESSION['login_id'].' ';

                                    $taken = $conn->query("SELECT count(id) as item_count from answers where quiz_id = '".$row['id']."'  ".$swhere )->fetch_array()['item_count'];
                                    
                        ?>
                        <tr>
                            <td><?php echo $row['title'] ?></td>
                            <td class="text-center"><?php echo $dateTime[0] ?></td>
                            <td class="text-center"><?php echo $dateTime[1] ?></td>
                            <?php $status = 0<$taken? "Taken":"Pending";?>
                            <?php if($_SESSION['login_user_type'] == 3): ?>
                            <td class="text-center"><?php echo $status ?></td>
                            <?php else: ?>
                            <td class="text-center"><?php echo $status ?></td>
                            <?php endif; ?>
                        </tr>
                        <?php
                        }

                        ?>
                    </tbody>  
                </table>
            </div>
        </div>
       </div>
            </div>
        </div>

    </div>

    <a href="http://api.whatsapp.com/send?phone=919114144667" target="_blank"><img src="image/whatsapp.png" class="whatsapp-contact"></a>

    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function(){
            el.classList.toggle("toggled");
        }
    </script>
</body>
</html>