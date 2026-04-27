<?php
$totalGames = count($gamesList ?? []);
$activeGames = 0;
if ($totalGames > 0) {
    foreach ($gamesList as $g) {
        if ($g['is_active']) $activeGames++;
    }
}
?>

<div class="flex text-bold text-4xl font-bold py-2 border-b border-white/5">
    Gestion des Jeux
</div>

<div class="relative overflow-x-auto bg-[#355872] shadow-xs rounded-base border border-black/35 mt-10">
    <table class="w-full text-sm text-left text-white">
        <thead class="bg-neutral-secondary-soft border-b border-default uppercase text-xs">
        <tr>
            <th class="px-6 py-4">ID</th>
            <th class="px-6 py-4">Nom du jeu</th>
            <th class="px-6 py-4">Slug</th>
            <th class="px-6 py-4 text-center">Statut</th>
            <th class="px-6 py-4">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($gamesList as $game): ?>
            <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                <td class="px-6 py-4 font-mono text-gray-400">#<?= $game['id'] ?></td>
                <td class="px-6 py-4 font-bold text-lg text-blue-300"><?= htmlspecialchars($game['name']) ?></td>
                <td class="px-6 py-4 font-mono text-xs"><?= htmlspecialchars($game['slug']) ?></td>
                <td class="px-6 py-4 text-center">
                    <span class="<?= $game['is_active'] ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' ?> border px-3 py-1 rounded text-xs font-bold uppercase">
                        <?= $game['is_active'] ? 'Actif' : 'Inactif' ?>
                    </span>
                </td>
                <td class="px-6 py-4">
                    <a href="/~uapv2500805/admin/Controller/controller_admingames.php?action_game=proba&id=<?= $game['id'] ?>" class="bg-[#1576e2] hover:bg-blue-500 text-white font-bold py-2 px-4 rounded transition-colors">
                        ⚙️ Modifier Probas
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php if ($game['slug'] === 'caseOpening'): ?>
    <div class="bg-[#1e3a5f] rounded-xl p-8 shadow-2xl border border-blue-400/30 mt-12">
        <h3 class="text-white text-2xl mb-6 font-bold flex items-center gap-3">
            <span class="bg-blue-500 text-white w-8 h-8 rounded-full flex items-center justify-center text-lg">+</span>
            Ajouter une nouvelle caisse
        </h3>

        <form method="POST" action="/~uapv2500805/admin/Controller/controller_admingames.php?action_game=add_case" class="space-y-6">
            <input type="hidden" name="game_id" value="<?= $game['id'] ?>">

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="text-white font-bold block mb-2 text-sm uppercase">Nom de la caisse</label>
                    <input type="text" name="new_case_name" placeholder="Ex: Caisse Diamant" class="w-full p-3 rounded bg-white text-black font-bold" required>
                </div>
                <div>
                    <label class="text-white font-bold block mb-2 text-sm uppercase">Prix (Jetons)</label>
                    <input type="number" step="0.01" name="new_case_price" placeholder="Ex: 50.00" class="w-full p-3 rounded bg-white text-black font-bold" required>
                </div>
            </div>

            <div class="grid grid-cols-5 gap-4">
                <?php
                $rarities = ['gris', 'bleu', 'violet', 'rouge', 'gold'];
                foreach ($rarities as $rarity):
                    ?>
                    <div class="bg-white/10 p-4 rounded-lg border border-white/10">
                        <p class="font-black uppercase text-xs mb-3 text-center text-white border-b border-white/10 pb-2"><?= $rarity ?></p>
                        <div class="space-y-3">
                            <div>
                                <label class="text-[9px] text-gray-300 block uppercase mb-1">Multiplicateur</label>
                                <input type="number" step="0.1" name="new_mult[<?= $rarity ?>]" value="1.0" class="w-full p-2 rounded text-sm bg-white text-black font-bold">
                            </div>
                            <div>
                                <label class="text-[9px] text-gray-300 block uppercase mb-1">Probabilité (%)</label>
                                <input type="number" name="new_prob[<?= $rarity ?>]" value="20" class="w-full p-2 rounded text-sm bg-white text-black font-bold">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white font-black py-4 rounded transition-all text-xl shadow-lg mt-4 uppercase">
                ✨ Créer et ajouter la caisse
            </button>
        </form>
    </div>
<?php endif; ?>