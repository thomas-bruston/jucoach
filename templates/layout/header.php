<header class="site-header" role="banner">
    <nav class="header-nav" aria-label="Navigation principale">

        <!-- Logo -->
        <a href="/" class="header-logo" aria-label="Ju Coach Sportif — Accueil">
            <img src="/images/ju2.webp" alt="Ju Coach Sportif" width="64" height="64">
        </a>

        <!-- Navigation centrale (desktop) -->
        <ul class="header-menu" role="list">
            <li>
                <a href="/programmes"
                   class="header-link <?= str_starts_with($_SERVER['REQUEST_URI'], '/programmes') ? 'header-link--active' : '' ?>"
                   aria-current="<?= str_starts_with($_SERVER['REQUEST_URI'], '/programmes') ? 'page' : 'false' ?>">
                    PROGRAMMES <i class="fa-solid fa-dumbbell" aria-hidden="true"></i>
                </a>
            </li>
            <li>
                <a href="/galerie"
                   class="header-link <?= str_starts_with($_SERVER['REQUEST_URI'], '/galerie') ? 'header-link--active' : '' ?>"
                   aria-current="<?= str_starts_with($_SERVER['REQUEST_URI'], '/galerie') ? 'page' : 'false' ?>">
                    GALERIE <i class="fa-solid fa-image" aria-hidden="true"></i>
                </a>
            </li>
            <li>
                <a href="/partenaire"
                class="header-link <?= str_starts_with($_SERVER['REQUEST_URI'], '/partenaire') ? 'header-link--active' : '' ?>"
                aria-current="<?= str_starts_with($_SERVER['REQUEST_URI'], '/partenaire') ? 'page' : 'false' ?>">
                    SÉANCES À NOSY BE <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                </a>
            </li>
            <li>
                <a href="/connexion"
                   class="header-link <?= $_SERVER['REQUEST_URI'] === '/connexion' ? 'header-link--active' : '' ?>"
                   aria-current="<?= $_SERVER['REQUEST_URI'] === '/connexion' ? 'page' : 'false' ?>">
                    CONNEXION <i class="fa-solid fa-power-off" aria-hidden="true"></i>
                </a>
            </li>
        </ul>

        <!-- Icône utilisateur + menu déroulant -->
        <div class="header-user">
            <button id="userBtn"
                    class="user-btn"
                    aria-label="Menu utilisateur"
                    aria-expanded="false"
                    aria-controls="userMenu">
                <?php if (\Core\Session::isLoggedIn()): ?>
                    <i class="fa-solid fa-circle-user" aria-hidden="true"></i>
                <?php else: ?>
                    <i class="fa-regular fa-circle-user" aria-hidden="true"></i>
                <?php endif; ?>
            </button>

            <ul id="userMenu"
                class="user-menu"
                role="menu"
                aria-hidden="true"
                inert>
                <?php if (\Core\Session::isLoggedIn()): ?>
                    <li role="none"><a href="/mon-programme"         role="menuitem">Mon programme</a></li>
                    <li role="none"><a href="/mon-profil"            role="menuitem">Mon profil</a></li>
                    <?php if (\Core\Session::isAdmin()): ?>
                        <li role="none"><a href="/admin"             role="menuitem">Administration</a></li>
                    <?php endif; ?>
                    <li role="none"><a href="/deconnexion"           role="menuitem">Se déconnecter</a></li>
                <?php else: ?>
                    <li role="none"><a href="/connexion"             role="menuitem">Se connecter</a></li>
                    <li role="none"><a href="/inscription"           role="menuitem">Créer un compte</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Bouton burger (mobile) -->
        <button id="burgerBtn"
                class="header-burger"
                aria-label="Ouvrir le menu"
                aria-expanded="false"
                aria-controls="sideMenu">
            <span class="burger-bar"></span>
            <span class="burger-bar"></span>
            <span class="burger-bar"></span>
        </button>

    </nav>
</header>

<!-- Menu latéral mobile -->
<nav id="sideMenu"
     class="side-menu"
     aria-label="Menu mobile"
     aria-hidden="true"
     inert>
    <ul role="list">
        <li><a href="/programmes">PROGRAMMES <i class="fa-solid fa-dumbbell" aria-hidden="true"></i></a></li>
        <li><a href="/galerie">GALERIE <i class="fa-solid fa-image" aria-hidden="true"></i></a></li>
        <li><a href="/partenaire">SÉANCES À NOSY BE <i class="fa-solid fa-location-dot" aria-hidden="true"></i></a></li>
        <li><a href="/connexion">CONNEXION <i class="fa-solid fa-power-off" aria-hidden="true"></i></a></li>
    </ul>
</nav>

<!-- Overlay -->
<div id="overlay" class="overlay" aria-hidden="true"></div>
