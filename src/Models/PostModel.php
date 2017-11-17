<?php
namespace Blog\Models;

    
use Blog\Domain\Entry;
use Blog\Exceptions\NotFoundException;
use PDO;

class PostModel extends AbstractModel
{

    const CLASSNAME = '\Blog\Domain\Entry';

    public function getAllWithPage(int $page, int $pageLength): array
    {
        $start = $pageLength * ($page - 1);
            
        $query = 'SELECT * FROM posts ORDER BY post_date DESC LIMIT :page, :length';
        $sth = $this->db->prepare($query);
        $sth->bindParam('page', $start, PDO::PARAM_INT);
        $sth->bindParam('length', $pageLength, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);

        if (empty($row)) {
            throw new NotFoundException();
        }
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM posts';
        $sth = $this->db->prepare($query);
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);

        if (empty($row)) {
            throw new NotFoundException();
        }
    }

    public function getOne(int $id): Array
    {
        $query = 'SELECT * FROM posts WHERE post_nr = :post_nr';
        $statement = $this->db->prepare($query);

        $statement->bindValue(':post_nr', $id);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function search(string $searchString): array
    {
        $query = <<<SQL
SELECT * FROM posts
WHERE post_title LIKE :searchString OR post_author LIKE :searchString
SQL;
        $sth = $this->db->prepare($query);
        $sth->bindValue('searchString', "%$searchString%");
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function getByType(string $type)
    {
        $sql = 'SELECT * FROM posts WHERE type = :type';

        $sth = $this->db->prepare($sql);
        $sth->bindValue(':type', $type);
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function getByUser(string $author)
    {
        $query = 'SELECT * FROM posts WHERE post_author = :author';
        $statement = $this->db->prepare($query);

        $statement->bindValue(':author', $author);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);   
    }

    public function createPost($post_title, $post_author, $post_text, $type) {
    
        $query = 'INSERT INTO posts (post_title, post_author, post_text, type) VALUES (:post_title, :post_author, :post_text, :type)';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':post_title', $post_title);
        $statement->bindValue(':post_author', $post_author);
        $statement->bindValue(':post_text', $post_text);
        $statement->bindValue(':type', $type);

        $statement->execute();

        return $this->db->lastInsertId();
    }

    }
