<?php
include('includes/header.php');
include('config/dbcon.php'); // Ensure the database connection is included
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
        <li>
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
        <li class="active">
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
        <form action="feedback.php" method="GET">
            <div class="form-input">
                <input type="search" name="search" placeholder="Search by Feedback ID or Content..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" />
                <button type="submit" class="search-btn">
                    <i class="bx bx-search"></i>
                </button>
            </div>
        </form>
    </nav>
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Feedback</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php
                    $search_query = "";
                    if (isset($_GET['search'])) {
                        $search = mysqli_real_escape_string($con, $_GET['search']);
                        $search_query = "WHERE feedback_id = '$search' OR feedback_text LIKE '%$search%'";
                    }

                    $query = "SELECT * FROM feedback $search_query";
                    $query_run = mysqli_query($con, $query);
                    ?>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Rating</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_assoc($query_run)) {
                            ?>
                                    <tr>
                                        <td><?php echo $row['feedback_id']; ?></td>
                                        <td><?php echo $row['u_name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['feedback_text']; ?></td>
                                        <td><?php echo $row['star']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-danger delete-btn" data-id="<?php echo $row['feedback_id'] ?>">Delete</button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='6'>No record found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Confirm?</h2>
    <p>Are you sure you want to delete this?</p>
    <form id="deleteForm" action="delete_feedback.php" method="post">
      <input type="hidden" name="delete_id" id="delete_id">
      <div class="modal-buttons">
        <button type="submit" name="delete_btn" class="btn btn-danger">Delete</button>
        <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script src="script.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/perfect-scrollbar.min.js"></script>
<script src="assets/js/smooth-scrollbar.min.js"></script>
</body>

</html>