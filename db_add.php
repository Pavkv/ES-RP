<?php
class Post_add {
    private $pdo;
    private $stmt;
    public $error;
    function __construct() {
        try {
            $this->pdo = new PDO(
                "pgsql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }

    function __destruct() {
        $this->pdo = null;
        $this->stmt = null;
    }

    function get ($pid) {
        $this->stmt = $this->pdo->prepare(
            "SELECT * FROM ext_camp_entrance WHERE post_id=?"
        );
        $this->stmt->execute([$pid]);
        return $this->stmt->fetchall(PDO::FETCH_NAMED);
    }

    function save($pid, $username, $post, $post_date=null) {
        if ($post_date==null) { $post_date = date("Y-m-d H:i:s"); }
        try {
            $this->stmt = $this->pdo->prepare(
                "INSERT INTO ext_camp_entrance (post_id, username, post, post_date) VALUES (?,?,?,?)"
            );
            $this->stmt->execute([$pid, $username, $post, $post_date]);
        } catch (Exception $ex) {
            $this->error = $ex->getMessage();
            return false;
        }
        return true;
    }

}

define('DB_HOST', 'localhost');
define('DB_NAME', 'ES:RP_database');
define('DB_USER', 'pavkv');
define('DB_PASSWORD', '8421537690');
$_GB = new Post_add();
