<?php

class UsersTest extends TestCase {

	/**
	 * @testdox A User has a name, email address, and username.
	 * @test
	 */
	public function basic() {
		$user = new Ormic\Model\User();
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
	public function name() {
		$user = new Ormic\Model\User();
		$user->username = 'test';
		$user->save();
		$this->assertEquals('test', $user->name);
	}

	/**
	 * @testdox Users can have Roles, which we use to determine what they can do in the application.
	 * @test
	 */
	public function roles() {
		$user = new Ormic\Model\User();
		$user->username = 'User Name';
		$user->save();
		$role = new \Ormic\Model\Role();
		$role->name = 'Role Name';
		$role->save();
		$user->roles()->attach($role->id);
		$this->assertEquals(1, $user->roles()->count());
		$this->assertEquals(1, $role->users()->count());
		$this->assertEquals('Role Name', $user->roles()->first()->name);
		$this->assertEquals('User Name', $role->users()->first()->username);
	}

}
