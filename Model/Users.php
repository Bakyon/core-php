<?php
class Users {
    private $id;
    private $role_id;
    private $name;
    private $email;
    private $password;
    private $birthday;
    private $gender;
    private $avatar;
    private $status;
    private $version;
    private $created_at;
    private $updated_at;
    private $deleted_at;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function getRole_id() {
        return $this->role_id;
    }
    public function setRole_id($role_id) {
        $this->role_id = $role_id;
    }
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function getBirthday() {
        return $this->birthday;
    }
    public function setBirthday($birthday) {
        $this->birthday = $birthday;
    }
    public function getGender() {
        return $this->gender;
    }
    public function setGender($gender) {
        $this->gender = $gender;
    }
    public function getAvatar() {
        return $this->avatar;
    }
    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }
    public function getStatus() {
        return $this->status;
    }
    public function setStatus($status) {
        $this->status = $status;
    }
}