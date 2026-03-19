<?php

namespace Model\Entity\user;
class User {
    private $id;
    private $username;
    private $password;
    private $credits;
    private $role;
    private $is_banned;
    private $can_play;
    private $can_transact;
    private $created_at;

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

    public function getId(){
        return $this->id;
    }

    public function getCredits(){
        return $this->credits;
    }

    public function addCredits($number){
        $this->credits += $number;
    }

    public function subCredits($number){
        if ($this->credits - $number < 0)
        {
            return;
        }
        $this->credits += $number;
    }
}