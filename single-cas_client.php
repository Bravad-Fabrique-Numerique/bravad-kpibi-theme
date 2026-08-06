<?php
/**
 * Gabarit d'affichage d'un cas client individuel (Custom Post Type « cas_client »).
 *
 * Chaque cas client obtient ainsi sa propre URL (/cas-client/nom-du-cas/),
 * indexable individuellement (bon pour le SEO), en plus d'apparaître dans la
 * liste de la page « Cas clients » (template-cas-clients.php). Le contenu
 * affiché ici (contexte, solution, résultats, citation) réutilise exactement
 * le même bloc de mise en page que celui de chaque carte dans la boucle de
 * template-cas-clients.php — voir ce fichier pour la version « liste ».
 *
 * Lien de retour vers la page « Cas clients » : il n'existe pas d'équivalent
 * WordPress natif à get_option('page_for_posts') pour « la page qui utilise
 * le gabarit template-cas-clients.php » (ça n'est pas un réglage standard).
 * Deux options existaient : (1) requêter la page via son meta
 * _wp_page_template, ou (2) un lien statique vers /cas-clients/. On retient
 * l'option (2), plus simple et plus robuste : le slug de la page « Cas
 * clients » est fixe et connu (c'est la page pivot du site, liée depuis le
 * menu principal), alors qu'une requête par meta ajoute une requête SQL
 * supplémentaire sur chaque page pour un gain quasi nul en robustesse.
 *
 * @package KPIBI
 */

get_header();

