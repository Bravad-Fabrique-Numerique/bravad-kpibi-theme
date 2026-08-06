<?php
/**
 * Champs ACF des SECTIONS COMMUNES aux 4 pages de services
 * (Optimisation, Applications, Automatisation, Dashboards) :
 * bannière, approche, étapes, section « pour qui », bénéfices, cta.
 *
 * Optimisation et Dashboards utilisent le gabarit générique
 * template-service.php. Applications et Automatisation utilisent chacune
 * leur propre gabarit dédié (template-service-applications.php,
 * template-service-automatisation.php) car elles ont, en plus des sections
 * communes ci-dessous, des sections uniques supplémentaires (voir
 * inc/acf-fields-services-extra.php). Le groupe ACF de ce fichier est donc
 * rattaché aux 3 gabarits (règles « OR » dans son « location ») afin que les
 * mêmes champs communs (mêmes noms/clés) soient éditables partout. Les
 * valeurs par défaut reprennent le contenu de service-optimisation.html
 * (page de référence) — Phil devra remplacer le contenu dans wp-admin pour
 * les 3 autres pages (applications, automatisation, dashboards).
 *
 * Les listes de longueur variable (approche, étapes, bénéfices) sont des
 * champs repeater ACF Pro : le nombre d'items diffère d'une page à l'autre
 * (ex. 5 étapes pour Optimisation, 4 pour Applications et Automatisation,
 * 5 pour Dashboards ; 8 bénéfices pour Optimisation et Applications,
 * 8 pour Automatisation, 8 pour Dashboards).
 *
 * @package KPIBI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'kpibi_register_service_fields' );

function kpibi_register_service_fields() {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// Helpers de construction de champs (définis globalement dans functions.php,
	// partagés par tous les fichiers inc/acf-fields-*.php).
	$txt  = 'kpibi_field_text';
	$area = 'kpibi_field_area';
	$tab  = 'kpibi_field_tab';
	$img  = 'kpibi_field_image';
	$bool = 'kpibi_field_bool';

	$fields = array();

	// ----- BANNIÈRE -----
	// Note : les noms de champs sont préfixés « service_ » pour éviter toute
	// collision avec les champs « hero_* » / « cta_* » / « rapport_* » de la
	// page d'accueil (inc/acf-fields.php). Deux groupes ACF utilisant le même
	// nom de champ génèrent aussi la même clé ACF (field_kpibi_{name}) et le
	// même meta_key en base — un vrai risque de contamination croisée entre
	// gabarits, qui s'est déjà produit une fois avant ce renommage.
	$fields[] = $tab( 'service_hero', 'Bannière' );
	$fields[] = $img( 'service_hero_image', 'Image de fond de la bannière' );
	$fields[] = $txt( 'service_hero_label', 'Sur-titre', "Amélioration des processus · Optimisation opérationnelle", 70 );
	$fields[] = $txt( 'service_hero_titre', 'Titre — début', 'Créer des systèmes où la', 45 );
	$fields[] = $txt( 'service_hero_titre_fort', 'Titre — partie en or', 'performance devient naturelle.', 45 );
	$fields[] = $area( 'service_hero_sub', 'Sous-titre', "Nous aidons les PME à simplifier, automatiser et mesurer leurs processus pour transformer la performance en résultat naturel du système — et non en effort constant.", 260 );
	$fields[] = $txt( 'service_hero_cta1_texte', 'Bouton 1 — texte', 'Consultation gratuite', 35 );
	$fields[] = $txt( 'service_hero_cta1_url', 'Bouton 1 — lien', '#cta' );
	$fields[] = $txt( 'service_hero_cta2_texte', 'Bouton 2 — texte', 'Voir le forfait', 35 );
	$fields[] = $txt( 'service_hero_cta2_url', 'Bouton 2 — lien', '' );

	// ----- APPROCHE -----
	//
	// Les interrupteurs `*_afficher` de ce groupe décident CÔTÉ SERVEUR si une
	// section est rendue (KPIBI-35). Ils remplacent un bloc JavaScript qui
	// masquait des sections après le rendu, selon l'identifiant de page : le
	// HTML était livré et indexé, et un flash de contenu précédait le masquage.
	//
	// Lecture au gabarit avec kpibi_f_bool(), JAMAIS kpibi_f() : celui-ci
	// laisse passer `false` et une case décochée resterait sans effet.
	$fields[] = $tab( 'service_approche', 'Approche' );
	$fields[] = $bool( 'approche_afficher', 'Afficher la section « Notre approche »', 1, "Décoché : la section entière disparaît du HTML, elle n'est plus livrée ni indexée." );
	$fields[] = $txt( 'approche_label', 'Sur-titre', 'Notre approche', 40 );
	$fields[] = $txt( 'approche_titre', 'Titre — début', 'Un système bien conçu crée', 45 );
	$fields[] = $txt( 'approche_titre_fort', 'Titre — partie en or', 'plus de performance', 40 );
	$fields[] = $txt( 'approche_titre_fin', 'Titre — fin (optionnel)', "qu'un effort supplémentaire", 40 );
	$fields[] = $area( 'approche_texte1', 'Paragraphe 1', 'Vos employés travaillent fort. Pourtant, les mêmes erreurs reviennent, les délais s\'accumulent et la croissance crée plus de friction qu\'elle n\'en résout.', 320 );
	$fields[] = $area( 'approche_texte2', 'Paragraphe 2', "Lorsqu'un problème survient, la réaction naturelle consiste souvent à ajouter de la formation, du contrôle ou des procédures. Notre approche est différente : nous cherchons d'abord à comprendre comment les processus, les outils, l'information et l'environnement de travail influencent les comportements et les résultats.", 420 );
	// Sans valeur par défaut (KPIBI-36, A2) : sur /en/process-optimization/, ce
	// paragraphe énumérait les cinq éléments de la frise affichée juste à côté.
	// Le champ est partagé par les trois gabarits service ; il doit donc pouvoir
	// être vidé PAGE PAR PAGE, d'où le retrait du défaut ici ET du second
	// argument de kpibi_f() dans les trois gabarits. Une page dont le champ est
	// rempli garde son texte ; seule une page au champ vide perd le paragraphe.
	$fields[] = $area( 'approche_texte3', 'Paragraphe 3', '', 220 );
	$fields[] = $txt( 'approche_btn_texte', 'Bouton — texte (optionnel)', 'Voir notre démarche', 35 );
	$fields[] = $txt( 'approche_btn_url', 'Bouton — lien', '#demarche' );

	// Colonne DROITE de la section approche : soit la frise numérotée +
	// l'encadré, soit une image de remplacement. Masquer la frise sans poser
	// d'image laissait la colonne vide et la grille à deux colonnes : le défaut
	// mesuré sur Tableaux de bord et Applications (hauteurs 563/0 et 535/0).
	// Le gabarit retombe alors sur une grille à une seule colonne
	// (`.split-inner.solo`), pour qu'aucune demi-grille vide ne subsiste.
	$fields[] = $bool( 'approche_frise_afficher', "Afficher la frise numérotée et l'encadré (colonne droite)", 1, "Décoché : la colonne droite affiche l'image ci-dessous. Sans image, la section passe sur une seule colonne." );
	$fields[] = $img( 'approche_image', 'Section approche : image de la colonne droite', "Ne sert QUE si la frise numérotée ci-dessus est masquée ; sans image, la section passe alors sur une seule colonne. Il n'y a pas d'emplacement gris de remplacement ici." );

	// Liste numérotée « approche » — nombre variable (repeater ACF Pro).
	// Note : la clé des sous-champs est redéfinie (sub_field_key) pour éviter
	// une collision avec les autres repeaters de ce groupe, qui utilisent
	// aussi des sous-champs nommés « titre » et « texte ».
	$kpibi_approche_sub_titre         = $txt( 'titre', 'Titre', '', 60 );
	$kpibi_approche_sub_titre['key']  = 'field_kpibi_approche_item_titre';
	$kpibi_approche_sub_texte         = $area( 'texte', 'Texte', '', 160 );
	$kpibi_approche_sub_texte['key']  = 'field_kpibi_approche_item_texte';
	$fields[] = array(
		'key'          => 'field_kpibi_approche_items',
		'label'        => "Liste numérotée — points d'approche",
		'name'         => 'approche_items',
		'type'         => 'repeater',
		'instructions' => "Les points affichés dans la colonne numérotée à droite de la section « Approche ». Le nombre de points peut varier d'une page service à l'autre (ex. 5 pour Optimisation).",
		'layout'       => 'block',
		'button_label' => 'Ajouter un point',
		'sub_fields'   => array(
			$kpibi_approche_sub_titre,
			$kpibi_approche_sub_texte,
		),
	);

	// Encart « rapport » (analyse comparative).
	$fields[] = $txt( 'service_rapport_titre', 'Encart — titre', 'Les fondations de la performance', 60 );
	$fields[] = $area( 'service_rapport_texte', 'Encart — texte', "L'automatisation d'un mauvais processus accélère rarement les bons résultats. C'est pourquoi nous intervenons dans cet ordre.", 200 );

	// ----- ÉTAPES -----
	$fields[] = $tab( 'service_etapes', 'Étapes' );
	$fields[] = $bool( 'etapes_afficher', 'Afficher la section « Ce qu\'on fait concrètement »', 1, "Décoché : la section entière disparaît du HTML, elle n'est plus livrée ni indexée." );
	$fields[] = $txt( 'etapes_label', 'Sur-titre', "Ce qu'on fait concrètement", 45 );
	$fields[] = $txt( 'etapes_titre', 'Titre — début', 'Faire en sorte que la performance devienne', 55 );
	$fields[] = $txt( 'etapes_titre_fort', 'Titre — partie en or', 'le résultat naturel du système', 45 );
	$fields[] = $area( 'etapes_intro', 'Intro', "On agit sur les vraies causes des frictions, puis on met en place les bons leviers — pas un effort de plus, mais un système qui travaille pour vous.", 260 );

	// Étapes numérotées — nombre variable (repeater ACF Pro).
	$kpibi_etapes_sub_titre        = $txt( 'titre', 'Titre', '', 55 );
	$kpibi_etapes_sub_titre['key'] = 'field_kpibi_etapes_item_titre';
	$kpibi_etapes_sub_texte        = $area( 'texte', 'Texte', '', 220 );
	$kpibi_etapes_sub_texte['key'] = 'field_kpibi_etapes_item_texte';
	$fields[] = array(
		'key'          => 'field_kpibi_etapes_items',
		'label'        => 'Étapes',
		'name'         => 'etapes_items',
		'type'         => 'repeater',
		'instructions' => "Les cartes numérotées (01, 02, 03…) de la section « démarche ». Le nombre d'étapes varie selon la page (4 ou 5 selon le service).",
		'layout'       => 'block',
		'button_label' => 'Ajouter une étape',
		'sub_fields'   => array(
			$kpibi_etapes_sub_titre,
			$kpibi_etapes_sub_texte,
		),
	);

	// ----- SECTION « POUR QUI » -----
	$fields[] = $tab( 'service_pourqui', 'Section « pour qui »' );
	// Les champs pourqui_* restent visibles en wp-admin même quand la section
	// est décochée : c'est la contrepartie assumée d'un interrupteur plutôt que
	// d'une suppression : le contenu est conservé et la section se rallume.
	$fields[] = $bool( 'pourqui_afficher', 'Afficher la section « Pour qui »', 1, "Décoché : la section entière disparaît du HTML, elle n'est plus livrée ni indexée." );
	$fields[] = $img( 'pourqui_image', 'Image' );
	$fields[] = $txt( 'pourqui_label', 'Sur-titre', 'Pour qui nous travaillons', 45 );
	$fields[] = $txt( 'pourqui_titre', 'Titre — début', 'Des dirigeants qui veulent', 40 );
	$fields[] = $txt( 'pourqui_titre_fort', 'Titre — partie en or', 'grandir sans alourdir', 35 );
	$fields[] = $area( 'pourqui_texte1', 'Paragraphe 1', 'Nous travaillons avec des dirigeants qui veulent augmenter leur capacité sans nécessairement embaucher, réduire leurs coûts opérationnels ou soutenir une croissance qui commence à créer plus de friction que de valeur.', 340 );
	$fields[] = $area( 'pourqui_texte2', 'Paragraphe 2', 'Nos clients viennent de secteurs très variés : fabrication, distribution, construction, services professionnels, santé, technologies, commerce de détail et secteur municipal. Ce qu\'ils ont en commun, c\'est que leur croissance ou leur complexité exige des processus et des systèmes mieux structurés.', 360 );

	// ----- BÉNÉFICES -----
	$fields[] = $tab( 'service_benefits', 'Bénéfices' );
	$fields[] = $txt( 'benefits_label', 'Sur-titre', 'Résultats types', 40 );
	$fields[] = $txt( 'benefits_titre', 'Titre — début', 'Ce que nos clients', 40 );
	$fields[] = $txt( 'benefits_titre_fort', 'Titre — partie en or', 'obtiennent réellement', 40 );
	$fields[] = $area( 'benefits_intro', 'Intro', 'Des gains concrets, mesurables et durables — pas des promesses, des systèmes qui livrent.', 160 );

	// Cartes bénéfices — nombre variable (repeater ACF Pro).
	$kpibi_benefits_sub_titre        = $txt( 'titre', 'Titre', '', 55 );
	$kpibi_benefits_sub_titre['key'] = 'field_kpibi_benefits_item_titre';
	$kpibi_benefits_sub_texte        = $area( 'texte', 'Texte', '', 200 );
	$kpibi_benefits_sub_texte['key'] = 'field_kpibi_benefits_item_texte';
	$kpibi_benefits_sub_icone        = array(
		'key'           => 'field_kpibi_benefits_item_icone',
		'label'         => 'Icône',
		'name'          => 'icone',
		'type'          => 'select',
		'choices'       => kpibi_icon_choices(),
		'default_value' => '',
		'ui'            => 1,
		'allow_null'    => 1,
		'return_format' => 'value',
		'instructions'  => 'Laisser vide = icône choisie automatiquement selon le titre.',
	);
	$fields[] = array(
		'key'          => 'field_kpibi_benefits_items',
		'label'        => 'Cartes bénéfices',
		'name'         => 'benefits_items',
		'type'         => 'repeater',
		'instructions' => "Les cartes de résultats affichées sur fond sombre. Le nombre de cartes varie selon la page (6 à 8 selon le service). Choisissez une icône par carte dans la liste.",
		'layout'       => 'block',
		'button_label' => 'Ajouter un bénéfice',
		'sub_fields'   => array(
			$kpibi_benefits_sub_titre,
			$kpibi_benefits_sub_texte,
			$kpibi_benefits_sub_icone,
		),
	);

	// ----- CTA -----
	$fields[] = $tab( 'service_cta', "Appel à l'action" );
	$fields[] = $txt( 'service_cta_label', 'Sur-titre', 'Et si la réponse était déjà là?', 45 );
	$fields[] = $txt( 'service_cta_titre', 'Titre — début', 'Votre prochain avantage concurrentiel se cache peut-être', 65 );
	$fields[] = $txt( 'service_cta_titre_fort', 'Titre — partie en or', 'déjà dans vos processus.', 40 );
	$fields[] = $area( 'service_cta_texte', 'Texte', 'Discutons de votre réalité et identifions ensemble les opportunités qui pourraient transformer votre performance.', 220 );
	$fields[] = $txt( 'service_cta_btn1_texte', 'Bouton 1 — texte', 'Planifier une consultation gratuite', 50 );
	$fields[] = $txt( 'service_cta_btn1_url', 'Bouton 1 — lien', 'mailto:' . get_theme_mod( 'kpibi_email', 'info@kpibi.com' ) );
	$fields[] = $txt( 'service_cta_btn2_texte', 'Bouton 2 — texte', 'Voir le forfait', 40 );
	$fields[] = $txt( 'service_cta_btn2_url', 'Bouton 2 — lien', '' );
	$fields[] = $txt( 'service_cta_garantie', 'Ligne de garantie', 'Sans engagement · Feuille de route claire · Analyse comparative de votre industrie', 110 );

	acf_add_local_field_group(
		array(
			'key'             => 'group_kpibi_service',
			'title'           => 'Page service KPIBI (sections communes)',
			'fields'          => $fields,
			// Groupes « OR » : ce groupe de champs communs (bannière, approche,
			// étapes, pour qui, bénéfices, cta) s'affiche pour les 3 gabarits de
			// service — le générique (Optimisation, Dashboards) ET les 2 gabarits
			// dédiés (Applications, Automatisation) qui ajoutent en plus leurs
			// propres sections uniques via inc/acf-fields-services-extra.php.
			'location'        => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'template-service.php',
					),
				),
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'template-service-applications.php',
					),
				),
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'template-service-automatisation.php',
					),
				),
			),
			'menu_order'      => 0,
			'position'        => 'normal',
			'style'           => 'default',
			'label_placement' => 'top',
			'active'          => true,
			'description'     => 'Contenu éditable des sections communes aux 4 pages de services (Optimisation, Applications, Automatisation, Dashboards) : bannière, approche, étapes, pour qui, bénéfices, cta. Valeurs par défaut = contenu de la page Optimisation. Les sections uniques à Applications et Automatisation sont gérées par des groupes ACF séparés (inc/acf-fields-services-extra.php).',
		)
	);
}
