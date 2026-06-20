document.addEventListener("DOMContentLoaded", function () {
  const formStars = document.querySelectorAll(".feedback-form .star-rating i");
  const ratingInput = document.getElementById("rating");
  const feedbackForm = document.querySelector(".feedback-form");
  const toast = document.getElementById("toast");

  formStars.forEach(star => {
    star.addEventListener("click", function () {
      const rating = this.getAttribute("data-value");
      ratingInput.value = rating;

      formStars.forEach(s => {
        s.classList.remove("active");
        s.classList.remove("bxs-star");
        s.classList.add("bx-star");
      });

      for (let i = 0; i < rating; i++) {
        formStars[i].classList.add("active");
        formStars[i].classList.remove("bx-star");
        formStars[i].classList.add("bxs-star");
      }
    });
  });

  feedbackForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(feedbackForm);

    fetch("submit_feedback.php", {
      method: "POST",
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      showToast(data.message);
      if (data.success) {
        feedbackForm.reset();
        formStars.forEach(star => {
          star.classList.remove("active");
          star.classList.remove("bxs-star");
          star.classList.add("bx-star");
        });
      }
    })
    .catch(error => {
      showToast("An error occurred. Please try again later.");
    });
  });

  function showToast(message) {
    toast.textContent = message;
    toast.className = "toast show";
    setTimeout(function () {
      toast.className = toast.className.replace("show", "");
    }, 3000);
  }
});