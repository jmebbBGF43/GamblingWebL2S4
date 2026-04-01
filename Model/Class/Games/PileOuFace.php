<?php

namespace Model\Entity\Games;
use Model\Entity\Game;

class PileOuFace extends Game
{
    private float $edge;
    private float $winMultiplier;
    private float $edgeMultiplier;
    private string $outcome = '';

    public function __construct(int $id, string $name, array $config, bool $isActive, string $slug, float $minBet = 1, float $maxBet = 426769736767) {
        parent::__construct($id, $name, $config, $isActive, $slug, $minBet, $maxBet);
        $this->edge = $this->getConfigParam('edge', 0.1);
        $this->winMultiplier = $this->getConfigParam('win_multiplier', 2.0);
        $this->edgeMultiplier = $this->getConfigParam('edge_multiplier', 4.0);
    }
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
    public function getOutcome(): string
    {
        return $this->outcome;
    }
    public function getEdge(): float { return $this->edge; }
    public function getWinMultiplier(): float { return $this->winMultiplier; }
    public function getEdgeMultiplier(): float { return $this->edgeMultiplier; }
}