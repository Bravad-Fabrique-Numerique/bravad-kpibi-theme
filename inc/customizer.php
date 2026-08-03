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

	/*
	 * Texte de présentation — version ANGLAISE (KPIBI-33).
	 *
	 * L'anglais était codé en dur dans footer.php : le français se modifiait
	 * ici, l'anglais nulle part. Le défaut ci-dessous reprend mot pour mot le
	 * texte qui était en dur, donc un champ laissé vide ne change rien à
	 * l'écran.
	 */
	$wp_customize->add_setting(
		'kpibi_footer_desc_en',
		array(
			'default'           => 'Quebec-based specialists in business intelligence for SMEs. KPI dashboards, process automation and custom business applications.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'kpibi_footer_desc_en',
		array(
			'label'       => __( 'Texte de présentation — anglais (pied de page)', 'kpibi' ),
			'description' => __( 'Affiché sur les pages anglaises (/en/). Laisser vide = texte d\'origine.', 'kpibi' ),
			'section'     => 'kpibi_coordonnees',
			'type'        => 'textarea',
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

	/*
	 * Copyright — français puis anglais.
	 *
	 * PIÈGE DE L'ANNÉE, à connaître avant de toucher à ces deux réglages :
	 * l'année vient de gmdate( 'Y' ) dans la valeur PAR DÉFAUT. Elle se met donc
	 * à jour toute seule au 1er janvier — mais SEULEMENT tant que le champ n'a
	 * pas été modifié. Dès que le client enregistre son propre texte, l'année
	 * qu'il a saisie est figée dans la base et personne ne s'en apercevra avant
	 * le janvier suivant. D'où la mise en garde dans les deux descriptions.
	 *
	 * On n'a délibérément PAS introduit de système de jetons (du genre %annee%)
	 * pour contourner ça : l'anglais doit se comporter exactement comme le
	 * français, et une amélioration appliquée d'un seul côté recréerait
	 * l'asymétrie que KPIBI-33 vient corriger. À traiter dans les deux langues
	 * à la fois, ou pas du tout.
	 */
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
			'label'       => __( 'Texte de copyright', 'kpibi' ),
			'description' => __( 'L\'année se met à jour automatiquement tant que ce champ n\'est pas modifié. Si vous le modifiez, pensez à corriger l\'année chaque janvier.', 'kpibi' ),
			'section'     => 'kpibi_coordonnees',
			'type'        => 'text',
		)
	);

	// Copyright — version ANGLAISE (KPIBI-33). Même défaut dynamique que le français.
	$wp_customize->add_setting(
		'kpibi_copyright_en',
		array(
			'default'           => '© ' . gmdate( 'Y' ) . ' KPIBI. All rights reserved. Quebec, Canada.',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'kpibi_copyright_en',
		array(
			'label'       => __( 'Texte de copyright — anglais', 'kpibi' ),
			'description' => __( 'Affiché sur les pages anglaises (/en/). L\'année se met à jour automatiquement tant que ce champ n\'est pas modifié. Si vous le modifiez, pensez à corriger l\'année chaque janvier.', 'kpibi' ),
			'section'     => 'kpibi_coordonnees',
			'type'        => 'text',
		)
	);
}
add_action( 'customize_register', 'kpibi_customize_register' );
