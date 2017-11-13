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
    // const CLASSNAME = '\Bookstore\Domain\Customer\CustomerFactory';  // kolla på axels vide om innan han lade till factory
    
    //     public function get(int $customerId): Customer
    //     {
    //         $query = 'SELECT * FROM customers WHERE id = :id';
    //         $sth = $this->db->prepare($query);
    //         $sth->execute(['id' => $customerId]);
    
    //         $row = $sth->fetch();
    //         if (empty($row)) {
    //             throw new NotFoundException();
    //         }
            
    //         return CustomerFactory::factory(
    //             $row['type'],
    //             $row['id'],
    //             $row['firstname'],
    //             $row['surname'],
    //             $row['email']
    //         );
    //     }
    
    //     public function getAll(): array
    //     {
    //         $query = 'SELECT * FROM customers';
    //         $sth = $this->db->prepare($query);
    //         $sth->execute();
    
    //         return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    
    //         if (empty($row)) {
    //             throw new NotFoundException();
    //         }
    
    //         return CustomerFactory::factory(
    //             $row['type'],
    //             $row['id'],
    //             $row['firstname'],
    //             $row['surname'],
    //             $row['email']
    //         );
    //     }
    
    //     public function getByEmail(string $email): Customer
    //     {
    //         $query = 'SELECT * FROM customers WHERE email = :user';
    //         $sth = $this->db->prepare($query);
    //         $sth->execute(['user' => $email]);
    
    //         $row = $sth->fetch();
    
    //         if (empty($row)) {
    //             throw new NotFoundException();
    //         }
    
    //         return CustomerFactory::factory(
    //             $row['type'],
    //             $row['id'],
    //             $row['firstname'],
    //             $row['surname'],
    //             $row['email']
    //         );
    //     }
}