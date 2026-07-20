<?php
/**
 * Réglages globaux éditables dans Apparence › Personnaliser.
 * (URL LinkedIn, courriel, texte du pied de page, copyright.)
 *
 * @package KPIBI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enregistre la section et les réglages.
 */
function kpibi_customize_register( $wp_customize ) {

	$wp_customize->add_section(
		'kpibi_coordonnees',
		array(
			'title'    => __( 'KPIBI — Coordonnées & réseaux', 'kpibi' ),
			'priority' => 30,
		)
	);

	// URL LinkedIn.
	$wp_customize->add_setting(
		'kpibi_linkedin_url',
		array(
			'default'           => 'https://www.linkedin.com/company/kpibi',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'kpibi_linkedin_url',
		array(
			'label'       => __( 'Adresse LinkedIn', 'kpibi' ),
			'description' => __( 'Lien complet vers la page LinkedIn (https://...).', 'kpibi' ),
			'section'     => 'kpibi_coordonnees',
			'type'        => 'url',
		)
	);

	// Courriel de contact.
	$wp_customize->add_setting(
		'kpibi_email',
		array(
			'default'           => 'info@kpibi.com',
			'sanitize_callback' => 'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'kpibi_email',
		array(
			'label'   => __( 'Courriel de contact', 'kpibi' ),
			'section' => 'kpibi_coordonnees',
			'type'    => 'email',
		)
	);

	// Texte de présentation (pied de page).
	$wp_customize->add_setting(
		'kpibi_footer_desc',
		array(
			'default'           => 'Spécialiste québécois en intelligence d\'affaires pour PME. Tableaux de bord KPI, automatisation des processus et développement d\'applications sur mesure.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'kpibi_footer_desc',
		array(
			'label'   => __( 'Texte de présentation (pied de page)', 'kpibi' ),
			'section' => 'kpibi_coordonnees',
			'type'    => 'textarea',
		)
	);

	// Lien — Politique de confidentialité.
	$wp_customize->add_setting(
		'kpibi_privacy_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'kpibi_privacy_url',
		array(
			'label'       => __( 'Lien — Politique de confidentialité', 'kpibi' ),
			'description' => __( 'URL de la page (créer la page correspondante d\'abord). Laisser vide = lien inactif.', 'kpibi' ),
			'section'     => 'kpibi_coordonnees',
			'type'        => 'url',
		)
	);

	// Lien — Conditions d'utilisation.
	$wp_customize->add_setting(
		'kpibi_terms_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'kpibi_terms_url',
		array(
			'label'       => __( "Lien — Conditions d'utilisation", 'kpibi' ),
			'description' => __( 'URL de la page (créer la page correspondante d\'abord). Laisser vide = lien inactif.', 'kpibi' ),
			'section'     => 'kpibi_coordonnees',
			'type'        => 'url',
		)
	);

	// Copyright.
	$wp_customize->add_setting(
		'kpibi_copyright',
		array(
			'default'           => '© ' . gmdate( 'Y' ) . ' KPIBI. Tous droits réservés. Québec, Canada.',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'kpibi_copyright',
		array(
			'label'   => __( 'Texte de copyright', 'kpibi' ),
			'section' => 'kpibi_coordonnees',
			'type'    => 'text',
		)
	);
}
add_action( 'customize_register', 'kpibi_customize_register' );
