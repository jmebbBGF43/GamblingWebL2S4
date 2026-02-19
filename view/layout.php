<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gambling.io</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" />
</head>
<body class="bg-[#0f212e] min-h-screen flex flex-col text-white">

<?php include "common/_header.php"; ?>

<div class="flex flex-1 gap-4">
    <?php include "common/_nav.php"; ?>
        <main class="flex-1 bg-gradient-to-b from-[#1a2c38] to-[#0f212e] p-4">
            <?php echo $content; ?>
        </main>
</div>

<?php include "common/_footer.php"; ?>

</body>
</html>