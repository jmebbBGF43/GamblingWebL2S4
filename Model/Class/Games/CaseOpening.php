<?php

namespace Model\Entity\Games;

use Model\Entity\Game;

/**
 * Classe CaseOpening
 * 
 * Représente la logique métier du jeu d'ouverture de caisses (Lootboxes).
 */
class CaseOpening extends Game
{
    /**
     * @var string L'identifiant de la caisse sélectionnée par le joueur.
     */
    private string $selectedCaseId = '';

    /**
     * @var string La rareté de l'objet ou de la récompense remportée.
     */
    private string $wonRarity = '';

    /**
     * @var float Le prix de la caisse actuellement en cours d'ouverture.
     */
    private float $currentCasePrice = 0.0;

    /**
     * Exécute l'ouverture d'une caisse.
     * 
     * @param float $betAmount Le montant disponible ou misé par l'utilisateur (doit couvrir le prix de la caisse).
     * @param string $choice L'identifiant de la caisse choisie.
     * @return float Le gain remporté (prix de la caisse * multiplicateur de la récompense).
     * @throws \Exception Si le jeu est désactivé, la caisse introuvable, ou les crédits insuffisants.
     */
    public function run(float $betAmount, string $choice = ''): float
    {
        if (!$this->isPlayable()) {
            throw new \Exception("Le jeu {$this->name} est désactivé.");
        }
        $this->selectedCaseId = $choice;
        $allCases = $this->config['cases'] ?? [];
        $targetCase = null;
        foreach ($allCases as $case) {
            if ($case['id'] === $choice) {
                $targetCase = $case;
                break;
            }
        }
        if (!$targetCase) {
            throw new \Exception("La caisse sélectionnée est introuvable.");
        }
        $this->currentCasePrice = (float)$targetCase['price'];
        if ($betAmount < $this->currentCasePrice) {
            throw new \Exception("Crédits insuffisants pour ouvrir cette caisse.");
        }
        $roll = mt_rand(1, 10000) / 100;
        $currentWeight = 0;
        $items = $targetCase['items'];
        foreach ($items as $rarity => $data) {
            $currentWeight += $data['prob'];
            if ($roll <= $currentWeight) {
                $this->wonRarity = $rarity;
                return $this->currentCasePrice * $data['mult'];
            }
        }
        return 0.0;
    }

    /**
     * Récupère la rareté de l'objet gagné lors du dernier tirage.
     * 
     * @return string
     */
    public function getWonRarity(): string
    {
        return $this->wonRarity;
    }

    /**
     * Récupère l'identifiant de la dernière caisse sélectionnée.
     * 
     * @return string
     */
    public function getSelectedCaseId(): string
    {
        return $this->selectedCaseId;
    }
}