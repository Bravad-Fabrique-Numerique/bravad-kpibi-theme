<?php
/**
 * En-tête : <head>, barre de navigation et menu mobile.
 *
 * @package KPIBI
 */

$kpibi_linkedin = esc_url( get_theme_mod( 'kpibi_linkedin_url', 'https://www.linkedin.com/company/kpibi' ) );
$kpibi_cta_href = is_front_page() ? '#cta' : esc_url( home_url( '/#cta' ) );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) { wp_body_open(); } ?>

<header>
	<nav class="nav" aria-label="Navigation principale">
		<div class="container nav-inner">
			<?php kpibi_logo( 38 ); ?>

			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'nav-links',
					'menu_id'        => '',
					'depth'          => 2,
					'walker'         => new KPIBI_Nav_Walker(),
					'fallback_cb'    => '__return_empty_string',
					'items_wrap'     => '<ul class="nav-links" role="list">%3$s</ul>',
				)
			);
			?>

			<a href="<?php echo esc_url( $kpibi_cta_href ); ?>" class="btn btn-primary nav-cta" style="font-size:13px; padding:10px 18px;"><?php echo esc_html( kpibi__( 'Consultation gratuite' ) ); ?></a>

			<a href="<?php echo esc_url( $kpibi_linkedin ); ?>" target="_blank" rel="noopener noreferrer" class="nav-linkedin" aria-label="KPIBI sur LinkedIn">
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"></path><circle cx="4" cy="4" r="2"></circle></svg>
			</a>

			<?php kpibi_language_switcher(); ?>

			<button class="hamburger" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="mobile-menu" id="hamburger-btn">
				<span></span><span></span><span></span>
			</button>
		</div>
	</nav>
</header>

<div class="mobile-menu" id="mobile-menu" role="dialog" aria-modal="true" aria-label="Menu de navigation">
	<div class="mobile-menu-header">
		<?php kpibi_logo( 32 ); ?>
		<button class="mobile-menu-close" id="mobile-menu-close" aria-label="Fermer le menu">&times;</button>
	</div>
	<nav>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'items_wrap'     => '%3$s',
				'depth'          => 2,
				'walker'         => new KPIBI_Mobile_Walker(),
				'fallback_cb'    => '__return_empty_string',
			)
		);
		?>
		<a href="<?php echo esc_url( $kpibi_linkedin ); ?>" target="_blank" rel="noopener noreferrer" class="sub">LinkedIn</a>
	</nav>
	<?php kpibi_language_switcher( 'lang-switcher lang-switcher-mobile' ); ?>
	<div class="mobile-cta"><a href="<?php echo esc_url( $kpibi_cta_href ); ?>" class="btn btn-primary"><?php echo esc_html( kpibi__( 'Consultation gratuite' ) ); ?></a></div>
</div>

<main>
