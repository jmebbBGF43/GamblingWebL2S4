<form method="POST" action="<?= BASE_URL ?>admin/utilisateurs/create" class="h-full w-full flex items-center justify-center">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <div class="flex items-center justify-center flex-col">
        <div class="w-auto flex flex-col gap-6 bg-[#355872] rounded-xl p-8">
            <p class="text-white text-3xl mb-4 text-center">Créer un utilisateur</p>

            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

            <label class="text-white font-bold">Pseudo</label>
            <input type="text" name="create_username" class="w-full p-3 rounded bg-white text-black" placeholder="Ex: JeanDupont" required />

            <label class="text-white font-bold">Mot de passe</label>
            <input type="password" name="create_password" class="w-full p-3 rounded bg-white text-black" placeholder="••••••••" required />

            <label class="text-white font-bold">Crédits de départ (€)</label>
            <input type="number" name="create_credits" step="0.01" value="0.00" class="w-full p-3 rounded bg-white text-black" required />

            <label class="text-white font-bold">Rôle</label>
            <select name="create_role" class="w-full p-3 rounded bg-white text-black font-bold">
                <option value="user" selected>Utilisateur (Par défaut)</option>
                <option value="admin">Administrateur</option>
            </select>
        </div>

        <button type="submit" class="w-full btn btn-primary rounded font-bold border-none bg-[#1576e2] text-white py-3 mt-4 hover:bg-blue-600 transition-colors">
            ✨ CRÉER LE COMPTE
        </button>
        <a href="admin/utilisateurs/" class="mt-4 text-white/50 hover:text-white text-sm transition-colors">Annuler et revenir</a>
    </div>
</form>