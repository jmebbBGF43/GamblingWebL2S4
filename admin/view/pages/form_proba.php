<?php
/**
 * Vue : Formulaire de modification des paramètres des jeux
 * Gère dynamiquement Pile ou Face et le Case Opening (JSON)
 */
?>

<div class="max-w-5xl mx-auto space-y-12 mt-10 mb-20">
    <?php if (isset($_SESSION['admin_error'])): ?>
        <div class="bg-red-500/20 border border-red-500 text-red-400 p-4 rounded mb-6 text-center font-bold">
            <?= $_SESSION['admin_error']; unset($_SESSION['admin_error']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['admin_success'])): ?>
        <div class="bg-green-500/20 border border-green-500 text-green-400 p-4 rounded mb-6 text-center font-bold">
            <?= $_SESSION['admin_success']; unset($_SESSION['admin_success']); ?>
        </div>
    <?php endif; ?>
    <div class="bg-[#355872] rounded-xl p-8 shadow-2xl border border-black/35">
        <h2 class="text-white text-3xl mb-6 font-bold border-b border-white/10 pb-4">
            Configuration : <span class="text-[#1576e2]"><?= htmlspecialchars($game['name']) ?></span>
        </h2>

        <form method="POST" action="<?= BASE_URL ?>admin/Controller/controller_admingames.php?action_game=update_proba" class="flex flex-col gap-8">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="hidden" name="id" value="<?= $game['id'] ?>">
            <input type="hidden" name="slug" value="<?= htmlspecialchars($game['slug']) ?>">

            <?php if ($game['slug'] === 'pileOuFace'): ?>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-black/20 p-6 rounded-lg">
                    <div>
                        <label class="text-white font-bold block mb-2 text-sm uppercase">Proba Tranche</label>
                        <input type="number" step="0.01" name="edge" value="<?= $game['probabilities']['edge'] ?? 0.1 ?>" class="w-full p-3 rounded bg-white text-black font-bold">
                    </div>
                    <div>
                        <label class="text-white font-bold block mb-2 text-sm uppercase">Mult. Victoire</label>
                        <input type="number" step="0.1" name="win_multiplier" value="<?= $game['probabilities']['win_multiplier'] ?? 2.0 ?>" class="w-full p-3 rounded bg-white text-black font-bold">
                    </div>
                    <div>
                        <label class="text-white font-bold block mb-2 text-sm uppercase">Mult. Tranche</label>
                        <input type="number" step="0.1" name="edge_multiplier" value="<?= $game['probabilities']['edge_multiplier'] ?? 4.0 ?>" class="w-full p-3 rounded bg-white text-black font-bold">
                    </div>
                </div>

            <?php elseif ($game['slug'] === 'caseOpening'): ?>
                <?php if (!empty($game['probabilities']['cases'])): ?>
                    <?php foreach ($game['probabilities']['cases'] as $index => $case): ?>
                        <div class="bg-black/20 p-6 rounded-lg border border-white/10 mb-6">

                            <div class="flex justify-between items-center mb-4 border-b border-white/5 pb-2">
                                <div class="flex items-center gap-4">
                                    <h3 class="text-xl font-black text-blue-400"><?= htmlspecialchars($case['name']) ?></h3>

                                    <a href="<?= BASE_URL ?>admin/jeux/delete_case/<?= $game['id'] ?>/<?= $case['id'] ?>?csrf_token=<?= $_SESSION['csrf_token'] ?>"
                                       onclick="return confirm('Supprimer définitivement la caisse <?= htmlspecialchars(addslashes($case['name'])) ?> ?');"
                                       class="bg-red-600/80 hover:bg-red-500 text-white font-bold py-1 px-3 rounded text-xs transition-colors border border-red-500/50">
                                        🗑️ Supprimer
                                    </a>
                                </div>

                                <input type="hidden" name="case_id[<?= $index ?>]" value="<?= htmlspecialchars($case['id']) ?>">
                                <input type="hidden" name="case_name[<?= $index ?>]" value="<?= htmlspecialchars($case['name']) ?>">

                                <div class="flex items-center gap-3">
                                    <label class="text-white font-bold text-sm uppercase">Prix :</label>
                                    <input type="number" step="0.01" name="case_price[<?= $index ?>]" value="<?= $case['price'] ?>" class="p-2 rounded bg-white text-black font-bold w-24 text-center">
                                </div>
                            </div>

                            <div class="grid grid-cols-5 gap-3">
                                <?php
                                $rarities = ['gris' => 'text-gray-400', 'bleu' => 'text-blue-400', 'violet' => 'text-purple-400', 'rouge' => 'text-red-400', 'gold' => 'text-yellow-400'];
                                foreach ($rarities as $key => $colorClass):
                                    $item = $case['items'][$key] ?? ['mult' => 0, 'prob' => 0];
                                    ?>
                                    <div class="bg-white/5 p-2 rounded border border-white/5">
                                        <p class="font-bold uppercase text-[10px] mb-2 text-center <?= $colorClass ?>"><?= $key ?></p>
                                        <div class="space-y-2">
                                            <div>
                                                <label class="text-[9px] text-gray-500 block uppercase">Mult.</label>
                                                <input type="number" step="0.1" name="mult[<?= $index ?>][<?= $key ?>]" value="<?= $item['mult'] ?>" class="w-full p-1 rounded text-xs bg-white text-black font-bold">
                                            </div>
                                            <div>
                                                <label class="text-[9px] text-gray-500 block uppercase">Proba (%)</label>
                                                <input type="number" name="prob[<?= $index ?>][<?= $key ?>]" value="<?= $item['prob'] ?>" class="w-full p-1 rounded text-xs bg-white text-black font-bold">
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-400 italic">Aucune caisse n'est configurée.</p>
                <?php endif; ?>

            <?php endif; ?>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-500 text-white font-black py-4 rounded transition-all text-xl shadow-lg uppercase">
                    💾 Sauvegarder les modifications
                </button>
                <a href="<?= BASE_URL ?>admin/jeux" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-4 px-8 rounded text-center transition-all flex items-center">
                    ANNULER
                </a>
            </div>
        </form>
    </div>

    <?php if ($game['slug'] === 'caseOpening'): ?>
        <div class="bg-[#1e3a5f] rounded-xl p-8 shadow-2xl border border-blue-400/30">
            <h3 class="text-white text-2xl mb-6 font-bold flex items-center gap-3">
                <span class="bg-blue-500 text-white w-8 h-8 rounded-full flex items-center justify-center text-lg">+</span>
                Ajouter une nouvelle caisse
            </h3>

            <form method="POST" action="<?= BASE_URL ?>admin/Controller/controller_admingames.php?action_game=add_case" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
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
                    <?php foreach (['gris', 'bleu', 'violet', 'rouge', 'gold'] as $rarity): ?>
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

</div>