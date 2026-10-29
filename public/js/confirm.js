// Confirmation avant envoi des formulaires portant data-confirm
// (remplace onsubmit="return confirm(...)", bloqué par la CSP)

document.querySelectorAll('form[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (e) => {
        if (!confirm(form.dataset.confirm)) {
            e.preventDefault();
        }
    });
});
