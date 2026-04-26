<?php
// Patch d'autochargement si la page est incluse directement via admin.php
if (!isset($mails) || !isset($users)) {
    require_once __DIR__ . "/../../../configuration/config.php";
    require_once ROOT_DIR . "Model/ConnexionDB.php";
    require_once ROOT_DIR . "Model/Class/MailManager.php";
    require_once ROOT_DIR . "Model/Class/UserDB.php";

    $mailManager = new \Model\Entity\MailManager();
    $userDB = new \Model\Entity\UserDB();

    $mails = $mailManager->getAllMails();
    $users = $userDB->getAllUsers();
}
?>

<div class="flex text-bold text-4xl font-bold py-2 border-b border-white/5">
    Messagerie (Boîte d'envoi)
</div>

<div class="relative overflow-x-auto bg-[#355872] shadow-xs rounded-base border border-black/35 mt-8">
    <table class="w-full text-sm text-left text-white">
        <thead class="bg-neutral-secondary-soft border-b border-default text-white">
        <tr>
            <th class="px-6 py-3">De</th>
            <th class="px-6 py-3">À</th>
            <th class="px-6 py-3">Sujet</th>
            <th class="px-6 py-3">Message</th>
            <th class="px-6 py-3">Date</th>
            <th class="px-6 py-3">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($mails as $mail): ?>
            <tr class="border-b border-default">
                <td class="px-6 py-4 font-bold text-yellow-400"><?= htmlspecialchars($mail['sender_name'] ?? 'Système') ?></td>
                <td class="px-6 py-4 font-bold text-green-400"><?= htmlspecialchars($mail['receiver_name'] ?? 'Inconnu') ?></td>
                <td class="px-6 py-4 font-bold"><?= htmlspecialchars($mail['subject']) ?></td>
                <td class="px-6 py-4 text-gray-300"><?= nl2br(htmlspecialchars($mail['message'])) ?></td>
                <td class="px-6 py-4 text-gray-400"><?= htmlspecialchars($mail['created_at']) ?></td>
                <td class="px-6 py-4 flex gap-2">
                    <a href="/~uapv2500805/admin/Controller/controller_mail.php?action_mail=delete&id=<?= $mail['id'] ?>" onclick="return confirm('Voulez-vous supprimer ce message ?');" class="p-2 bg-red-600 rounded text-center hover:opacity-80">
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
    <p class="text-white text-2xl mb-6">Envoyer un nouveau message</p>
    <form method="POST" action="/~uapv2500805/admin/Controller/controller_mail.php?action_mail=store" class="flex flex-col gap-4">

        <label class="text-white">Destinataire</label>
        <select name="receiver_id" class="p-2 rounded bg-white text-black" required>
            <option value="" disabled selected>-- Sélectionnez un joueur --</option>
            <?php foreach ($users as $u): ?>
                <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['username']) ?> (ID: <?= $u['id'] ?>)</option>
            <?php endforeach; ?>
        </select>

        <label class="text-white">Sujet</label>
        <input type="text" name="subject" placeholder="Ex: Problème de dépôt résolu" class="p-2 rounded bg-white text-black" required>

        <label class="text-white">Message</label>
        <textarea name="message" placeholder="Votre message pour ce joueur..." class="p-2 rounded bg-white text-black h-32" required></textarea>

        <button type="submit" class="bg-[#1576e2] text-white font-bold py-3 mt-4 rounded hover:bg-blue-700">
            Envoyer le message
        </button>
    </form>
</div>