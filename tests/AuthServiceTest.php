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
    $this->authService = new AuthService($mockRepo);
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
        ]);
    }
}
