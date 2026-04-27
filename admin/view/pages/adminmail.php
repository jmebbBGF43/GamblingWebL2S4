<?php
if (!isset($messages)) {
    require_once __DIR__ . "/../../../configuration/config.php";
    require_once ROOT_DIR . "Model/ConnexionDB.php";
    require_once ROOT_DIR . "admin/Model/Class/MailManager.php";
    $mailManager = new \Model\Entity\MailManager();
    $messages = $mailManager->getAllMessages();
}
?>

<div class="flex text-bold text-4xl font-bold py-2 border-b border-white/5">
    Support Client (Messages)
</div>

<?php if (isset($_SESSION['mail_success'])): ?>
    <div class="bg-green-500/20 border border-green-500 text-green-400 p-4 rounded mt-6 text-center font-bold">
        <?= $_SESSION['mail_success']; unset($_SESSION['mail_success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['mail_error'])): ?>
    <div class="bg-red-500/20 border border-red-500 text-red-400 p-4 rounded mt-6 text-center font-bold">
        <?= $_SESSION['mail_error']; unset($_SESSION['mail_error']); ?>
    </div>
<?php endif; ?>

<div class="relative overflow-x-auto bg-[#355872] shadow-xs rounded-base border border-black/35 mt-8 pb-10">
    <table class="w-full text-sm text-left text-white">
        <thead class="bg-neutral-secondary-soft border-b border-default text-white uppercase text-xs">
        <tr>
            <th class="px-6 py-3">Joueur</th>
            <th class="px-6 py-3">Email</th>
            <th class="px-6 py-3">Message</th>
            <th class="px-6 py-3 text-center">Statut</th>
            <th class="px-6 py-3 text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($messages as $msg): ?>
            <tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
                <td class="px-6 py-4 font-bold text-blue-300"><?= htmlspecialchars($msg['username'] ?? 'Invité') ?></td>
                <td class="px-6 py-4 font-mono text-xs"><?= htmlspecialchars($msg['reply_email']) ?></td>
                <td class="px-6 py-4 max-w-md">
                    <p class="font-bold text-white"><?= htmlspecialchars($msg['subject']) ?></p>
                    <p class="text-gray-300 text-xs italic">"<?= nl2br(htmlspecialchars($msg['message'])) ?>"</p>
                </td>
                <td class="px-6 py-4 text-center">
                    <?php if ($msg['status'] === 'unread'): ?>
                        <span class="bg-red-500/20 text-red-400 border border-red-500/50 px-2 py-1 rounded text-[10px] font-bold uppercase">Non lu</span>
                    <?php else: ?>
                        <span class="bg-blue-500/20 text-blue-400 border border-blue-500/50 px-2 py-1 rounded text-[10px] font-bold uppercase">Lu</span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4">
                    <div class="flex flex-col gap-2">
                        <button type="button" onclick="toggleReplyForm(<?= $msg['id'] ?>)" class="bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-bold py-2 px-3 rounded text-center">✉️ RÉPONDRE</button>

                        <?php if ($msg['status'] === 'unread'): ?>
                            <a href="<?= BASE_URL ?>admin/Controller/controller_mail.php?action_mail=status&id=<?= $msg['id'] ?>&status=read" class="bg-emerald-600 hover:bg-emerald-500 text-white text-[10px] font-bold py-2 px-3 rounded text-center">✓ MARQUER LU</a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>admin/Controller/controller_mail.php?action_mail=status&id=<?= $msg['id'] ?>&status=unread" class="bg-gray-600 hover:bg-gray-500 text-white text-[10px] font-bold py-2 px-3 rounded text-center">MARQUER NON LU</a>
                        <?php endif; ?>

                        <a href="<?= BASE_URL ?>admin/Controller/controller_mail.php?action_mail=delete&id=<?= $msg['id'] ?>" onclick="return confirm('Supprimer ?')" class="bg-red-600/20 text-red-500 border border-red-500/50 hover:bg-red-600 hover:text-white text-[10px] font-bold py-2 px-3 rounded text-center">🗑️ SUPPRIMER</a>
                    </div>
                </td>
            </tr>
            <tr id="reply-row-<?= $msg['id'] ?>" class="hidden bg-black/30">
                <td colspan="5" class="px-6 py-4">
                    <form method="POST" action="<?= BASE_URL ?>admin/Controller/controller_mail.php?action_mail=reply" class="flex flex-col gap-3">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                        <textarea name="admin_reply" class="w-full p-3 rounded bg-white text-black text-sm h-24" placeholder="Votre réponse email..." required><?= htmlspecialchars($msg['admin_reply'] ?? '') ?></textarea>
                        <div class="flex gap-2">
                            <button type="submit" class="bg-green-600 hover:bg-green-500 text-white font-bold py-2 px-4 rounded text-sm">Envoyer la réponse</button>
                            <button type="button" onclick="toggleReplyForm(<?= $msg['id'] ?>)" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded text-sm">Annuler</button>
                        </div>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function toggleReplyForm(id) {
        const row = document.getElementById('reply-row-' + id);
        row.classList.toggle('hidden');
    }
</script>