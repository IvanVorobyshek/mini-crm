document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('feedbackForm');
    if (!form) return;

    const submitBtn = document.getElementById('submitBtn');
    const loading = document.getElementById('loading');
    const successMessage = document.getElementById('successMessage');
    const globalError = document.getElementById('globalError');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        document.querySelectorAll('.error').forEach(el => el.textContent = '');
        globalError.style.display = 'none';
        successMessage.style.display = 'none';

        submitBtn.disabled = true;
        loading.style.display = 'block';

        const formData = new FormData(form);

        try {
            const response = await fetch('/api/tickets', {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                successMessage.style.display = 'block';
                form.reset();
            } else {
                if (data.errors) {
                    for (const [field, messages] of Object.entries(data.errors)) {
                        const errorEl = document.getElementById(`error-${field}`);
                        if (errorEl) {
                            errorEl.textContent = messages[0];
                        }
                    }
                } else {
                    globalError.style.display = 'block';
                    globalError.textContent = data.message ?? 'Unexpected error';
                }
            }
        } catch {
            globalError.style.display = 'block';
            globalError.textContent = 'Unable to send request. Please try again later.';
        } finally {
            submitBtn.disabled = false;
            loading.style.display = 'none';
        }
    });
});
