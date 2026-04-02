<form method="POST" action="admin/Controller/Cadminusers.php?action_user=store" class="h-full w-full flex items-center justify-center">
    <div class="flex items-center justify-center flex-col">
        <div class="w-auto flex flex-col gap-6 bg-[#355872] rounded-xl p-8">

            <label class="text-white">Pseudo</label>
            <input type="text" name="create_username" class="w-full p-2 rounded bg-white text-black" required />

            <label class="text-white">Mot de passe</label>
            <input type="text" name="create_password" class="w-full p-2 rounded bg-white text-black" required />

            <label class="text-white">Crédits</label>
            <input type="number" name="create_credits" class="w-full p-2 rounded bg-white text-black" required />

            <label class="text-white">Rôle</label>
            <input type="text" name="create_role" class="w-full p-2 rounded bg-white text-black" required />
        </div>
        <button type="submit" class="w-full btn btn-primary rounded font-bold border-none bg-[#1576e2] text-white py-3 mt-4">
            Ajouter
        </button>
    </div>
</form>