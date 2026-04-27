<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Secrète - Gambling Admin</title>
    <base href="<?= BASE_URL ?>">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0f212e] min-h-screen flex items-center justify-center text-white">

<div class="max-w-md w-full bg-[#1a2c38] rounded-xl border border-white/10 shadow-2xl p-8 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-[#1576e2]"></div>

    <div class="text-center mb-8 mt-4">
        <h1 class="text-3xl font-black tracking-tighter text-white">GAMBLING<span class="text-[#1576e2]">.ADMIN</span></h1>
        <p class="text-gray-400 mt-2 text-sm uppercase tracking-widest">Accès Restreint</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="bg-red-500/20 border border-red-500 text-red-400 p-4 rounded mb-6 text-center font-bold text-sm">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>admin/connexion" class="flex flex-col gap-5">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <div>
            <label class="block text-sm font-bold mb-2 text-gray-300">Nom d'utilisateur</label>
            <input type="text" name="username" required class="w-full p-3 rounded bg-[#0f212d] border border-white/10 focus:border-blue-500 outline-none text-white transition-colors">
        </div>

        <div>
            <label class="block text-sm font-bold mb-2 text-gray-300">Mot de passe</label>
            <input type="password" name="password" required class="w-full p-3 rounded bg-[#0f212d] border border-white/10 focus:border-blue-500 outline-none text-white transition-colors">
        </div>

        <button type="submit" class="mt-4 bg-[#1576e2] hover:bg-blue-600 text-white font-bold py-3 px-4 rounded transition-colors w-full shadow-lg shadow-blue-500/20">
            VERROUILLAGE SÉCURISÉ
        </button>

        <div class="text-center mt-6">
            <a href="<?= BASE_URL ?>home" class="text-sm text-gray-500 hover:text-white transition-colors flex items-center justify-center gap-2">
                <span>←</span> Retour au site public
            </a>
        </div>
    </form>
</div>

</body>
</html>