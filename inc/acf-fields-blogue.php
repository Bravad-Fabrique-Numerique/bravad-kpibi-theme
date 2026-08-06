<?php
/**
 * Champs ACF de la page Blogue (bannière + CTA de fin).
 * La liste des articles elle-même est native WordPress (index.php) — pas
 * besoin de champs ACF pour ça, seulement pour l'habillage (texte de la
 * bannière et bloc CTA en bas de page).
 *
 * Cette page est rattachée via 'page_type' => 'posts_page', c'est-à-dire la
 * page choisie dans Réglages › Lecture › « Une page statique » › Page des
 * articles. Créer une page « Blogue », puis la sélectionner à cet endroit.
 *
 * @package KPIBI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'kpibi_register_blogue_fields' );

function kpibi_register_blogue_fields() {

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
	// L'image de fond manquait purement et simplement : ce groupe ne déclarait
	// aucun champ image et index.php ne rendait aucun .page-hero-bg. Les deux
	// pages blogue étaient donc les seules du site à porter une bannière sans
	// photo. Ce n'était pas un champ vide, mais une fonctionnalité absente
	// (KPIBI-35).
	$fields[] = $tab( 'blogue_hero', 'Bannière' );
	$fields[] = $img( 'blogue_hero_image', 'Image de fond de la bannière' );
	$fields[] = $txt( 'blogue_hero_label', 'Sur-titre', 'Blogue · Ressources', 45 );
	$fields[] = $txt( 'blogue_hero_titre', 'Titre', 'Blogue', 40 );
	$fields[] = $area( 'blogue_hero_sub', 'Sous-titre', "Des articles pratiques sur l'excellence opérationnelle, les KPI, l'automatisation, les applications d'affaires et les systèmes qui soutiennent la performance.", 260 );

	// ----- CATÉGORIES -----
	$fields[] = $tab( 'blogue_categories', 'Section catégories' );
	$fields[] = $txt( 'blogue_categories_label', 'Sur-titre', "Catégories d'articles", 40 );
	$fields[] = $txt( 'blogue_categories_titre', 'Titre — début', 'Explorez par', 30 );
	$fields[] = $txt( 'blogue_categories_titre_fort', 'Titre — partie en or', 'thématique', 25 );

	// ----- APPEL À L'ACTION -----
	$fields[] = $tab( 'blogue_cta', 'Appel à l\'action' );
	$fields[] = $txt( 'blogue_cta_label', 'Sur-titre', 'Discutons', 40 );
	$fields[] = $txt( 'blogue_cta_titre', 'Titre — début', 'Vous avez des questions?', 40 );
	$fields[] = $txt( 'blogue_cta_titre_fort', 'Titre — partie en or', 'Parlons-en.', 30 );
	$fields[] = $area( 'blogue_cta_texte', 'Texte', "Un sujet d'article vous interpelle ou vous vivez le même défi dans votre PME? La première consultation est gratuite et sans engagement.", 220 );
	$fields[] = $txt( 'blogue_cta_btn1_texte', 'Bouton 1 — texte', 'Réserver ma consultation gratuite', 45 );
	$fields[] = $txt( 'blogue_cta_btn1_url', 'Bouton 1 — lien', '' );
	$fields[] = $txt( 'blogue_cta_btn2_texte', 'Bouton 2 — texte', 'Voir le forfait', 30 );
	$fields[] = $txt( 'blogue_cta_btn2_url', 'Bouton 2 — lien', 'forfait.html' );
	$fields[] = $txt( 'blogue_cta_garantie', 'Ligne de garantie', 'Sans engagement · Réponse en moins de 24h · Expertise locale québécoise', 90 );

	acf_add_local_field_group(
		array(
			'key'             => 'group_kpibi_blogue',
			'title'           => 'Page Blogue KPIBI',
			'fields'          => $fields,
			'location'        => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'posts_page',
					),
				),
			),
			'menu_order'      => 0,
			'position'        => 'normal',
			'style'           => 'default',
			'label_placement' => 'top',
			'active'          => true,
			'description'     => 'Habillage de la page Blogue (la liste des articles est automatique).',
		)
	);
}
