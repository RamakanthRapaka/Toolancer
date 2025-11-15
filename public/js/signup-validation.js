document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('signupForm');
    if (!form) return;

    // helper: clear previous error states
    function clearErrors() {
        form.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });
        form.querySelectorAll('.invalid-feedback.ajax-error').forEach(function (el) {
            el.remove();
        });
        var general = form.querySelector('.ajax-message');
        if (general) general.remove();
    }

    // helper: show field errors object { field: [messages] }
    function showErrors(errors) {
        Object.keys(errors).forEach(function (field) {
            var input = form.querySelector('[name="' + field + '"]');
            var messages = errors[field]; // array
            if (input) {
                input.classList.add('is-invalid');
                // append invalid-feedback under the input if not exists
                var wrapper = document.createElement('div');
                wrapper.className = 'invalid-feedback ajax-error';
                wrapper.innerText = messages.join(' ');
                // try to insert after input (or its parent)
                if (input.parentNode) {
                    input.parentNode.appendChild(wrapper);
                } else {
                    input.after(wrapper);
                }
            } else {
                // field not found: show as general message
                var general = document.createElement('div');
                general.className = 'alert alert-danger ajax-message';
                general.innerText = messages.join(' ');
                form.prepend(general);
            }
        });
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        // client-side HTML5 check
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        // gather form data
        var formData = new FormData(form);
        var action = form.getAttribute('action') || window.location.href;

        // clear previous states
        clearErrors();

        // show a small loading state (disable submit)
        var submitBtn = form.querySelector('button[type="submit"]');
        var origText = submitBtn ? submitBtn.innerHTML : null;
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Please wait...';
        }

        // CSRF token from meta or hidden input + request headers to signal AJAX/json
        var token = document.querySelector('meta[name="csrf-token"]');
        var headers = {
            'Accept': 'application/json',               // <--- tell Laravel we accept JSON
            'X-Requested-With': 'XMLHttpRequest'        // helpful fallback for some servers
        };
        if (token) {
            headers['X-CSRF-TOKEN'] = token.getAttribute('content');
        }


        fetch(action, {
            method: 'POST',
            headers: headers,
            body: formData,
            credentials: 'same-origin'
        })
            .then(function (resp) {
                if (resp.status === 422) {
                    // validation error
                    return resp.json().then(function (data) {
                        throw { type: 'validation', payload: data };
                    });
                }
                if (!resp.ok) {
                    return resp.text().then(function (txt) {
                        throw { type: 'error', payload: txt || 'Server error' };
                    });
                }
                return resp.json();
            })
            .then(function (data) {
                // success
                var successMsg = document.createElement('div');
                successMsg.className = 'alert alert-success ajax-message';
                successMsg.innerText = data.message || 'Signup successful.';
                form.prepend(successMsg);

                // optionally reset form
                form.reset();
                form.classList.remove('was-validated');

                // close offcanvas after 1.5s
                var el = document.getElementById('loginslide');
                if (el) {
                    var bs = bootstrap.Offcanvas.getOrCreateInstance(el);
                    setTimeout(function () {
                        bs.hide();
                        // remove success message after hide
                        setTimeout(function () {
                            var gm = form.querySelector('.ajax-message');
                            if (gm) gm.remove();
                        }, 400);
                    }, 5000);
                } else {
                    // fallback: remove message after delay
                    setTimeout(function () {
                        var gm = form.querySelector('.ajax-message');
                        if (gm) gm.remove();
                    }, 5000);
                }
            })
            .catch(function (err) {
                if (err && err.type === 'validation' && err.payload && err.payload.errors) {
                    showErrors(err.payload.errors);
                    // reopen offcanvas (if closed) and focus first invalid
                    var el = document.getElementById('loginslide');
                    if (el) {
                        var bs = bootstrap.Offcanvas.getOrCreateInstance(el);
                        bs.show();
                        var firstInvalid = el.querySelector('.is-invalid, :invalid');
                        if (firstInvalid) firstInvalid.focus();
                    }
                } else {
                    // general error
                    var general = document.createElement('div');
                    general.className = 'alert alert-danger ajax-message';
                    general.innerText = (err.payload && err.payload.message) ? err.payload.message : 'An error occurred. Try again later.';
                    form.prepend(general);
                }
            })
            .finally(function () {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = origText;
                }
            });
    }, false);
});
