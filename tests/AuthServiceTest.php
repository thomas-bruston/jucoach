<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Service\AuthService;

/**
 * Tests unitaires — AuthService
 * Couvre : validatePassword(), login(), register()
 * CP7 — Composants métier, style défensif, tests unitaires
 */
class AuthServiceTest extends TestCase
{
    private AuthService $authService;

    protected function setUp(): void
{
    $mockRepo = $this->createMock(\Repository\UserRepository::class);
    $this->authService = $this->makeAuthService($mockRepo);
}

    /* Construit un AuthService avec un UserRepository donné et un
       LoginAttemptRepository mocké (aucune tentative récente par défaut). */
    private function makeAuthService(\Repository\UserRepository $userRepo, int $recentAttempts = 0): AuthService
    {
        $loginAttemptRepo = $this->createMock(\Repository\LoginAttemptRepository::class);
        $loginAttemptRepo->method('countRecent')->willReturn($recentAttempts);

        return new AuthService($userRepo, $loginAttemptRepo);
    }

    // -------------------------------------------------------------------------
    // validatePassword()
    // -------------------------------------------------------------------------

    /** @test */
    public function testMotDePasseValide(): void
    {
        $errors = $this->authService->validatePassword('Test12345!', 'Test12345!');
        $this->assertEmpty($errors, 'Un mot de passe valide ne doit générer aucune erreur.');
    }

    /** @test */
    public function testMotDePasseTropCourt(): void
    {
        $errors = $this->authService->validatePassword('Test1!');
        $this->assertNotEmpty($errors);
        $this->assertStringContainsString('10 caractères', $errors[0]);
    }

    /** @test */
    public function testMotDePasseSansMajuscule(): void
    {
        $errors = $this->authService->validatePassword('test12345!');
        $this->assertNotEmpty($errors);
        $this->assertStringContainsString('majuscule', implode(' ', $errors));
    }

    /** @test */
    public function testMotDePasseSansMinuscule(): void
    {
        $errors = $this->authService->validatePassword('TEST12345!');
        $this->assertNotEmpty($errors);
        $this->assertStringContainsString('minuscule', implode(' ', $errors));
    }

    /** @test */
    public function testMotDePasseSansChiffre(): void
    {
        $errors = $this->authService->validatePassword('TestTestTest!');
        $this->assertNotEmpty($errors);
        $this->assertStringContainsString('chiffre', implode(' ', $errors));
    }

    /** @test */
    public function testMotDePasseSansCaractereSpecial(): void
    {
        $errors = $this->authService->validatePassword('Test123456');
        $this->assertNotEmpty($errors);
        $this->assertStringContainsString('spécial', implode(' ', $errors));
    }

    /** @test */
    public function testMotDePasseConfirmationDifferente(): void
    {
        $errors = $this->authService->validatePassword('Test12345!', 'Test12345?');
        $this->assertNotEmpty($errors);
        $this->assertStringContainsString('correspondent pas', implode(' ', $errors));
    }

    /** @test */
    public function testMotDePasseMultiplesErreurs(): void
    {
        $errors = $this->authService->validatePassword('abc');
        $this->assertGreaterThan(1, count($errors), 'Plusieurs erreurs doivent être retournées.');
    }

    // -------------------------------------------------------------------------
    // register() — validation des données sans BDD
    // -------------------------------------------------------------------------

    /** @test */
    public function testRegisterEmailInvalide(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('email invalide');

        $this->authService->register([
            'nom'              => 'Dupont',
            'prenom'           => 'Marie',
            'email'            => 'email-invalide',
            'password'         => 'Test12345!',
            'password_confirm' => 'Test12345!',
            'consent_donnees'  => true,
        ]);
    }

    /** @test */
    public function testRegisterSansConsentement(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('politique de confidentialité');

        $this->authService->register([
            'nom'              => 'Dupont',
            'prenom'           => 'Marie',
            'email'            => 'marie@test.com',
            'password'         => 'Test12345!',
            'password_confirm' => 'Test12345!',
        ]);
    }

    /** @test */
    public function testRegisterNomVide(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('obligatoires');

        $this->authService->register([
            'nom'              => '',
            'prenom'           => 'Marie',
            'email'            => 'marie@test.com',
            'password'         => 'Test12345!',
            'password_confirm' => 'Test12345!',
        ]);
    }

