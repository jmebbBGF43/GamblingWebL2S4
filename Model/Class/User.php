<?php

namespace Model\Entity;

/**
 * Classe User
 * 
 * Représente l'entité d'un utilisateur (joueur ou administrateur) sur la plateforme.
 */
class User {
    /**
     * @var int L'identifiant unique de l'utilisateur.
     */
    private int $id;

    /**
     * @var string Le nom d'utilisateur (pseudo).
     */
    private string $username;

    /**
     * @var string Le mot de passe (généralement stocké sous forme de hash).
     */
    private string $password;

    /**
     * @var float Le solde actuel de crédits du joueur.
     */
    private float $credits;

    /**
     * @var string Le rôle de l'utilisateur (ex: 'user', 'admin').
     */
    private string $role;

    /**
     * @var bool Indique si l'utilisateur est banni de la plateforme.
     */
    private bool $is_banned;

    /**
     * @var bool Indique si l'utilisateur est autorisé à jouer aux jeux.
     */
    private bool $can_play;

    /**
     * @var bool Indique si l'utilisateur a le droit d'effectuer des transactions.
     */
    private bool $can_transact;

    /**
     * @var string La date et l'heure de création du compte au format 'Y-m-d H:i:s'.
     */
    private string $created_at;

    /**
     * Constructeur de la classe User.
     * 
     * @param string $username Le nom d'utilisateur.
     * @param string $password Le mot de passe de l'utilisateur.
     * @param float $credits Le montant initial des crédits (défaut à 0).
     * @param string $role Le rôle assigné (défaut à 'user').
     */
    public function __construct($username, $password, $credits = 0, $role = 'user') {
        $this->username = $username;
        $this->password = $password;
        $this->credits = $credits;
        $this->role = $role;
        $this->is_banned = false;
        $this->can_play = true;
        $this->can_transact = true;
        $this->created_at = date("Y-m-d H:i:s");
    }

    /**
     * Représentation sous forme de chaîne de caractères de l'utilisateur.
     * 
     * @return string Chaîne formatée [username|role].
     */
    function __toString(){
        return "[" . $this->username."|".$this->role."]";
    }

    /**
     * Récupère l'identifiant de l'utilisateur.
     * 
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Récupère le solde de crédits de l'utilisateur.
     * 
     * @return int
     */
    public function getCredits(): int
    {
        return $this->credits;
    }

    /**
     * Ajoute des crédits au solde de l'utilisateur.
     * 
     * @param float $number Le montant à ajouter.
     * @return void
     */
    public function addCredits($number){
        $this->credits += $number;
    }

    /**
     * Soustrait des crédits du solde de l'utilisateur, s'il a suffisamment de fonds.
     * 
     * @param float $number Le montant à déduire.
     * @return void
     */
    public function subCredits(float $number) {
        if ($this->credits >= $number) {
            $this->credits -= $number;
        }
    }

    /**
     * Récupère le rôle de l'utilisateur.
     * 
     * @return string
     */
    public function getRole(){
        return $this->role;
    }

    /**
     * Promeut l'utilisateur au rang d'administrateur.
     * 
     * @return void
     */
    public function upgradeAdmin(){
        $this->role = 'admin';
    }

    /**
     * Vérifie si l'utilisateur est banni.
     * 
     * @return bool
     */
    public function isBanned(){
        return $this->is_banned;
    }

    /**
     * Bannit l'utilisateur (passe le statut de bannissement à true).
     * 
     * @return void
     */
    public function ban(){
        $this->is_banned = true;
    }

    /**
     * Vérifie si l'utilisateur est autorisé à jouer.
     * 
     * @return bool
     */
    public function canPlay(){
        return $this->can_play;
    }

    /**
     * Révoque l'autorisation de jouer de l'utilisateur.
     * 
     * @return void
     */
    public function banPlay(){
        $this->can_play = false;
    }

    /**
     * Vérifie si l'utilisateur a le droit de faire des transactions.
     * 
     * @return bool
     */
    public function canTransact(){
        return $this->can_transact;
    }

    /**
     * Définit si l'utilisateur a le droit d'effectuer des transactions.
     * 
     * @param bool $bool True pour autoriser, False pour interdire.
     * @return void
     */
    public function setTransact(bool $bool){
        $this->can_transact = $bool;
    }

    /**
     * Récupère le nom d'utilisateur.
     * 
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Récupère le mot de passe (hash) de l'utilisateur.
     * 
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Récupère la date de création de l'utilisateur.
     * 
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
}
