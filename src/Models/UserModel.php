<?php

namespace Blog\Models;

use PDO;
use Blog\Domain\User;
use Blog\Exceptions\NotFoundException;

class UserModel extends AbstractModel
{
    const CLASSNAME = '\Blog\Domain\User';

    public function getByEmail(string $email): array
    {
        $query = 'SELECT * FROM user WHERE email = :email';
        $sth = $this->db->prepare($query);
        $sth->execute(['email' => $email]);

        $result = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);

        return $result;

        if (empty($row)) {
            throw new NotFoundException();
        }
    } 
}