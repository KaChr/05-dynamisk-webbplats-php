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

        $query = 'SELECT p.*, CONCAT(u.firstname, " ", u.surname) as post_author_fullname FROM
        posts p LEFT JOIN user u ON u.user_id = p.post_author
        ORDER BY post_date DESC LIMIT :page, :length';

        $sth = $this->db->prepare($query);
        $sth->bindParam('page', $start, PDO::PARAM_INT);
        $sth->bindParam('length', $pageLength, PDO::PARAM_INT);
        $sth->execute();

        $row = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);

        if (empty($row)) {
            throw new NotFoundException();
        }

        return $row;
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM posts';
        $sth = $this->db->prepare($query);
        $sth->execute();

        $row = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);

        if (empty($row)) {
            throw new NotFoundException();
        }

        return $row;
    }

    public function getAllWithTags(int $page, int $pageLength)
    {
        $start = $pageLength * ($page - 1);

        $query = 'SELECT posts.*,
                        GROUP_CONCAT(tags.tag_name ORDER BY tags.tag_name) AS tags,
                        CONCAT(user.firstname, " ", user.surname) AS post_author_fullname
                    FROM posts
                    LEFT JOIN post_tags
                        ON posts.post_nr = post_tags.id_post
                    LEFT JOIN tags
                        ON post_tags.id_tag = tags.tag_id
                    LEFT JOIN user
                        ON user.user_id = posts.post_author
                    GROUP BY posts.post_nr
                    ORDER BY post_date DESC LIMIT :page, :length';

        $statement = $this->db->prepare($query);
        $statement->bindParam('page', $start, PDO::PARAM_INT);
        $statement->bindParam('length', $pageLength, PDO::PARAM_INT);
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);

        return $results;
    }

    public function getOne(int $id): array
    {
        $query = 'SELECT posts.*,
                    GROUP_CONCAT(tags.tag_name ORDER BY tags.tag_name) AS tags,
                    CONCAT(user.firstname, " ", user.surname) AS post_author_fullname
                    FROM posts
                    LEFT JOIN post_tags
                        ON posts.post_nr = post_tags.id_post
                    LEFT JOIN tags
                        ON post_tags.id_tag = tags.tag_id
                    LEFT JOIN user
                        ON user.user_id = posts.post_author
                    WHERE post_nr = :post_nr';
        $statement = $this->db->prepare($query);

        $statement->bindValue(':post_nr', $id);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function search(string $searchString): array
    {
        $query = 'SELECT posts.*,
                    GROUP_CONCAT(tags.tag_name ORDER BY tags.tag_name) AS tags,
                    CONCAT(user.firstname, " ", user.surname) AS post_author_fullname
                    FROM posts
                    LEFT JOIN post_tags
                        ON posts.post_nr = post_tags.id_post
                    LEFT JOIN tags
                        ON post_tags.id_tag = tags.tag_id
                    LEFT JOIN user
                        ON user.user_id = posts.post_author
                    WHERE post_title
                        LIKE :searchString
                    OR post_text
                        LIKE :searchString
                    OR post_author
                        LIKE :searchString';

        $sth = $this->db->prepare($query);
        $sth->bindValue('searchString', "%$searchString%");
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function getByType(string $type)
    {
        $sql = 'SELECT posts.*,
                    GROUP_CONCAT(tags.tag_name ORDER BY tags.tag_name) AS tags,
                    CONCAT(user.firstname, " ", user.surname) AS post_author_fullname
                    FROM posts
                    LEFT JOIN post_tags
                        ON posts.post_nr = post_tags.id_post
                    LEFT JOIN tags
                        ON post_tags.id_tag = tags.tag_id
                    LEFT JOIN user
                        ON user.user_id = posts.post_author
                    WHERE type = :type
                    GROUP BY :type';

        $sth = $this->db->prepare($sql);
        $sth->bindValue(':type', $type);
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function getByTags(int $tagId)
    {
        $query = 'SELECT p.*, t.tag_id, t.tag_name,
                    CONCAT(u.firstname, " ", u.surname) as post_author_fullname
                    FROM post_tags pt
                    LEFT JOIN posts p ON pt.id_post = p.post_nr
                    LEFT JOIN tags t ON pt.id_tag = t.tag_id
                    LEFT JOIN user u ON p.post_author = u.user_id
                    WHERE pt.id_tag = :tag_id';

        $statement = $this->db->prepare($query);
        $statement->execute(['tag_id' => $tagId]);

        return $statement->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function getByUser(string $author)
    {
        $query = 'SELECT posts.*,
                    GROUP_CONCAT(tags.tag_name ORDER BY tags.tag_name) AS tags,
                    CONCAT(user.firstname, " ", user.surname) AS post_author_fullname
                    FROM posts
                    LEFT JOIN post_tags
                        ON posts.post_nr = post_tags.id_post
                    LEFT JOIN tags
                        ON post_tags.id_tag = tags.tag_id
                    LEFT JOIN user
                        ON user.user_id = posts.post_author
                    WHERE post_author = :author';

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

        foreach ($tags as $tag) {
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
        $query = 'UPDATE posts
                    SET post_title = :post_title, post_author = :post_author, post_text = :post_text, type = :type WHERE post_nr = :post_nr';

        $statement = $this->db->prepare($query);

        $statement->bindValue(':post_nr', $post_nr);
        $statement->bindValue(':post_title', $post_title);
        $statement->bindValue(':post_author', $post_author);
        $statement->bindValue(':post_text', $post_text);
        $statement->bindValue(':type', $type);

        if (!$statement->execute()) {
            throw \Exception('AAAAAH');
        }

        // kolla ifall taggen med samma tag_id finns i post_tags if ()
        $query = 'SELECT * FROM post_tags WHERE id_post = :id_post';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':id_post', $post_nr);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $i = 0;

        foreach ($tags as $tag) {
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

    public function getAllTags()
    {
        $results = $this->db->query('SELECT * FROM tags');

        return $results->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTag(int $tagId)
    {
        $query = 'SELECT * FROM tags WHERE tag_id = :tag_id';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':tag_id', $tagId);
        $statement->execute();

        $tag = $statement->fetch(PDO::FETCH_ASSOC);
        return $tag;
    }

    public function createTag(string $tagName)
    {
        $query = 'INSERT INTO tags (tag_name) VALUES (:tag_name)';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':tag_name', $tagName);
        $statement->execute();
    }

    public function updateTag(int $tagId, string $tagName)
    {
        $query = 'UPDATE tags SET tag_name = :tag_name WHERE tag_id = :tag_id';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':tag_name', $tagName);
        $statement->bindValue(':tag_id', $tagId);
        $statement->execute();

        $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteTag(int $tagId)
    {
        $query = 'DELETE FROM post_tags WHERE id_tag = :tag_id';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':id_tag', $tagId);
        $statement->execute();

        $query = 'DELETE FROM tags WHERE tag_id = :tag_id';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':tag_id', $tagId);

        $statement->execute();
    }
}
