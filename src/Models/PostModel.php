<?php
    namespace Blog\Models;

    use Blog\Models\AbstractModel;

    use PDO;

    class PostModel extends AbstractModel
    {

        const CLASSNAME = '\Blog\Domain\Post';

        public function getAll(): array
        {
            $query = 'SELECT * FROM post';
            $statement = $this->db->prepare($query);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        }

        public function getOne(int $id) {
            $query = 'SELECT * FROM post WHERE post_nr = :post_nr';
            $statement = $this->db->prepare($query);

            $statement->bindValue(':post_nr', $id);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        }
    }
