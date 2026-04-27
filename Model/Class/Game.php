<?php

namespace Model\Entity;

/**
 * Classe abstraite Game
 * 
 * Fournit la base et les attributs partagés pour la logique de tous les jeux du site.
 */
abstract class Game implements GameInterface {
    /**
     * @var int L'identifiant du jeu en base de données.
     */
    protected int $id;

    /**
     * @var string Le nom affiché du jeu.
     */
    protected string $name;

    /**
     * @var array Configuration du jeu (contenant par exemple les probabilités décodées).
     */
    protected array $config;

    /**
     * @var bool État d'activation du jeu.
     */
    protected bool $isActive;

    /**
     * @var float La mise minimale autorisée pour jouer.
     */
    protected float $minBet = 1;

    /**
     * @var float La mise maximale autorisée pour jouer.
     */
    protected float $maxBet = 426769736767;

    /**
     * @var string Le slug (identifiant URL) du jeu.
     */
    protected string $slug;

    /**
     * Constructeur pour initialiser les attributs de base d'un jeu.
     * 
     * @param int $id L'identifiant du jeu.
     * @param string $name Le nom du jeu.
     * @param array $config Configuration (probabilités, multiplicateurs, etc.).
     * @param bool $isActive Statut d'activation.
     * @param string $slug Le nom formatté pour l'URL.
     * @param float $minBet La mise minimale par défaut.
     * @param float $maxBet La mise maximale par défaut.
     */
    public function __construct(int $id, string $name, array $config, bool $isActive, string $slug, float $minBet, float $maxBet) {
        $this->id = $id;
        $this->name = $name;
        $this->config = $config;
        $this->isActive = $isActive;
        $this->minBet = $minBet;
        $this->maxBet = $maxBet;
        $this->slug = $slug;
    }

    /**
     * Vérifie si le jeu est actuellement jouable.
     * 
     * @return bool
     */
    public function isPlayable(): bool {
        return $this->isActive;
    }

    /**
     * Récupère un paramètre de configuration spécifique du jeu.
     * 
     * @param string $key La clé du paramètre recherché.
     * @param mixed|null $default Valeur par défaut si la clé n'existe pas.
     * @return mixed
     */
    protected function getConfigParam(string $key, $default = null) {
        return $this->config[$key] ?? $default;
    }

    /**
     * Vérifie que le montant misé est compris entre la limite minimale et maximale.
     * 
     * @param float $amount Le montant de la mise.
     * @return bool
     */
    public function isBetValid(float $amount): bool {
        return ($amount >= $this->minBet && $amount <= $this->maxBet);
    }

    /**
     * Récupère le slug associé au jeu.
     * 
     * @return string
     */
    public function getSlug(): string {
        return $this->slug;
    }

    /**
     * Récupère le montant minimal de mise.
     * 
     * @return float
     */
    public function getMinBet(): float {
        return $this->minBet;
    }

    /**
     * Récupère le montant maximal de mise.
     * 
     * @return float
     */
    public function getMaxBet(): float {
        return $this->maxBet;
    }

    /**
     * Méthode abstraite exécutant le jeu, à implémenter dans les classes filles.
     * 
     * @param float $betAmount Le montant du pari.
     * @param string $choice Le choix du joueur.
     * @return float Les gains générés.
     */
    abstract public function run(float $betAmount, string $choice = ''): float;
}