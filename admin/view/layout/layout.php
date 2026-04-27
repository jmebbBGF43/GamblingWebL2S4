<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <base href="https://pedago.univ-avignon.fr/~uapv2500969/">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" />
</head>
<body class="bg-[#7AAACE] min-h-screen flex flex-col text-white">
<?php include __DIR__."/../common/_header.php"; ?>
<div class="flex flex-1 gap-4">
    <?php include __DIR__."/../common/_nav.php"; ?>
    <main class="flex-1 bg-[#9CD5FF] p-4 border-b border-black/35">
        <?php
        /**
         * @var $content
         */
        echo $content;
        ?>
    </main>
</div>
</body>
</html>