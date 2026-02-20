<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gambling.io</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.min.css" rel="stylesheet" />
</head>
<body class="bg-[#0f212e] min-h-screen flex flex-col">
    <main class="flex-1 flex items-center justify-center bg-gradient-to-b from-[#1a2c38] to-[#0f212e] p-4">
        <?php include 'view/pages/'.$_GET['url'].'.php'; ?>
    </main>
</body>
</html>