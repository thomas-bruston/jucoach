(function () {
    'use strict';

    const reviews = [
        {
            name:   'MB J',
            initials: 'MB',
            color:  '#C2185B',
            rating: 5,
            text:   'Julien un coach super motivant, déterminé, gentil, joyeux. Il s\'adapte à notre rythme. Toujours là, pour nous encourager. N\'hésitez pas à l\'avoir comme coach sportif.'
        },
        {
            name:   'Marina P',
            initials: 'M',
            color:  '#E65100',
            rating: 4,
            text:   'Vous cherchez un coatch sérieux ? Engagé ? Qui sait adapter vos séances et prendre en compte vos objectifs ? Vous êtes au bon endroit ! Julien sait m\'accompagner et être bienveillant et faire en sorte que chaque séance soit aussi un bon moment partagé !'
        },
        {
            name:   'Leslie F',
            initials: 'LF',
            color:  '#6A1B9A',
            rating: 5,
            text:   'Julien est un excellent coach ! Au delà de l\'aspect sportif il m\'a aussi beaucoup aidé au niveau du mental. Il m\'a aidé vraiment à reprendre le chemin du sport. Ses séances sont ultra complètes et variées.'
        },
        {
            name:   'Robert F',
            initials: 'RF',
            color:  '#00695C',
            rating: 5,
            text:   'Julien est très attentif à l\'équilibre intensité et durée de l\'effort, versus temps de récupération après exercices. Bonne communication / écoute.'
        },
        {
            name:   'Didier H',
            initials: 'DH',
            color:  '#1565C0',
            rating: 5,
            text:   'Plus de 7 décennies… super forme grand merci à toi de l\'entraînement cotidient.. p\'tit photo récente..'
        },
        {
            name:   'Lottermoser C',
            initials: 'LC',
            color:  '#2E7D32',
            rating: 5,
            text:   'Pro fiable sympa, exercices variés, Julien est attentif à s\'adapter à chaque situation, que ce soit pour de l\'entretien ou une récupération post opératoire. Je recommande.'
        },
        {
            name:   'Yoann',
            initials: 'Y',
            color:  '#F57F17',
            rating: 5,
            text:   'Cela fait près de deux mois que je m\'entraîne avec Julien, et je ne pourrais être plus satisfait des résultats. Après avoir détesté le sport pendant plus de 30 ans, je n\'aurais jamais cru qu\'une telle transformation était possible. Julien est un professionnel exceptionnel. Il a su faire preuve d\'une adaptabilité remarquable.'
        },
        {
            name:   'Rem B',
            initials: 'RB',
            color:  '#00838F',
            rating: 5,
            text:   'Julien est un coach exceptionnel : motivant, à l\'écoute, et très professionnel. Je recommande à 100 % !'
        }
    ];

    const VISIBLE = window.innerWidth < 768 ? 1 : 3;
    let current   = 0;

    /**
     * Génère les étoiles HTML selon la note
     */
    function buildStars(rating) {
        let html = '';
        for (let i = 1; i <= 5; i++) {
            html += `<span class="review-star ${i <= rating ? 'review-star--full' : 'review-star--empty'}" aria-hidden="true">★</span>`;
        }
        return html;
    }

    /**
     * Génère le HTML d'une card avis
     */
    function buildCard(review) {
        return `
        <article class="review-card" aria-label="Avis de ${review.name}">
            <div class="review-card__header">
                <div class="review-card__avatar" style="background-color:${review.color};" aria-hidden="true">
                    ${review.initials}
                </div>
                <div class="review-card__meta">
                    <p class="review-card__name">${review.name}</p>
                    <div class="review-card__stars" role="img" aria-label="Note : ${review.rating} sur 5">
                        ${buildStars(review.rating)}
                    </div>
                </div>
                <svg class="review-card__google" viewBox="0 0 24 24" aria-label="Google" role="img">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
            </div>
            <p class="review-card__text">${review.text}</p>
        </article>`;
    }

    /**
     * Met à jour l'affichage du carrousel
     */
    function updateCarousel(track, prevBtn, nextBtn) {
        const cards   = track.querySelectorAll('.review-card');
        const total   = reviews.length;

        cards.forEach((card, i) => {
            const pos = (i - current + total) % total;
            card.style.display = pos < VISIBLE ? 'flex' : 'none';
        });

        prevBtn.disabled = false;
        nextBtn.disabled = false;
    }

    /**
     * Initialise le carrousel
     */
    function init() {
        const section = document.getElementById('reviewsCarousel');
        if (!section) return;

        // Construction HTML
        const track = section.querySelector('.reviews-track');
        if (!track) return;

        reviews.forEach(r => {
            track.insertAdjacentHTML('beforeend', buildCard(r));
        });

        const prevBtn = section.querySelector('.reviews-prev');
        const nextBtn = section.querySelector('.reviews-next');

        updateCarousel(track, prevBtn, nextBtn);

        prevBtn.addEventListener('click', () => {
            current = (current - 1 + reviews.length) % reviews.length;
            updateCarousel(track, prevBtn, nextBtn);
        });

        nextBtn.addEventListener('click', () => {
            current = (current + 1) % reviews.length;
            updateCarousel(track, prevBtn, nextBtn);
        });
    }

    document.addEventListener('DOMContentLoaded', init);

})();
