<?php
/**
 * Champs ACF de la page d'accueil.
 * Enregistrés en PHP : aucune création manuelle de champ requise.
 * Les titres ont une LIMITE DE CARACTÈRES (maxlength) pour ne pas casser la mise en page.
 *
 * Compatible ACF gratuit (champs text, textarea, tab, message).
 *
 * @package KPIBI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Hooké sur `init` priorité 20 (et non `acf/init`, plus précoce) pour que
// Polylang ait déjà enregistré sa taxonomie `post_translations` et son API :
// on peut alors résoudre les traductions de la page d'accueil de façon fiable.
add_action( 'init', 'kpibi_register_home_fields', 20 );

function kpibi_register_home_fields() {

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

	// ----- HERO -----
	$fields[] = $tab( 'hero', 'Bannière (hero)' );
	$fields[] = $img( 'hero_image', 'Image de fond de la bannière' );
	$fields[] = $txt( 'hero_label', 'Sur-titre', 'Optimisation des processus • Automatisation • Tableaux de bord KPI', 90 );
	$fields[] = $txt( 'hero_titre', 'Titre — début', 'Moins de friction. Plus de capacité.', 60 );
	$fields[] = $txt( 'hero_titre_fort', 'Titre — mot en or', 'Sans embaucher.', 30 );
	$fields[] = $txt( 'hero_titre_fin', 'Titre — fin (optionnel)', '', 22 );
	$fields[] = $area( 'hero_sub', 'Sous-titre', "Vos opérations sont complexes. Nos solutions, elles, ne le sont pas. Nous concevons des processus, des automatisations et des outils qui s'adaptent à votre réalité, pour que la performance devienne le résultat naturel de votre système, pas un effort quotidien.", 320 );
	$fields[] = $txt( 'hero_cta1_texte', 'Bouton 1 — texte', 'Parler à un expert', 30 );
	$fields[] = $txt( 'hero_cta1_url', 'Bouton 1 — lien', '#cta' );
	$fields[] = $txt( 'hero_cta2_texte', 'Bouton 2 — texte', 'Voir nos réalisations', 30 );
	$fields[] = $txt( 'hero_cta2_url', 'Bouton 2 — lien', 'cas-clients.html' );

	// ----- STATISTIQUES -----
	$fields[] = $tab( 'stats', 'Statistiques' );
	$fields[] = $txt( 'stat1_num', 'Stat 1 — nombre', '15+', 12 );
	$fields[] = $txt( 'stat1_label', 'Stat 1 — libellé', "ans d'expérience terrain", 40 );
	$fields[] = $txt( 'stat2_num', 'Stat 2 — nombre', '3 000+', 12 );
	$fields[] = $txt( 'stat2_label', 'Stat 2 — libellé', 'opérations automatisées chaque jour', 45 );
	$fields[] = $txt( 'stat3_num', 'Stat 3 — texte/nombre', 'Multisectoriel', 25 );
	$fields[] = $txt( 'stat3_label', 'Stat 3 — libellé', 'manufacturier, municipal, santé, finance, distribution et plus', 90 );

	// ----- PILIERS -----
	$fields[] = $tab( 'piliers', 'Piliers' );
	$fields[] = $txt( 'piliers_label', 'Sur-titre', 'Nos solutions', 40 );
	$fields[] = $txt( 'piliers_titre', 'Titre — début', 'Quatre leviers qui travaillent', 45 );
	$fields[] = $txt( 'piliers_titre_fort', 'Titre — partie forte', 'ensemble', 40 );
	$fields[] = $area( 'piliers_intro', 'Intro', 'Quatre leviers qui travaillent ensemble pour simplifier vos opérations et améliorer votre performance.', 160 );
	$piliers = array(
		array( 'Optimisation des processus', "Des processus mieux conçus pour éliminer le gaspillage et les goulots d'étranglement, maximiser vos ressources et améliorer votre efficacité opérationnelle.", 'service-optimisation.html' ),
		array( 'Tableaux de bord KPI', "Accédez à des indicateurs de performance fiables et à jour afin d'améliorer votre visibilité opérationnelle, de prendre de meilleures décisions et d'aligner vos équipes sur les bonnes priorités.", 'service-dashboards.html' ),
		array( 'Automatisation des processus', "Automatisez les tâches répétitives, qu'elles soient simples ou complexes, connectez vos systèmes et réduisez les délais afin de permettre à vos équipes de se concentrer sur les activités à valeur ajoutée.", 'service-automatisation.html' ),
		array( 'Applications web sur mesure', 'Des applications sur mesure conçues autour de votre réalité opérationnelle pour compléter ou remplacer les fichiers Excel, les ERP et les CRM mal adaptés à vos processus.', 'service-applications.html' ),
	);
	$pilier_icones = array( 'optimisation', 'tableau_bord', 'automatisation', 'application' );
	foreach ( $piliers as $i => $p ) {
		$n        = $i + 1;
		$fields[] = $txt( "pilier{$n}_titre", "Pilier {$n} — titre", $p[0], 45 );
		$fields[] = $area( "pilier{$n}_texte", "Pilier {$n} — texte", $p[1], 220 );
		$fields[] = kpibi_field_icon( "pilier{$n}_icon", "Pilier {$n} — icône", $pilier_icones[ $i ] );
		$fields[] = $img( "pilier{$n}_image", "Pilier {$n} — image" );
		$fields[] = $txt( "pilier{$n}_url", "Pilier {$n} — lien", $p[2] );
	}

	// ----- POURQUOI -----
	$fields[] = $tab( 'pourquoi', 'Pourquoi KPIBI' );
	$fields[] = $img( 'pourquoi_image', 'Image de la section' );
	$fields[] = $txt( 'pourquoi_label', 'Sur-titre', 'Pourquoi KPIBI', 40 );
	$fields[] = $txt( 'pourquoi_titre', 'Titre — début', 'Pourquoi', 30 );
	$fields[] = $txt( 'pourquoi_titre_fort', 'Titre — mot en or', 'KPIBI', 22 );
	$fields[] = $txt( 'pourquoi_titre_fin', 'Titre — fin', '?', 10 );
	$fields[] = $area( 'pourquoi_intro', 'Intro', "La plupart des firmes s'arrêtent aux recommandations. Les intégrateurs, eux, s'arrêtent à la technologie. Chez KPIBI, on fait le pont entre les deux : on analyse vos processus, on conçoit les bons outils et on les implante. Ensemble, ces leviers créent des systèmes où vos équipes peuvent enfin travailler comme elles devraient.", 420 );
	$diffs = array(
		array( 'Performance naturelle', "Les organisations les plus performantes ne demandent pas des efforts héroïques à leurs équipes : elles s'appuient sur des systèmes bien conçus. Nous agissons sur les processus, les outils et l'environnement de travail pour que les bonnes pratiques deviennent naturelles." ),
		array( "De la stratégie à l'implantation", "La plupart des consultants livrent un rapport, la plupart des intégrateurs livrent un outil. Nous livrons des solutions complètes sur mesure, avec des gains mesurables, et on s'assure que ça fonctionne dans votre réalité." ),
		array( "Partenaire d'amélioration continue", "Grâce à notre modèle de forfait mensuel, nous continuons d'améliorer, d'adapter et de soutenir vos solutions à mesure que votre organisation évolue." ),
		array( 'Résultats mesurables', "Chaque initiative est liée à des objectifs clairs, des indicateurs de performance et des résultats observables, pour concentrer les efforts là où ils créent le plus de valeur." ),
	);
	foreach ( $diffs as $i => $d ) {
		$n        = $i + 1;
		$fields[] = $txt( "diff{$n}_titre", "Différenciateur {$n} — titre", $d[0], 45 );
		$fields[] = $area( "diff{$n}_texte", "Différenciateur {$n} — texte", $d[1], 320 );
	}
	$fields[] = $txt( 'pourquoi_badge_num', 'Badge — nombre', '3 000+', 12 );
	$fields[] = $txt( 'pourquoi_badge_label', 'Badge — libellé', 'opérations automatisées chaque jour', 45 );
	$fields[] = $txt( 'rapport_titre', 'Encart rapport — titre', 'Analyse comparative offerte à la consultation', 60 );
	$fields[] = $area( 'rapport_texte', 'Encart rapport — texte', 'Repartez avec une feuille de route claire et une analyse comparative financière de votre industrie.', 160 );

	// ----- TÉMOIGNAGES -----
	$fields[] = $tab( 'temoignages', 'Témoignages' );
	$fields[] = $txt( 'temo_label', 'Sur-titre', 'Ce que disent nos clients', 40 );
	$fields[] = $txt( 'temo_titre', 'Titre — début', 'Des organisations qui ont', 35 );
	$fields[] = $txt( 'temo_titre_fort', 'Titre — partie forte', 'fait le saut', 22 );
	$fields[] = $area( 'temo_intro', 'Intro (optionnel)', '', 140 );
	$temos = array(
		array( 'Brass Plomberie', 'Grâce à KPIBI, nous avons maintenant des KPI clairs, utiles et faciles à suivre au quotidien, regroupés dans un tableau de bord automatisé connecté à notre ERP et à notre logiciel comptable. Nous avons une meilleure visibilité sur nos opérations et une information plus structurée pour soutenir nos décisions.', 'Stéphanie Girard', 'CoPropriétaire, Stratégie et Optimisation des projets, Brass Plomberie' ),
		array( 'N.V. Cloutier', "Avant KPIBI, notre suivi client était éclaté entre des notes, des appels et des souvenirs. Aujourd'hui, tout est centralisé, nos représentants travaillent efficacement sur le terrain et nous avons une visibilité complète sur les ventes, les activités et les opportunités.", 'Charles Martineau', 'CoPropriétaire, Directeur des opérations fixes, N.V. Cloutier' ),
		array( 'Bravad', "KPIBI se distingue par sa capacité à comprendre rapidement les réalités d'affaires et à transformer des défis opérationnels complexes en solutions concrètes. Leur équipe nous accompagne sur une variété d'initiatives, de l'amélioration des processus à l'automatisation, toujours avec une approche pragmatique ancrée dans la réalité du terrain.", 'Pierre-Philippe Rousseau', 'Vice-Président Finance et administration, Bravad' ),
	);
	foreach ( $temos as $i => $t ) {
		$n        = $i + 1;
		$fields[] = $txt( "temo{$n}_client", "Témoignage {$n} — client", $t[0], 40 );
		$fields[] = $area( "temo{$n}_quote", "Témoignage {$n} — citation", $t[1], 420 );
		$fields[] = $txt( "temo{$n}_nom", "Témoignage {$n} — nom", $t[2], 40 );
		$fields[] = $txt( "temo{$n}_role", "Témoignage {$n} — rôle", $t[3], 90 );
	}

	// ----- CTA -----
	$fields[] = $tab( 'cta', 'Appel à l\'action' );
	$fields[] = $txt( 'cta_label', 'Sur-titre', 'Première étape', 40 );
	$fields[] = $txt( 'cta_titre', 'Titre — début', 'Une heure avec nous.', 40 );
	$fields[] = $txt( 'cta_titre_fort', 'Titre — partie forte', 'Une feuille de route pour vous.', 60 );
	$fields[] = $area( 'cta_texte', 'Texte', "Planifiez une consultation gratuite, sans engagement. Vous repartirez avec une feuille de route claire, les premiers leviers d'amélioration identifiés et une analyse comparative financière de votre industrie.", 280 );
	$fields[] = $txt( 'cta_btn1_texte', 'Bouton 1 — texte', 'Planifier une consultation gratuite', 50 );
	$fields[] = $txt( 'cta_btn1_url', 'Bouton 1 — lien', 'mailto:' . get_theme_mod( 'kpibi_email', 'info@kpibi.com' ) );
	$fields[] = $txt( 'cta_btn2_texte', 'Bouton 2 — texte', 'Voir nos réalisations', 40 );
	$fields[] = $txt( 'cta_btn2_url', 'Bouton 2 — lien', 'cas-clients.html' );
	$fields[] = $txt( 'cta_garantie', 'Ligne de garantie', 'Sans engagement · Feuille de route claire · Analyse comparative de votre industrie', 110 );

	// Emplacement : la vraie page d'accueil WP, PLUS chaque traduction Polylang
	// de la page d'accueil (ex. la page EN servie à /en/), pour que le contenu
	// du hero soit éditable dans chaque langue. Calculé à chaque chargement,
	// donc aucun ID codé en dur — valable en dev comme en production.
	$kpibi_location = array(
		array(
			array(
				'param'    => 'page_type',
				'operator' => '==',
				'value'    => 'front_page',
			),
		),
	);
	$kpibi_front = (int) get_option( 'page_on_front' );
	if ( $kpibi_front ) {
		// Rassemble tous les IDs de page d'accueil (la page WP + ses traductions
		// Polylang) pour ajouter une règle `page ==` sur chacun. On lit
		// DIRECTEMENT la taxonomie Polylang `post_translations` (stockée en base)
		// plutôt que les fonctions pll_* : celles-ci ne sont pas encore prêtes au
		// moment du hook `acf/init` (le modèle de langues n'est pas initialisé),
		// alors que la taxonomie, elle, est déjà enregistrée et interrogeable.
		$kpibi_home_ids = array( $kpibi_front );
		$kpibi_terms    = get_the_terms( $kpibi_front, 'post_translations' );
		if ( $kpibi_terms && ! is_wp_error( $kpibi_terms ) ) {
			$kpibi_map = maybe_unserialize( $kpibi_terms[0]->description );
			if ( is_array( $kpibi_map ) ) {
				foreach ( $kpibi_map as $kpibi_tr ) {
					$kpibi_home_ids[] = (int) $kpibi_tr;
				}
			}
		}
		// Repli : si Polylang expose déjà son API, on complète.
		if ( function_exists( 'pll_get_post_translations' ) ) {
			foreach ( (array) pll_get_post_translations( $kpibi_front ) as $kpibi_tr ) {
				$kpibi_home_ids[] = (int) $kpibi_tr;
			}
		}
		foreach ( array_unique( array_filter( $kpibi_home_ids ) ) as $kpibi_home_id ) {
			$kpibi_location[] = array(
				array(
					'param'    => 'page',
					'operator' => '==',
					'value'    => (string) $kpibi_home_id,
				),
			);
		}
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_kpibi_accueil',
			'title'                 => 'Page d\'accueil KPIBI',
			'fields'                => $fields,
			'location'              => $kpibi_location,
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'active'                => true,
			'description'           => 'Contenu éditable de la page d\'accueil.',
		)
	);
}
