<div class="max-w-4xl mx-auto p-6 bg-[#1a2c38] rounded border border-white/10 shadow-2xl text-[#9d9d9d]">
    <h2 class="text-3xl font-bold text-white mb-8 text-center">Support Client & Réclamations (Le Bureau des Pleurs)</h2>

    <h3 class="text-xl font-bold text-white mt-6 mb-2">Comment (ne pas) nous contacter ?</h3>
    <p class="mb-4">
        Vous avez perdu toutes vos économies et vous cherchez quelqu'un à qui parler ? Vous êtes au bon endroit pour être ignoré avec professionnalisme.
    </p>

    <h3 class="text-xl font-bold text-white mt-8 mb-2">Nos moyens de communication :</h3>
    <ul class="list-disc list-inside mb-4">
        <li><strong>Chat en direct :</strong> Discutez avec notre Intelligence Artificielle de pointe, entraînée exclusivement sur une base de données d'insultes de Gordon Ramsay et de sarcasmes.</li>
        <li><strong>Par Mail :</strong> Envoyez vos larmes à <em>on-s-en-fout@gambling.io</em>. Délai de réponse estimé : entre 3 et 5 réincarnations.</li>
        <li><strong>Par Téléphone :</strong> Appelez notre numéro surtaxé (15€/minute). La musique d'attente est un enregistrement continu du bruit des machines à sous qui crachent le jackpot.</li>
    </ul>

    <h3 class="text-xl font-bold text-white mt-8 mb-2">F.A.Q.I (Foire Aux Questions Ignorées)</h3>
    <div class="space-y-4 mt-4">

        <?php if (!empty($faqs)): ?>
            <?php foreach ($faqs as $faq): ?>
                <div class="p-4 bg-white/5 rounded-lg border border-white/10">
                    <p class="text-white font-bold">Q : <?= htmlspecialchars($faq['question']) ?></p>
                    <p class="mt-2 text-sm text-gray-300">R : <?= nl2br(htmlspecialchars($faq['answer'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="italic text-center py-4">Aucune question n'a été trouvée... Tout le monde a déjà abandonné.</p>
        <?php endif; ?>

    </div>

    <br>
    <h3 class="text-xl font-bold text-white mt-8 mb-2">Envoyez-nous un Mail qu'on ne lira pas :</h3>

    <div class="max-w-2xl mx-auto mt-10">

        <?php if (isset($_SESSION['contact_success'])): ?>
            <div class="bg-green-500/20 border border-green-500 text-green-400 p-4 rounded mb-6 text-center font-bold">
                <?= $_SESSION['contact_success']; unset($_SESSION['contact_success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['contact_error'])): ?>
            <div class="bg-red-500/20 border border-red-500 text-red-400 p-4 rounded mb-6 text-center font-bold">
                <?= $_SESSION['contact_error']; unset($_SESSION['contact_error']); ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>Controller/controller_contact.php" method="POST" class="flex flex-col gap-4">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
            <input type="email" name="email" required placeholder="votre@email.com" class="w-full p-3 rounded bg-white text-black focus:ring-2 focus:ring-blue-500 outline-none" />
            <input type="text" name="subject" required placeholder="Sujet du litige perdu d'avance" class="w-full p-3 rounded bg-white text-black focus:ring-2 focus:ring-blue-500 outline-none" />
            <textarea name="message" required placeholder="Contenu de votre message inutile..." rows="5" class="w-full p-3 h-40 rounded bg-white text-black resize-none focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
            <button type="submit" class="w-full py-3 rounded font-bold bg-[#1576e2] hover:bg-blue-600 text-white transition-colors shadow-lg">
                Envoyer dans le vide
            </button>
        </form>

    </div>
</div>