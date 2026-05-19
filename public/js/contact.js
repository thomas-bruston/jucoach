(function () {
    'use strict';

    const form     = document.getElementById('contactForm');
    const feedback = document.getElementById('contact-feedback');
    const submitBtn = document.getElementById('contactSubmit');

    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const nom     = form.querySelector('#nom').value.trim();
        const email   = form.querySelector('#email').value.trim();
        const message = form.querySelector('#message').value.trim();

        // Validation côté client
        if (!nom || !email || !message) {
            showFeedback('error', 'Veuillez remplir tous les champs.');
            return;
        }

        if (!isValidEmail(email)) {
            showFeedback('error', 'Adresse email invalide.');
            return;
        }

        // Désactiver le bouton pendant l'envoi
        submitBtn.disabled = true;
        submitBtn.textContent = 'Envoi en cours...';

        const formData = new FormData(form);

        fetch('/contact', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showFeedback('success', data.message);
                form.reset();
            } else {
                showFeedback('error', data.message);
            }
        })
        .catch(() => {
            showFeedback('error', 'Une erreur est survenue. Veuillez réessayer.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = 'ENVOYER';
        });
    });

    function showFeedback(type, message) {
        feedback.className   = 'alert alert--' + type;
        feedback.textContent = message;
        feedback.style.display = 'block';
        feedback.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

})();
