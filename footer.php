<?php
/**
 * Pied de page.
 *
 * @package KPIBI
 */

$kpibi_linkedin   = esc_url( get_theme_mod( 'kpibi_linkedin_url', 'https://www.linkedin.com/company/kpibi' ) );
$kpibi_email      = sanitize_email( get_theme_mod( 'kpibi_email', 'info@kpibi.com' ) );
$kpibi_footer_is_en = function_exists( 'pll_current_language' ) && 'en' === pll_current_language();
/*
 * Descriptif et copyright, une langue = un réglage.
 *
 * Les deux textes ANGLAIS étaient codés en dur ici alors que leurs
 * équivalents français venaient du Personnalisateur (KPIBI-33) : Phil
 * modifiait le français, l'anglais ne suivait pas, et rien ne lui permettait
 * de le corriger — le pied de page anglais se désynchronisait en silence.
 *
 * Le test de langue SURVIT : il ne choisit plus un texte mais le réglage à
 * lire. Les valeurs de repli reproduisent exactement les textes précédents,
 * donc un champ laissé vide ne change rien à l'écran.
 *
 * L'année du copyright est dynamique TANT QUE le champ n'est pas modifié —
 * ensuite elle se fige sur ce que le client a saisi. Ce comportement est
 * celui du français : la parité est délibérée (voir KPIBI-33), et le
 * Personnalisateur en avertit désormais dans les deux langues.
 */
if ( $kpibi_footer_is_en ) {
	$kpibi_desc      = get_theme_mod( 'kpibi_footer_desc_en', "Quebec-based specialists in business intelligence for SMEs. KPI dashboards, process automation and custom business applications." );
	$kpibi_copyright = get_theme_mod( 'kpibi_copyright_en', '© ' . gmdate( 'Y' ) . ' KPIBI. All rights reserved. Quebec, Canada.' );
} else {
	$kpibi_desc      = get_theme_mod( 'kpibi_footer_desc', "Spécialiste québécois en intelligence d'affaires pour PME. Tableaux de bord KPI, automatisation des processus et développement d'applications sur mesure." );
	$kpibi_copyright = get_theme_mod( 'kpibi_copyright', '© ' . gmdate( 'Y' ) . ' KPIBI. Tous droits réservés. Québec, Canada.' );
}
/*
 * Lien « Politique de confidentialité » du pied de page.
 *
 * Il pointait vers « # » (lien mort relevé en QA) parce que le réglage du
 * Personnalisateur n'a jamais été rempli. On ajoute deux replis avant de
 * renoncer, du plus explicite au plus automatique :
 *   1. le réglage du Personnalisateur, s'il est renseigné — il reste
 *      prioritaire, notamment pour pointer vers une page externe ;
 *   2. la page de confidentialité désignée dans Réglages › Confidentialité,
 *      mécanisme natif de WordPress ;
 *   3. la page dont le slug est « politique-de-confidentialite ».
 * Le lien n'est affiché que si l'une des trois pistes aboutit : mieux vaut pas
 * de lien qu'un lien mort.
 */
$kpibi_privacy_url = get_theme_mod( 'kpibi_privacy_url', '' );
if ( '' === $kpibi_privacy_url ) {
	$kpibi_privacy_url = (string) get_privacy_policy_url();
}
if ( '' === $kpibi_privacy_url ) {
	$kpibi_privacy_page = get_page_by_path( 'politique-de-confidentialite' );
	$kpibi_privacy_url  = $kpibi_privacy_page ? (string) get_permalink( $kpibi_privacy_page ) : '';
}
// Lien vers la politique de témoins (cookies) générée par Complianz.
$kpibi_cookie_page  = get_page_by_path( 'politique-de-temoins-ca' );
$kpibi_cookie_url   = $kpibi_cookie_page ? get_permalink( $kpibi_cookie_page ) : '';
$kpibi_cookie_label = kpibi__( 'Politique de cookies' );
?>
</main>

