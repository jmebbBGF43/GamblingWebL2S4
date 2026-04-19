<div class="max-w-xl mx-auto p-6 bg-[#1a2c38] rounded border border-white/10 shadow-2xl text-[#9d9d9d]">
    <h2 class="text-3xl font-bold text-white mb-8 text-center">Ajouter des fonds</h2>

    <?php if (isset($_SESSION['payment_success'])): ?>
        <div class="bg-green-500/20 border border-green-500 text-green-400 p-4 rounded mb-6 text-center font-bold text-lg">
            <?= $_SESSION['payment_success']; unset($_SESSION['payment_success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['payment_error'])): ?>
        <div class="bg-red-500/20 border border-red-500 text-red-400 p-4 rounded mb-6 text-center font-bold text-lg">
            <?= $_SESSION['payment_error']; unset($_SESSION['payment_error']); ?>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>Controller/controller_add_funds.php" method="POST" class="flex flex-col items-center gap-8 p-4">

        <div class="flex flex-row justify-center items-center gap-4 w-full">
            <button type="button" onclick="changeAmount(-10)" class="bg-[#1576e2] hover:bg-blue-600 text-white text-2xl font-bold border-none rounded px-6 w-14 h-14 flex items-center justify-center">
                -
            </button>

            <div class="w-48">
                <label for="amountInput" class="sr-only">Montant</label>
                <input type="number" id="amountInput" name="amount" value="50" min="1" step="1" required class="w-full h-14 bg-[#0f212e] border border-white/10 rounded-lg text-center text-white font-bold text-2xl">
            </div>

            <button type="button" onclick="changeAmount(10)" class="bg-[#1576e2] hover:bg-blue-600 text-white text-2xl font-bold border-none rounded px-6 w-14 h-14 flex items-center justify-center">
                +
            </button>
        </div>

        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-xl font-bold border-none rounded px-6 w-full h-14 text-center max-w-xs shadow-lg shadow-green-500/20 transition-all">
            AJOUTER
        </button>
    </form>
</div>

<script>
    function changeAmount(step) {
        const input = document.getElementById('amountInput');
        let currentValue = parseInt(input.value) || 0;
        let newValue = currentValue + step;
        if (newValue < 1) newValue = 1;

        input.value = newValue;
    }
</script>