<?php

namespace Model\Entity;

use Model\Entity\User;

/**
 * Interface UserDBInterface
 * 
 * Contrat définissant les méthodes obligatoires pour la persistance des utilisateurs en base de données.
 */
interface UserDBInterface {

    /**
     * Insère un nouvel utilisateur dans la base de données.
     * 
     * @param User $user L'entité utilisateur à insérer.
     * @return void
     */
    public function insertUser(User $user): void;

    /**
     * Met à jour les informations globales d'un utilisateur.
     * 
     * @param int $id L'identifiant de l'utilisateur.
     * @param string $username Le nom d'utilisateur.
     * @param float $credits Les crédits actuels.
     * @param string $role Le rôle (ex: admin, user).
     * @param bool $is_banned Statut de bannissement.
     * @param bool $can_play Droit de jouer.
     * @param bool $can_transact Droit d'effectuer des transactions.
     * @return void
     */
    public function updateUser($id, $username, $credits, $role, $is_banned, $can_play, $can_transact): void;

    /**
     * Vérifie les identifiants de connexion d'un utilisateur.
     * 
     * @param User $user L'utilisateur contenant les informations de connexion à vérifier.
     * @return bool True si les identifiants sont valides, False sinon.
     */
    public function verifyUser($user): bool;

    /**
     * Supprime un utilisateur de la base de données via son identifiant.
     * 
     * @param int $id L'identifiant de l'utilisateur.
     * @return void
     */
    public function deleteUser($id): void;

    /**
     * Récupère un utilisateur spécifiquement par son identifiant.
     * 
     * @param int $id L'identifiant de l'utilisateur.
     * @return mixed Les données de l'utilisateur sous forme de tableau, ou false.
     */
    public function getUserById($id);

    /**
     * Récupère la liste intégrale de tous les utilisateurs enregistrés.
     * 
     * @return array Liste des utilisateurs.
     */
    public function getAllUsers(): array;
}