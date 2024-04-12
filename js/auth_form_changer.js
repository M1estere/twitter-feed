window.onload = function() {

    const loginForm = document.querySelector('#login-form');
    const regForm = document.querySelector('#reg-form');

    const loginButton = document.querySelector('#login-button');
    const regButton = document.querySelector('#reg-button');

    loginButton.onclick = () => {
        changeForms();
    }

    regButton.onclick = () => {
        changeForms();
    }

    function changeForms() {
        loginForm.classList.toggle('visible');
        loginForm.classList.toggle('hidden');

        regForm.classList.toggle('visible');
        regForm.classList.toggle('hidden');

        loginButton.classList.toggle('border-b-2');
        regButton.classList.toggle('border-b-2');
    }

}