<?php
/**
 * Gabarit générique de page (pages créées dans WordPress).
 *
 * @package KPIBI
 */

get_header();

while ( have_posts() ) :
	the_post();
	$kpibi_bg = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '';
	?>
	<section class="page-hero">
		<?php if ( $kpibi_bg ) : ?>
			<div class="page-hero-bg" style="background-image:url('<?php echo esc_url( $kpibi_bg ); ?>');"></div>
		<?php endif; ?>
		<div class="page-hero-gradient"></div>
		<div class="container"><div class="page-hero-inner">
			<h1><?php the_title(); ?></h1>
		</div></div>
	</section>

	<section class="section-split bg-light">
		<div class="container" style="max-width:860px;">
			<div class="split-content">
				<?php the_content(); ?>
			</div>
		</div>
	</section>
	<?php
endwhile;

get_footer();
