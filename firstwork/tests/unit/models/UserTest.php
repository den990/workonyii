<?php

namespace tests\unit\models;

use app\models\BaseUser;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        verify($user = BaseUser::findIdentity(100))->notEmpty();
        verify($user->username)->equals('admin');

        verify(BaseUser::findIdentity(999))->empty();
    }

    public function testFindUserByAccessToken()
    {
        verify($user = BaseUser::findIdentityByAccessToken('100-token'))->notEmpty();
        verify($user->username)->equals('admin');

        verify(BaseUser::findIdentityByAccessToken('non-existing'))->empty();
    }

    public function testFindUserByUsername()
    {
        verify($user = BaseUser::findByUsername('admin'))->notEmpty();
        verify(BaseUser::findByUsername('not-admin'))->empty();
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        $user = BaseUser::findByUsername('admin');
        verify($user->validateAuthKey('test100key'))->notEmpty();
        verify($user->validateAuthKey('test102key'))->empty();

        verify($user->validatePassword('admin'))->notEmpty();
        verify($user->validatePassword('123456'))->empty();        
    }

}
