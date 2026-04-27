<div class="max-w-4xl mx-auto p-8 bg-[#1a2c38] rounded-xl border border-white/10 shadow-2xl">
    <h1 class="text-4xl font-black text-white mb-10 border-b border-white/10 pb-4">Plan du Site</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div>
            <h2 class="text-[#1576e2] text-xl font-bold mb-4 flex items-center gap-2">
                <span>🌐</span> Navigation Principale
            </h2>
            <ul class="space-y-3 text-gray-300">
                <li><a href="home" class="hover:text-white hover:underline">Accueil</a></li>
                <li><a href="connexion" class="hover:text-white hover:underline">Connexion</a></li>
                <li><a href="inscription" class="hover:text-white hover:underline">Inscription</a></li>
                <li><a href="support" class="hover:text-white hover:underline">Support & FAQ</a></li>
            </ul>

            <h2 class="text-[#1576e2] text-xl font-bold mt-8 mb-4 flex items-center gap-2">
                <span>🎮</span> Nos Jeux
            </h2>
            <ul class="space-y-3 text-gray-300">
                <li><a href="game/caseOpening" class="hover:text-white hover:underline">Case Opening (Ouverture de caisses)</a></li>
                <li><a href="game/pileOuFace" class="hover:text-white hover:underline">Pile ou Face</a></li>
            </ul>
        </div>

        <div>
            <h2 class="text-[#1576e2] text-xl font-bold mb-4 flex items-center gap-2">
                <span>👤</span> Mon Compte
            </h2>
            <ul class="space-y-3 text-gray-300">
                <li><a href="paiement" class="hover:text-white hover:underline">Ajouter des fonds</a></li>
                <li><a href="parametres" class="hover:text-white hover:underline">Paramètres du profil</a></li>
            </ul>

            <h2 class="text-red-500 text-xl font-bold mt-8 mb-4 flex items-center gap-2">
                <span>🛠️</span> Administration
            </h2>
            <ul class="space-y-3 text-gray-400 text-sm italic">
                <li><a href="admin" class="hover:text-white">Tableau de bord</a></li>
                <li><a href="admin/utilisateurs" class="hover:text-white">Gestion Utilisateurs</a></li>
                <li><a href="admin/jeux" class="hover:text-white">Configuration des Jeux</a></li>
                <li><a href="admin/faq" class="hover:text-white">Modération FAQ</a></li>
                <li><a href="admin/mails" class="hover:text-white">Gestion des Mails</a></li>
                <li><a target="_blank" href="<?= BASE_URL ?>sitemap.xml" class="hover:text-white">sitemap.xml</a></li>
            </ul>
        </div>
    </div>
</div>