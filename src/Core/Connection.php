<?php

    namespace Blog\Core;

    use \PDO;
    use Blog\Core\Config;
    use Blog\Utils\Singleton;
    
    class Connection extends Singleton
    {
        public $handler;
        protected function __construct()
        {
            try {
                $config = Config::getInstance()->get('db');
                $this->handler = new PDO(
                    $config['dsn'],
                    $config['user'],
                    $config['password']
                );
                $this->handler->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }