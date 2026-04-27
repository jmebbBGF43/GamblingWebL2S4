<?php include ROOT_DIR . "configuration/temp_game.php"; ?>
<div class="flex w-full text-bold text-3xl font-bold h-20 border-b border-white/5 pt-3">
    Sélection des jeux :
</div>
<div class="flex w-full justify-center pt-10">
    <div class="w-[90%] flex flex-row flex-wrap justify-center gap-8 p-4">

        <?php
        /**
         * @var array $game_list
         */
        foreach ($game_list as $game => $value) : ?>
            <a href="<?= BASE_URL ?>game/<?= $game ?>" class="w-40 h-60 flex items-center justify-center border border-white/10 rounded hover:scale-105 transition-transform cursor-pointer">
                <img src="view/images/game/<?= $game ?>.jpg" alt="<?= htmlspecialchars($value) ?>" class="w-full h-full object-cover">
            </a>
        <?php endforeach; ?>
    </div>
</div>


