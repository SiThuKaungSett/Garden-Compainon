<?php
session_start();
include('includes/header.php'); ?>

<header>
    <a href="index.php" class="logo"><img src="assets/logo/logo1.png" alt=""></a>

    <ul class="navmenu">
        <li><a href="index.php">Home</a></li>
        <li><a href="plants.php">Plants</a></li>

        <li class="active"><a href="aboutus.php">About Us</a></li>
        <li><a href="feedback.php">Feedback</a></li>
    </ul>

    <div class="nav-icon">
        <input class="search-input" type="search" id="searchBox" placeholder="Search...." maxlength="50">
        <button class="search-button" type="submit">
            <i class='bx bx-search'></i>
        </button>
        <ul id="searchResults" class="search-results"></ul>
        <?php
        if (isset($_SESSION['auth_user'])) {
            $cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
            echo "<a href='cart.php' class='cart-icon'>
              <i class='bx bx-cart'></i>";
            if ($cartCount > 0) {
                echo "<span class='cart-badge'>$cartCount</span>";
            }
            echo "</a>";
            echo "<a href='logout.php'><i class='bx bx-log-out'></i></a>";
        } else {
        ?>
            <a href="adlogin.php"><i class='bx bx-user-circle'></i></a>
        <?php
        }
        ?>

    </div>
</header>
<div class="wrapper">

    <div class="title">
        <h4>Our Group Members</h4>
    </div>

    <div class="card_Container">

        <div class="card">

            <div class="imbBx">
                <img src="assets/images/p1.jpg" alt="">
            </div>

            <div class="content">
                <div class="contentBx">
                    <h3>Mg SiThu Kaung Sett <br><br><span>UCSTT(17-18)-041</span></h3>
                </div>

            </div>

        </div>

        <div class="card">

            <div class="imbBx">
                <img src="assets/images/p3.jpg" alt="">
            </div>

            <div class="content">
                <div class="contentBx">
                    <h3>Ma Yadanar Myo <br><br><span>UCSTT(22-23)J-143</span></h3>
                </div>

            </div>

        </div>

        <div class="card">

            <div class="imbBx">
                <img src="assets/images/p5.jpg" alt="">
            </div>

            <div class="content">
                <div class="contentBx">
                    <h3>Ma Moe Sandar Tun<br><br><span>UCSTT(22-23)J-149</span></h3>
                </div>

            </div>

        </div>

        <div class="card">

            <div class="imbBx">
                <img src="assets/images/p4.jpg" alt="">
            </div>

            <div class="content">
                <div class="contentBx">
                    <h3>Ma Thae Su Hlaing<br><br><span>UCSTT(22-23)J-161</span></h3>
                </div>

            </div>
        </div>




        <div class="card">

            <div class="imbBx">
                <img src="assets/images/p2.jpg" alt="">
            </div>

            <div class="content">
                <div class="contentBx">
                    <h3>Ma Myat Myat Soe<br><br><span>UCSTT(22-23)J-164</span></h3>
                </div>

            </div>

        </div>
    </div>
</div>




<?php include('includes/footer.php'); ?>