<?php
// Calcul des statistiques
$totalUsers = count($users ?? []);
$totalCredits = 0;
$bannedCount = 0;

if ($totalUsers > 0) {
    foreach ($users as $u) {
        $totalCredits += $u['credits'];
        if ($u['is_banned']) $bannedCount++;
    }
}
$avgCredits = $totalUsers > 0 ? round($totalCredits / $totalUsers, 2) : 0;
$banRate = $totalUsers > 0 ? round(($bannedCount / $totalUsers) * 100, 2) : 0;
?>

<div class="flex text-bold text-4xl font-bold py-2 border-b border-white/5">
    Informations générales
</div>

<div class="grid grid-cols-4 gap-6 p-10">
    <div class="flex flex-col items-center gap-6 bg-[#355872] rounded-xl p-6">
        <div class="text-white f-bold">
            <p class="text-white text-3xl">Nombre d'utilisateurs</p>
        </div>
        <div class="text-white">
            <p class="text-white text-3xl"><?= $totalUsers ?></p>
        </div>
    </div>
    <div class="flex flex-col items-center gap-6 bg-[#355872] rounded-xl p-6">
        <div class="text-white f-bold">
            <p class="text-white text-3xl">Solde moyen</p>
        </div>
        <div class="text-white">
            <p class="text-white text-3xl"><?= $avgCredits ?></p>
        </div>
    </div>
    <div class="flex flex-col items-center gap-6 bg-[#355872] rounded-xl p-6">
        <div class="text-white f-bold">
            <p class="text-white text-3xl">Bénéfices du Casino</p>
        </div>
        <div class="text-white">
            <p class="text-white text-3xl">N/A</p>
        </div>
    </div>
    <div class="flex flex-col items-center gap-6 bg-[#355872] rounded-xl p-6">
        <div class="text-white f-bold">
            <p class="text-white text-3xl">Taux de bannissement</p>
        </div>
        <div class="text-white">
            <p class="text-white text-3xl"><?= $banRate ?> %</p>
        </div>
    </div>
</div>

<hr class="my-10 border-white">

<div class="flex text-bold text-4xl font-bold mb-8 border-b border-white/5">
    Liste des utilisateurs
</div>

<div class="relative overflow-x-auto bg-[#355872] shadow-xs rounded-base border border-black/35">
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
        <tr>
            <th scope="col" class="px-6 py-3 font-medium text-white">Id</th>
            <th scope="col" class="px-6 py-3 font-medium text-white">Pseudo</th>
            <th scope="col" class="px-6 py-3 font-medium text-white">Solde</th>
            <th scope="col" class="px-6 py-3 font-medium text-white">Rôle</th>
            <th scope="col" class="px-6 py-3 font-medium text-white">Banni</th>
            <th scope="col" class="px-6 py-3 font-medium text-white">Droit de jeux</th>
            <th scope="col" class="px-6 py-3 font-medium text-white">Droit de transactions</th>
            <th scope="col" class="px-6 py-3 font-medium text-white">Date d'inscription</th>
            <th scope="col" class="px-6 py-3 font-medium text-white">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr class="bg-neutral-primary border-b border-default text-white">
                <td class="px-6 py-4"><?= htmlspecialchars($user['id']) ?></td>
                <td class="px-6 py-4"><?= htmlspecialchars($user['username']) ?></td>
                <td class="px-6 py-4"><?= htmlspecialchars($user['credits']) ?></td>
                <td class="px-6 py-4"><?= htmlspecialchars($user['role']) ?></td>
                <td class="px-6 py-4"><?= !empty($user['is_banned']) ? 'Oui' : 'Non' ?></td>
                <td class="px-6 py-4"><?= !empty($user['can_play']) ? 'Oui' : 'Non' ?></td>
                <td class="px-6 py-4"><?= !empty($user['can_transact']) ? 'Oui' : 'Non' ?></td>
                <td class="px-6 py-4"><?= htmlspecialchars($user['created_at']) ?></td>
                <td class="flex gap-4 my-2 px-6 py-4">
                    <a href="<?= BASE_URL ?>admin/Controller/controller_adminusers.php?action_user=edit&id=<?= $user['id'] ?>" class="btn btn-primary rounded font-bold border-none bg-[#1576e2] text-white py-2 px-4 hover:opacity-80">
                        Modifier
                    </a>
                    <a href="<?= BASE_URL ?>admin/Controller/controller_adminusers.php?action_user=delete&id=<?= $user['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');" class="btn btn-primary rounded font-bold border-none bg-red-600 text-white py-2 px-4 hover:opacity-80">
                        Supprimer
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<hr class="my-10 border-white">

<div class="flex text-bold text-4xl font-bold py-2 border-b border-white/5">
    Autres actions
</div>

<a href="<?= BASE_URL ?>admin/Controller/controller_adminusers.php?action_user=create" class="w-fit flex items-center gap-3 px-6 py-5 my-5 bg-[#E0F2FE] text-[#2C4A63] font-semibold rounded-xl border border-[#7AAACE]/30 hover:bg-[#7AAACE] hover:text-white transition-all shadow-sm">
    Ajouter un utilisateur
</a>