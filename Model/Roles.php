<?php
class Roles {
    private $id;
    private $name;
    private $version;
    private $created_at;
    private $updated_at;
    private $deleted_at;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function setName($name) {
        $this->name = $name;
    }
}