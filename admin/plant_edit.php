<?php
include('includes/header.php');
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
      <a href="#">
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
                        <h4 class="m-0 font-weight-bold text-info">Edit Plant Data</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_POST['edit_btn'])) {
                            $id = $_POST['pedit_id'];

                            $query = "SELECT * FROM plants WHERE p_id='$id'";
                            $query_run = mysqli_query($con, $query);

                            foreach ($query_run as $row) {
                        ?>
                                <form action="../functions/code.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="pedit_id" value="<?php echo $row['p_id'] ?>">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="">Plant ID</label>
                                            <input type="text" name="plantid" value="<?php echo $row['p_id'] ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="">Plant Name</label>
                                            <input type="text" name="name" value="<?php echo $row['p_name'] ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="">Upload Image</label>
                                            <input type="file" name="image" class="form-control">
                                            <label for="">Current Image</label>
                                            <input type="hidden" name="old_image" value="<?= $row['p_image'] ?>">
                                            <img src="../uploads/<?= $row['p_image'] ?>" width="50px" height="50px">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="">Price</label>
                                            <input type="text" name="price" value="<?php echo $row['price'] ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="">Instock</label>
                                            <input type="text" name="instock" value="<?php echo $row['instock'] ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="">Season</label>
                                            <select class="form-select" aria-label="Default select example" name="season">
                                        <option selected><?php echo $row['season'] ?></option>
                                        <option value="Hot Season">Hot Season</option>
                                        <option value="Rainy Season">Rainy Season</option>
                                        <option value="Cold Season">Cold Season</option>
                                      
                                    </select>
                                            
                                        </div>
                                    </div>
                                    
                                   
                                    
                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Description</label>
                                            <textarea rows="3" name="description" value="<?php echo $row['description'] ?>" class="form-control"><?php echo $row['description'] ?></textarea>
                                        </div>
                                    </div>

                            <?php
                            }
                        }
                            ?>
                            <br>
                            <div class="modal-footer">

                                <div class="col-md-12">
                                    <a href="index.php" class="btn btn-danger">Cancel</a>
                                    <button type="submit" name="update_plantbtn" class="btn btn-success">Update</button>
                                </div>
                            </div>
                                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>