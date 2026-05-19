(function () {
    'use strict';

    const filterBtns  = document.querySelectorAll('.filtre-btn');
    const cards       = document.querySelectorAll('.programme-card');

    if (!filterBtns.length || !cards.length) return;

    // Filtre actif
    let filtreActif = 'tous';

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {

            // MAJ bouton actif
            filterBtns.forEach(b => {
                b.classList.remove('filtre-btn--active');
                b.setAttribute('aria-pressed', 'false');
            });
            btn.classList.add('filtre-btn--active');
            btn.setAttribute('aria-pressed', 'true');

            filtreActif = btn.dataset.type;

            // Affiche / masque les cards
            cards.forEach(card => {
                if (filtreActif === 'tous' || card.dataset.type === filtreActif) {
                    card.style.display = '';
                    card.removeAttribute('aria-hidden');
                } else {
                    card.style.display = 'none';
                    card.setAttribute('aria-hidden', 'true');
                }
            });
        });
    });

})();
