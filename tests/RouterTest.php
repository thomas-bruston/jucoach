<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Core\Router;

/**
 * Tests unitaires — Router::hasSufficientRole()
 * Couvre la hiérarchie des rôles utilisée pour protéger les routes admin.
 */
class RouterTest extends TestCase
{
    /** @test */
    public function testUtilisateurSurRoutePubliqueOuUtilisateur(): void
    {
        $this->assertTrue(Router::hasSufficientRole('utilisateur', 'utilisateur'));
    }

    /** @test */
    public function testAdministrateurSurRouteUtilisateur(): void
    {
        $this->assertTrue(Router::hasSufficientRole('administrateur', 'utilisateur'));
    }

    /** @test */
    public function testAdministrateurSurRouteAdministrateur(): void
    {
        $this->assertTrue(Router::hasSufficientRole('administrateur', 'administrateur'));
    }

    /** @test */
    public function testUtilisateurSurRouteAdministrateurRefuse(): void
    {
        $this->assertFalse(Router::hasSufficientRole('utilisateur', 'administrateur'));
    }

    /** @test */
    public function testVisiteurNonConnecteRefuse(): void
    {
        $this->assertFalse(Router::hasSufficientRole(null, 'utilisateur'));
        $this->assertFalse(Router::hasSufficientRole(null, 'administrateur'));
    }

    /** @test */
    public function testRoleInconnuRefuse(): void
    {
        // Un rôle qui n'existe pas dans la hiérarchie ne doit jamais donner accès
        $this->assertFalse(Router::hasSufficientRole('role_invalide', 'utilisateur'));
    }
}
