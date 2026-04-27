<div class="max-w-2xl mx-auto p-8 bg-[#1a2c38] rounded border border-white/10 shadow-2xl">

    <div class="flex items-center gap-6 mb-10 border-b border-white/5 pb-8">
        <div class="w-20 h-20 bg-[#1576e2] rounded-full flex items-center justify-center text-3xl font-bold text-white">
            <?= $firstLetter ?>
        </div>
        <div>
            <h2 class="text-3xl font-bold text-white"><?= htmlspecialchars($userData['username']) ?></h2>
        </div>
    </div>

    <div class="space-y-6">
        <div class="flex justify-between items-center py-3 border-b border-white/5">
            <span class="text-lg font-medium text-[#9d9d9d]">Crédits disponibles :</span>
            <span class="text-2xl font-bold text-green-500"><?= $userData['credits'] ?> €</span>
        </div>

        <div class="flex justify-between items-center py-3 border-b border-white/5">
            <span class="text-lg font-medium text-[#9d9d9d]">Gains/Pertes totaux :</span>
            <span class="text-2xl font-bold <?= $profitColor ?>">
                <?= $profitFormate ?> €
            </span>
        </div>

        <div class="flex justify-between items-center py-3 border-b border-white/5">
            <span class="text-lg font-medium text-[#9d9d9d]">Statut du compte :</span>
            <span class="px-3 py-1 bg-blue-500/20 text-blue-400 font-bold rounded-full border border-blue-500/30">
                <?= strtoupper(htmlspecialchars($userData['role'])) ?>
            </span>
        </div>

        <div class="flex justify-between items-center py-3 border-b border-white/5">
            <span class="text-lg font-medium text-[#9d9d9d]">Inscrit le :</span>
            <span class="text-white"><?= $dateInscription ?></span>
        </div>

        <div class="flex justify-between items-center py-3 border-b border-white/5">
            <span class="text-lg font-medium text-[#9d9d9d]">Restrictions :</span>
            <span class="<?= $restrictionColor ?> font-bold"><?= $restrictionText ?></span>
        </div>
    </div>

    <div class="mt-10 flex flex-col gap-3">
        <a href="<?= BASE_URL ?>parametres" class="block w-full py-3 text-center bg-[#1576e2] hover:bg-blue-600 text-white font-bold rounded">
            MODIFIER LE MOT DE PASSE
        </a>
        <a href="<?= BASE_URL ?>Controller/controller_logout.php" class="block w-full py-3 text-center bg-red-500/10 hover:bg-red-500/20 text-red-500 border border-red-500/30 font-bold rounded">
            SE DÉCONNECTER
        </a>
    </div>
</div>