const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const passInput = form.querySelector('input[name="password"]');
const confirmedPassInput = form.querySelector('input[name="confirmed_pass"]');


function isEmail(email){
    return /\S+@\S+\.\S+/.test(email);
}

function arePasswordsSame(password, confirmedPassword) {
    return password === confirmedPassword;}

    function markValidation(element, condition) {
        !condition ? element.classList.add('is-invalid') && passInput.classList.add('is-invalid') : element.classList.remove('is-invalid');
        element.classList.add('is-valid');passInput.classList.remove('is-invalid');passInput.classList.add('is-valid');
    }

    emailInput.addEventListener('keyup', function () {
        setTimeout(function () {
                markValidation(emailInput, isEmail(emailInput.value))
            }, 1000
        );
    });

    confirmedPassInput.addEventListener('keyup', function () {
        setTimeout(function () {
                const condition = arePasswordsSame(
                    passInput.value,
                    confirmedPassInput.value);
                markValidation(confirmedPassInput, condition);
            }, 1000
        );
    });

