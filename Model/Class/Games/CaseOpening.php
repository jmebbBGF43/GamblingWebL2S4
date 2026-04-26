<?php

namespace Model\Entity\Games;

use Model\Entity\Game;

class CaseOpening extends Game
{
    private string $selectedCaseId = '';
    private string $wonRarity = '';
    private float $currentCasePrice = 0.0;

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
    public function getWonRarity(): string
    {
        return $this->wonRarity;
    }
    public function getSelectedCaseId(): string
    {
        return $this->selectedCaseId;
    }
}