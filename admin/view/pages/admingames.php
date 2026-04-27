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
                    <a href="<?= BASE_URL ?>admin/Controller/controller_admingames.php?action_game=toggle_status&id=<?= $game['id'] ?>" class="<?= $game['is_active'] ? 'bg-green-500/20 text-green-400 border-green-500/50 hover:bg-green-500/40' : 'bg-red-500/20 text-red-400 border-red-500/50 hover:bg-red-500/40' ?> border px-3 py-1 rounded text-xs font-bold uppercase inline-block transition-colors">
                        <?= $game['is_active'] ? 'Actif' : 'Inactif' ?>
                    </a>
                </td>
                <td class="px-6 py-4">
                    <a href="<?= BASE_URL ?>admin/Controller/controller_admingames.php?action_game=proba&id=<?= $game['id'] ?>" class="bg-[#1576e2] hover:bg-blue-500 text-white font-bold py-2 px-4 rounded transition-colors">
                        ⚙️ Modifier Jeu
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
