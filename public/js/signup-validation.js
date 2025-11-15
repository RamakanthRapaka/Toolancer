document.addEventListener('DOMContentLoaded', function () {

    // Bootstrap-style client validation
    (function () {
        'use strict'
        var form = document.querySelector('#signupForm')
        if (!form) return

        form.addEventListener('submit', function (event) {

            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })();

    // Reopen offcanvas if server returned validation errors
    if (window.hasSignupErrors) {
        try {
            var el = document.getElementById('loginslide');
            if (el) {
                var bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(el);
                bsOffcanvas.show();

                var firstInvalid = el.querySelector('.is-invalid, :invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                }
            }
        } catch (e) {
            console.error('Offcanvas open error', e);
        }
    }

    // Auto close on success
    if (window.signupSuccess) {
        setTimeout(function () {
            var el = document.getElementById('loginslide');
            if (el) {
                var bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(el);
                bsOffcanvas.hide();
            }
        }, 2000);
    }
});
