<?php

namespace Blog\Controllers;

use Blog\Exceptions\NotFoundException;
use Blog\Models\UserModel;

class UserController extends AbstractController
{
    public function login()
    {
       
        if (!$this->request->isPost()) {
            return $this->render('views/login.php', []);
        }

        $params = $this->request->getParams();  
        // var_dump($params); //här
        // die();
        
        if (!$params->has('email')) {
            $params = ['errorMessage' => 'No info provided.'];
            return $this->render('views/login.php', $params);
        }
        
        $email = $params->getString('email');
        $userModel = new UserModel();
        
        try {
            $user = $userModel->getByEmail($email);
        } catch (NotFoundException $e) {
             $this->log->warn('User email not found: ' . $email);
            $params = ['errorMessage' => 'Email not found.'];
            return $this->render('views/login.php', $params);
         }
        
        setcookie('user', $user->getId());
        
        $newUser = new PostController($this->request);
        $this->redirect('/posts');
         return $newUser->getAll();
     } 
}