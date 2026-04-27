<?php
if (!isset($faqs)) {
    require_once __DIR__ . "/../../../configuration/config.php";
    require_once ROOT_DIR . "Model/ConnexionDB.php";
    require_once ROOT_DIR . "admin/Model/Class/FaqManager.php";

    $faqManager = new \Model\Entity\FaqManager();
    $faqs = $faqManager->getAllFaqs();
}
?>

<div class="flex text-bold text-4xl font-bold py-2 border-b border-white/5">
    Gestion de la FAQ
</div>

<div class="relative overflow-x-auto bg-[#355872] shadow-xs rounded-base border border-black/35 mt-8">
    <table class="w-full text-sm text-left text-white">
        <thead class="bg-neutral-secondary-soft border-b border-default text-white">
        <tr>
            <th class="px-6 py-3">Question</th>
            <th class="px-6 py-3">Réponse</th>
            <th class="px-6 py-3">Statut</th>
            <th class="px-6 py-3">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($faqs as $faq): ?>
            <tr class="border-b border-default">
                <td class="px-6 py-4 font-bold"><?= htmlspecialchars($faq['question']) ?></td>
                <td class="px-6 py-4 text-gray-300"><?= htmlspecialchars($faq['answer']) ?></td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded <?= $faq['is_active'] ? 'bg-green-600' : 'bg-red-600' ?>">
                        <?= $faq['is_active'] ? 'Affiché' : 'Masqué' ?>
                    </span>
                </td>
                <td class="px-6 py-4 flex gap-2">
                    <a href="<?= BASE_URL ?>admin/faq/toggle/<?= $faq['id'] ?>" class="p-2 bg-yellow-600 rounded text-center hover:opacity-80">
                        <?= $faq['is_active'] ? 'Masquer' : 'Afficher' ?>
                    </a>
                    <a href="<?= BASE_URL ?>admin/faq/delete/<?= $faq['id'] ?>" onclick="return confirm('Supprimer définitivement ?');" class="p-2 bg-red-600 rounded text-center hover:opacity-80">
                        Supprimer
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<hr class="my-10 border-white">

<div class="bg-[#355872] rounded-xl p-8 w-full max-w-2xl mx-auto">
    <p class="text-white text-2xl mb-6">Ajouter une nouvelle FAQ</p>
    <form method="POST" action="<?= BASE_URL ?>admin/faq/store/" class="flex flex-col gap-4">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="text" name="question" placeholder="La question..." class="p-2 rounded bg-white text-black" required>
        <textarea name="answer" placeholder="La réponse..." class="p-2 rounded bg-white text-black h-32" required></textarea>
        <button type="submit" class="bg-[#1576e2] text-white font-bold py-3 rounded hover:bg-blue-700">
            Enregistrer la question
        </button>
    </form>
</div>