<?php
session_start();
include('includes/header.php');
include('admin/config/dbcon.php'); // Include your database connection file

// Fetch feedback data from the database
$query = "SELECT u_name, feedback_text, star FROM feedback ORDER BY feedback_id DESC LIMIT 4";
$result = $con->query($query);
$feedbacks = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }
}
?>

<header>
  <a href="index.php" class="logo"><img src="assets/logo/logo1.png" alt=""></a>

  <ul class="navmenu">
    <li><a href="index.php">Home</a></li>
    <li><a href="plants.php">Plants</a></li>
    <li><a href="aboutus.php">About Us</a></li>
    <li class="active"><a href="feedback.php">Feedback</a></li>
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

<section class="feedback-section">
  <div class="container">
    <div class="feedback-left">
      <h2>Feedback</h2>
      <p>We value your feedback. Please let us know your thoughts and suggestions.</p>
      <form action="submit_feedback.php" method="POST" class="feedback-form">
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="rating">Rating:</label>
          <div class="star-rating">
            <i class='bx bx-star bx-flip-horizontal' style='color:#44b18d' data-value="1"></i>
            <i class='bx bx-star bx-flip-horizontal' style='color:#44b18d' data-value="2"></i>
            <i class='bx bx-star bx-flip-horizontal' style='color:#44b18d' data-value="3"></i>
            <i class='bx bx-star bx-flip-horizontal' style='color:#44b18d' data-value="4"></i>
            <i class='bx bx-star bx-flip-horizontal' style='color:#44b18d' data-value="5"></i>
          </div>
          <input type="hidden" id="rating" name="rating" required>
        </div>
        <div class="form-group">
          <label for="message">Message:</label>
          <textarea id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="submit-btn">Submit</button>
      </form>
    </div>
    <div class="feedback-right">
      <h2>Reviews</h2>
      <div class="reviews">
        <?php foreach ($feedbacks as $feedback): ?>
          <div class="review-card">
            <h3><?php echo htmlspecialchars($feedback['u_name']); ?></h3>
            <div class="star-rating">
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <?php if ($i <= $feedback['star']): ?>
                  <i class='bx bxs-star bx-flip-horizontal' style='color:#44b18d'></i>
                <?php else: ?>
                  <i class='bx bx-star bx-flip-horizontal' style='color:#44b18d'></i>
                <?php endif; ?>
              <?php endfor; ?>
            </div>
            <p><?php echo htmlspecialchars($feedback['feedback_text']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- Toast Notification -->
<div id="toast" class="toast"></div>

<?php include('includes/footer.php'); ?>

<script src="assets/js/feedback.js"></script>