<div class="bg-primary" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
                <h6 style="color: whitesmoke;">S2K Exam Portal</h6>
            </div>
            <div class="list-group list-group-flush my-3">
                <a href="home.php" class="list-group-item list-group-item-action bg-transparent second-text active">
						<i class="fa fa-home"> </i>  Home
				</a>
                <?php if($_SESSION['login_user_type'] != 3): ?>
			    <?php if($_SESSION['login_user_type'] == 1): ?>
                    <a href="faculty.php" class="list-group-item list-group-item-action bg-transparent second-text">
						<i class="fa fa-users"> </i>  Faculty List
				</a>
                <?php endif; ?>
                <a href="student.php" class="list-group-item list-group-item-action bg-transparent second-text">
						<i class="fa fa-users"> </i>  Student List
				</a>
                <a href="quiz.php" class="list-group-item list-group-item-action bg-transparent second-text">
						<i class="fa fa-list"> </i> Quiz List
				</a>
                <a href="history.php" class="list-group-item list-group-item-action bg-transparent second-text">
						<i class="fa fa-history"> </i>  Quiz Records
				</a>
                <?php else: ?>
                <a href="student_quiz_list.php" class="list-group-item list-group-item-action bg-transparent second-text">
					<i class="fa fa-list"> </i>  Quiz List
				</a>
                <?php endif; ?>
                <a href="logout.php" class="list-group-item list-group-item-action bg-transparent second-text"> <i class="fa fa-power-off"></i> Logout</a>






                <!-- <a  href="<?//php echo base_url();?>/uservalidation/staffLogout" class="list-group-item list-group-item-action bg-transparent second-text">
                    <i class="fas fa-tachometer-alt me-2"></i>Logout
                </a> -->
            </div>
</div>