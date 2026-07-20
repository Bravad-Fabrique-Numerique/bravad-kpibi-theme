<?php
/**
 * Champs ACF de la page À propos.
 * Enregistrés en PHP : aucune création manuelle de champ requise.
 * Les titres ont une LIMITE DE CARACTÈRES (maxlength) pour ne pas casser la mise en page.
 *
 * La grille des valeurs utilise un champ repeater (ACF Pro) pour permettre
 * un nombre variable de cartes, éditable sans intervention technique.
 *
 * @package KPIBI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'kpibi_register_apropos_fields' );

function kpibi_register_apropos_fields() {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// Helpers de construction de champs (définis globalement dans functions.php,
	// partagés par tous les fichiers inc/acf-fields-*.php).
	$txt  = 'kpibi_field_text';
	$area = 'kpibi_field_area';
	$tab  = 'kpibi_field_tab';
	$img  = 'kpibi_field_image';

	$fields = array();

	// ----- BANNIÈRE -----
	$fields[] = $tab( 'apropos_hero', 'Bannière (hero)' );
	$fields[] = $img( 'apropos_hero_image', 'Image de fond de la bannière' );
	$fields[] = $txt( 'apropos_hero_label', 'Sur-titre', 'Notre firme · Québec', 40 );
	$fields[] = $txt( 'apropos_hero_titre', 'Titre — début', 'Derrière KPIBI,', 40 );
	$fields[] = $txt( 'apropos_hero_titre_fort', 'Titre — partie forte', 'il y a une conviction simple.', 45 );
	$fields[] = $area( 'apropos_hero_sub', 'Sous-titre', "Les résultats d'une organisation dépendent d'abord de la qualité de ses systèmes — pas de l'effort individuel. Toute notre approche en découle.", 220 );
	$fields[] = $txt( 'apropos_hero_cta1_texte', 'Bouton 1 — texte', 'Planifier une consultation gratuite', 50 );
	$fields[] = $txt( 'apropos_hero_cta1_url', 'Bouton 1 — lien', '#cta' );
	$fields[] = $txt( 'apropos_hero_cta2_texte', 'Bouton 2 — texte', 'Voir notre forfait', 30 );
	$fields[] = $txt( 'apropos_hero_cta2_url', 'Bouton 2 — lien', 'forfait.html' );

	// ----- FONDATEUR -----
	$fields[] = $tab( 'fondateur', 'Fondateur' );
	$fields[] = $img( 'fondateur_image', 'Photo du fondateur' );
	$fields[] = $txt( 'fondateur_image_alt', 'Photo — texte alternatif', 'Phil Bexton, fondateur et président de KPIBI', 90 );
	$fields[] = $txt( 'fondateur_label', 'Sur-titre', 'Le fondateur', 40 );
	$fields[] = $txt( 'fondateur_titre', 'Titre — début', 'Phil Bexton,', 30 );
	$fields[] = $txt( 'fondateur_titre_fort', 'Titre — partie forte', 'fondateur et président', 35 );
	$fields[] = $area( 'fondateur_texte1', 'Paragraphe 1', 'Phil Bexton est le fondateur et président de KPIBI. Depuis plus de 15 ans, il aide les organisations à simplifier leurs opérations, améliorer leur visibilité et concevoir des environnements où la performance devient le résultat naturel du système.', 420 );
	$fields[] = $area( 'fondateur_texte2', 'Paragraphe 2', "Son parcours couvre les deux solitudes de l'amélioration organisationnelle : la stratégie et l'exécution. Il a dirigé des initiatives touchant les opérations, la finance, les ressources humaines, les ventes, l'administration et la logistique. Ancien pionnier de l'intelligence d'affaires chez Bombardier Aéronautique, puis cadre supérieur dans les secteurs public et privé, il combine une expertise en Lean Six Sigma, en architecture d'entreprise et en technologies d'affaires pour transformer des objectifs stratégiques en résultats concrets.", 620 );
	$fields[] = $area( 'fondateur_texte3', 'Paragraphe 3', "KPIBI est née d'un constat répété : trop d'organisations investissent dans des outils ou des conseils qui ne changent rien sur le terrain. Pas parce que les gens manquent de volonté, mais parce que le système n'est pas conçu pour les soutenir. Cette conviction guide chacune des interventions de KPIBI.", 420 );

	// ----- MISSION & PHILOSOPHIE -----
	$fields[] = $tab( 'mission', 'Mission & philosophie' );
	$fields[] = $txt( 'mission_label', 'Sur-titre — mission', 'Notre mission', 40 );
	$fields[] = $txt( 'mission_titre', 'Mission — titre début', 'Rendre la performance', 40 );
	$fields[] = $txt( 'mission_titre_fort', 'Mission — titre fort', 'naturelle', 25 );
	$fields[] = $area( 'mission_texte', 'Mission — texte', "Notre mission est de concevoir des systèmes de travail où les processus, les outils, les indicateurs et l'environnement opérationnel rendent la performance naturelle.", 260 );
	$fields[] = $txt( 'philosophie_label', 'Sur-titre — philosophie', 'Notre philosophie', 40 );
	$fields[] = $txt( 'philosophie_titre', 'Philosophie — titre début', 'La qualité du système', 40 );
	$fields[] = $txt( 'philosophie_titre_fort', 'Philosophie — titre fort', "avant l'effort individuel", 40 );
	$fields[] = $area( 'philosophie_texte', 'Philosophie — texte', "Nous croyons que les résultats d'une organisation sont principalement déterminés par la qualité de ses systèmes plutôt que par l'effort individuel. Lorsque les processus, les outils et l'environnement de travail sont bien conçus, les bonnes décisions deviennent plus faciles, les erreurs diminuent et la performance émerge naturellement.", 420 );

	// ----- VALEURS -----
	$fields[] = $tab( 'valeurs', 'Nos valeurs' );
	$fields[] = $txt( 'valeurs_label', 'Sur-titre', 'Nos valeurs', 40 );
	$fields[] = $txt( 'valeurs_titre', 'Titre — début', 'Ce qui guide', 30 );
	$fields[] = $txt( 'valeurs_titre_fort', 'Titre — partie forte', 'chacune de nos interventions', 45 );
	$fields[] = array(
		'key'          => 'field_kpibi_valeurs',
		'label'        => 'Cartes de valeurs',
		'name'         => 'valeurs',
		'type'         => 'repeater',
		'instructions' => "Une carte par valeur. Laisser l'icône vide pour reprendre une icône par défaut.",
		'layout'       => 'block',
		'button_label' => 'Ajouter une valeur',
		'min'          => 0,
		'sub_fields'   => array(
			$txt( 'titre', 'Titre', '', 45 ),
			$area( 'texte', 'Texte', '', 220 ),
			array(
				'key'           => 'field_kpibi_valeur_icone',
				'label'         => 'Icône',
				'name'          => 'icone',
				'type'          => 'select',
				'choices'       => kpibi_icon_choices(),
				'default_value' => 'cible',
				'ui'            => 1,
				'allow_null'    => 1,
				'return_format' => 'value',
				'instructions'  => 'Choisissez une icône (laisser vide = icône par défaut).',
			),
		),
	);

	// ----- STATISTIQUES -----
	$fields[] = $tab( 'apropos_stats', 'Statistiques' );
	$fields[] = $txt( 'apropos_stat1_num', 'Stat 1 — nombre', '15+', 12 );
	$fields[] = $txt( 'apropos_stat1_label', 'Stat 1 — libellé', "Ans d'expérience terrain", 40 );
	$fields[] = $txt( 'apropos_stat2_num', 'Stat 2 — nombre', '3 000+', 12 );
	$fields[] = $txt( 'apropos_stat2_label', 'Stat 2 — libellé', 'Opérations automatisées chaque jour', 45 );
	$fields[] = $txt( 'apropos_stat3_num', 'Stat 3 — nombre', '6', 12 );
	$fields[] = $txt( 'apropos_stat3_label', 'Stat 3 — libellé', "Axes transversaux d'intervention", 45 );
	$fields[] = $area( 'apropos_stats_texte', 'Texte sous les statistiques — début', 'Opérations, Finance, RH, Ventes, TI, Gouvernance et gestion des risques — soutenus par', 160 );
	$fields[] = $txt( 'apropos_stats_texte_fort', 'Texte sous les statistiques — partie forte', "3 piliers d'expertise combinés", 45 );
	$fields[] = $txt( 'apropos_stats_texte_fin', 'Texte sous les statistiques — fin', ': Stratégie · Architecture · Exécution.', 60 );

	// ----- NOTRE FORCE -----
	$fields[] = $tab( 'force', 'Notre force' );
	$fields[] = $img( 'force_image', 'Image de la section' );
	$fields[] = $txt( 'force_label', 'Sur-titre', 'Notre force', 40 );
	$fields[] = $txt( 'force_titre', 'Titre — début', 'Une expertise ancrée dans la', 40 );
	$fields[] = $txt( 'force_titre_fort', 'Titre — partie forte', 'réalité terrain', 30 );
	$fields[] = $area( 'force_texte1', 'Paragraphe 1', "La différence entre une solution qui fonctionne sur papier et une qui fonctionne sur le terrain, c'est la connaissance de ce terrain. C'est pourquoi nous nous entourons de professionnels ayant eux-mêmes conçu, implanté et optimisé des processus, des systèmes et des outils qui ont généré des gains de performance concrets et mesurables.", 420 );
	$fields[] = $area( 'force_texte2', 'Paragraphe 2', "Qu'il s'agisse d'opérations, de finance, d'ingénierie, de logistique, de ressources humaines, de technologies ou de gestion des risques, nous privilégions une compréhension profonde des réalités quotidiennes des organisations. Nous combinons cette expérience pratique à une solide expertise des technologies d'affaires afin de transformer les défis en leviers de performance.", 420 );
	$fields[] = $txt( 'force_texte3_fort', 'Paragraphe 3 — partie forte', 'Notre force :', 20 );
	$fields[] = $area( 'force_texte3', 'Paragraphe 3 — texte', "comprendre à la fois où l'organisation veut aller et ce qui se passe vraiment sur le plancher. C'est ce qui nous permet de livrer des résultats tangibles, rapidement visibles et durables.", 260 );

	// ----- CTA -----
	$fields[] = $tab( 'apropos_cta', "Appel à l'action" );
	$fields[] = $txt( 'apropos_cta_label', 'Sur-titre', 'Première étape', 40 );
	$fields[] = $txt( 'apropos_cta_titre', 'Titre — début', 'Parlons de', 30 );
	$fields[] = $txt( 'apropos_cta_titre_fort', 'Titre — partie forte', 'votre réalité.', 30 );
	$fields[] = $area( 'apropos_cta_texte', 'Texte', 'Chaque organisation est différente. Prenons le temps de discuter de votre réalité, de vos priorités et des leviers qui pourraient créer le plus de valeur pour votre équipe.', 280 );
	$fields[] = $txt( 'apropos_cta_btn_texte', 'Bouton — texte', 'Planifier une consultation gratuite — sans engagement', 60 );
	$fields[] = $txt( 'apropos_cta_btn_url', 'Bouton — lien', 'mailto:' . get_theme_mod( 'kpibi_email', 'info@kpibi.com' ) );
	$fields[] = $area( 'apropos_cta_garantie', 'Ligne de garantie', "Vous repartirez avec une feuille de route claire, les premiers leviers d'amélioration identifiés et une analyse comparative financière de votre industrie.", 200 );

	acf_add_local_field_group(
		array(
			'key'             => 'group_kpibi_apropos',
			'title'           => 'Page à propos KPIBI',
			'fields'          => $fields,
			'location'        => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'template-a-propos.php',
					),
				),
			),
			'menu_order'      => 0,
			'position'        => 'normal',
			'style'           => 'default',
			'label_placement' => 'top',
			'active'          => true,
			'description'     => 'Contenu éditable de la page à propos.',
		)
	);
}
