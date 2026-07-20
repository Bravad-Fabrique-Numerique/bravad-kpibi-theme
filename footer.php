<?php
/**
 * Pied de page.
 *
 * @package KPIBI
 */

$kpibi_linkedin   = esc_url( get_theme_mod( 'kpibi_linkedin_url', 'https://www.linkedin.com/company/kpibi' ) );
$kpibi_email      = sanitize_email( get_theme_mod( 'kpibi_email', 'info@kpibi.com' ) );
$kpibi_footer_is_en = function_exists( 'pll_current_language' ) && 'en' === pll_current_language();
if ( $kpibi_footer_is_en ) {
	$kpibi_desc      = "Quebec-based specialists in business intelligence for SMEs. KPI dashboards, process automation and custom business applications.";
	$kpibi_copyright = '© ' . gmdate( 'Y' ) . ' KPIBI. All rights reserved. Quebec, Canada.';
} else {
	$kpibi_desc      = get_theme_mod( 'kpibi_footer_desc', "Spécialiste québécois en intelligence d'affaires pour PME. Tableaux de bord KPI, automatisation des processus et développement d'applications sur mesure." );
	$kpibi_copyright = get_theme_mod( 'kpibi_copyright', '© ' . gmdate( 'Y' ) . ' KPIBI. Tous droits réservés. Québec, Canada.' );
}
$kpibi_privacy_url = get_theme_mod( 'kpibi_privacy_url', '' );
// Lien vers la politique de témoins (cookies) générée par Complianz.
$kpibi_cookie_page  = get_page_by_path( 'politique-de-temoins-ca' );
$kpibi_cookie_url   = $kpibi_cookie_page ? get_permalink( $kpibi_cookie_page ) : '';
$kpibi_cookie_label = $kpibi_footer_is_en ? 'Cookie Policy' : 'Politique de cookies';
?>
</main>

<footer aria-label="Pied de page">
	<div class="container">
		<div class="footer-grid">
			<div class="footer-brand">
				<?php kpibi_logo( 32 ); ?>
				<p><?php echo esc_html( $kpibi_desc ); ?></p>
				<div class="footer-social">
					<a href="<?php echo esc_url( $kpibi_linkedin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="KPIBI sur LinkedIn">
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
			<nav class="footer-legal" aria-label="Liens légaux">
				<a href="<?php echo esc_url( $kpibi_privacy_url ? $kpibi_privacy_url : '#' ); ?>"><?php echo esc_html( kpibi__( 'Politique de confidentialité' ) ); ?></a>
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
	$kpibi_modal_eye   = $kpibi_is_en ? 'First step' : 'Première étape';
	$kpibi_modal_title = $kpibi_is_en ? 'Book a free consultation' : 'Planifier une consultation gratuite';
	$kpibi_modal_close = $kpibi_is_en ? 'Close' : 'Fermer';
	?>
	<div class="kpibi-modal" id="kpibi-form-modal" aria-hidden="true">
		<div class="kpibi-modal-overlay" data-kpibi-close></div>
		<div class="kpibi-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="kpibi-modal-title">
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
