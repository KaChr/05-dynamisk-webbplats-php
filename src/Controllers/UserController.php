<?php

namespace Blog\Controllers;

use Blog\Exceptions\NotFoundException;
use Blog\Models\UserModel;
use Exceptions;

class UserController extends AbstractController
{
    public function login() 
    {
        if (!$this->request->isPost()) {
            return $this->redirect('/');
        }

        $params = $this->request->getParams();

        if (! $params->has('email')) {
            return $this->redirect('/');
        }

        $userModel = new UserModel();

        $userFound = $userModel->getByEmail($params->get('email'))[0];

        if (! empty($userFound)) {
            $cookieUser = [
                'fullname' => $userFound->getFullName(),
                'email' => $userFound->getEmail(),
                'user_id' => $userFound->getId()
            ];

            setcookie(
                "User", 
                json_encode($cookieUser), 
                time()+3600
            );  /* expire in 1 hour */
            
            return $this->redirect('/dashboard');
        }
    }

//     public function getAll(): string
//     {
//         $userModel = new UserModel();

//         $users = $userModel->getAll();

//         $properties = [
//             'users' => $users
//         ];

//         return $this->render('//glöm inte', $properties);
//     }
}