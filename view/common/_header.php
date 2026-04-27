<?php
use Model\Entity\UserDB;

$currentCredits = "0.00";
if (isset($_SESSION['user_id'])) {
    require_once ROOT_DIR . "Model/ConnexionDB.php";
    require_once ROOT_DIR . "Model/Class/UserDB.php";

    $headerUserDB = new UserDB();
    $headerUserData = $headerUserDB->getUserById($_SESSION['user_id']);

    if ($headerUserData) {
        $currentCredits = number_format($headerUserData['credits'], 2, '.', ' ');
    }
}
?>
<header class="h-20 flex justify-between px-8 bg-[#0f212e] border-b border-white/5">
    <div class="flex items-center">
        <div class="text-2xl font-black tracking-tighter text-white">
            <a href="<?= BASE_URL ?>home">GAMBLING<span class="text-[#1576e2]">.IO</span></a>
        </div>
    </div>

    <div class="flex items-center gap-6">

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="bg-[#1576e2] border border-white/10 px-4 py-2 h-[3rem] rounded flex items-center gap-2">
                <span id="user-balance" class="text-grey-400 font-bold"><?= $currentCredits ?></span>
                <span class="text-xs text-white-400 uppercase tracking-widest font-semibold">€</span>
            </div>

            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn bg-[#1576e2] hover:bg-blue-600 text-white border-none rounded font-bold px-6">
                    MENU
                </div>
                <ul tabindex="0" class="dropdown-content menu p-2 mt-4 bg-[#1a2c38] w-max rounded border border-white/10 text-[#9d9d9d] font-medium z-[100]">

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li>
                            <a href="<?= BASE_URL ?>admin/admin.php" class="text-yellow-400 hover:bg-yellow-400/10 hover:text-yellow-300 transition-colors rounded py-3 font-bold">
                                👑 Panel Admin
                            </a>
                        </li>
                        <div class="h-[1px] bg-white/10 my-1 mx-1"></div>
                    <?php endif; ?>

                    <li>
                        <a href="<?= BASE_URL ?>profile" class="hover:bg-white/10 hover:text-white transition-colors rounded py-3">
                            👤 Profil
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>paiement" class="hover:bg-white/10 hover:text-white transition-colors rounded py-3">
                            💳 Paiement
                        </a>
                    </li>
                    <!--<li>
                        <a href="<?= BASE_URL ?>Controller/controller_menu.php?user_pageID=parameter" class="hover:bg-white/10 hover:text-white transition-colors rounded py-3">
                            ⚙️ Paramètres
                        </a>
                    </li> -->
                    <div class="h-[1px] bg-white/10 my-1 mx-1"></div>
                    <li>
                        <a href="<?= BASE_URL ?>Controller/controller_logout.php" class="text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors rounded py-3">
                            ➜] Déconnexion
                        </a>
                    </li>
                </ul>
            </div>

        <?php else: ?>
            <a href="<?= BASE_URL ?>connexion" class="btn bg-[#1576e2] hover:bg-blue-600 text-white border-none rounded font-bold px-6">
                Se connecter
            </a>
        <?php endif; ?>

    </div>
</header>