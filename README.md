# feedbot

**Recommandations :**<br />
Les taches crons s'excecutant en PHP, je recommande d'installer Feedbot sur un VPS disposant de deux coeurs afin d'éviter des ralentissements lors de la navigation.<br />

**Dépendances / Dependencies :**<br />
php{version}-xml<br />
php{version}-curl<br />
php{version}-mysql<br />
php{version}-gd<br />

**Ajouter le bouton Telegram dans les paramètres utilisateur :**<br />
https://core.telegram.org/widgets/login<br />
Choisir "Redirect to URL", à faire pointer vers : https://votredomaine.tld/includes/telegram.php<br />
Ajouter le script dans la variable $telegram_bot dans le fichier config.php<br />

**Sources :**<br />
MastoPHP : https://github.com/StefOfficiel/MastoPHP<br />
Sidebar : https://www.codinglabweb.com/2021/04/responsive-side-navigation-bar-in-html.html<br />
AmplitudeJS (Audio Player) : https://github.com/521dimensions/amplitudejs
