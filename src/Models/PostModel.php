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

    public function getAllWithTags(int $page, int $pageLength) {
        $start = $pageLength * ($page - 1);

        $query = 'SELECT posts.*,
                        GROUP_CONCAT(tags.tag_name ORDER BY tags.tag_name) AS tags
                    FROM posts
                    LEFT JOIN post_tags
                        ON posts.post_nr = post_tags.id_post
                    LEFT JOIN tags
                        ON post_tags.id_tag = tags.tag_id
                    GROUP BY posts.post_nr
                    ORDER BY post_date DESC LIMIT :page, :length';

        $statement = $this->db->prepare($query);
        $statement->bindParam('page', $start, PDO::PARAM_INT);
        $statement->bindParam('length', $pageLength, PDO::PARAM_INT);
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);

        return $results;
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

    public function getByTags(int $tagId)
    {
        $query = 'SELECT p.post_nr, p.post_title, p.post_author, p.post_date, p.post_text, p.type, t.tag_id, t.tag_name
FROM post_tags pt
LEFT JOIN posts p ON pt.id_post = p.post_nr
LEFT JOIN tags t ON pt.id_tag = t.tag_id
WHERE pt.id_tag = :tag_id'; 

        $statement = $this->db->prepare($query);
        $statement->execute(['tag_id' => $tagId]);

        return $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function getByUser(string $author)
    {
        $query = 'SELECT * FROM posts WHERE post_author = :author';
        $statement = $this->db->prepare($query);

        $statement->bindValue(':author', $author);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);   
    }

    public function createPost($post_title, $post_author, $post_text, $type, $tags = []) 
    {
        $query = 'INSERT INTO posts (post_title, post_author, post_text, type) VALUES (:post_title, :post_author, :post_text, :type)';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':post_title', $post_title);
        $statement->bindValue(':post_author', $post_author);
        $statement->bindValue(':post_text', $post_text);
        $statement->bindValue(':type', $type);

        $statement->execute();

        $lastPostId = $this->db->lastInsertId();

        foreach($tags as $tag) {
            $sql = 'INSERT INTO post_tags (id_post, id_tag) VALUES (:id_post, :id_tag)';

            $statement = $this->db->prepare($sql);
            $statement->bindValue(':id_post', $lastPostId);
            $statement->bindValue(':id_tag', $tag);

            $statement->execute();
        }

        return $lastPostId;
    }

    public function editPost($post_nr, $post_title, $post_author, $post_text, $type, $tags = []) 
    {
        $query = 'UPDATE posts SET post_title = :post_title, post_author = :post_author, post_text = :post_text, type = :type)
        WHERE post_nr = :post_nr';
        
        $statement = $this->db->prepare($query);
        $statement->bindValue(':post_title', $post_title);
        $statement->bindValue(':post_author', $post_author);
        $statement->bindValue(':post_text', $post_text);
        $statement->bindValue(':post_nr', $post_nr);
        $statement->bindValue(':type', $type);

        $statement->execute();

        

            // kolla ifall taggen med samma tag_id finns i post_tags if ()
            $query = 'SELECT * FROM post_tags WHERE id_post = :id_post';
            $statement = $this->db->prepare($query);
            $statement->bindValue(':id_post', $post_nr);
            $statement->execute();

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            $i = 0;
        foreach($tags as $tag) {

            if (isset($result[$i]['id_tag']) && $result[$i]['id_tag'] === $tag) {
                continue;
            }

            if (isset($result[$i]['id_tag']) && $result[$i]['id_tag'] !== $tag) {
                $query = 'UPDATE post_tags SET id_tag = :id_tag WHERE id_post = :id_post LIMIT 1';
                $statement = $this->db->prepare($query);
                $statement->bindValue(':id_tag', $tag);
                $statement->bindValue(':id_post', $post_nr);
                $statement->execute();
            } else {
                $query = 'INSERT INTO post_tags (id_post, id_tag) VALUES (:id_post, :id_tag)';
                $statement = $this->db->prepare($query);
                $statement->bindValue(':id_post', $post_nr);
                $statement->bindValue(':id_tag', $tag);
                $statement->execute();
            }

            $i++;
        }

        return $post_nr;
    }

    public function deletePost(int $postId)
    {

        $query = 'DELETE FROM post_tags WHERE id_post = :post_nr';
        
        $statement = $this->db->prepare($query);
        $statement->bindValue(':post_nr', $postId);
        $statement->execute();

        $query = 'DELETE FROM posts WHERE post_nr = :post_nr';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':post_nr', $postId);

        $statement->execute();
    }

    public function getAllTags() {
        $results = $this->db->query('SELECT * FROM tags');

        return $results->fetchAll(PDO::FETCH_ASSOC);
    }
}