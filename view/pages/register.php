<form action="controller_userphp" method="POST" class="h-full w-full flex items-center justify-center">

    <div class="w-80 flex flex-col gap-6 bg-[#0f212d] rounded-xl p-6">
        <div>
            <p class="text-white text-2xl">S'enregistrer</p>
        </div>
        <div>
            <label for="ID">
                <input type="text" name="username" placeholder="Identifiant" class="w-full p-2 rounded bg-white text-black"/>
            </label>
        </div>
        <div>
            <label for="PASSWORD">
                <input type="password" name="password" placeholder="Mot de passe" class="w-full p-2 rounded bg-white text-black""/>
            </label>
        </div>
        <div>
            <label for="PASSWORD_VERIFICATION">
                <input type="password" name="confirmpassword" placeholder="Confirmation mot de passe" class="w-full p-2 rounded bg-white text-black""/>
            </label>
        </div>
        <hr>
        <a href="../index.php" class="btn btn-primary rounded font-bold border-none bg-[#1576e2] text-white">
            Créer un compte
        </a>
    </div>

</form>