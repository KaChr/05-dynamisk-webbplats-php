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
            
        $query = 'SELECT * FROM posts LIMIT :page, :length';
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

        // public function addPost($post_nr, $post_title, $post_author, $post_tags, $post_text, $type)
        // {
        //     $query = 'INSERT INTO posts SET '
        // }
    }
