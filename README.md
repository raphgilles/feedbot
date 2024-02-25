# Feedbot

**Installation :**<br />
Le dossier dans lequel se trouve le fichier "install.php" doit avoir les droits configurés en "777".<br />
Le dossier "/includes/mastophp" doit avoir les droits configurés en "777".<br />

**Dépendances / Dependencies :**<br />
php{version}-xml<br />
php{version}-curl<br />
php{version}-mysql<br />
php{version}-gd<br />

**Ajouter le bouton Telegram dans les paramètres utilisateur :**<br />
Pour créer un bot Telegram :<br />
https://korben.info/comment-creer-bot-telegram.html<br />
Renseignez l'API de votre bot dans le fichier config.php :<br />
$telegram_api = 'API_ICI';<br />
Rendez-vous ensuite sur cette page pour récupérer le script du bouton :<br />
https://core.telegram.org/widgets/login<br />
Choisir "Redirect to URL", à faire pointer vers : https://votredomaine.tld/includes/telegram.php<br />
Ajouter le script dans la variable $telegram_bot dans le fichier config.php<br />

**Recommandations :**<br />
Les taches crons s'excecutant en PHP, je recommande d'installer Feedbot sur un VPS disposant de deux coeurs afin d'éviter des ralentissements lors de la navigation.<br />

**Feedbot Manager :**<br />
Pour les hebergements mutualisés, vous pouvez ajouter votre instance dans le Feedbot Manager qui se chargera de l'automatisation :<br />
https://manager.feedbot.net<br />

**Logo :**<br />
Logo créé par Maous, sous licence CC BY-NC-ND 4.0 (https://creativecommons.org/licenses/by-nc-nd/4.0/)<br />
https://maous.fr/<br />

**Sources :**<br />
MastoPHP : https://github.com/StefOfficiel/MastoPHP<br />
Sidebar : https://www.codinglabweb.com/2021/04/responsive-side-navigation-bar-in-html.html<br />
AmplitudeJS (Audio Player) : https://github.com/521dimensions/amplitudejs
