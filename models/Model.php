<?php
// models/Model.php — base model
class Model {
    protected $db;
    public function __construct($db) { $this->db = $db; }
}
