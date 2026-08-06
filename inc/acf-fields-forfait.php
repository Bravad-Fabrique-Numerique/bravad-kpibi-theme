<?php
/**
 * Champs ACF de la page Forfait (partenariat KPIBI).
 * Enregistrés en PHP : aucune création manuelle de champ requise.
 *
 * Les valeurs par défaut reprennent le contenu de la maquette forfait.html.
 * La liste de FAQ (nombre d'items variable) utilise un champ repeater ACF Pro.
 *
 * @package KPIBI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'kpibi_register_forfait_fields' );

function kpibi_register_forfait_fields() {

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
	$fields[] = $tab( 'forfait_hero', 'Bannière' );
	$fields[] = $img( 'forfait_hero_image', 'Image de fond de la bannière' );
	$fields[] = $txt( 'forfait_hero_label', 'Sur-titre', 'Le modèle KPIBI · Partenariat', 60 );
	$fields[] = $txt( 'forfait_hero_titre', 'Titre — début', 'Vos priorités évoluent.', 40 );
	$fields[] = $txt( 'forfait_hero_titre_fort', 'Titre — partie en or', 'Vos solutions devraient évoluer aussi.', 55 );
	$fields[] = $area( 'forfait_hero_sub', 'Sous-titre', 'Avec KPIBI, nous concevons, opérons et faisons évoluer vos systèmes de performance.', 200 );
	$fields[] = $txt( 'forfait_hero_cta1_texte', 'Bouton 1 — texte', 'Planifier une consultation gratuite', 50 );
	$fields[] = $txt( 'forfait_hero_cta1_url', 'Bouton 1 — lien', '#cta' );
	$fields[] = $txt( 'forfait_hero_cta2_texte', 'Bouton 2 — texte', 'Voir nos réalisations', 40 );
	$fields[] = $txt( 'forfait_hero_cta2_url', 'Bouton 2 — lien', 'cas-clients.html' );

	// ----- LE PARTENARIAT (pourquoi cette approche + cycle 5 étapes + transparence) -----
	$fields[] = $tab( 'forfait_partenariat', 'Le partenariat' );

	$fields[] = $img( 'forfait_pourquoi_image', 'Section « pourquoi » — image' );
	$fields[] = $txt( 'forfait_pourquoi_badge_num', 'Badge — nombre', '15+', 12 );
	$fields[] = $txt( 'forfait_pourquoi_badge_label', 'Badge — libellé', "ans d'expérience terrain", 45 );
	$fields[] = $txt( 'forfait_pourquoi_label', 'Sur-titre', 'Le modèle', 40 );
	$fields[] = $txt( 'forfait_pourquoi_titre', 'Titre — début', 'Pourquoi cette', 30 );
	$fields[] = $txt( 'forfait_pourquoi_titre_fort', 'Titre — partie en or', 'approche', 25 );
	$fields[] = $txt( 'forfait_pourquoi_titre_fin', 'Titre — fin', '?', 10 );
	$fields[] = $area( 'forfait_pourquoi_texte1', 'Paragraphe 1', "Les besoins d'une organisation évoluent constamment. Les priorités changent, les processus se transforment et de nouveaux objectifs émergent. Un tableau de bord révèle une nouvelle opportunité. Une automatisation demande des ajustements. Une application doit suivre la réalité du terrain.", 340 );
	$fields[] = $area( 'forfait_pourquoi_texte2', 'Paragraphe 2', "Trop de projets génèrent des gains initiaux qui s'essoufflent quelques mois après leur déploiement. Le vrai défi n'est pas seulement l'implantation : c'est la capacité à maintenir, faire évoluer et améliorer les solutions pour qu'elles continuent de créer de la valeur.", 320 );
	$fields[] = $txt( 'forfait_pourquoi_texte3_debut', 'Paragraphe 3 — début', "C'est pourquoi KPIBI privilégie un", 45 );
	$fields[] = $txt( 'forfait_pourquoi_texte3_fort', 'Paragraphe 3 — partie en or', 'modèle de partenariat continu', 40 );
	$fields[] = $area( 'forfait_pourquoi_texte3_fin', 'Paragraphe 3 — fin', "plutôt qu'une approche traditionnelle par projet. Nous concevons, opérons et faisons évoluer vos systèmes de performance afin qu'ils génèrent de la valeur bien après leur mise en place.", 260 );

	$fields[] = $txt( 'forfait_compris_label', 'Cycle — sur-titre', 'Le partenariat', 40 );
	$fields[] = $txt( 'forfait_compris_titre', 'Cycle — titre — début', 'Ce que comprend un', 35 );
	$fields[] = $txt( 'forfait_compris_titre_fort', 'Cycle — titre — partie en or', 'partenariat KPIBI', 35 );
	$fields[] = $area( 'forfait_compris_intro', 'Cycle — intro', 'Un cycle continu qui transforme vos objectifs en systèmes performants — et qui les fait évoluer avec vous.', 160 );

	$kpibi_cycle_defaults = array(
		array( 'Comprendre', "Nous analysons vos processus, vos systèmes, vos données et vos objectifs afin d'identifier les opportunités ayant le plus grand potentiel de valeur." ),
		array( 'Concevoir', "Nous concevons les processus, indicateurs, automatisations et solutions nécessaires pour soutenir vos objectifs d'affaires." ),
		array( 'Implanter', "Nous développons et déployons les solutions retenues de manière progressive et priorisée selon la valeur d'affaires générée." ),
		array( 'Opérer', "Nous assurons le suivi des solutions afin d'en maintenir la stabilité, la fiabilité et la performance." ),
		array( 'Faire évoluer', "Nous continuons d'améliorer les solutions, dans le périmètre défini, à mesure que votre organisation évolue afin de maximiser leur impact." ),
	);
	foreach ( $kpibi_cycle_defaults as $i => $d ) {
		$n        = $i + 1;
		$fields[] = $txt( "forfait_cycle{$n}_titre", "Étape {$n} — titre", $d[0], 35 );
		$fields[] = $area( "forfait_cycle{$n}_texte", "Étape {$n} — texte", $d[1], 220 );
	}

	// ----- TRANSPARENCE -----
	$fields[] = $tab( 'forfait_transparence', 'Transparence' );
	$fields[] = $img( 'forfait_transparence_image', 'Image' );
	$fields[] = $txt( 'forfait_transparence_label', 'Sur-titre', 'Transparence', 40 );
	$fields[] = $txt( 'forfait_transparence_titre', 'Titre — début', 'Votre environnement. Vos licences.', 45 );
	$fields[] = $txt( 'forfait_transparence_titre_fort', 'Titre — partie en or', 'Vos solutions.', 25 );
	$fields[] = $area( 'forfait_transparence_texte1', 'Paragraphe 1', "Sauf exception, les solutions développées par KPIBI sont déployées directement dans vos environnements. Nous vous accompagnons dans la gestion de votre écosystème Microsoft — Power BI, Power Apps, Power Automate et Azure — pour concevoir une architecture simple, performante et adaptée à votre réalité.", 400 );
	$fields[] = $area( 'forfait_transparence_texte2', 'Paragraphe 2', "Cette approche vous offre une transparence complète sur les coûts, élimine les frais cachés et vous laisse le contrôle de votre environnement à long terme. Vous demeurez propriétaire de vos données, de vos solutions et de votre environnement, pendant que nous en assurons la conception, l'évolution et l'optimisation continue.", 420 );
	$fields[] = $txt( 'forfait_transparence_badge1', 'Badge 1', 'Transparence des coûts', 35 );
	$fields[] = $txt( 'forfait_transparence_badge2', 'Badge 2', 'Vous restez propriétaire', 35 );
	$fields[] = $txt( 'forfait_transparence_badge3', 'Badge 3', 'Aucune dépendance fournisseur', 40 );

	// ----- INVESTISSEMENT -----
	$fields[] = $tab( 'forfait_investissement', 'Investissement' );
	$fields[] = $txt( 'forfait_invest_label', 'Sur-titre', "L'investissement", 40 );
	$fields[] = $txt( 'forfait_invest_titre', 'Titre — début', 'Un investissement', 30 );
	$fields[] = $txt( 'forfait_invest_titre_fort', 'Titre — partie en or', 'orienté valeur', 30 );
	$fields[] = $area( 'forfait_invest_texte', 'Texte d\'intro', "Les gains que nous observons — élimination de rapports manuels, automatisation, meilleures décisions — génèrent souvent des économies récurrentes de plusieurs milliers de dollars par mois. Chaque initiative est priorisée selon son potentiel de valeur et de retour sur investissement.", 340 );
	$fields[] = $txt( 'forfait_invest_prix', 'Chiffre 1 — prix', '1 000 $', 20 );
	$fields[] = $txt( 'forfait_invest_prix_unite', 'Chiffre 1 — unité', '/ mois', 15 );
	$fields[] = $area( 'forfait_invest_prix_note', 'Chiffre 1 — légende', 'À partir de — forfait mensuel fixe, pour une prévisibilité budgétaire complète.', 160 );
	$fields[] = $txt( 'forfait_invest_ratio', 'Chiffre 2 — ratio', '1 $ → 3 $', 20 );
	$fields[] = $area( 'forfait_invest_ratio_note', 'Chiffre 2 — légende', 'Chaque dollar investi vise à générer environ 3 $ de valeur créée ou d\'économies générées.', 160 );

	// ----- AIDE FINANCIÈRE -----
	$fields[] = $tab( 'forfait_aide', 'Aide financière' );
	$fields[] = $txt( 'forfait_aide_label', 'Sur-titre', 'Aide financière', 40 );
	$fields[] = $txt( 'forfait_aide_titre', 'Titre — début', 'Des programmes qui peuvent', 40 );
	$fields[] = $txt( 'forfait_aide_titre_fort', 'Titre — partie en or', 'réduire votre investissement', 40 );
	$fields[]                       = $area( 'forfait_aide_intro', 'Intro', "Plusieurs programmes gouvernementaux soutiennent l'adoption du numérique, l'automatisation et l'amélioration de la productivité. Nous vous aidons à identifier ceux auxquels vous pourriez être admissible. [Contenu à confirmer]", 340 );
	$fields[ count( $fields ) - 1 ]['instructions'] = 'Bloc placeholder : aucun programme précis n\'est encore confirmé au moment de la rédaction. (max 340 caractères)';

	$kpibi_aide_defaults = array(
		array( 'Subventions et programmes', "Programme d'aide à confirmer — aide financière directe pour vos projets admissibles. [Placeholder]" ),
		array( "Crédits d'impôt", 'Programme d\'aide à confirmer — crédits applicables aux investissements technologiques. [Placeholder]' ),
		array( 'Accompagnement', 'Nous vous orientons vers les bons programmes et facilitons les démarches. [Placeholder]' ),
	);
	foreach ( $kpibi_aide_defaults as $i => $d ) {
		$n        = $i + 1;
		$fields[] = $txt( "forfait_aide{$n}_titre", "Carte {$n} — titre", $d[0], 40 );
		$fields[] = $area( "forfait_aide{$n}_texte", "Carte {$n} — texte", $d[1], 200 );
	}
	// Sans valeur par défaut (KPIBI-36, A1) : la note portait « Liste finale à
	// valider et à mettre à jour », une note de travail interne publiée en ligne.
	// Tant qu'un défaut existait ici ET en second argument de kpibi_f() au
	// gabarit, vider le champ en wp-admin le faisait réapparaître (story S3).
	// Champ vide = aucun paragraphe rendu, voir template-forfait.php.
	$fields[] = $area( 'forfait_aide_note', 'Note de bas de section', '', 200 );

	// ----- LE PARCOURS -----
	$fields[] = $tab( 'forfait_parcours', 'Le parcours' );
	$fields[] = $txt( 'forfait_parcours_label', 'Sur-titre', 'Le parcours', 40 );
	$fields[] = $txt( 'forfait_parcours_titre', 'Titre — début', 'Comment', 25 );
	$fields[] = $txt( 'forfait_parcours_titre_fort', 'Titre — partie en or', 'débuter', 20 );
	$fields[] = $area( 'forfait_parcours_intro', 'Intro', 'Un démarrage clair, progressif et sans engagement.', 120 );

	$kpibi_parcours_defaults = array(
		array( 'Consultation gratuite', "Une rencontre exploratoire pour comprendre votre réalité et vos opportunités. Vous repartez avec une ébauche de charte de mandat, des leviers d'amélioration et une analyse comparative de votre industrie." ),
		array( 'Diagnostic de faisabilité', 'Au besoin, pour les environnements complexes : une journée pour valider processus, systèmes, données et contraintes. Investissement typique : 1 000 $ à 3 000 $.' ),
		array( 'Sommaire commercial', 'Nous présentons les solutions proposées, les impacts mesurables, les livrables, les frais et modalités. Ce document sert de feuille de route commune.' ),
		array( 'Entente de partenariat', "Une fois le sommaire approuvé, nous finalisons l'entente qui encadre la collaboration, les responsabilités et les modalités." ),
		array( 'Mobilisation et lancement', 'Le mandat débute généralement dans les 30 jours suivant la signature, pour une mise en œuvre rapide des premières priorités.' ),
	);
	foreach ( $kpibi_parcours_defaults as $i => $d ) {
		$n        = $i + 1;
		$fields[] = $txt( "forfait_parcours{$n}_titre", "Étape {$n} — titre", $d[0], 35 );
		$fields[] = $area( "forfait_parcours{$n}_texte", "Étape {$n} — texte", $d[1], 260 );
	}

	// ----- FAQ -----
	$fields[] = $tab( 'forfait_faq_tab', 'FAQ' );
	$fields[] = $txt( 'forfait_faq_label', 'Sur-titre', 'Questions fréquentes', 40 );
	$fields[] = $txt( 'forfait_faq_titre', 'Titre — début', 'Les réponses aux', 30 );
	$fields[] = $txt( 'forfait_faq_titre_fort', 'Titre — partie en or', 'questions courantes', 30 );

	// Liste de questions/réponses — nombre variable (repeater ACF Pro).
	$kpibi_faq_sub_question        = $txt( 'question', 'Question', '', 140 );
	$kpibi_faq_sub_question['key'] = 'field_kpibi_faq_item_question';
	$kpibi_faq_sub_reponse         = $area( 'reponse', 'Réponse', '', 600 );
	$kpibi_faq_sub_reponse['key']  = 'field_kpibi_faq_item_reponse';
	$fields[]                      = array(
		'key'          => 'field_kpibi_forfait_faq',
		'label'        => 'Questions et réponses',
		'name'         => 'forfait_faq',
		'type'         => 'repeater',
		'instructions' => "La liste de questions/réponses affichée en accordéon. Le nombre de questions peut varier dans le temps.",
		'layout'       => 'block',
		'button_label' => 'Ajouter une question',
		'sub_fields'   => array(
			$kpibi_faq_sub_question,
			$kpibi_faq_sub_reponse,
		),
	);

	// ----- CTA -----
	$fields[] = $tab( 'forfait_cta', "Appel à l'action" );
	$fields[] = $txt( 'forfait_cta_label', 'Sur-titre', 'Première étape', 40 );
	$fields[] = $txt( 'forfait_cta_titre', 'Titre — début', 'Voyons si cette approche est', 40 );
	$fields[] = $txt( 'forfait_cta_titre_fort', 'Titre — partie en or', 'adaptée à votre réalité.', 40 );
	$fields[] = $area( 'forfait_cta_texte', 'Texte', 'Chaque organisation a ses contraintes, ses systèmes et ses priorités. Une première conversation nous permettra de voir si un partenariat avec KPIBI est la bonne option — et si oui, par où commencer.', 260 );
	$fields[] = $txt( 'forfait_cta_btn1_texte', 'Bouton 1 — texte', 'Planifier une consultation gratuite', 50 );
	$fields[] = $txt( 'forfait_cta_btn1_url', 'Bouton 1 — lien', 'mailto:' . get_theme_mod( 'kpibi_email', 'info@kpibi.com' ) );
	$fields[] = $txt( 'forfait_cta_btn2_texte', 'Bouton 2 — texte', 'Voir nos réalisations', 40 );
	$fields[] = $txt( 'forfait_cta_btn2_url', 'Bouton 2 — lien', 'cas-clients.html' );
	$fields[] = $txt( 'forfait_cta_garantie', 'Ligne de garantie', 'Sans engagement · Feuille de route claire · Analyse comparative de votre industrie', 110 );

	acf_add_local_field_group(
		array(
			'key'             => 'group_kpibi_forfait',
			'title'           => 'Page forfait KPIBI',
			'fields'          => $fields,
			'location'        => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'template-forfait.php',
					),
				),
			),
			'menu_order'      => 0,
			'position'        => 'normal',
			'style'           => 'default',
			'label_placement' => 'top',
			'active'          => true,
			'description'     => 'Contenu éditable de la page Forfait (partenariat KPIBI). Valeurs par défaut = contenu de la maquette forfait.html.',
		)
	);
}
