# KPIBI — thème WordPress — conventions

Thème WordPress sur mesure (Bravad pour KPIBI, PME de conseil BI/automatisation au Québec, fondateur Phil Bexton). Contexte produit et historique complet dans Confluence, espace **KPIBI** (clé `KP`). Backlog et suivi dans Jira, projet **BRAV**, label `KPIBI` (stories `S1`, `S2`, ... — voir section Workflow ci-dessous).

## Stack

- WordPress 6.0+, PHP classique (pas de build step, pas de Gutenberg pour les gabarits personnalisés).
- ACF (Advanced Custom Fields) — champs enregistrés en **PHP** (`acf_add_local_field_group`), pas via l'admin. Choix délibéré : versionné dans Git, déploiement fiable entre environnements (local/dev/prod), pas de risque de modification accidentelle par un client dans l'admin. Ne pas proposer de migrer vers une config admin sans validation explicite.
- Polices : Dubai (titres) + Manrope (corps), chargées via Google Fonts dans `functions.php`.
- CSS : un seul fichier `assets/css/style.css`, pas de SCSS/build step à ce jour (voir story `S14` si ça change).
- JS : `assets/js/main.js`, vanilla (menu mobile, dropdowns, animations au scroll).

## Structure des fichiers

- `functions.php` — setup du thème, enqueue des assets, helpers i18n (`kpibi__()`), en-têtes de sécurité.
- `inc/acf-fields-*.php` — un fichier par groupe de champs ACF, nommé par section (`acf-fields-forfait.php`, `acf-fields-a-propos.php`, etc.).
- `inc/cpt-cas-clients.php` — déclaration du Custom Post Type `cas_client`.
- `inc/customizer.php` — options du Personnalisateur (coordonnées, réseaux sociaux, pied de page).
- `inc/nav-walkers.php` — walker de menu personnalisé (dropdowns).
- `template-*.php` — un gabarit de page par section du site (service, forfait, à propos, cas-clients). Chaque gabarit lit ses propres champs ACF.
- `single-cas_client.php` — gabarit d'affichage individuel du CPT cas client.

## Règle anti-collision des champs ACF

Une convention de préfixage par section est en place pour éviter les collisions de noms de champs entre groupes ACF (ex. champs du forfait préfixés différemment des champs services). **Toujours vérifier le préfixe existant dans le fichier `inc/acf-fields-*.php` concerné avant d'ajouter un nouveau champ**, plutôt que de réutiliser un nom générique.

## Règle grille de cartes — classe `cols3`

Quand une grille de cartes/tuiles peut avoir un nombre variable d'éléments (ACF repeater ou tableau PHP) :

- **≤ 4 cartes** : une seule rangée, les cartes s'adaptent en taille (comportement par défaut de `.steps-grid`, grid `auto-fit`).
- **> 4 cartes** : rangées de 3 maximum, cartes de **taille fixe identique** (`flex: 0 0 340px`), centrées avec `justify-content: center` — même une rangée incomplète (ex. 5 cartes → 3+2, les 2 restantes centrées, pas agrandies).

Implémentation : classe CSS `.steps-grid.cols3` dans `style.css` + logique PHP `count($items) > 4 ? 'steps-grid cols3' : 'steps-grid'` dans le gabarit. Ne **jamais** utiliser `flex: 1 1 Npx` (grow activé) pour ce pattern — ça fait grossir les cartes d'une rangée incomplète, ce qui a été explicitement rejeté par le client.

## Pièges déjà rencontrés (à ne pas répéter)

- **Ne pas réutiliser une balise sémantique HTML (`<footer>`, `<header>`, etc.) pour un bloc de contenu local** (ex. attribution de citation) — elle hérite du style global de cette balise (ex. `footer { background: #050505; }` du thème), causant des bugs visuels difficiles à diagnostiquer. Utiliser une classe dédiée sur un `<p>`/`<div>` neutre.
- Un champ ACF vide (`hero`/`cta` non rempli dans wp-admin) retombe sur le `default_value` du champ — si plusieurs gabarits partagent un champ avec le même défaut, ils afficheront le même texte générique tant que le contenu réel n'est pas saisi. Ce n'est pas un bug de code (voir story `S3`).
- Après création d'un nouveau CPT, faire un flush des permaliens (visiter Réglages > Permaliens et enregistrer, ou `flush_rewrite_rules()`), sinon les URLs individuelles renvoient une 404.

