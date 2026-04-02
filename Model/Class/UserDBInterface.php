<?php

namespace Model\Entity;

use Model\Entity\User;

interface UserDBInterface {

    public function insertUser(User $user): void;

    public function updateUser($id, $username, $credits, $role, $is_banned, $can_play, $can_transact): void;

    public function verifyUser($user): bool;

    public function deleteUser($id): void;

    public function getUserById($id);

    public function getAllUsers(): array;
}