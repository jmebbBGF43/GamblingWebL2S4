<?php include ROOT_DIR . "configuration/temp_game.php"; ?>
<aside class="w-64 flex flex-col pl-4 py-4">
    <nav class="flex-1 flex-col px-6 bg-[#1a2c38] rounded border border-white/5">
        <div class="flex text-bold text-xl font-bold py-2 border-b border-white/5 pt-3">
            Nos jeux :
        </div>
        <?php
        /**
         * @var array $game_list
         */
        foreach ($game_list as $game => $value) : ?>
            <a href="<?= BASE_URL ?>game/<?= $game ?>" class="flex items-center my-3">
                 <?php include "icon/".$game.".php" ?><?= htmlspecialchars($value) ?>
            </a>
        <?php endforeach; ?>
    </nav>
</aside>