# Thème KPIBI — guide d'installation

Thème WordPress sur mesure reprenant la maquette noir et or. La page d'accueil est entièrement éditable (titres avec limite de caractères, textes), le menu et les pages se gèrent nativement, et le lien LinkedIn se modifie dans le Personnalisateur.

## Prérequis

- Un site WordPress (version 6.0+) avec accès administrateur.
- L'extension **Advanced Custom Fields** (ACF) — la version **gratuite** suffit.

## Installation

1. **Installer ACF** : Extensions › Ajouter › chercher « Advanced Custom Fields » › Installer › Activer.
2. **Installer le thème** : compresser le dossier `kpibi` en `.zip` (ou utiliser le zip fourni), puis Apparence › Thèmes › Ajouter › Téléverser un thème › choisir le zip › Installer › **Activer**.
   - Alternative : copier le dossier `kpibi/` dans `wp-content/themes/` par FTP.
3. **Définir la page d'accueil** :
   - Pages › Ajouter : créer une page « Accueil » et la publier.
   - Réglages › Lecture : « Votre page d'accueil affiche » → **Une page statique** → Page d'accueil = « Accueil ».
   - Les champs de contenu apparaissent alors en bas de la page « Accueil » (onglets : Bannière, Statistiques, Piliers, etc.).

## Éditer le contenu

- **Page d'accueil** : modifier la page « Accueil ». Chaque section a ses champs. Les **titres ont une limite de caractères** : impossible de dépasser, donc la mise en page ne casse pas. Tant que les champs sont vides, le contenu d'origine s'affiche par défaut.
- **LinkedIn, courriel, texte du pied de page, copyright** : Apparence › Personnaliser › **KPIBI — Coordonnées & réseaux**.

## Menu et pages

- **Ajouter une page** : Pages › Ajouter. Elle utilise le gabarit générique (`page.php`) avec l'en-tête noir et or ; l'image mise en avant devient l'arrière-plan de la bannière.
- **Gérer le menu** : Apparence › Menus › créer un menu › cocher « Menu principal » comme emplacement.
  - Pour créer un **menu déroulant**, glisser des éléments légèrement vers la droite sous un élément parent (ils deviennent des sous-éléments).
  - Deux emplacements supplémentaires existent pour les colonnes du pied de page (« Pied de page — Colonne 1 / 2 »).

## À faire ensuite (hors page d'accueil)

La page d'accueil sert de **référence validée**. Les 8 autres pages (services, forfait, à propos, cas clients, blogue) peuvent ensuite être :

- soit rédigées dans l'éditeur via le gabarit générique `page.php` ;
- soit converties en gabarits dédiés avec leurs propres champs ACF (sections « étapes », « bénéfices », etc.), sur le même modèle que l'accueil.

Le blogue fonctionne nativement (`index.php` liste les articles en cartes).

## SEO

Installer **Rank Math** ou **Yoast SEO**. Les titres rédigés dans la maquette sont déjà optimisés.

## Images

Les images de la page d'accueil s'ajoutent depuis le CMS : modifier la page « Accueil » et téléverser les visuels dans les champs prévus (bannière, section « Pourquoi », image de chaque pilier). Tant qu'un champ est vide, un emplacement neutre tient la mise en page. Aucune image n'est livrée avec le thème (chargement allégé).
