// const rmCheck = document.getElementById("remember-me"),
//     emailInput = document.getElementById("email");

// if (localStorage.checkbox && localStorage.checkbox !== ""){
//     rmCheck.setAttribute("checked", "checked");
//     emailInput.value = localStorage.email;
// } else{
//     rmCheck.removeAttribute("Checked");
//     emailInput.value = "";
// }

// function is_remember_me(){
//     if (rmCheck.checked && emailInput.value !== ""){
//         localStorage.email = emailInput.value;
//         localStorage.checkbox = rmCheck.value;
//     } else {
//         localStorage.email = "";
//         localStorage.checkbox = "";
//     }
// }

// Function to check if the "Remember me" checkbox is checked
function rememberMe() {
    const rememberCheckbox = document.getElementById('remember-me');
    const emailInput = document.getElementById('email');
    const pwdInput = document.getElementById('pwd');

    if (rememberCheckbox.checked) {
        // If checkbox is checked, store email and password in localStorage
        localStorage.setItem('rememberedEmail', emailInput.value);
        localStorage.setItem('rememberedPwd', pwdInput.value);
    } else {
        // If checkbox is not checked, remove stored email and password from localStorage
        localStorage.removeItem('rememberedEmail');
        localStorage.removeItem('rememberedPwd');
    }
}

// Function to load stored email and password if "Remember me" checkbox is checked
function loadRememberedCredentials() {
    const rememberCheckbox = document.getElementById('remember-me');
    const emailInput = document.getElementById('email');
    const pwdInput = document.getElementById('pwd');

    if (rememberCheckbox.checked) {
        const rememberedEmail = localStorage.getItem('rememberedEmail');
        const rememberedPwd = localStorage.getItem('rememberedPwd');

        if (rememberedEmail && rememberedPwd) {
            emailInput.value = rememberedEmail;
            pwdInput.value = rememberedPwd;
        }
    }
}

// Event listener to call rememberMe function when checkbox state changes
document.getElementById('remember-me').addEventListener('change', rememberMe);

// Call loadRememberedCredentials function when the page loads
document.addEventListener('DOMContentLoaded', loadRememberedCredentials);
