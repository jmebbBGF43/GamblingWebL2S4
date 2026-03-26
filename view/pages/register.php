<form action="../../Controller/controller_user.php" method="POST" class="h-full w-full flex items-center justify-center">

    <div class="w-80 flex flex-col gap-6 bg-[#0f212d] rounded-xl p-6">
        <div>
            <p class="text-white text-2xl">S'enregistrer</p>
        </div>
        <div>
            <label for="username">
                <input type="text" id="username" name="username" placeholder="Identifiant" class="w-full p-2 rounded bg-white text-black" required />
            </label>
        </div>
        <div>
            <label for="password">
                <input type="password" id="password" name="password" placeholder="Mot de passe" class="w-full p-2 rounded bg-white text-black" required />
            </label>
        </div>
        <div>
            <label for="confirmpassword">
                <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirmation mot de passe" class="w-full p-2 rounded bg-white text-black" required />
            </label>
        </div>

        <hr class="border-white/20">

        <a href="#" type="submit" class="btn btn-primary rounded font-bold border-none bg-[#1576e2] text-white py-2 text-center hover:bg-blue-600 transition-colors">
            Créer un compte
        </a>
    </div>

</form>