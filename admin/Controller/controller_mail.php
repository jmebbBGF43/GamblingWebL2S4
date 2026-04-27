<?php
// Affichage des erreurs pour le débug (Très important pour notre test)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Inclusions sécurisées
    require_once "controller_adminlogin.php";
    require_once __DIR__ . "/../../configuration/config.php";
    require_once ROOT_DIR . "Model/ConnexionDB.php";
    require_once ROOT_DIR . "admin/Model/Class/MailManager.php";

    $mailManager = new \Model\Entity\MailManager();
    $action = $_GET['action_mail'] ?? '';

    // =========================================================
    // ACTION : RÉPONDRE (MODE TEST ULTRA SIMPLE EN DUR)
    // =========================================================
    if ($action === 'reply' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $reply_text = htmlspecialchars(trim($_POST['admin_reply']));

        // 1. On sauvegarde en base (ça, on sait que ça marche)
        $mailManager->saveReply($id, $reply_text);

        // 2. ENVOI DE TEST EN DUR (On ignore l'email du joueur pour le moment)
        $to = "quincieu.thomas@gmail.com";
        $subject = "Test ultime depuis Admin";
        $body = "Ceci est un test.\nTexte tapé dans l'admin : " . $reply_text;

        // Le seul header qu'on garde : celui qui a marché pour ton pote
        $headers = "From: noreply@gambling.io\r\n";

        // On lance la commande et on stocke le résultat (true ou false)
        $envoi = mail($to, $subject, $body, $headers);

        // 3. AFFICHAGE DU RÉSULTAT (Bloque la page exprès pour qu'on voit le résultat)
        if ($envoi) {
            die("<div style='background: #dcfce7; color: #166534; padding: 20px; font-family: sans-serif; border-radius: 8px; margin: 20px;'>
                    <h1 style='margin-top:0;'>✅ SUCCÈS PHP</h1>
                    <p>La fonction mail() a retourné TRUE. Le serveur a accepté d'envoyer le message vers <b>$to</b>.</p>
                    <p><i>Si tu ne reçois rien, regarde impérativement dans tes spams, car le message a bien quitté le serveur.</i></p>
                    <br><a href='controller_mail.php' style='color: #166534; font-weight: bold;'>Retour au panel</a>
                 </div>");
        } else {
            die("<div style='background: #fee2e2; color: #991b1b; padding: 20px; font-family: sans-serif; border-radius: 8px; margin: 20px;'>
                    <h1 style='margin-top:0;'>❌ ÉCHEC FATAL</h1>
                    <p>La fonction mail() a retourné FALSE. Le serveur de l'université refuse l'envoi.</p>
                    <br><a href='controller_mail.php' style='color: #991b1b; font-weight: bold;'>Retour au panel</a>
                 </div>");
        }
    }

    // =========================================================
    // ACTION : SUPPRIMER
    // =========================================================
    elseif ($action === 'delete' && isset($_GET['id'])) {
        $mailManager->deleteMessage($_GET['id']);
        header("Location: controller_mail.php");
        exit();
    }

    // =========================================================
    // ACTION : STATUT (LU / NON LU)
    // =========================================================
    elseif ($action === 'status' && isset($_GET['id']) && isset($_GET['status'])) {
        $mailManager->updateStatus($_GET['id'], $_GET['status']);
        header("Location: controller_mail.php");
        exit();
    }

    // =========================================================
    // AFFICHAGE DE LA PAGE
    // =========================================================
    ob_start();
    $messages = $mailManager->getAllMessages();
    include '../view/pages/adminmail.php';
    $content = ob_get_clean();
    include '../view/layout/layout.php';

} catch (Throwable $e) {
    die("<div style='background:#b91c1c; color:white; padding:20px;'>Erreur : " . $e->getMessage() . "</div>");
}
?>