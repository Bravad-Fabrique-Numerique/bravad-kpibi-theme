<?php
/**
 * Champs ACF propres aux 2 pages de services qui ont des sections uniques
 * en plus des sections communes (Applications, Automatisation).
 *
 * Ces deux pages utilisent chacune leur propre gabarit :
 * - template-service-applications.php
 * - template-service-automatisation.php
 *
 * Les sections communes (bannière, approche, étapes, pour qui, bénéfices, cta)
 * restent gérées par le SEUL groupe ACF « Page service KPIBI »
 * (inc/acf-fields-services.php, clé group_kpibi_service) — ce fichier ne les
 * redéfinit pas. Ce groupe commun a simplement été élargi (règles « location »
 * en OR) pour s'afficher aussi sur les gabarits template-service-applications.php
 * et template-service-automatisation.php, en plus de template-service.php.
 * Ce fichier-ci ajoute seulement 2 NOUVEAUX groupes ACF, un par gabarit dédié,
 * pour les sections UNIQUES qui n'existent pas sur les autres pages service.
 *
 * IMPORTANT — anti-collision : tous les nouveaux champs propres aux sections
 * uniques sont préfixés `svcapp_` (Applications) et `svcauto_` (Automatisation).
 * Vérifié le 2026-07-01 : ces préfixes n'existent nulle part ailleurs dans
 * inc/acf-fields*.php (les autres fichiers utilisent apropos_, forfait_,
 * fondateur_, mission_, philosophie_, valeurs_, force_, service_, approche_,
 * etapes_, pourqui_, benefits_, cas_, banniere_, blogue_ — aucun chevauchement).
 *
 * @package KPIBI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'kpibi_register_service_extra_fields' );

function kpibi_register_service_extra_fields() {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// Helpers de construction de champs (définis globalement dans functions.php).
	$txt  = 'kpibi_field_text';
	$area = 'kpibi_field_area';
	$tab  = 'kpibi_field_tab';
	$img  = 'kpibi_field_image';

	/* ==========================================================
	 * GROUPE 1 — Sections uniques de la page « Applications »
	 * ========================================================== */
	$fields_app = array();

	// ----- Section split « Pourquoi des applications sur mesure? » -----
	$fields_app[] = $tab( 'svcapp_pourquoi', 'Pourquoi sur mesure (section unique)' );
	$fields_app[] = $img( 'svcapp_pourquoi_image', 'Image' );
	$fields_app[] = $txt( 'svcapp_pourquoi_label', 'Sur-titre', 'Pourquoi sur mesure?', 45 );
	$fields_app[] = $txt( 'svcapp_pourquoi_titre', 'Titre — début', 'Pourquoi des applications', 45 );
	$fields_app[] = $txt( 'svcapp_pourquoi_titre_fort', 'Titre — partie en or', 'sur mesure?', 30 );
	$fields_app[] = $area( 'svcapp_pourquoi_texte1', 'Paragraphe 1', "La plupart des entreprises finissent par tordre leurs processus pour les faire entrer dans un logiciel générique conçu pour des milliers d'autres compagnies.", 320 );
	$fields_app[] = $area( 'svcapp_pourquoi_texte2', 'Paragraphe 2', 'Résultat : Excel parallèles, doubles saisies, contournements, perte d\'information, frustration et manque de visibilité.', 260 );
	$fields_app[] = $txt( 'svcapp_pourquoi_texte3_debut', 'Paragraphe 3 — début', "Chez KPIBI, on fait l'inverse. Nous créons des applications taillées sur mesure pour vos processus, vos équipes et vos objectifs. L'idée n'est pas d'ajouter de la technologie pour le plaisir, mais de concevoir un système qui", 320 );
	$fields_app[] = $txt( 'svcapp_pourquoi_texte3_fort', 'Paragraphe 3 — partie en or', 'rend la performance naturelle.', 40 );

	// ----- Grille « Types d'applications que nous développons » -----
	$fields_app[] = $tab( 'svcapp_tuiles', 'Grille des 6 tuiles (section unique)' );
	$fields_app[] = $txt( 'svcapp_tuiles_label', 'Sur-titre', 'Ce que nous développons', 45 );
	$fields_app[] = $txt( 'svcapp_tuiles_titre', 'Titre — début', 'Types d\'applications que', 40 );
	$fields_app[] = $txt( 'svcapp_tuiles_titre_fort', 'Titre — partie en or', 'nous développons', 30 );
	$fields_app[] = $area( 'svcapp_tuiles_intro', 'Intro', "Nous développons principalement des applications qui touchent le cœur des opérations. Si vous gérez encore ce processus dans Excel, c'est probablement un bon candidat.", 260 );

	$kpibi_svcapp_sub_titre        = $txt( 'titre', 'Titre', '', 60 );
	$kpibi_svcapp_sub_titre['key'] = 'field_kpibi_svcapp_tuile_titre';
	$kpibi_svcapp_sub_texte        = $area( 'texte', 'Texte', '', 200 );
	$kpibi_svcapp_sub_texte['key'] = 'field_kpibi_svcapp_tuile_texte';
	$kpibi_svcapp_sub_icone = array(
		'key'           => 'field_kpibi_svcapp_tuile_icone',
		'label'         => 'Icône',
		'name'          => 'icone',
		'type'          => 'select',
		'choices'       => kpibi_icon_choices(),
		'default_value' => 'application',
		'ui'            => 1,
		'allow_null'    => 1,
		'return_format' => 'value',
		'instructions'  => 'Choisissez une icône (vide = icône par défaut).',
	);
	$fields_app[] = array(
		'key'          => 'field_kpibi_svcapp_tuiles',
		'label'        => 'Tuiles (6 attendues)',
		'name'         => 'svcapp_tuiles',
		'type'         => 'repeater',
		'instructions' => "Les 6 tuiles de la grille « Types d'applications que nous développons ». Le nombre a été validé à 6 par le client — conservez ce nombre.",
		'layout'       => 'block',
		'button_label' => 'Ajouter une tuile',
		'sub_fields'   => array(
			$kpibi_svcapp_sub_titre,
			$kpibi_svcapp_sub_texte,
			$kpibi_svcapp_sub_icone,
		),
	);

	acf_add_local_field_group(
		array(
			'key'             => 'group_kpibi_service_applications_unique',
			'title'           => 'Page service — Applications (sections uniques)',
			'fields'          => $fields_app,
			'location'        => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'template-service-applications.php',
					),
				),
			),
			'menu_order'      => 1,
			'position'        => 'normal',
			'style'           => 'default',
			'label_placement' => 'top',
			'active'          => true,
			'description'     => "Contenu éditable des 2 sections propres à la page Applications (pas partagées avec les autres pages service) : le split « pourquoi sur mesure » et la grille des 6 tuiles. Valeurs par défaut = contenu de service-applications.html.",
		)
	);

	/* ==========================================================
	 * GROUPE 2 — Sections uniques de la page « Automatisation »
	 * ========================================================== */
	$fields_auto = array();

	// ----- Section split 1 : « L'automatisation commence là où la valeur ajoutée s'arrête » -----
	$fields_auto[] = $tab( 'svcauto_depart', 'Point de départ (section unique 1)' );
	$fields_auto[] = $img( 'svcauto_depart_image', 'Image' );
	$fields_auto[] = $txt( 'svcauto_depart_label', 'Sur-titre', 'Le point de départ', 40 );
	$fields_auto[] = $txt( 'svcauto_depart_titre', 'Titre — début', "L'automatisation commence là où la", 55 );
	$fields_auto[] = $txt( 'svcauto_depart_titre_fort', 'Titre — partie en or', 'valeur ajoutée s\'arrête', 35 );
	$fields_auto[] = $area( 'svcauto_depart_texte1', 'Paragraphe 1', "Combien d'heures votre équipe passe-t-elle cette semaine à copier des données d'un système à l'autre? La plupart des entreprises perdent un temps fou sur des tâches répétitives qui n'apportent aucune valeur réelle : doubles saisies, validations manuelles, transferts de données, rapports, suivis, etc.", 400 );
	$fields_auto[] = $area( 'svcauto_depart_texte2', 'Paragraphe 2', "Chez KPIBI, nous ne nous contentons pas d'automatiser pour automatiser. Nous commençons par simplifier et standardiser les processus, puis nous automatisons tout ce qui n'apporte pas de valeur ajoutée. Résultat : vos équipes se concentrent enfin sur ce qui compte vraiment, les clients, les décisions et la croissance.", 400 );
	$fields_auto[] = $txt( 'svcauto_depart_texte3_fort', 'Paragraphe 3 — partie en or', "L'objectif est clair :", 30 );
	$fields_auto[] = $area( 'svcauto_depart_texte3_fin', 'Paragraphe 3 — fin', 'augmenter votre capacité, réduire vos coûts et améliorer votre prévisibilité, sans devoir embaucher proportionnellement.', 220 );

	// ----- Grille « Ce que nous automatisons » -----
	$fields_auto[] = $tab( 'svcauto_tuiles', 'Grille des 6 tuiles (section unique)' );
	$fields_auto[] = $txt( 'svcauto_tuiles_label', 'Sur-titre', 'Notre champ d\'action', 40 );
	$fields_auto[] = $txt( 'svcauto_tuiles_titre', 'Titre — début', 'Ce que nous', 30 );
	$fields_auto[] = $txt( 'svcauto_tuiles_titre_fort', 'Titre — partie en or', 'automatisons', 25 );
	$fields_auto[] = $area( 'svcauto_tuiles_intro', 'Intro', "Des processus complets, orchestrés de bout en bout, dans votre environnement existant.", 200 );

	$kpibi_svcauto_sub_titre        = $txt( 'titre', 'Titre', '', 60 );
	$kpibi_svcauto_sub_titre['key'] = 'field_kpibi_svcauto_tuile_titre';
	$kpibi_svcauto_sub_texte        = $area( 'texte', 'Texte', '', 200 );
	$kpibi_svcauto_sub_texte['key'] = 'field_kpibi_svcauto_tuile_texte';
	$kpibi_svcauto_sub_icone = array(
		'key'           => 'field_kpibi_svcauto_tuile_icone',
		'label'         => 'Icône',
		'name'          => 'icone',
		'type'          => 'select',
		'choices'       => kpibi_icon_choices(),
		'default_value' => 'automatisation',
		'ui'            => 1,
		'allow_null'    => 1,
		'return_format' => 'value',
		'instructions'  => 'Choisissez une icône (vide = icône par défaut).',
	);
	$fields_auto[] = array(
		'key'          => 'field_kpibi_svcauto_tuiles',
		'label'        => 'Tuiles (6 attendues)',
		'name'         => 'svcauto_tuiles',
		'type'         => 'repeater',
		'instructions' => "Les 6 tuiles de la grille « Ce que nous automatisons ». Le nombre a été validé à 6 par le client — conservez ce nombre.",
		'layout'       => 'block',
		'button_label' => 'Ajouter une tuile',
		'sub_fields'   => array(
			$kpibi_svcauto_sub_titre,
			$kpibi_svcauto_sub_texte,
			$kpibi_svcauto_sub_icone,
		),
	);

	// ----- Section split 2 : « Une automatisation robuste et intégrée » -----
	$fields_auto[] = $tab( 'svcauto_techno', 'La technologie (section unique 2)' );
	$fields_auto[] = $img( 'svcauto_techno_image', 'Image' );
	$fields_auto[] = $txt( 'svcauto_techno_label', 'Sur-titre', 'La technologie', 30 );
	$fields_auto[] = $txt( 'svcauto_techno_titre', 'Titre — début', 'Une automatisation robuste et', 45 );
	$fields_auto[] = $txt( 'svcauto_techno_titre_fort', 'Titre — partie en or', 'intégrée', 20 );
	$fields_auto[] = $area( 'svcauto_techno_texte1', 'Paragraphe 1', "Nous utilisons principalement Microsoft Power Automate (cloud et RPA), Power Query pour l'automatisation et la transformation de données, ainsi que Power Apps et Azure.", 320 );
	$fields_auto[] = $area( 'svcauto_techno_texte2', 'Paragraphe 2', "Cette combinaison nous permet de créer des automatisations fiables qui s'intègrent parfaitement à votre environnement existant, même lorsque les systèmes ne communiquent pas nativement.", 320 );
	$fields_auto[] = $area( 'svcauto_techno_texte3', 'Paragraphe 3', "Nous ne choisissons pas la technologie la plus complexe. Nous choisissons celle qui fonctionne le mieux pour éliminer le travail sans valeur.", 260 );

	acf_add_local_field_group(
		array(
			'key'             => 'group_kpibi_service_automatisation_unique',
			'title'           => 'Page service — Automatisation (sections uniques)',
			'fields'          => $fields_auto,
			'location'        => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'template-service-automatisation.php',
					),
				),
			),
			'menu_order'      => 1,
			'position'        => 'normal',
			'style'           => 'default',
			'label_placement' => 'top',
			'active'          => true,
			'description'     => "Contenu éditable des 3 sections propres à la page Automatisation (pas partagées avec les autres pages service) : les 2 splits (« point de départ » et « la technologie ») et la grille des 6 tuiles. Valeurs par défaut = contenu de service-automatisation.html.",
		)
	);
}
