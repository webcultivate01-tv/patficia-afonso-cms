<?php
require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

class Database {
    private static $instance = null;
    private $db;

    private function __construct() {
        $client = new Client("mongodb+srv://webcultivate01_db_user:fxYDP2MtRlwDVn0T@patricia-afonso-sms.vdl68mq.mongodb.net/?appName=Patricia-afonso-sms");
        $this->db = $client->selectDatabase('patricia_sms');
    }

    public static function getInstance(): self {
        if (!self::$instance) self::$instance = new self();
        return self::$instance;
    }

    public function getCollection(string $name) {
        return $this->db->selectCollection($name);
    }
}

