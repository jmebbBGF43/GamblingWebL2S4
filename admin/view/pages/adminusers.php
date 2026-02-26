<div class="flex text-bold text-4xl font-bold py-2 border-b border-white/5">
    Informations générales
</div>

<div class="grid grid-cols-4 gap-6 p-10">
        <div class="flex flex-col items-center gap-6 bg-[#355872] rounded-xl p-6">
            <div class="text-white f-bold">
                <p class="text-white text-3xl">Nombre d'utilisateurs</p>
            </div>
            <div class="text-white">
                <p class="text-white text-3xl">_ _</p>
            </div>
        </div>
        <div class="flex flex-col items-center gap-6 bg-[#355872] rounded-xl p-6">
            <div class="text-white f-bold">
                <p class="text-white text-3xl">Solde moyen</p>
            </div>
            <div class="text-white">
                <p class="text-white text-3xl">_ _</p>
            </div>
        </div>
        <div class="flex flex-col items-center gap-6 bg-[#355872] rounded-xl p-6">
            <div class="text-white f-bold">
                <p class="text-white text-3xl">Bénéfices du Casino</p>
            </div>
            <div class="text-white">
                <p class="text-white text-3xl">_ _</p>
            </div>
        </div>
        <div class="flex flex-col items-center gap-6 bg-[#355872] rounded-xl p-6">
            <div class="text-white f-bold">
                <p class="text-white text-3xl">Taux de bannissement</p>
            </div>
            <div class="text-white">
                <p class="text-white text-3xl">_ _</p>
            </div>
        </div>
</div>

<hr class="my-10 border-white">

<div class="flex text-bold text-4xl font-bold mb-8 border-b border-white/5">
    Liste des utilisateurs
</div>

<div class="relative overflow-x-auto bg-[#355872] shadow-xs rounded-base border border border-black/35">
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
        <tr>
            <th scope="col" class="px-6 py-3 font-medium">
                Id
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
                Pseudo
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
                Solde
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
                Banni
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
                Droit de jeux
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
                Droit de transations
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
                Date d'inscription
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
                Actions
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        /**
         * @var $data
         */
        foreach ($data as $user => $info): ?>
        <tr class="bg-neutral-primary border-b border-default">
            <td class="px-6 py-4">
                <?= $user ?>
            </td>
            <td class="px-6 py-4">
                <?= $info['pseudo'] ?>
            </td>
            <td class="px-6 py-4">
                <?= $info['solde'] ?>
            </td>
            <td class="px-6 py-4">
                <?= $info['banni'] ?>
            </td>
            <td class="px-6 py-4">
                <?= $info['droit_jeux'] ?>
            </td>
            <td class="px-6 py-4">
                <?= $info['droit_transac'] ?>
            </td>
            <td class="px-6 py-4">
                <?= $info['date_inscription'] ?>
            </td>
            <td class="grid grid-cols-2 gap-4 my-2">
                <a href="admin/Controller/Cadminusers.php?action_user=edit&id=<?= $user?>" class="btn btn-primary rounded font-bold border-none bg-[#1576e2] text-white hover:text-blue">
                    Modifier
                </a>
                <a href="#" class="btn btn-primary rounded font-bold border-none bg-[#1576e2] text-white hover:text-blue">
                    Supprimer
                </a>
            </td>
            <td class="px-6 py-4">

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


<a href="admin/Controller/Cadminusers.php?action_user=create" class="w-fit flex items-center gap-3 px-6 py-5 my-5 bg-[#E0F2FE] text-[#2C4A63] font-semibold rounded-xl border border-[#7AAACE]/30 hover:bg-[#7AAACE] hover:text-white transition-all shadow-sm">
    Ajouter un utilisateur
</a>

