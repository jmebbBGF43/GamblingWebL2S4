<form method="POST" action="<?= BASE_URL ?>admin/utilisateurs/update" class="h-full w-full flex items-center justify-center">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <div class="flex items-center justify-center flex-col">
        <div class="w-auto flex flex-col gap-6 bg-[#355872] rounded-xl p-8">
            <p class="text-white text-3xl">Modifier l'utilisateur</p>

            <input type="hidden" name="update_id" value="<?= htmlspecialchars($u['id'] ?? '') ?>">

            <label class="text-white">Pseudo</label>
            <input type="text" name="update_username" value="<?= htmlspecialchars($u['username'] ?? '') ?>" class="w-full p-2 rounded bg-white text-black" required/>


            <label class="text-white">Crédits</label>
            <input type="number" name="update_credits" value="<?= htmlspecialchars($u['credits'] ?? '') ?>" class="w-full p-2 rounded bg-white text-black" required/>

            <label class="text-white">Rôle</label>
            <input type="text" name="update_role" value="<?= htmlspecialchars($u['role'] ?? '') ?>" class="w-full p-2 rounded bg-white text-black" required/>

            <label class="text-white flex items-center gap-2">
                <input type="checkbox" name="update_is_banned" <?= !empty($u['is_banned']) ? 'checked' : '' ?>> Banni
            </label>

            <label class="text-white flex items-center gap-2">
                <input type="checkbox" name="update_can_play" <?= !empty($u['can_play']) ? 'checked' : '' ?>> Droit de jeux
            </label>

            <label class="text-white flex items-center gap-2">
                <input type="checkbox" name="update_can_transact" <?= !empty($u['can_transact']) ? 'checked' : '' ?>> Droit de transactions
            </label>

            <label class="text-white">Date d'inscription (Lecture seule)</label>
            <input type="text" value="<?= htmlspecialchars($u['created_at'] ?? '') ?>" class="w-full p-2 rounded bg-gray-300 text-gray-600 cursor-not-allowed" disabled/>

            <button type="submit" class="btn btn-primary rounded font-bold border-none bg-[#1576e2] text-white py-3 mt-4">Mettre à jour</button>
        </div>
    </div>
</form>