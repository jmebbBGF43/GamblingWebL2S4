<div class="flex text-bold text-4xl font-bold py-2 border-b border-white/5">
    Informations générales
</div>

<div class="grid grid-cols-3 gap-6 p-10">
    <div class="flex flex-col items-center gap-6 bg-[#355872] rounded-xl p-6">
        <div class="text-white f-bold">
            <p class="text-white text-3xl">Nombre de jeux</p>
        </div>
        <div class="text-white">
            <p class="text-white text-3xl">_ _</p>
        </div>
    </div>
    <div class="flex flex-col items-center gap-6 bg-[#355872] rounded-xl p-6">
        <div class="text-white f-bold">
            <p class="text-white text-3xl">Probabilité moyenne</p>
        </div>
        <div class="text-white">
            <p class="text-white text-3xl">_ _</p>
        </div>
    </div>
    <div class="flex flex-col items-center gap-6 bg-[#355872] rounded-xl p-6">
        <div class="text-white f-bold">
            <p class="text-white text-3xl">Nombre de jeux bloqués</p>
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
    <table class="w-full table-fixed text-sm text-left rtl:text-right text-body">
        <thead class="w-100 text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
        <tr>
            <th scope="col" class="px-6 py-3 font-medium">
                Id
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
                Nom
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
                Actif
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
                Actions
            </th>
        </tr>
        </thead>
        <tbody>
        <tr class="bg-neutral-primary border-b border-default">
            <td class="px-6 py-4">
                simple test
            </td>
            <td class="px-6 py-4">
                sans tableau
            </td>
            <td class="px-6 py-4">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" class="sr-only peer">
                    <div class="relative w-9 h-5 bg-[#1576e2] rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer  after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                </label>
            </td>
            </td>
            <td class="grid grid-cols-2 gap-4 m-2">
                <a href="admin/Controller/Cadmingames.php?action_game=proba" class="btn btn-primary rounded font-bold border-none bg-[#1576e2] text-white hover:text-blue">
                    Modifier les probas
                </a>
                <a href="#" class="btn btn-primary rounded font-bold border-none bg-[#1576e2] text-white hover:text-blue">
                    Supprimer le jeux
                </a>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<hr class="my-10 border-white">

<div class="flex text-bold text-4xl font-bold py-2 border-b border-white/5">
    Autres actions
</div>

<a href="admin/Controller/Cadmingames.php?action_game=addgame" class="w-fit flex items-center gap-3 px-6 py-5 my-5 bg-[#E0F2FE] text-[#2C4A63] font-semibold rounded-xl border border-[#7AAACE]/30 hover:bg-[#7AAACE] hover:text-white transition-all shadow-sm">
    Ajouter un jeux
</a>

