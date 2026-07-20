<?php
/**
 * Champs ACF de la page Cas clients (bannière + appel à l'action seulement).
 *
 * La LISTE des cas clients elle-même (Brass Plomberie, N.V. Cloutier,
 * distributeur national, etc.) n'utilise plus de repeater ACF ici : chaque
 * cas est maintenant un article du Custom Post Type « cas_client » (voir
 * inc/cpt-cas-clients.php et inc/acf-fields-cas-client-cpt.php), affiché sur
 * cette page via une requête WP_Query/get_posts() dans
 * template-cas-clients.php. Ce fichier ne gère donc plus que l'habillage de
 * la page (bannière et bloc CTA de fin), à la manière de
 * inc/acf-fields-blogue.php pour la page Blogue.
 *
 * @package KPIBI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'kpibi_register_cas_clients_fields' );

function kpibi_register_cas_clients_fields() {

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
	$fields[] = $tab( 'banniere', 'Bannière' );
	$fields[] = $img( 'banniere_image', 'Image de fond de la bannière' );
	$fields[] = $txt( 'banniere_label', 'Sur-titre', 'Cas clients · Résultats réels', 60 );
	$fields[] = $txt( 'banniere_titre', 'Titre — début', 'Ce que ça donne, concrètement, pour des entreprises', 90 );
	$fields[] = $txt( 'banniere_titre_fort', 'Titre — partie en or', 'comme la vôtre.', 40 );
	$fields[] = $area( 'banniere_sous_titre', 'Sous-titre', 'Trois mandats, trois réalités différentes. Le même fil conducteur : des opérations simplifiées, des données fiables et des gains mesurables qui durent.', 260 );
	$fields[] = $txt( 'banniere_cta1_texte', 'Bouton 1 — texte', 'Planifier une consultation gratuite', 50 );
	$fields[] = $txt( 'banniere_cta1_url', 'Bouton 1 — lien', '#cta' );
	$fields[] = $txt( 'banniere_cta2_texte', 'Bouton 2 — texte', 'Voir le forfait', 30 );
	$fields[] = $txt( 'banniere_cta2_url', 'Bouton 2 — lien', 'forfait.html' );

	// ----- APPEL À L'ACTION -----
	// Note : champs préfixés « cas_ » pour éviter toute collision de nom/clé
	// ACF avec les champs « cta_* » de la page d'accueil (voir l'incident
	// similaire déjà corrigé pour le gabarit template-service.php).
	$fields[] = $tab( 'cas_cta', "Appel à l'action" );
	$fields[] = $txt( 'cas_cta_label', 'Sur-titre', 'À votre tour', 40 );
	$fields[] = $txt( 'cas_cta_titre', 'Titre — début', 'Vous venez de lire des résultats concrets.', 60 );
	$fields[] = $txt( 'cas_cta_titre_fort', 'Titre — partie forte', 'Voyons ce qui est possible pour vous.', 60 );
	$fields[] = $area( 'cas_cta_texte', 'Texte', "Vous repartirez avec une feuille de route claire, les premiers leviers d'amélioration identifiés et une analyse comparative financière de votre industrie.", 260 );
	$fields[] = $txt( 'cas_cta_btn1_texte', 'Bouton 1 — texte', 'Planifier une consultation gratuite', 50 );
	$fields[] = $txt( 'cas_cta_btn1_url', 'Bouton 1 — lien', 'mailto:' . get_theme_mod( 'kpibi_email', 'info@kpibi.com' ) );
	$fields[] = $txt( 'cas_cta_btn2_texte', 'Bouton 2 — texte', 'Voir le forfait', 30 );
	$fields[] = $txt( 'cas_cta_btn2_url', 'Bouton 2 — lien', 'forfait.html' );
	$fields[] = $txt( 'cas_cta_garantie', 'Ligne de garantie', 'Sans engagement · Réponse en moins de 24h · Expertise locale québécoise', 110 );

	acf_add_local_field_group(
		array(
			'key'             => 'group_kpibi_cas_clients',
			'title'           => 'Page Cas clients',
			'fields'          => $fields,
			'location'        => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'template-cas-clients.php',
					),
				),
			),
			'menu_order'      => 0,
			'position'        => 'normal',
			'style'           => 'default',
			'label_placement' => 'top',
			'active'          => true,
			'description'     => 'Contenu éditable de la page Cas clients (bannière, liste des cas et appel à l\'action).',
		)
	);
}
