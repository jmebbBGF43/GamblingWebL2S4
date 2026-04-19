<div class="flex w-full text-bold text-3xl font-bold h-20 border-b border-white/5 pt-3 mb-11">
    Pile OU Face
</div>
<div class="max-w-xl mx-auto p-6 bg-[#1a2c38] rounded border border-white/10 shadow-2xl text-[#9d9d9d]">
    <div class="flex flex-col gap-4">
        <label for="betAmount" class="text-3xl font-bold text-white mb-8">Mise (€) :</label>
        <input type="number" id="betAmount" value="10" min="1" class="w-full h-14 bg-[#0f212e] border border-white/10 rounded-lg text-center text-white font-bold text-2xl">

        <div class="flex gap-4 mt-2">
            <button onclick="playGame('pile')" class="flex-1 bg-blue-600 hover:bg-blue-500 p-3 rounded font-bold transition text-white">Jouer Pile</button>
            <button onclick="playGame('tranche')" class="flex-1 bg-purple-600 hover:bg-purple-500 p-3 rounded font-bold transition text-white">Jouer Tranche (x4)</button>
            <button onclick="playGame('face')" class="flex-1 bg-red-600 hover:bg-red-500 p-3 rounded font-bold transition text-white">Jouer Face</button>
        </div>
    </div>

    <div id="resultBox" class="mt-8 p-4 text-center rounded hidden font-bold text-lg">
    </div>
</div>

<script>
    async function playGame(choice) {
        const betInput = document.getElementById('betAmount').value;
        const resultBox = document.getElementById('resultBox');

        resultBox.className = "mt-8 p-4 text-center rounded bg-gray-700 text-white font-bold";
        resultBox.innerText = "La pièce tourne...";
        resultBox.classList.remove('hidden');

        try {
            const response = await fetch('<?= BASE_URL ?>Controller/controller_play.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({game: 'pileOuFace', bet: betInput, choice: choice
                })
            });
            const data = await response.json();

            if (data.status === 'win' || data.status === 'loss') {
                const headerBalance = document.getElementById('user-balance');
                if (headerBalance && data.new_balance !== undefined) {
                    headerBalance.innerText = parseFloat(data.new_balance).toLocaleString('fr-FR', { minimumFractionDigits: 2 });
                }

                if (data.status === 'win') {
                    resultBox.className = "mt-8 p-4 text-center rounded bg-green-600 text-white font-bold text-xl";
                    resultBox.innerText = `Tombé sur ${data.outcome.toUpperCase()} ! ${data.message} Gain : ${data.payout} €`;
                } else {
                    resultBox.className = "mt-8 p-4 text-center rounded bg-red-600 text-white font-bold text-xl";
                    resultBox.innerText = `Tombé sur ${data.outcome.toUpperCase()}. ${data.message} -${data.payout} €`;
                }
            }
        } catch (error) {
            console.error("Erreur de connexion avec le serveur", error);
            resultBox.innerText = error;
        }
    }
</script>