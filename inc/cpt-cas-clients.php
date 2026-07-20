<?php
/**
 * Custom Post Type « Cas clients » (cas_client).
 *
 * Remplace l'ancien repeater ACF unique (field_kpibi_cas_clients, voir
 * inc/acf-fields-cas-clients.php avant son retrait) : chaque cas client est
 * maintenant un article indépendant dans wp-admin (Cas clients > Ajouter),
 * plus simple à gérer pour Phil qu'un gros repeater imbriqué, et prêt à
 * grandir dans le temps sans limite technique.
 *
 * - Le TITRE du post WordPress (post_title) = le nom du client (ex. « Brass
 *   Plomberie — »), pas de champ ACF dupliqué pour ça.
 * - L'IMAGE mise en avant (featured image) remplace l'ancien champ ACF
 *   « image » du repeater.
 * - has_archive => false : on garde la page « Cas clients » existante
 *   (gabarit template-cas-clients.php) comme page de liste ; pas d'archive
 *   générique WordPress à /cas-client/.
 * - Pas d'éditeur de contenu (supports ne contient pas 'editor') : tout le
 *   contenu structuré (contexte, solution, résultats, citation…) vit dans
 *   les champs ACF dédiés, voir inc/acf-fields-cas-client-cpt.php.
 *
 * @package KPIBI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'kpibi_register_cas_client_cpt' );

function kpibi_register_cas_client_cpt() {

	$labels = array(
		'name'                  => 'Cas clients',
		'singular_name'         => 'Cas client',
		'menu_name'             => 'Cas clients',
		'name_admin_bar'        => 'Cas client',
		'add_new'               => 'Ajouter',
		'add_new_item'          => 'Ajouter un cas client',
		'new_item'              => 'Nouveau cas client',
		'edit_item'             => 'Modifier le cas client',
		'view_item'             => 'Voir le cas client',
		'view_items'            => 'Voir les cas clients',
		'all_items'             => 'Tous les cas clients',
		'search_items'          => 'Rechercher un cas client',
		'not_found'             => 'Aucun cas client trouvé.',
		'not_found_in_trash'    => 'Aucun cas client dans la corbeille.',
		'featured_image'        => 'Image du cas client',
		'set_featured_image'    => "Choisir l'image du cas client",
		'remove_featured_image' => "Retirer l'image du cas client",
		'use_featured_image'    => 'Utiliser comme image du cas client',
		'archives'              => 'Archives des cas clients',
		'insert_into_item'      => 'Insérer dans le cas client',
		'uploaded_to_this_item' => 'Téléversé pour ce cas client',
	);

	$args = array(
		'labels'             => $labels,
		'description'        => 'Cas clients affichés sur la page « Cas clients » (résultats réels, témoignages).',
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => false,
		'show_in_admin_bar'  => true,
		'show_in_rest'       => true,
		'menu_position'      => 20,
		'menu_icon'          => 'dashicons-portfolio',
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'supports'           => array( 'title', 'thumbnail' ),
		'has_archive'        => false,
		'rewrite'            => array( 'slug' => 'cas-client' ),
		'query_var'          => true,
		'can_export'         => true,
	);

	register_post_type( 'cas_client', $args );
}
