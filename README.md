# Gambling.io 🎲

Plateforme web académique de jeux de hasard comprenant un Front-office pour les joueurs et un Back-office de gestion complet. Le projet repose sur une architecture MVC PHP sur-mesure (sans framework externe), sécurisée et optimisée avec des URL propres.

## 🚀 Fonctionnalités

### 🎮 Front-Office (Joueurs)
* **Authentification** : Inscription, connexion, protection CSRF systématique et hachage des mots de passe.
* **Portefeuille virtuel** : Interface d'ajout de fonds (`/paiement`).
* **Jeux interactifs** (Propulsés par Fetch API pour un rendu asynchrone) :
  * *Case Opening* : Ouverture de caisses avec gestion stricte des probabilités (100%) et des raretés.
  * *Pile ou Face* : Jeu de coinflip avec multiplicateurs configurables.
* **Support & Navigation** : Formulaire de contact, FAQ dynamique, Sitemap (XML côté serveur & HTML côté client).

### 👑 Back-Office (Administration)
* **Porte dérobée sécurisée** : Accès restreint au panel via une URL dédiée (`/admin/connexion`).
* **Gestion des Utilisateurs** : Création de comptes, modification des droits, bannissement et blocage des transactions.
* **Configuration des Jeux** : Création dynamique de caisses, ajustement des pourcentages de drop en temps réel, activation/désactivation des jeux en un clic.
* **Support Client** : Lecture des tickets et envoi direct de réponses par mail dynamique depuis le panel.
* **Modération FAQ** : Ajout, modification, suppression et masquage (toggle) des questions.

## 🛠️ Stack Technique

* **Backend** : PHP 8+ (Architecture MVC / POO personnalisée)
* **Base de données** : PostgreSQL / MySQL (Accès sécurisé via PDO)
* **Frontend** : HTML5, TailwindCSS, DaisyUI, JavaScript (Vanilla, DOM manipulation, Fetch API)
* **Serveur** : Apache (URL Rewriting complet via `.htaccess`)

## ⚙️ Installation & Lancement

1. Clone le dépôt localement :
```bash
git clone https://github.com/ton-repo/gambling-io.git
```

2. Configure la base de données :
Importe le schéma SQL fourni dans ton SGBD (PostgreSQL ou MySQL).

3. Paramètre l'environnement :
Vérifie le fichier `configuration/config.php` et mets à jour les identifiants de connexion PDO ainsi que la constante `BASE_URL` pour qu'elle pointe vers ton répertoire local ou universitaire.

```php
<?php
define('BASE_URL', 'https://pedago.univ-avignon.fr/~uapvXXXXXXX/');
// Constantes DB...
```

4. Configuration Serveur :
Assure-toi que le module `mod_rewrite` est activé sur ton serveur Apache. Sans cela, le `.htaccess` ne pourra pas traiter les URL propres (ex: `/admin/jeux/proba/1`).

## 🛡️ Sécurité Implémentée
* Génération et vérification de **Tokens CSRF** sur l'intégralité des formulaires (Front et Back).
* Utilisation exclusive de **requêtes préparées PDO** pour contrer les injections SQL.
* Routage sécurisé empêchant l'accès direct aux fichiers PHP d'action.
* Protection des données sensibles via `password_hash()` et `password_verify()`.
* Séparation stricte des sessions Admin et User.

## 📚 Documentation
* Le code source PHP (Classes, Interfaces, Méthodes et Contrôleurs) est intégralement documenté selon les standards **PHPDoc**.
* L'arborescence est indexée via `sitemap.xml` à la racine pour le SEO.
