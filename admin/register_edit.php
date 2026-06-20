<?php
include('includes/header.php');
?>
<section id="sidebar">
    <a href="index.php" class="brand">
        <i class="bx bxs-leaf"></i>
        <span class="text">AdminBoard</span>
    </a>
    <ul class="side-menu top">
        <li>
            <a href="index.php">
                <i class='bx bxs-tree'></i>
                <span class="text">Plants</span>
            </a>
        </li>
        <li class="active">
            <a href="account.php">
                <i class="bx bxs-user"></i>
                <span class="text">Admin Account</span>
            </a>
        </li>
        <li>
            <a href="useraccount.php">
                <i class='bx bxs-user-detail'></i>
                <span class="text">User Account</span>
            </a>
        </li>
        <li>
            <a href="order.php">
                <i class='bx bx-book-alt'></i>
                <span class="text">Order</span>
            </a>
        </li>
        <li>
            <a href="feedback.php">
                <i class='bx bx-envelope-open'></i>
                <span class="text">Feedback</span>
            </a>
        </li>
    </ul>

    <ul class="side-menu">
        <li>
            <a href="logout.php" class="logout">
                <i class="bx bx-log-out"></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</section>
<section id="content">
    <nav>
        <form action="#">
            <div class="form-input">
                <input type="search" placeholder="Search..." />
                <button type="submit" class="search-btn">
                    <i class="bx bx-search"></i>
                </button>
            </div>
        </form>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="m-0 font-weight-bold text-info">Edit Admin Account</h4>
                    </div>
                    <div class="card-body">
                        <div class="msg" id="validationAlert">
                            <!-- Validation alert will be displayed here -->
                        </div>
                        <?php
                        if (isset($_POST['edit_btn'])) {
                            $id = $_POST['edit_id'];

                            $query = "SELECT * FROM admin WHERE id='$id'";
                            $query_run = mysqli_query($con, $query);

                            foreach ($query_run as $row) {
                        ?>
                            <form action="../functions/code.php" method="POST" onsubmit="return validatePassword()">
                                <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Username</label>
                                        <input type="text" name="edit_name" value="<?php echo $row['name'] ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Password</label>
                                        <input type="password" id="password" name="edit_password" placeholder="Enter New Password" class="form-control">
                                        <i class="bi bi-eye-slash" id="togglePassword"></i>
                                        <ul class="requirement-list">
                                            <li>
                                                <i class="fa-solid fa-circle"></i>
                                                <span>At least 8 characters length</span>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-circle"></i>
                                                <span>At least 1 number (0-9)</span>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-circle"></i>
                                                <span>At least 1 lowercase letter (a-z)</span>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-circle"></i>
                                                <span>At least 1 uppercase letter (A-Z)</span>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-circle"></i>
                                                <span>At least 1 special symbol (!@#$%^&*)</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Confirm Password</label>
                                        <input type="password" id="confirm_password" name="repassword" placeholder="Confirm Password" class="form-control">
                                        <br>
                                        <span id="password_error" style="color: red;"></span>
                                    </div>
                                </div>
                                <br>
                                <div class="modal-footer">
                                    <div class="col-md-12">
                                        <a href="account.php" class="btn btn-danger">Cancel</a>
                                        <button type="submit" name="updatebtn" class="btn btn-success">Update</button>
                                    </div>
                                </div>
                            </form>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="assets/js/script.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/perfect-scrollbar.min.js"></script>
<script src="assets/js/smooth-scrollbar.min.js"></script>
</body>
</html>