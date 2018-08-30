<?php
/**
 * User: erick.antunes
 * Date: 29/08/2018
 * Time: 16:52
 */

namespace Paggcerto\Tests;


use Paggcerto\Auth\Auth;
use Paggcerto\Paggcerto;

class RoleTest extends TestCase
{

    public function testShouldCreateRole()
    {
        $paggcerto = new Paggcerto(new Auth("erick.antunes@paggcerto.com.br", "95625845"));
        $paggcerto->createNewSession();

        $createdRole = $paggcerto->role()
            ->setName("Administrador")
            ->createRole();

        $this->assertNotEmpty($createdRole->id);
        $this->assertEquals("Administrador", $createdRole->name);
        $this->assertEquals(true, $createdRole->active);
        $this->assertGreaterThanOrEqual(0, $createdRole->totalUsers);
        $this->assertEquals(0, count($createdRole->scopes));

        return $createdRole->id;
    }

    /**
     * @depends testShouldCreateRole
     */
    public function testShouldUpdateRole($roleId)
    {

        $paggcerto = new Paggcerto(new Auth("erick.antunes@paggcerto.com.br", "95625845"));
        $paggcerto->createNewSession();

        $updatedRole = $paggcerto->role()
            ->setName("Admin Update Test")
            ->setActive(true)
            ->setRoleId($roleId)
            ->updateRole();

        $this->assertEquals(true, $updatedRole->active);
        $this->assertEquals("Admin Update Test", $updatedRole->name);
    }

    public function testShouldRoles()
    {
        $paggcerto = new Paggcerto(new Auth("erick.antunes@paggcerto.com.br", "95625845"));
        $paggcerto->createNewSession();

        $return = $paggcerto->role()
            ->rolesList();

        $returnWithFilters = $paggcerto->role()
            ->setLength(2)
            ->setIndex(2)
            ->rolesList();

        $this->assertGreaterThanOrEqual(0, count($return->roles));
        $this->assertEquals(2, count($returnWithFilters->roles));
    }

    /**
     * @depends testShouldCreateRole
     */
    public function testShouldSearchRole($roleId)
    {
        $paggcerto = new Paggcerto(new Auth("erick.antunes@paggcerto.com.br", "95625845"));
        $paggcerto->createNewSession();

        $return = $paggcerto->role()
            ->setRoleId($roleId)
            ->searchRole();

        $this->assertEquals(true, $return->active);
        $this->assertEquals("Admin Update Test", $return->name);
    }

    /**
     * @depends testShouldCreateRole
     */
    public function testShouldDeactivateRole($roleId)
    {
        $paggcerto = new Paggcerto(new Auth("erick.antunes@paggcerto.com.br", "95625845"));
        $paggcerto->createNewSession();

        $return = $paggcerto->role()
            ->setRoleId($roleId)
            ->deactivateRole();

        $this->assertEquals(false, $return->active);
    }

    /**
     * @depends testShouldCreateRole
     */
    public function testShouldActivateRole($roleId)
    {
        $paggcerto = new Paggcerto(new Auth("erick.antunes@paggcerto.com.br", "95625845"));
        $paggcerto->createNewSession();

        $roleReturn = $paggcerto->role()
            ->setRoleId($roleId)
            ->activateRole();

        $this->assertEquals(true, $roleReturn->active);
    }

    /**
     * @depends testShouldCreateRole
     */
    public function testShouldDeleteRole($roleId)
    {
        $paggcerto = new Paggcerto(new Auth("erick.antunes@paggcerto.com.br", "95625845"));
        $paggcerto->createNewSession();

        $roleReturn = $paggcerto->role()
            ->setRoleId($roleId)
            ->deleteRole();

        $this->assertEquals($roleId, $roleReturn->id);
    }

    public function testShouldRoleGrantPerm()
    {
        $paggcerto = new Paggcerto(new Auth("erick.antunes@paggcerto.com.br", "95625845"));
        $paggcerto->createNewSession();

        $paggcerto->roleConcept()
            ->setRoleId("pL")
            ->setScopes(["account.users.edit", "account.users.readonly"])
            ->roleGrantPermission();

        $this->assertTrue(true);
    }

    public function testShouldRoleRevokePerm()
    {
        $paggcerto = new Paggcerto(new Auth("erick.antunes@paggcerto.com.br", "95625845"));
        $paggcerto->createNewSession();

        $paggcerto->roleConcept()
            ->setRoleId("pL")
            ->setScopes(["account.users.edit", "account.users.readonly"])
            ->roleRevokePermission();

        $this->assertTrue(true);
    }
}