document.addEventListener("DOMContentLoaded", function () {
  const allSideMenu = document.querySelectorAll("#sidebar .side-menu.top li a");

  allSideMenu.forEach((item) => {
    const li = item.parentElement;

    item.addEventListener("click", function () {
      allSideMenu.forEach((i) => {
        i.parentElement.classList.remove("active");
      });
      li.classList.add("active");
    });
  });

  const menuBar = document.querySelector("#content nav .bx.bx-menu");
  const sideBar = document.getElementById("sidebar");

  if (menuBar) {
    menuBar.addEventListener("click", function () {
      sideBar.classList.toggle("hide");
    });
  }

  const deleteModal = document.getElementById("deleteModal");
  const deleteForm = document.getElementById("deleteForm");
  const deleteIdInput = document.getElementById("delete_id");
  const closeModal = document.querySelector(".modal .close");
  const cancelBtn = document.getElementById("cancelBtn");

  document.querySelectorAll(".delete-btn").forEach(button => {
    button.addEventListener("click", function (event) {
      event.preventDefault();
      const id = this.dataset.id;
      deleteIdInput.value = id;
      deleteModal.style.display = "block";
    });
  });

  if (closeModal) {
    closeModal.addEventListener("click", function () {
      deleteModal.style.display = "none";
    });
  }

  if (cancelBtn) {
    cancelBtn.addEventListener("click", function () {
      deleteModal.style.display = "none";
    });
  }

  window.addEventListener("click", function (event) {
    if (event.target == deleteModal) {
      deleteModal.style.display = "none";
    }
  });

  // Password validation script
  const togglePassword = document.querySelector('#togglePassword');
  const passwordInput = document.querySelector('#password');
  const confirmPasswordInput = document.querySelector('#confirm_password');
  const passwordError = document.getElementById("password_error");
  const validationAlert = document.getElementById("validationAlert");
  const requirementsList = document.querySelectorAll(".requirement-list li");

  const requirements = [
    {regex : /.{8,}/, index: 0},
    {regex : /[0-9]/, index: 1},
    {regex : /[a-z]/, index: 2},
    {regex : /[^A-Za-z0-9]/, index: 3},
    {regex : /[A-Z]/, index: 4},
  ];

  passwordInput.addEventListener("keyup", (e) => {
    requirements.forEach(items => {
      const isValid = items.regex.test(e.target.value);
      const requirementsItem = requirementsList[items.index];

      if (isValid) {
        requirementsItem.firstElementChild.className = "fa-solid fa-check";
        requirementsItem.classList.add("valid");
      } else {
        requirementsItem.firstElementChild.className = "fa-solid fa-circle";
        requirementsItem.classList.remove("valid");
      }
    });
  });

  if (togglePassword) {
    togglePassword.addEventListener('click', (e) => {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      e.target.classList.toggle('bi-eye');
    });
  }

  if (passwordInput && confirmPasswordInput && passwordError) {
    confirmPasswordInput.addEventListener("input", function () {
      if (passwordInput.value !== confirmPasswordInput.value) {
        passwordError.textContent = "Passwords do not match.";
      } else {
        passwordError.textContent = "";
      }
    });
  }
});

function validatePassword() {
  const password = document.querySelector("#password").value;
  const repassword = document.querySelector("#confirm_password").value;
  const validationAlert = document.getElementById("validationAlert");
  const requirements = [
    {regex : /.{8,}/},
    {regex : /[0-9]/},
    {regex : /[a-z]/},
    {regex : /[^A-Za-z0-9]/},
    {regex : /[A-Z]/},
  ];
  const valid = requirements.every(item => item.regex.test(password));

  if (!valid) {
    validationAlert.innerHTML = `
      <div class="alert alert-danger" role="alert">
        Password does not meet the requirements.
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
      </div>
    `;
    return false;
  }

  if (password !== repassword) {
    validationAlert.innerHTML = `
      <div class="alert alert-danger" role="alert">
        Passwords do not match.
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
      </div>
    `;
    return false;
  }

  return true;
}