    /** @test */
    public function testRegisterPrenomVide(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('obligatoires');

        $this->authService->register([
            'nom'              => 'Dupont',
            'prenom'           => '',
            'email'            => 'marie@test.com',
            'password'         => 'Test12345!',
            'password_confirm' => 'Test12345!',
        ]);
    }

    /** @test */
    public function testRegisterMotDePasseTropCourt(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('10 caractères');

        $this->authService->register([
            'nom'              => 'Dupont',
            'prenom'           => 'Marie',
            'email'            => 'marie@test.com',
            'password'         => 'Test1!',
            'password_confirm' => 'Test1!',
            'consent_donnees'  => true,
        ]);
    }

    // -------------------------------------------------------------------------
    // login()
    // -------------------------------------------------------------------------

    private function makeUser(
        string $password = 'Test12345!',
        string $statut   = 'actif',
        string $role     = 'utilisateur'
    ): \Entity\User {
        return new \Entity\User(
            email:    'marie@test.com',
            password: password_hash($password, PASSWORD_BCRYPT),
            prenom:   'Marie',
            nom:      'Dupont',
            statut:   $statut,
            role:     $role,
            roleId:   $role === 'administrateur' ? 2 : 1,
            id:       1
        );
    }

    /** @test */
    public function testLoginEmailVide(): void
    {
        $this->assertNull($this->authService->login('', 'Test12345!'));
    }

    /** @test */
    public function testLoginPasswordVide(): void
    {
        $this->assertNull($this->authService->login('marie@test.com', ''));
    }

    /** @test */
    public function testLoginUtilisateurInexistant(): void
    {
        $mockRepo = $this->createMock(\Repository\UserRepository::class);
        $mockRepo->method('findByEmail')->willReturn(null);

        $authService = $this->makeAuthService($mockRepo);

        $this->assertNull($authService->login('inconnu@test.com', 'Test12345!'));
    }

    /** @test */
    public function testLoginCompteInactif(): void
    {
        $mockRepo = $this->createMock(\Repository\UserRepository::class);
        $mockRepo->method('findByEmail')->willReturn($this->makeUser(statut: 'inactif'));

        $authService = $this->makeAuthService($mockRepo);

        $this->assertNull($authService->login('marie@test.com', 'Test12345!'));
    }

    /** @test */
    public function testLoginMotDePasseIncorrect(): void
    {
        $mockRepo = $this->createMock(\Repository\UserRepository::class);
        $mockRepo->method('findByEmail')->willReturn($this->makeUser());

        $authService = $this->makeAuthService($mockRepo);

        $this->assertNull($authService->login('marie@test.com', 'MauvaisMotDePasse1!'));
    }

    /** @test */
    public function testLoginSucces(): void
    {
        \Core\Session::start();

        $mockRepo = $this->createMock(\Repository\UserRepository::class);
        $mockRepo->method('findByEmail')->willReturn($this->makeUser());

        $authService = $this->makeAuthService($mockRepo);
        $user        = $authService->login('marie@test.com', 'Test12345!');

        $this->assertNotNull($user);
        $this->assertSame('marie@test.com', $user->getEmail());
        $this->assertSame(1, \Core\Session::getUserId());
        $this->assertSame('utilisateur', \Core\Session::getUserRole());
        $this->assertTrue(\Core\Session::isLoggedIn());
    }

    /** @test */
    public function testLoginAdministrateurSucces(): void
    {
        \Core\Session::start();

        $mockRepo = $this->createMock(\Repository\UserRepository::class);
        $mockRepo->method('findByEmail')->willReturn($this->makeUser(role: 'administrateur'));

        $authService = $this->makeAuthService($mockRepo);
        $user        = $authService->login('marie@test.com', 'Test12345!');

        $this->assertNotNull($user);
        $this->assertTrue(\Core\Session::isAdmin());
    }

    /** @test */
    public function testLoginBloqueApresTropDeTentatives(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Trop de tentatives');

        $mockRepo = $this->createMock(\Repository\UserRepository::class);
        $mockRepo->method('findByEmail')->willReturn($this->makeUser());

        // 5 tentatives récentes déjà enregistrées => verrouillage
        $authService = $this->makeAuthService($mockRepo, recentAttempts: 5);

        $authService->login('marie@test.com', 'Test12345!');
    }
}
