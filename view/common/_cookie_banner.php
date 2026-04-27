<div id="cookie-banner" class="fixed bottom-0 left-0 w-full bg-[#0a151d] border-t border-[#1576e2]/30 p-4 md:p-6 z-[998] shadow-[0_-10px_30px_rgba(0,0,0,0.5)] hidden flex-col md:flex-row justify-between items-center gap-6">
    <div class="text-[#9d9d9d] text-sm max-w-4xl">
        <h3 class="text-white text-lg font-bold mb-2">🍪 Gestion de vos préférences</h3>
        Nous utilisons des cookies pour assurer le bon fonctionnement du site (obligatoires), mémoriser vos préférences de jeu, et analyser notre trafic pour améliorer votre expérience et revendre vos donnés à la Chine. Vous pouvez choisir d'accepter, de refuser (option de gros LOSER) ou de personnaliser vos choix.
    </div>
    <div class="flex flex-wrap gap-3 shrink-0">
        <button onclick="document.getElementById('cookie-modal').showModal()" class="px-4 py-2 rounded bg-white/10 hover:bg-white/20 text-white font-bold transition-colors text-sm">
            Personnaliser
        </button>
        <button onclick="saveCookieConsent('refused')" class="px-4 py-2 rounded bg-red-500/10 hover:bg-red-500/20 text-red-400 font-bold transition-colors text-sm border border-red-500/30">
            Tout Refuser
        </button>
        <button onclick="saveCookieConsent('accepted')" class="px-4 py-2 rounded bg-[#1576e2] hover:bg-blue-600 text-white font-bold transition-colors text-sm shadow-[0_0_10px_rgba(21,118,226,0.3)]">
            Tout Accepter
        </button>
    </div>
</div>

<dialog id="cookie-modal" class="modal bg-black/60">
    <div class="modal-box bg-[#1a2c38] border border-white/10 text-[#9d9d9d] max-w-2xl">
        <h3 class="font-bold text-2xl text-white mb-6">Paramètres des cookies</h3>

        <div class="flex flex-col gap-4">
            <div class="flex justify-between items-center p-4 bg-[#0f212e] rounded border border-white/5">
                <div>
                    <h4 class="text-white font-bold">Cookies strictement nécessaires</h4>
                    <p class="text-sm text-gray-500">Requis pour la connexion (Sessions) et la sécurité. Ne peuvent pas être désactivés.</p>
                </div>
                <input type="checkbox" checked disabled class="toggle toggle-info opacity-50" />
            </div>

            <div class="flex justify-between items-center p-4 bg-[#0f212e] rounded border border-white/5">
                <div>
                    <h4 class="text-white font-bold">Cookies de préférences</h4>
                    <p class="text-sm text-gray-500">Permet de mémoriser vos choix (ex: "Se souvenir de moi").</p>
                </div>
                <input type="checkbox" id="cookie-pref" class="toggle toggle-info" checked />
            </div>

            <div class="flex justify-between items-center p-4 bg-[#0f212e] rounded border border-white/5">
                <div>
                    <h4 class="text-white font-bold">Cookies analytiques</h4>
                    <p class="text-sm text-gray-500">Nous donne acces à votres ordinateur au complet et install de multiples spyware dans votre ordinateur </p>
                </div>
                <input type="checkbox" id="cookie-stats" class="toggle toggle-info" checked />
            </div>
        </div>

        <div class="modal-action mt-8">
            <form method="dialog" class="flex gap-3">
                <button class="btn bg-transparent border border-white/20 text-white hover:bg-white/10">Annuler</button>
                <button onclick="saveCustomCookies()" class="btn bg-[#1576e2] hover:bg-blue-600 border-none text-white font-bold">Enregistrer mes choix</button>
            </form>
        </div>
    </div>
</dialog>

<script>
    const COOKIE_NAME = 'gambling_cookie_consent';
    const BANNER_EL = document.getElementById('cookie-banner');

    // 1. Vérification au chargement de la page
    document.addEventListener("DOMContentLoaded", () => {
        // Si le cookie n'existe pas, on affiche le bandeau
        if (!document.cookie.split('; ').find(row => row.startsWith(COOKIE_NAME + '='))) {
            BANNER_EL.classList.remove('hidden');
            BANNER_EL.classList.add('flex');
        }
    });

    // 2. Sauvegarde globale (Tout accepter ou Tout refuser)
    function saveCookieConsent(status) {
        const preferences = {
            essential: true, // Toujours vrai
            preferences: status === 'accepted',
            analytics: status === 'accepted'
        };

        applyConsent(preferences);
    }

    // 3. Sauvegarde personnalisée depuis la modale
    function saveCustomCookies() {
        const preferences = {
            essential: true,
            preferences: document.getElementById('cookie-pref').checked,
            analytics: document.getElementById('cookie-stats').checked
        };

        applyConsent(preferences);
    }

    // 4. Fonction finale qui écrit le cookie dans le navigateur
    function applyConsent(preferences) {
        // On sauvegarde le choix pour 6 mois (180 jours) en format JSON texte
        const maxAge = 180 * 24 * 60 * 60;
        document.cookie = `${COOKIE_NAME}=${JSON.stringify(preferences)}; path=/; max-age=${maxAge}; SameSite=Lax`;

        // On cache le bandeau
        BANNER_EL.classList.add('hidden');
        BANNER_EL.classList.remove('flex');

        console.log("Choix RGPD enregistrés :", preferences);

        // Optionnel : Recharger la page si on veut appliquer des scripts bloqués
        // window.location.reload();
    }
</script>