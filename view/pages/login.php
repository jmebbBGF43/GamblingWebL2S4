<div class="h-full w-full flex items-center justify-center">
    <div class="flex items-center justify-center flex-col">
        <div class="w-80 flex flex-col gap-6 bg-[#0f212d] rounded-xl p-6">
            <div>
                <p class="text-white text-3xl">Se connecter </p>
            </div>
            <div>
                <label for="ID">
                    <input type="text" placeholder="Identifiant" class="w-full p-2 rounded bg-white text-black"/>
                </label>
            </div>
            <div>
                <label for="PASSWORD">
                    <input type="password" placeholder="Mot de passe" class="w-full p-2 rounded bg-white text-black""/>
                </label>

            </div>
            <hr>
            <div class="gap-2 flex flex-col">
                <a href="../index.php" class="btn btn-primary rounded font-bold border-none bg-[#1576e2] text-white">
                    Connection
                </a>
                <p>
                    Mot de passe oublié ?
                </p>
            </div>
        </div>
        <p>
            Toujours pas de compte ?
            <a href="controller_register.php" class="font-bold border-none text-[#1576e2]">
                Crée un compte
            </a>
        </p>
    </div>
</div>