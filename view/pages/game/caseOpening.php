<?php
use Model\Entity\GameManager;

$gameManager = new GameManager();
$gameData = $gameManager->getGameDataSlug('caseOpening');

$config = is_string($gameData['probabilities']) ? json_decode($gameData['probabilities'], true) : $gameData['probabilities'];
$cases = $config['cases'] ?? [];

$colorMap = [
        'gris' => 'text-gray-400 border-gray-400',
        'bleu' => 'text-blue-400 border-blue-400',
        'violet' => 'text-purple-500 border-purple-500',
        'rouge' => 'text-red-500 border-red-500',
        'gold' => 'text-yellow-400 border-yellow-400 drop-shadow-[0_0_10px_rgba(250,204,21,0.8)]'
];
?>

<div class="max-w-6xl mx-auto p-4">
    <h1 class="text-4xl font-black text-white text-center mb-6 uppercase tracking-widest">Case <span class="text-[#1576e2]">Opening</span></h1>

    <div class="h-[280px] w-full flex justify-center items-center mb-8">
        <div id="result-zone" class="w-full max-w-2xl p-8 rounded-lg border-2 bg-[#1a2c38] text-center shadow-2xl transition-all duration-300 opacity-0 pointer-events-none transform scale-95">
            <h2 class="text-2xl font-bold text-white mb-2">Résultat de l'ouverture</h2>
            <div id="result-item" class="text-5xl font-black uppercase my-6 tracking-widest"></div>
            <p id="result-payout" class="text-xl font-bold"></p>
            <button onclick="closeResult()" class="mt-6 px-6 py-2 bg-white/10 hover:bg-white/20 text-white rounded font-bold transition-colors">
                Fermer
            </button>
        </div>
    </div>

    <div class="flex flex-wrap justify-center gap-8">
        <?php foreach ($cases as $case): ?>
            <div class="w-full max-w-[350px] bg-[#1a2c38] rounded-xl border border-white/10 p-6 flex flex-col items-center shadow-xl hover:border-[#1576e2]/50 transition-colors group">

                <h3 class="text-2xl font-bold text-white mb-4"><?= htmlspecialchars($case['name']) ?></h3>

                <img src="<?= BASE_URL ?>view/images/case.png" alt="Caisse" class="w-48 h-48 object-contain mb-6 group-hover:scale-110 transition-transform duration-300 drop-shadow-2xl">

                <div class="w-full flex gap-1 mb-6 h-3 rounded overflow-hidden">
                    <?php
                    $rarityOrder = ['gris', 'bleu', 'violet', 'rouge', 'gold'];
                    foreach ($rarityOrder as $rarity):
                        if (isset($case['items'][$rarity])):
                            $data = $case['items'][$rarity];
                            ?>
                            <div class="h-full <?= explode(' ', $colorMap[$rarity])[0] ?> bg-current opacity-80" style="width: <?= $data['prob'] ?>%" title="<?= ucfirst($rarity) ?> : <?= $data['prob'] ?>%"></div>
                        <?php
                        endif;
                    endforeach;
                    ?>
                </div>

                <button onclick="openCase('<?= $case['id'] ?>', <?= $case['price'] ?>)" class="w-full py-4 bg-[#1576e2] hover:bg-blue-600 text-white font-black text-xl rounded shadow-[0_0_15px_rgba(21,118,226,0.4)] transition-all">
                    OUVRIR - <?= number_format($case['price'], 2, '.', ' ') ?> €
                </button>

            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    function closeResult() {
        const resultZone = document.getElementById('result-zone');
        resultZone.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
        resultZone.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
    }

    async function openCase(caseId, price) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const resultZone = document.getElementById('result-zone');
        const resultItem = document.getElementById('result-item');
        const resultPayout = document.getElementById('result-payout');
        resultZone.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
        resultZone.classList.add('opacity-100', 'scale-100', 'pointer-events-auto');
        resultZone.classList.add('scale-105');
        setTimeout(() => resultZone.classList.remove('scale-105'), 150);
        resultItem.innerText = "Ouverture...";
        resultItem.className = "text-3xl font-black uppercase my-6 tracking-widest text-gray-400 animate-pulse";
        resultPayout.innerText = "";
        resultZone.className = "w-full max-w-2xl p-8 rounded-lg border-2 bg-[#1a2c38] text-center shadow-2xl transition-all duration-300 opacity-100 scale-100 pointer-events-auto border-gray-500";

        try {
            const response = await fetch('<?= BASE_URL ?>Controller/controller_play.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    game: 'caseOpening',
                    choice: caseId,
                    bet: price, csrf_token: csrfToken
                })
            });

            const data = await response.json();
            if (data.status === 'error') {
                alert(data.message);
                closeResult();
                return;
            }

            const headerBalance = document.getElementById('user-balance');
            if (headerBalance && data.new_balance !== undefined) {
                headerBalance.innerText = parseFloat(data.new_balance).toLocaleString('fr-FR', { minimumFractionDigits: 2 });
            }

            const colors = {
                'gris': { text: 'text-gray-400', border: 'border-gray-400' },
                'bleu': { text: 'text-blue-400', border: 'border-blue-400' },
                'violet': { text: 'text-purple-500', border: 'border-purple-500' },
                'rouge': { text: 'text-red-500', border: 'border-red-500' },
                'gold': { text: 'text-yellow-400 drop-shadow-[0_0_10px_rgba(250,204,21,0.8)]', border: 'border-yellow-400 shadow-[0_0_30px_rgba(250,204,21,0.2)]' }
            };

            const rarityColor = colors[data.outcome] || colors['gris'];
            resultItem.className = `text-5xl font-black uppercase my-6 tracking-widest ${rarityColor.text}`;
            resultItem.innerText = `Objet ${data.outcome}`;
            resultZone.className = `w-full max-w-2xl p-8 rounded-lg border-2 bg-[#1a2c38] text-center shadow-2xl transition-all duration-300 opacity-100 scale-100 pointer-events-auto ${rarityColor.border}`;

            if (data.payout >= price) {
                resultPayout.className = "text-2xl font-bold text-green-500";
                resultPayout.innerText = `PROFIT ! Vous avez récupéré ${data.payout} € !`;
            } else {
                resultPayout.className = "text-xl font-bold text-[#9d9d9d]";
                resultPayout.innerText = `Valeur : ${data.payout} €`;
            }
            window.scrollTo({ top: 0, behavior: 'smooth' });

        } catch (error) {
            console.error("Erreur d'ouverture :", error);
            alert("Une erreur de connexion est survenue.");
            closeResult();
        }
    }
</script>