while ( have_posts() ) :
	the_post();

	$kpibi_post_id = get_the_ID();
	$kpibi_has_acf = function_exists( 'get_field' );

	$kpibi_tag            = $kpibi_has_acf ? kpibi_typo_deep( get_field( 'ccpt_tag', $kpibi_post_id ) ) : '';
	$kpibi_image           = has_post_thumbnail( $kpibi_post_id ) ? get_the_post_thumbnail_url( $kpibi_post_id, 'full' ) : '';
	$kpibi_titre           = get_the_title( $kpibi_post_id );
	$kpibi_titre_fort      = $kpibi_has_acf ? kpibi_typo_deep( get_field( 'ccpt_titre_fort', $kpibi_post_id ) ) : '';
	$kpibi_contexte        = kpibi_cas_lines( $kpibi_has_acf ? get_field( 'ccpt_contexte', $kpibi_post_id ) : '' );
	$kpibi_solution        = kpibi_cas_lines( $kpibi_has_acf ? get_field( 'ccpt_solution', $kpibi_post_id ) : '' );
	$kpibi_solution_liste  = kpibi_cas_lines( $kpibi_has_acf ? get_field( 'ccpt_solution_liste', $kpibi_post_id ) : '' );
	$kpibi_solution_apres  = kpibi_cas_lines( $kpibi_has_acf ? get_field( 'ccpt_solution_apres', $kpibi_post_id ) : '' );
	$kpibi_chiffres        = $kpibi_has_acf ? kpibi_typo_deep( (array) get_field( 'ccpt_resultats_chiffres', $kpibi_post_id ) ) : array();
	$kpibi_resultats       = kpibi_cas_lines( $kpibi_has_acf ? get_field( 'ccpt_resultats_liste', $kpibi_post_id ) : '' );
	$kpibi_citation        = $kpibi_has_acf ? kpibi_typo_deep( get_field( 'ccpt_citation', $kpibi_post_id ) ) : '';
	$kpibi_citation_fort   = $kpibi_has_acf ? kpibi_typo_deep( get_field( 'ccpt_citation_fort', $kpibi_post_id ) ) : '';
	$kpibi_auteur_nom      = $kpibi_has_acf ? kpibi_typo_deep( get_field( 'ccpt_auteur_nom', $kpibi_post_id ) ) : '';
	$kpibi_auteur_role     = $kpibi_has_acf ? kpibi_typo_deep( get_field( 'ccpt_auteur_role', $kpibi_post_id ) ) : '';
	$kpibi_img_pos         = ( $kpibi_has_acf && get_field( 'ccpt_img_position', $kpibi_post_id ) ) ? get_field( 'ccpt_img_position', $kpibi_post_id ) : 'center';

	$kpibi_cas_clients_url = home_url( '/cas-clients/' );
	?>

	<!-- BANNIÈRE -->
	<section class="page-hero">
		<?php if ( $kpibi_image ) : ?>
			<div class="page-hero-bg" style="background-image:url('<?php echo esc_url( $kpibi_image ); ?>');background-position:<?php echo esc_attr( $kpibi_img_pos ); ?>;"></div>
		<?php endif; ?>
		<div class="page-hero-gradient"></div>
		<div class="container"><div class="page-hero-inner">
			<?php if ( $kpibi_tag ) : ?>
				<p class="page-hero-label"><?php echo esc_html( $kpibi_tag ); ?></p>
			<?php endif; ?>
			<?php
			// Une phrase par ligne (KPIBI-36, C2). Même règle que les bannières de
			// page : la fiche d'un cas client porte la même bannière .page-hero.
			$kpibi_h1 = esc_html( $kpibi_titre );
			if ( $kpibi_titre_fort ) {
				$kpibi_h1 .= '<br><strong>' . esc_html( $kpibi_titre_fort ) . '</strong>';
			}
			?>
			<h1><?php echo kpibi_titre_phrases( $kpibi_h1 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fragments déjà échappés ci-dessus, le helper n'ajoute que des <br>. ?></h1>
		</div></div>
	</section>

	<!-- CAS CLIENT -->
	<section class="section-cas">
		<div class="container">
			<article class="cas-card reveal">
				<div class="cas-card-body">

					<?php if ( ! empty( $kpibi_contexte ) ) : ?>
						<h4 style="font-family:'Dubai',sans-serif;font-size:14px;font-weight:500;color:var(--gold-700);text-transform:uppercase;letter-spacing:1.5px;margin-bottom:10px;"><?php echo esc_html( kpibi__( 'Contexte' ) ); ?></h4>
						<?php foreach ( $kpibi_contexte as $kpibi_p ) : ?>
							<p><?php echo esc_html( $kpibi_p ); ?></p>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php if ( ! empty( $kpibi_solution ) ) : ?>
						<h4 style="font-family:'Dubai',sans-serif;font-size:14px;font-weight:500;color:var(--gold-700);text-transform:uppercase;letter-spacing:1.5px;margin-bottom:10px;"><?php echo esc_html( kpibi__( 'La solution KPIBI' ) ); ?></h4>
						<?php foreach ( $kpibi_solution as $kpibi_p ) : ?>
							<p><?php echo esc_html( $kpibi_p ); ?></p>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php if ( ! empty( $kpibi_solution_liste ) ) : ?>
						<ul style="list-style:none;display:grid;gap:10px;margin-bottom:24px;">
							<?php foreach ( $kpibi_solution_liste as $kpibi_item ) : ?>
								<li style="display:flex;gap:10px;font-size:15px;color:var(--slate-700);line-height:1.6;"><span style="color:var(--gold-600);font-weight:700;flex-shrink:0;">›</span><?php echo esc_html( $kpibi_item ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<?php foreach ( $kpibi_solution_apres as $kpibi_p ) : ?>
						<p><?php echo esc_html( $kpibi_p ); ?></p>
					<?php endforeach; ?>

					<?php if ( ! empty( $kpibi_chiffres ) ) : ?>
						<div class="cas-results">
							<?php foreach ( $kpibi_chiffres as $kpibi_chiffre ) : ?>
								<div><p class="cas-result-num"><?php echo esc_html( isset( $kpibi_chiffre['num'] ) ? $kpibi_chiffre['num'] : '' ); ?></p><p class="cas-result-label"><?php echo esc_html( isset( $kpibi_chiffre['label'] ) ? $kpibi_chiffre['label'] : '' ); ?></p></div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $kpibi_resultats ) ) : ?>
						<h4 style="font-family:'Dubai',sans-serif;font-size:14px;font-weight:500;color:var(--gold-700);text-transform:uppercase;letter-spacing:1.5px;margin-bottom:12px;"><?php echo esc_html( kpibi__( 'Résultats' ) ); ?></h4>
						<ul style="list-style:none;display:grid;gap:10px;margin-bottom:28px;">
							<?php foreach ( $kpibi_resultats as $kpibi_item ) : ?>
								<li style="display:flex;gap:10px;font-size:15px;color:var(--slate-700);line-height:1.6;"><span style="color:var(--gold-600);font-weight:700;flex-shrink:0;">✓</span><?php echo esc_html( $kpibi_item ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<?php if ( $kpibi_citation ) : ?>
						<blockquote style="font-style:italic;font-size:16px;color:var(--slate-700);border-left:3px solid var(--gold-400);padding-left:20px;margin:0 0 28px;">
							<?php
							if ( $kpibi_citation_fort && false !== strpos( $kpibi_citation, $kpibi_citation_fort ) ) {
								$kpibi_parts = explode( $kpibi_citation_fort, $kpibi_citation, 2 );
								echo '« ' . esc_html( $kpibi_parts[0] ) . '<strong>' . esc_html( $kpibi_citation_fort ) . '</strong>' . esc_html( $kpibi_parts[1] ) . ' »';
							} else {
								echo '« ' . esc_html( $kpibi_citation ) . ' »';
							}
							?>
							<p class="cas-quote-attrib" style="margin-top:12px;font-size:13px;color:var(--slate-500);font-style:normal;"><strong style="color:var(--slate-900);font-weight:700;"><?php echo esc_html( $kpibi_auteur_nom ); ?></strong> — <?php echo esc_html( $kpibi_auteur_role ); ?></p>
						</blockquote>
					<?php endif; ?>

					<a href="<?php echo esc_url( $kpibi_cas_clients_url ); ?>" class="btn btn-outline-dark">&larr; <?php echo esc_html( kpibi__( 'Retour aux cas clients' ) ); ?></a>
				</div>
			</article>
		</div>
	</section>

	<?php
endwhile;

get_footer();
