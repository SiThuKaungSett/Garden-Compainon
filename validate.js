const passwordInput = document.querySelector(".login__box_password input");
const requirementsList = document.querySelectorAll(".requirement-list li");

const requirements = [
    {regex : /.{8,}/, index: 0},
    {regex : /[0-9]/, index: 1},
    {regex : /[a-z]/, index: 2},
    {regex : /[^A-Za-z0-9]/, index: 3},
    {regex : /[A-Z]/, index: 4},
]

passwordInput.addEventListener("keyup", (e)=>{
    requirements.forEach(items => {
        const isValid = items.regex.test(e.target.value);
        const requirementsItem = requirementsList[items.index];

        if(isValid){
            requirementsItem.firstElementChild.className = "fa-solid fa-check";
            requirementsItem.classList.add("valid");
        }else{
            requirementsItem.firstElementChild.className = "fa-solid fa-circle"
            requirementsItem.classList.remove("valid");
        }
    });
});

