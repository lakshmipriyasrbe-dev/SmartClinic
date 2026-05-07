function formSubmit(form_name, from_page, to_page) {
    const form = document.forms[form_name];
    if (!form) {
        console.error("Form not found:", form_name);
        return;
    }

    // Clear previous errors and success messages
    const errorSpans = form.querySelectorAll('.error-msg');
    errorSpans.forEach(span => span.innerText = '');
    
    const successDiv = form.querySelector('.success-msg');
    if (successDiv) {
        successDiv.innerText = '';
        successDiv.classList.add('hidden');
    }

    const formData = new FormData(form);

    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerText;
    submitBtn.disabled = true;
    submitBtn.innerText = 'Processing...';

    fetch(from_page, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            if (successDiv) {
                successDiv.innerText = data.message;
                successDiv.classList.remove('hidden');
            }
            
            // Redirect after a short delay to show success message
            setTimeout(() => {
                window.location.href = to_page;
            }, 1500);
        } else {
            if (data.errors && Object.keys(data.errors).length > 0) {
                // Show field-specific errors
                for (const field in data.errors) {
                    const errorSpan = document.getElementById('error-' + field);
                    if (errorSpan) {
                        errorSpan.innerText = data.errors[field];
                    }
                }
            } else if (data.message) {
                // General error message
                alert(data.message);
            }
            
            submitBtn.disabled = false;
            submitBtn.innerText = originalBtnText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An unexpected error occurred.');
        submitBtn.disabled = false;
        submitBtn.innerText = originalBtnText;
    });
}

// Password Visibility Toggle
document.addEventListener('click', function(e) {
    const toggleBtn = e.target.closest('.toggle-password') || (e.target.id === 'toggle-password' ? e.target : null);
    
    if (toggleBtn) {
        const targetId = toggleBtn.getAttribute('data-target') || 'reg-password';
        const passwordInput = document.getElementById(targetId);
        if (!passwordInput) return;

        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Update icon
        const iconName = type === 'password' ? 'eye' : 'eye-off';
        toggleBtn.setAttribute('data-lucide', iconName);
        lucide.createIcons();
    }
});

// Password Requirements Check
function checkPasswordRequirements(password) {
    const requirements = {
        lower: /[a-z]/.test(password),
        upper: /[A-Z]/.test(password),
        number: /[0-9]/.test(password),
        special: /[\W]/.test(password),
        length: password.length >= 8
    };

    for (const req in requirements) {
        const element = document.getElementById('hint-' + req);
        if (element) {
            if (requirements[req]) {
                element.classList.remove('invalid');
                element.classList.add('valid');
                element.querySelector('svg').outerHTML = '<i data-lucide="check-circle-2"></i>';
            } else {
                element.classList.remove('valid');
                element.classList.add('invalid');
                element.querySelector('svg').outerHTML = '<i data-lucide="circle"></i>';
            }
        }
    }
    lucide.createIcons();
}
