<?php
namespace Model\Entity;

/**
 * Interface GameInterface
 *
 * Contrat stipulant les méthodes essentielles que tous les jeux de la plateforme doivent implémenter.
 */
interface GameInterface
{
    /**
     * Exécute la logique de jeu.
     *
     * @param float $betAmount Le montant parié par le joueur.
     * @param string $choice Le choix du joueur (optionnel selon le jeu).
     * @return float Le montant des gains (0 si le joueur perd).
     */
    public function run(float $betAmount, string $choice): float;

    /**
     * Indique si le jeu est actuellement jouable (activé sur le site).
     *
     * @return bool True si activé, False sinon.
     */
    public function isPlayable(): bool;

    /**
     * Vérifie si le montant misé est valide par rapport aux limites du jeu (min/max).
     *
     * @param float $amount Le montant de la mise à vérifier.
     * @return bool True si la mise est valide, False sinon.
     */
    public function isBetValid(float $amount): bool;
}