## i18n / bilingue

Le thème utilise un helper `kpibi__()` (dans `functions.php`) pour les chaînes d'interface, en plus de Polylang pour le contenu éditorial. Toute nouvelle chaîne visible à l'écran doit passer par ce helper, pas être codée en dur.

### ⚠️ La convention est en DEUX temps — c'est la cause racine de plusieurs bogues

Ajouter une chaîne d'interface demande **deux gestes**, et n'en faire qu'un échoue **silencieusement** :

1. **Enregistrer** la source française dans `kpibi_register_strings()` (`functions.php`).
2. **Appeler** `kpibi__( 'La source française' )` dans le gabarit.

Puis, en CMS : saisir la traduction anglaise dans **Langues > Traductions**. Aucune API ne permet de la poser depuis le code — une story i18n n'est donc **jamais fermée par un commit seul**.

**Les deux façons de se tromper, toutes deux vécues :**

- *Appeler sans enregistrer* — la chaîne paraît traduisible et ne l'est pas. Elle n'apparaît pas dans Langues > Traductions, et la page anglaise sert le texte français. C'est le défaut corrigé par `KPIBI-31` (10 chaînes), introduit par `KPIBI-8`.
- *Contourner le helper* — un ternaire sur `pll_current_language()` affiche la bonne langue mais échappe au CMS : le client ne peut plus corriger le texte. C'est le défaut corrigé par `KPIBI-33`.

**L'appariement se fait sur la chaîne EXACTE**, octet pour octet. Une espace insécable, un guillemet `«` au lieu de `"`, une apostrophe typographique au lieu d'une droite, et Polylang ne fait pas le lien — sans erreur, sans avertissement. Ne **jamais retaper** une chaîne pour l'enregistrer : l'extraire du gabarit (le tokenizer PHP `token_get_all()` est fiable pour ça), et prouver l'appariement par comparaison stricte des deux ensembles — enregistrées vs appelées — plutôt que par relecture.

**Contrôle utile avant de conclure une story i18n :** l'ensemble des chaînes enregistrées et celui des chaînes appelées doivent être **identiques dans les deux sens**. Une chaîne enregistrée mais jamais appelée est une entrée morte qui encombre l'écran des traductions.

**Exceptions légitimes à `pll_current_language()`** — ne pas les « corriger » :

- `footer.php` — choisir l'identifiant du formulaire Contact Form 7 selon la langue (`b8cc433` en FR, `39e9e84` en EN). Ce n'est pas du texte.
- `functions.php`, `kpibi_link()` — suivre la traduction d'une page.

## Sécurité — connu et à corriger avant prod

Voir les stories `S4` à `S8` (label `KPIBI`, projet BRAV) : désactivation de l'éditeur de fichiers WP, retrait du plugin d'injection PHP WPCode, vérification des permaliens, attributs ALT, optimisation des images. Ne pas considérer le thème comme prêt pour la mise en production tant que ces points ne sont pas fermés.

## Workflow Git / Jira

- Dépôt : `Bravad-Fabrique-Numerique/bravad-kpibi-theme` sur GitHub, branche `main`.
- Convention reprise du projet interne **BravadOS** : le backlog vit dans Jira (projet `BRAV`, label `KPIBI`), chaque story est numérotée `S1`, `S2`, ... et sa description (format `**En tant que**/**je veux**/**afin que**` + `**Critères d'acceptation :**`) sert **directement** de prompt pour Claude Code dans VS Code — pas de section « prompt » séparée à rédiger.
- Où trouver quoi : backlog/stories → Jira (BRAV) ; conventions de code/état du projet → ce fichier ; architecture/décisions/roadmap → Confluence (espace KPIBI).
