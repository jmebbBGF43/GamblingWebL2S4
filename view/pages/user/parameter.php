<div class="max-w-xl mx-auto p-6 bg-[#1a2c38] rounded border border-white/10 shadow-2xl text-[#9d9d9d]">
    <h2 class="text-3xl font-bold text-white mb-8 text-center">Paramètres du compte</h2>

    <?php if (isset($_SESSION['pwd_success'])): ?>
        <div class="bg-green-500/20 border border-green-500 text-green-400 p-4 rounded mb-6 text-center font-bold">
            <?= $_SESSION['pwd_success']; unset($_SESSION['pwd_success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['pwd_error'])): ?>
        <div class="bg-red-500/20 border border-red-500 text-red-400 p-4 rounded mb-6 text-center font-bold">
            <?= $_SESSION['pwd_error']; unset($_SESSION['pwd_error']); ?>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>Controller/controller_update_password.php" method="POST" class="flex flex-col gap-6">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <div>
            <label for="old_password" class="block text-white font-bold mb-2">Ancien mot de passe</label>
            <input type="password" id="old_password" name="old_password" required class="w-full p-3 rounded bg-[#0f212d] text-white border border-white/10 focus:border-blue-500 outline-none">
        </div>

        <div>
            <label for="new_password" class="block text-white font-bold mb-2">Nouveau mot de passe</label>
            <input type="password" id="new_password" name="new_password" required class="w-full p-3 rounded bg-[#0f212d] text-white border border-white/10 focus:border-blue-500 outline-none">
        </div>

        <div>
            <label for="confirm_password" class="block text-white font-bold mb-2">Confirmer le nouveau mot de passe</label>
            <input type="password" id="confirm_password" name="confirm_password" required class="w-full p-3 rounded bg-[#0f212d] text-white border border-white/10 focus:border-blue-500 outline-none">
        </div>

        <button type="submit" class="mt-4 bg-[#1576e2] hover:bg-blue-600 text-white text-lg font-bold border-none rounded py-3 transition-colors">
            Mettre à jour le mot de passe
        </button>
    </form>
</div>