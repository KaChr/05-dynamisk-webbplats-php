<?php

namespace Blog\Models;

use PDO;
use Blog\Domain\User;
use Blog\Exceptions\NotFoundException;

class UserModel extends AbstractModel
{
    public function findByUserName($username)
    {
        $statement = $this->db->query('SELECT * FROM user WHERE username = :username');
        $statement->bindValue(':username', $username);

        if ($statement->execute()){
            return $statement->fetch(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }
}