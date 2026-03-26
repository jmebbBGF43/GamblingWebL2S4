<?php

namespace Model\Entity;
class User {
    private int $id;
    private string $username;
    private string $password;
    private float $credits;
    private string $role;
    private bool $is_banned;
    private bool $can_play;
    private bool $can_transact;
    private string $created_at;

    public function __construct($username, $passwordHash, $credits = 0, $role = 'user') {
        $this->username = $username;
        $this->password = $passwordHash;
        $this->credits = $credits;
        $this->role = $role;
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

    public function subCredits(float $number) {
        if ($this->credits >= $number) {
            $this->credits -= $number;
        }
    }

    public function verifyPassword(string $passwordClair): bool
    {
        return password_verify($passwordClair, $this->password);
    }
}