<footer aria-label="<?php echo esc_attr( kpibi__( 'Pied de page' ) ); ?>">
	<div class="container">
		<div class="footer-grid">
			<div class="footer-brand">
				<?php kpibi_logo( 32 ); ?>
				<p><?php echo esc_html( $kpibi_desc ); ?></p>
				<div class="footer-social">
					<a href="<?php echo esc_url( $kpibi_linkedin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( kpibi__( 'KPIBI sur LinkedIn' ) ); ?>">
						<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"></path><circle cx="4" cy="4" r="2"></circle></svg>
					</a>
				</div>
			</div>

			<div class="footer-col">
				<h4><?php echo esc_html( kpibi__( 'Nos solutions' ) ); ?></h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer_solutions',
						'container'      => false,
						'items_wrap'     => '<ul>%3$s</ul>',
						'depth'          => 1,
						'fallback_cb'    => '__return_empty_string',
					)
				);
				?>
			</div>

			<div class="footer-col">
				<h4><?php echo esc_html( kpibi__( 'KPIBI' ) ); ?></h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer_kpibi',
						'container'      => false,
						'items_wrap'     => '<ul>%3$s</ul>',
						'depth'          => 1,
						'fallback_cb'    => '__return_empty_string',
					)
				);
				?>
			</div>
		</div>

		<div class="footer-bottom">
			<p><?php echo esc_html( $kpibi_copyright ); ?></p>
			<nav class="footer-legal" aria-label="<?php echo esc_attr( kpibi__( 'Liens légaux' ) ); ?>">
				<?php if ( $kpibi_privacy_url ) : ?>
					<a href="<?php echo esc_url( $kpibi_privacy_url ); ?>"><?php echo esc_html( kpibi__( 'Politique de confidentialité' ) ); ?></a>
				<?php endif; ?>
				<a href="<?php echo esc_url( $kpibi_cookie_url ? $kpibi_cookie_url : '#' ); ?>"><?php echo esc_html( $kpibi_cookie_label ); ?></a>
			</nav>
		</div>
	</div>
</footer>

<?php
// Modale du formulaire de consultation — ouverte par les boutons CTA (voir main.js).
if ( function_exists( 'shortcode_exists' ) && shortcode_exists( 'contact-form-7' ) ) :
	$kpibi_is_en  = function_exists( 'pll_current_language' ) && 'en' === pll_current_language();
	$kpibi_cf7_id = $kpibi_is_en ? '39e9e84' : 'b8cc433';
	$kpibi_cf7_id = apply_filters( 'kpibi_consultation_form_id', $kpibi_cf7_id );
	$kpibi_modal_eye   = kpibi__( 'Première étape' );
	$kpibi_modal_title = kpibi__( 'Planifier une consultation gratuite' );
	$kpibi_modal_close = kpibi__( 'Fermer' );
	?>
	<div class="kpibi-modal" id="kpibi-form-modal" aria-hidden="true">
		<div class="kpibi-modal-overlay" data-kpibi-close></div>
		<?php
		/*
		 * `tabindex="-1"` rend le dialogue focalisable par script sans l'ajouter à
		 * l'ordre de tabulation. À l'ouverture, main.js y place le focus PLUTÔT que
		 * sur le premier champ : le lecteur d'écran annonce le dialogue et son
		 * titre, mais le clavier virtuel ne s'ouvre pas — c'est lui qui rendait le
		 * bouton d'envoi inatteignable sur téléphone.
		 */
		?>
		<div class="kpibi-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="kpibi-modal-title" tabindex="-1">
			<button type="button" class="kpibi-modal-close" data-kpibi-close aria-label="<?php echo esc_attr( $kpibi_modal_close ); ?>">&times;</button>
			<p class="kpibi-modal-eyebrow"><?php echo esc_html( $kpibi_modal_eye ); ?></p>
			<h2 id="kpibi-modal-title" class="kpibi-modal-title"><?php echo esc_html( $kpibi_modal_title ); ?></h2>
			<div class="kpibi-modal-body">
				<?php echo do_shortcode( '[contact-form-7 id="' . esc_attr( $kpibi_cf7_id ) . '"]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
