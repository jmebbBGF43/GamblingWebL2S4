<?php

namespace Model\Entity;
class User {
    public int $id;
    public string $username;
    public string $password;
    public int $credits;
    public string $role;
    public bool $is_banned;
    public bool $can_play;
    public bool $can_transact;
    public string $created_at;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
        $this->credits = 0;
        $this->role='user';
        $this->is_banned = false;
        $this->can_play = true;
        $this->can_transact = true;
        $this->created_at = date("Y-m-d H:i:s");
    }

    function __toString(){
        return "[" . $this->username."|".$this->role."]";
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCredits(): int
    {
        return $this->credits;
    }

    public function addCredits($number){
        $this->credits += $number;
    }

    public function subCredits($number){
        $this->credits -= $number;
    }

    public function getRole(){
        return $this->role;
    }

    public function upgradeAdmin(){
        $this->role = 'admin';
    }

    public function isBanned(){
        return $this->is_banned;
    }

    public function ban(){
        $this->is_banned = true;
    }

    public function canPlay(){
        return $this->can_play;
    }

    public function banPlay(){
        $this->can_play = false;
    }

    public function canTransact(){
        return $this->can_transact;
    }

    public function banTransact(){
        $this->can_transact = false;
    }



}