<?php
/**
 * Champs ACF du Custom Post Type « cas_client ».
 *
 * Remplace le sous-repeater qui vivait auparavant dans le repeater
 * « cas_clients » de la page Cas clients (inc/acf-fields-cas-clients.php).
 * Chaque cas client est maintenant un article indépendant : ces champs
 * décrivent son contenu structuré (tag, contexte, solution, résultats
 * chiffrés, citation…).
 *
 * IMPORTANT — préfixe « ccpt_ » et clés « field_kpibi_ccpt_... » :
 * tous les noms de champs ci-dessous sont préfixés pour garantir qu'aucun
 * nom (et donc aucune clé ACF / meta_key) n'entre en collision avec les
 * champs des autres groupes ACF du thème (page d'accueil, pages de
 * services, page à propos, page forfait, page cas clients elle-même pour
 * ses champs banniere_* et cas_cta_*). C'est une règle stricte du projet,
 * suite à un bug déjà corrigé où deux groupes ACF partageant le même nom de
 * champ avaient fait fuiter du contenu entre deux pages différentes.
 *
 * Le TITRE du cas (ex. « Brass Plomberie — ») est le titre du post natif
 * (post_title), pas un champ ACF. L'IMAGE est l'image mise en avant
 * (featured image / post thumbnail), pas un champ ACF « image ».
 *
 * @package KPIBI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'kpibi_register_cas_client_cpt_fields' );

function kpibi_register_cas_client_cpt_fields() {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// Helpers de construction de champs (définis globalement dans functions.php,
	// partagés par tous les fichiers inc/acf-fields-*.php). Note : ces helpers
	// génèrent des clés du type « field_kpibi_{name} » — comme le « name »
	// passé ici est déjà préfixé « ccpt_ », la clé finale est bien unique
	// (ex. field_kpibi_ccpt_tag).
	$txt  = 'kpibi_field_text';
	$area = 'kpibi_field_area';
	$tab  = 'kpibi_field_tab';

	$fields = array();

	// ----- IDENTIFICATION -----
	$fields[] = $tab( 'ccpt_identification', 'Identification' );
	$fields[] = $txt( 'ccpt_tag', 'Tag / catégorie', '', 90, 'Ex. : Tableaux de bord KPI · Connecteurs sur mesure' );
	$fields[] = $txt( 'ccpt_titre_fort', 'Titre — accroche (en évidence)', '', 90, "Affichée après le titre du cas (titre du post), en gras. Ex. : « Une visibilité stratégique qui s'autofinance »." );

	// ----- CONTEXTE & SOLUTION -----
	$fields[] = $tab( 'ccpt_contenu', 'Contexte & solution' );
	$fields[] = array(
		'key'          => 'field_kpibi_ccpt_contexte',
		'label'        => 'Contexte (paragraphes)',
		'name'         => 'ccpt_contexte',
		'type'         => 'textarea',
		'rows'         => 5,
		'new_lines'    => '',
		'instructions' => 'Un paragraphe par ligne.',
	);
	$fields[] = array(
		'key'          => 'field_kpibi_ccpt_solution',
		'label'        => 'La solution KPIBI (paragraphes)',
		'name'         => 'ccpt_solution',
		'type'         => 'textarea',
		'rows'         => 5,
		'new_lines'    => '',
		'instructions' => 'Un paragraphe par ligne.',
	);
	$fields[] = array(
		'key'          => 'field_kpibi_ccpt_solution_liste',
		'label'        => "Détails de la solution — liste à puces (optionnel)",
		'name'         => 'ccpt_solution_liste',
		'type'         => 'textarea',
		'rows'         => 5,
		'new_lines'    => '',
		'instructions' => "Une puce par ligne. Utile pour détailler une liste de fonctionnalités entre les paragraphes de solution (ex. cas N.V. Cloutier). Laisser vide si non applicable.",
	);
	$fields[] = array(
		'key'          => 'field_kpibi_ccpt_solution_apres',
		'label'        => 'Paragraphe(s) de conclusion après la liste (optionnel)',
		'name'         => 'ccpt_solution_apres',
		'type'         => 'textarea',
		'rows'         => 3,
		'new_lines'    => '',
		'instructions' => 'Un paragraphe par ligne. Affiché après la liste à puces ci-dessus.',
	);

	// ----- RÉSULTATS -----
	$fields[] = $tab( 'ccpt_resultats', 'Résultats' );
	$fields[] = array(
		'key'          => 'field_kpibi_ccpt_resultats_chiffres',
		'label'        => 'Résultats chiffrés',
		'name'         => 'ccpt_resultats_chiffres',
		'type'         => 'repeater',
		'instructions' => 'Les chiffres clés affichés en bandeau (ex. « 20–30 h » / « Économisées par mois »). Nombre variable.',
		'layout'       => 'table',
		'button_label' => 'Ajouter un résultat chiffré',
		'sub_fields'   => array(
			array(
				'key'          => 'field_kpibi_ccpt_resultat_num',
				'label'        => 'Chiffre',
				'name'         => 'num',
				'type'         => 'text',
				'maxlength'    => 14,
				'instructions' => 'Ex. : 20–30 h, 700+, 5 → 3',
			),
			array(
				'key'       => 'field_kpibi_ccpt_resultat_label',
				'label'     => 'Libellé',
				'name'      => 'label',
				'type'      => 'text',
				'maxlength' => 45,
			),
		),
	);
	$fields[] = array(
		'key'          => 'field_kpibi_ccpt_resultats_liste',
		'label'        => 'Résultats — liste à puces',
		'name'         => 'ccpt_resultats_liste',
		'type'         => 'textarea',
		'rows'         => 8,
		'new_lines'    => '',
		'instructions' => 'Une puce par ligne. Nombre variable.',
	);

	// ----- CITATION -----
	$fields[] = $tab( 'ccpt_citation_tab', 'Citation' );
	$fields[] = array(
		'key'          => 'field_kpibi_ccpt_citation',
		'label'        => 'Citation',
		'name'         => 'ccpt_citation',
		'type'         => 'textarea',
		'rows'         => 3,
		'new_lines'    => '',
		'instructions' => 'Texte de la citation, sans les guillemets « » (ajoutés automatiquement).',
	);
	$fields[] = array(
		'key'          => 'field_kpibi_ccpt_citation_fort',
		'label'        => 'Citation — passage en évidence (optionnel)',
		'name'         => 'ccpt_citation_fort',
		'type'         => 'text',
		'maxlength'    => 60,
		'instructions' => "Doit être un extrait exact de la citation ci-dessus ; ce passage sera mis en gras. Laisser vide pour ne rien mettre en évidence.",
	);
	$fields[] = array(
		'key'       => 'field_kpibi_ccpt_auteur_nom',
		'label'     => "Citation — nom de l'auteur",
		'name'      => 'ccpt_auteur_nom',
		'type'      => 'text',
		'maxlength' => 60,
	);
	$fields[] = array(
		'key'       => 'field_kpibi_ccpt_auteur_role',
		'label'     => "Citation — rôle / entreprise",
		'name'      => 'ccpt_auteur_role',
		'type'      => 'text',
		'maxlength' => 90,
	);

	// ----- AVANCÉ -----
	$fields[] = $tab( 'ccpt_avance', 'Avancé' );
	$fields[] = array(
		'key'           => 'field_kpibi_ccpt_img_position',
		'label'         => "Position de l'image (avancé)",
		'name'          => 'ccpt_img_position',
		'type'          => 'text',
		'default_value' => 'center',
		'instructions'  => "Valeur CSS object-position pour l'image mise en avant. Laisser « center » si incertain.",
	);

	acf_add_local_field_group(
		array(
			'key'             => 'group_kpibi_cas_client_cpt',
			'title'           => 'Détails du cas client',
			'fields'          => $fields,
			'location'        => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'cas_client',
					),
				),
			),
			'menu_order'      => 0,
			'position'        => 'normal',
			'style'           => 'default',
			'label_placement' => 'top',
			'active'          => true,
			'description'     => 'Contenu structuré d\'un cas client (contexte, solution, résultats, citation). Le titre = post_title, l\'image = image mise en avant.',
		)
	);
}
