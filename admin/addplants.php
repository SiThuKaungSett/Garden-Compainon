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
                        <h4 class="m-0 font-weight-bold text-info">Add New Plants</h4>
                    </div>
                    <div class="card-body">
                        <div class="col-md-3">
                            <div class="msg">
                                <?php
                                if (isset($_SESSION['addsuccess'])) { ?>
                                    <div class="alert" role="alert">
                                        <?= $_SESSION['addsuccess']; ?>
                                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                                    </div>
                                <?php
                                    unset($_SESSION['addsuccess']);
                                }
                                ?>
                            </div>
                        </div>
                        <form action="../functions/code.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Enter Plant ID</label>
                                    <input type="text" name="plantid" placeholder="Enter Plant ID" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Plant Name</label>
                                    <input type="text" name="name" placeholder="Enter Plant Name" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Price</label>
                                    <input type="text" name="price" placeholder="Enter Price" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Instock</label>
                                    <input type="text" name="instock" placeholder="Enter Instock Quantity" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Season</label>
                                    <select class="form-select" aria-label="Default select example" name="season">
                                        <option selected>Choose the season</option>
                                        <option value="Hot Season">Hot Season</option>
                                        <option value="Rainy Season">Rainy Season</option>
                                        <option value="Cold Season">Cold Season</option>

                                    </select>
                                </div>
                            </div>




                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Description</label>
                                    <textarea rows="3" name="description" placeholder="Enter Description" class="form-control"></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="index.php">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </a>
                                    <button type="submit" class="btn btn-success" name="add_plants_btn">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="assets/js/script.js"></script>
</body>

</html>