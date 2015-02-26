<?php namespace Ormic\Tests;

use Ormic\Model\User;

/**
 * @group ormic
 */
class UsersTest extends TestCase
{

    /**
     * @testdox A User has a name, email address, and username.
     * @test
     */
    public function basic()
    {
        $user = new User();
        $user->name = 'Test User';
        $user->email = 'test@example.com';
        $user->username = 'test';
        $user->save();
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertEquals('test', $user->username);
    }

    /**
     * @testdox If no name is present, the username is substituted.
     * @test
     */
    public function name()
    {
        $user = new User();
        $user->username = 'test';
        $user->save();
        $this->assertEquals('test', $user->name);
    }

    /**
     * @testdox Users can have Roles, which we use to determine what they can do in the application.
     * @test
     */
    public function roles()
    {
        $user = new User();
        $user->username = 'User Name';
        $user->save();
        $role = new \Ormic\Model\Role();
        $role->name = 'Role Name';
        $role->save();
        $user->roles()->attach($role->id);
        $this->assertEquals(2, $user->roles()->count()); // 2, because of the admin role.
        $this->assertEquals(1, $role->users()->count());
        $this->assertContains('Role Name', $user->roles()->lists('name'));
        $this->assertEquals('User Name', $role->users()->first()->username);
    }

    /**
     * @testdox The first user to log in is made an Administrator, and can edit users' roles.
     */
    public function firstUser()
    {
        $user1 = new User();
        $user1->username = 'User One';
        $user1->save();
        $this->assertTrue($user1->hasRole('Administrator'));
        $this->assertTrue($user1->isAdmin());
        $user2 = new User();
        $user2->username = 'User Two';
        $user2->save();
        $this->assertFalse($user2->hasRole('Administrator'));
        $this->assertFalse($user2->isAdmin());
    }
}
