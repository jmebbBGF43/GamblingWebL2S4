<?php

namespace Model\Entity\Games;
use Model\Entity\Game;

/**
 * Classe PileOuFace
 * 
 * Logique métier du jeu de pari "Pile ou Face".
 */
class PileOuFace extends Game
{
    /**
     * @var float L'avantage du casino (probabilité de tomber sur la tranche).
     */
    private float $edge;

    /**
     * @var float Le multiplicateur de gain classique (généralement x2).
     */
    private float $winMultiplier;

    /**
     * @var float Le multiplicateur en cas de victoire sur un cas exceptionnel (tranche).
     */
    private float $edgeMultiplier;

    /**
     * @var string Le résultat final du tirage ('pile', 'face', ou 'tranche').
     */
    private string $outcome = '';

    /**
     * Constructeur surchargeant la récupération des paramètres spécifiques au Pile ou Face.
     * 
     * @param int $id Identifiant du jeu.
     * @param string $name Nom du jeu.
     * @param array $config Configuration (edge, win_multiplier, edge_multiplier).
     * @param bool $isActive Statut du jeu.
     * @param string $slug Identifiant URL.
     * @param float $minBet Mise minimale.
     * @param float $maxBet Mise maximale.
     */
    public function __construct(int $id, string $name, array $config, bool $isActive, string $slug, float $minBet = 1, float $maxBet = 426769736767) {
        parent::__construct($id, $name, $config, $isActive, $slug, $minBet, $maxBet);
        $this->edge = $this->getConfigParam('edge', 0.1);
        $this->winMultiplier = $this->getConfigParam('win_multiplier', 2.0);
        $this->edgeMultiplier = $this->getConfigParam('edge_multiplier', 4.0);
    }

    /**
     * Exécute une partie de Pile ou Face.
     * 
     * @param float $betAmount Le montant misé.
     * @param string $choice Le choix du joueur ('pile' ou 'face').
     * @return float Le gain (0 si perdu).
     * @throws \Exception Si le jeu est inactif ou la mise invalide.
     */
    public function run(float $betAmount, string $choice = 'pile'): float
    {
        if (!$this->isPlayable()) {
            throw new \Exception("Le jeu {$this->name} est actuellement désactivé.");
        }
        if (!$this->isBetValid($betAmount)) {
            throw new \Exception("Le montant du pari doit être compris entre {$this->minBet} et {$this->maxBet}.");
        }

        $roll = mt_rand(1, 10000) / 10000;
        $sideProbability = (1.0 - $this->edge) / 2;

        if ($roll <= $this->edge) {
            $this->outcome = 'tranche';
        } elseif ($roll <= $this->edge + $sideProbability) {
            $this->outcome = 'pile';
        } else {
            $this->outcome = 'face';
        }

        if ($choice === $this->outcome) {
            if ($this->outcome === 'tranche') {
                return $betAmount * $this->edgeMultiplier;
            }
            return $betAmount * $this->winMultiplier;
        }
        return 0.0;
    }

    /**
     * Récupère le résultat exact généré lors du dernier lancer.
     * 
     * @return string
     */
    public function getOutcome(): string
    {
        return $this->outcome;
    }

    /**
     * Récupère la marge (avantage) du casino.
     * @return float
     */
    public function getEdge(): float { return $this->edge; }

    /**
     * Récupère le multiplicateur de victoire classique.
     * @return float
     */
    public function getWinMultiplier(): float { return $this->winMultiplier; }

    /**
     * Récupère le multiplicateur d'avantage (si tombé sur la tranche).
     * @return float
     */
    public function getEdgeMultiplier(): float { return $this->edgeMultiplier; }
}