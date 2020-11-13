<?php

class UserService extends Controller
{
    private $__UserModel;

    function __construct()
    {
        return $this->__UserModel = $this->model('UserModel');
    }

    public function getUserByEmail($email)
    {
        $user = $this->__UserModel->getUser($email);
        if (!empty($user)) {
            return fillterdataService::encodeDataArray($user);
        }
    }

    public function addUser($email, $password, $filePath, $username)
    {
        return $this->__UserModel->addUser($email, $password, $filePath, $username);
    }

    public function getUserById($idUser)
    {
        return $this->__UserModel->getuserById($idUser);
    }
}