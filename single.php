<?php
/**
 * Gabarit d'un article de blogue individuel.
 * Sans ce gabarit, WordPress retombait sur index.php (pensé pour une liste
 * d'articles, pas pour l'affichage complet d'un seul).
 *
 * @package KPIBI
 */

get_header();

while ( have_posts() ) :
	the_post();
	$kpibi_bg  = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '';
	$kpibi_cat = get_the_category();

	$kpibi_blog_page_id = (int) get_option( 'page_for_posts' );
	$kpibi_blog_url      = $kpibi_blog_page_id ? get_permalink( $kpibi_blog_page_id ) : home_url( '/' );
	?>
	<section class="page-hero">
		<?php if ( $kpibi_bg ) : ?>
			<div class="page-hero-bg" style="background-image:url('<?php echo esc_url( $kpibi_bg ); ?>');"></div>
		<?php endif; ?>
		<div class="page-hero-gradient"></div>
		<div class="container"><div class="page-hero-inner">
			<?php if ( ! empty( $kpibi_cat ) ) : ?>
				<p class="page-hero-label"><?php echo esc_html( $kpibi_cat[0]->name ); ?></p>
			<?php endif; ?>
			<h1><?php the_title(); ?></h1>
			<p class="page-hero-sub"><?php echo esc_html( get_the_date() ); ?></p>
		</div></div>
	</section>

	<section class="section-split bg-light">
		<div class="container" style="max-width:860px;">
			<div class="split-content">
				<?php the_content(); ?>
			</div>
			<div style="margin-top:40px;">
				<a href="<?php echo esc_url( $kpibi_blog_url ); ?>" class="btn btn-outline-dark">&larr; <?php echo esc_html( kpibi__( 'Retour au blogue' ) ); ?></a>
			</div>
		</div>
	</section>
	<?php
endwhile;

get_footer();
