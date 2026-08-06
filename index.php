<?php
/**
 * Gabarit de repli : accueil du blogue et archives (liste d'articles).
 *
 * @package KPIBI
 */

get_header();

/*
 * Bannière du blogue : rendue UNIQUEMENT sur l'accueil du blogue. Ce gabarit
 * sert aussi de repli d'archive (catégorie, étiquette, auteur, date, recherche)
 * et une archive ne doit pas hériter de la bannière du blogue.
 *
 * Le contexte de lecture est explicite. Sur is_home(), get_field() est appelé
 * HORS BOUCLE : sans identifiant, la lecture dépend de la résolution implicite
 * d'ACF, alors que le groupe est rattaché par « page_type == posts_page » et
 * non par un identifiant de page. On désigne donc la publication à lire.
 */
$kpibi_blog_bg = is_home() ? kpibi_f( 'blogue_hero_image', '', kpibi_posts_page_id() ) : '';
?>

<section class="page-hero">
	<?php if ( $kpibi_blog_bg ) : ?>
		<div class="page-hero-bg" style="background-image:url('<?php echo esc_url( $kpibi_blog_bg ); ?>');"></div>
	<?php endif; ?>
	<div class="page-hero-gradient"></div>
	<div class="container"><div class="page-hero-inner">
		<?php if ( is_home() ) : ?>
			<p class="page-hero-label"><?php echo esc_html( kpibi_f( 'blogue_hero_label', 'Blogue · Ressources' ) ); ?></p>
		<?php endif; ?>
		<h1><?php echo esc_html( is_home() ? kpibi_f( 'blogue_hero_titre', 'Blogue' ) : wp_get_document_title() ); ?></h1>
		<?php if ( is_home() ) : ?>
			<p class="page-hero-sub"><?php echo esc_html( kpibi_f( 'blogue_hero_sub', "Des articles pratiques sur l'excellence opérationnelle, les KPI, l'automatisation, les applications d'affaires et les systèmes qui soutiennent la performance." ) ); ?></p>
		<?php endif; ?>
	</div></div>
</section>

<?php if ( is_home() ) : ?>
	<?php $kpibi_blog_cats = get_categories( array( 'hide_empty' => true ) ); ?>
	<?php if ( ! empty( $kpibi_blog_cats ) ) : ?>
		<section class="section-blog" style="padding-bottom:0;">
			<div class="container">
				<div class="section-header reveal" style="margin-bottom:32px;">
					<p class="section-label"><?php echo esc_html( kpibi_f( 'blogue_categories_label', "Catégories d'articles" ) ); ?></p>
					<h2><?php echo esc_html( kpibi_f( 'blogue_categories_titre', 'Explorez par' ) ); ?> <strong><?php echo esc_html( kpibi_f( 'blogue_categories_titre_fort', 'thématique' ) ); ?></strong></h2>
				</div>
				<div class="reveal" style="display:flex;flex-wrap:wrap;justify-content:center;gap:12px;">
					<?php foreach ( $kpibi_blog_cats as $kpibi_cat_item ) : ?>
						<a href="<?php echo esc_url( get_category_link( $kpibi_cat_item ) ); ?>" class="blog-tag"><?php echo esc_html( $kpibi_cat_item->name ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>
<?php endif; ?>

<section class="section-blog">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="blog-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<a href="<?php the_permalink(); ?>" class="blog-card reveal">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php
							// Repli : le titre de l'article, qui décrit la vignette. Un article
							// sans titre resterait sans alt : libellé générique dans ce cas.
							$kpibi_vignette_repli = trim( (string) get_the_title() );
							if ( '' === $kpibi_vignette_repli ) {
								$kpibi_vignette_repli = kpibi__( 'Article du blogue KPIBI' );
							}
							?>
							<img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium_large' ) ); ?>" alt="<?php echo esc_attr( kpibi_thumb_alt( get_the_ID(), $kpibi_vignette_repli ) ); ?>" class="blog-card-img" loading="lazy">
						<?php endif; ?>
						<div class="blog-card-body">
							<?php
							$kpibi_cat = get_the_category();
							if ( ! empty( $kpibi_cat ) ) :
								?>
								<span class="blog-card-tag"><?php echo esc_html( $kpibi_cat[0]->name ); ?></span>
							<?php endif; ?>
							<h3><?php the_title(); ?></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
							<div class="blog-card-footer">
								<span class="blog-card-date"><?php echo esc_html( get_the_date() ); ?></span>
								<span class="blog-read-more"><?php echo esc_html( kpibi__( 'Lire' ) ); ?> <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"></path></svg></span>
							</div>
						</div>
					</a>
					<?php
				endwhile;
				?>
			</div>
			<div style="margin-top:48px; text-align:center;">
				<?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?>
			</div>
		<?php else : ?>
			<p style="text-align:center; color:var(--slate-500);"><?php echo esc_html( kpibi__( 'Aucun article pour le moment.' ) ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php if ( is_home() ) : ?>
<section class="section-cta" id="cta" aria-labelledby="cta-heading">
	<div class="container">
		<p class="cta-label"><?php echo esc_html( kpibi_f( 'blogue_cta_label', 'Discutons' ) ); ?></p>
		<h2 id="cta-heading"><?php echo esc_html( kpibi_f( 'blogue_cta_titre', 'Vous avez des questions?' ) ); ?><br><strong><?php echo esc_html( kpibi_f( 'blogue_cta_titre_fort', 'Parlons-en.' ) ); ?></strong></h2>
		<p><?php echo esc_html( kpibi_f( 'blogue_cta_texte', 'Un sujet d\'article vous interpelle ou vous vivez le même défi dans votre PME? La première consultation est gratuite et sans engagement.' ) ); ?></p>
		<div class="cta-actions">
			<a href="<?php echo esc_url( kpibi_f( 'blogue_cta_btn1_url', 'mailto:' . get_theme_mod( 'kpibi_email', 'info@kpibi.com' ) ) ); ?>" class="btn btn-primary" style="font-size:16px;padding:14px 32px;"><?php echo esc_html( kpibi_f( 'blogue_cta_btn1_texte', 'Réserver ma consultation gratuite' ) ); ?></a>
			<a href="<?php echo esc_url( kpibi_link( kpibi_f( 'blogue_cta_btn2_url', '' ), 'forfait' ) ); ?>" class="btn btn-outline" style="font-size:16px;padding:14px 32px;"><?php echo esc_html( kpibi_f( 'blogue_cta_btn2_texte', 'Voir le forfait' ) ); ?></a>
		</div>
		<p class="cta-guarantee"><?php echo esc_html( kpibi_f( 'blogue_cta_garantie', 'Sans engagement · Réponse en moins de 24h · Expertise locale québécoise' ) ); ?></p>
	</div>
</section>
<?php endif; ?>

<?php
get_footer();
