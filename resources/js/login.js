document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('login-form');
    const errorDiv = document.getElementById('login-error');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        errorDiv.textContent = '';

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const remember = form.querySelector('input[name="remember"]').checked;

        console.log(email);

        try {
            const response = await fetch('/api/lynkr/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    email,
                    password,
                    remember
                })
            });

            const data = await response.json();

            if (!response.ok) {
                const message = data.message || 'Login failed';
                const fieldErrors = data.errors?.email?.[0] || message;
                throw new Error(fieldErrors);
            }

            localStorage.setItem('lynkr_token', data.access_token);
            localStorage.setItem('lynkr_token_type', data.token_type);
            localStorage.setItem('lynkr_user', JSON.stringify(data.user));

            window.location.href = '/';

        } catch (error) {
            errorDiv.textContent = error.message;
        }
    });
});
