<?php

namespace Model\Entity\user;
class User {
    private int $id;
    private string $username;
    private string $password;
    private int $credits;
    private string $role;
    private bool $is_banned;
    private bool $can_play;
    private bool $can_transact;
    private string $created_at;

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
}