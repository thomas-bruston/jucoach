(function () {
    'use strict';

    window.toggleForm = function (id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    };

    // Lightbox galerie photos

    const lightbox = document.getElementById('lightbox');
    if (!lightbox) return;

    const images     = Array.from(document.querySelectorAll('.galerie-item__img'));
    const lightboxImg = lightbox.querySelector('.lightbox__img');
    const legendeEl   = lightbox.querySelector('.lightbox__legende');
    const btnClose    = lightbox.querySelector('.lightbox__close');
    const btnPrev     = lightbox.querySelector('.lightbox__prev');
    const btnNext     = lightbox.querySelector('.lightbox__next');

    let currentIndex = 0;

    function show(index) {
        currentIndex = (index + images.length) % images.length;
        const img = images[currentIndex];
        lightboxImg.src = img.src;
        lightboxImg.alt = img.alt;
        legendeEl.textContent = img.dataset.legende || '';
    }

    function open(index) {
        show(index);
        lightbox.classList.add('open');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function close() {
        lightbox.classList.remove('open');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    images.forEach((img, index) => {
        img.style.cursor = 'zoom-in';
        img.addEventListener('click', () => open(index));
    });

    btnClose.addEventListener('click', close);
    btnPrev.addEventListener('click', () => show(currentIndex - 1));
    btnNext.addEventListener('click', () => show(currentIndex + 1));

    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) close();
    });

    document.addEventListener('keydown', (e) => {
        if (!lightbox.classList.contains('open')) return;
        if (e.key === 'Escape')     close();
        if (e.key === 'ArrowLeft')  show(currentIndex - 1);
        if (e.key === 'ArrowRight') show(currentIndex + 1);
    });

})();
