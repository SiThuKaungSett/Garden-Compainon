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
    <li class="active">
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
      <i class='bx bxs-user-detail' ></i>
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
    <form action="index.php" method="GET">
      <div class="form-input">
        <input type="search" name="search" placeholder="Search by Plant ID or Name..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" />
        <button type="submit" class="search-btn">
          <i class="bx bx-search"></i>
        </button>
      </div>
    </form>
  </nav>
  <div class="container-fluid">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">
          <a href="addplants.php">
            <button type="button" class="btn btn-info">
              Add New Plants
            </button>
          </a>
        </h6>
      </div>
      <div class="card-body">
        
        <?php
        $search_query = "";
        if (isset($_GET['search'])) {
            $search = mysqli_real_escape_string($con, $_GET['search']);
            $search_query = "WHERE p_id = '$search' OR p_name LIKE '%$search%'";
        }

        $query = "SELECT * FROM plants $search_query";
        $query_run = mysqli_query($con, $query);

        // Check for low stock and display alert
        $low_stock_alerts = [];
        while ($row = mysqli_fetch_assoc($query_run)) {
            if ($row['instock'] <= 10) {
                $low_stock_alerts[] = "Your Plants (" . $row['p_name'] . ", ID: " . $row['p_id'] . ") stock is too low. Please restock soon.";
            }
        }

        // Reset the pointer to the beginning of the result set
        mysqli_data_seek($query_run, 0);
        ?>

        <?php if (!empty($low_stock_alerts)): ?>
          <div class="alert-container">
            <?php foreach ($low_stock_alerts as $alert): ?>
              <div class="alert alert-danger text-center custom-alert">
                <i class="bx bx-error-circle"></i>
                <p><?= $alert ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Plant Name</th>
                <th>Image</th>
                <th>Season</th>
                <th>Price</th>
                <th>Instock</th>
                <th>Description</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              if (mysqli_num_rows($query_run) > 0) {
                while ($row = mysqli_fetch_assoc($query_run)) {
              ?>
                  <tr>
                    <td><?= $row['p_id'] ?></td>
                    <td><?= $row['p_name'] ?></td>
                    <td>
                      <img src="../uploads/<?= $row['p_image']; ?>" width="50px" height="50px">
                    </td>
                    <td><?= $row['season'] ?></td>
                    
                    <td><?= $row['price'] ?></td>
                    <td><?= $row['instock'] ?></td>
                  
                    <td style="max-width:100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis"><?= $row['description'] ?></td>
                    <td>
                      <form action="plant_edit.php" method="post">
                        <input type="hidden" name="pedit_id" value="<?php echo $row['p_id']; ?>">
                        <button type="submit" name="edit_btn" class="btn btn-success">Edit</button>
                      </form>
                    </td>
                    <td>
                      <button type="button" class="btn btn-danger delete-btn" data-id="<?php echo $row['p_id'] ?>">Delete</button>
                    </td>
                  </tr>

              <?php
                }
              } else {
                echo "<tr><td colspan='9'>No record found</td></tr>";
              }
              ?>

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
    <form id="deleteForm" action="delete_plant.php" method="post">
      <input type="hidden" name="delete_id" id="delete_id">
      <div class="modal-buttons">
        <button type="submit" name="delete_btn" class="btn btn-danger">Delete</button>
        <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script src="assets/js/script.js"></script>
</body>

</html>