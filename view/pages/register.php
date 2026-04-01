<form action="/~uapv2500969/Controller/controller_register.php" method="POST" class="h-full w-full flex items-center justify-center">

    <div class="w-80 flex flex-col gap-6 bg-[#0f212d] rounded-xl p-6">
        <div>
            <p class="text-white text-2xl">S'enregistrer</p>
        </div>
        <div>
            <label for="register_username">
                <input type="text" id="register_username" name="register_username" placeholder="Identifiant" class="w-full p-2 rounded bg-white text-black" required />
            </label>
        </div>
        <div>
            <label for="register_password">
                <input type="password" id="register_password" name="register_password" placeholder="Mot de passe" class="w-full p-2 rounded bg-white text-black" required />
            </label>
        </div>
        <div>
            <label for="register_confirmpassword">
                <input type="password" id="register_confirmpassword" name="register_confirmpassword" placeholder="Confirmation mot de passe" class="w-full p-2 rounded bg-white text-black" required />
            </label>
        </div>

        <hr class="border-white/20">

        <button type="submit" class="btn btn-primary rounded font-bold border-none bg-[#1576e2] text-white py-2 text-center hover:bg-blue-600 transition-colors">
            Créer un compte
        </button>
    </div>

</form>