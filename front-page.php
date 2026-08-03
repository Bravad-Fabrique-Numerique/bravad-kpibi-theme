<?php
/**
 * Page d'accueil.
 * Tout le contenu provient des champs ACF (onglet « Page d'accueil KPIBI »),
 * avec repli sur le contenu d'origine si un champ est vide ou si ACF est absent.
 *
 * @package KPIBI
 */

get_header();

/* Petite fonction locale : 5 étoiles. */
$kpibi_stars = '<div class="stars" aria-label="' . esc_attr( kpibi__( '5 étoiles sur 5' ) ) . '">' .
	str_repeat( '<svg viewBox="0 0 24 24" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>', 5 ) .
	'</div>';

$kpibi_hero_img = kpibi_f( 'hero_image', '' );
?>

<!-- HERO -->
<section class="hero" aria-labelledby="hero-heading">
	<?php if ( $kpibi_hero_img ) : ?>
		<div class="hero-bg" style="background-image:url('<?php echo esc_url( $kpibi_hero_img ); ?>');" role="img" aria-label="KPIBI"></div>
	<?php endif; ?>
	<div class="hero-gradient"></div>
	<div class="container"><div class="hero-inner">
		<p class="hero-label"><?php echo esc_html( kpibi_f( 'hero_label', 'Optimisation des processus • Automatisation • Tableaux de bord KPI' ) ); ?></p>
		<h1 id="hero-heading"><?php
			echo esc_html( kpibi_f( 'hero_titre', 'Moins de friction. Plus de capacité.' ) );
			echo '<br><strong>' . esc_html( kpibi_f( 'hero_titre_fort', 'Sans embaucher.' ) ) . '</strong>';
			$kpibi_hero_fin = kpibi_f( 'hero_titre_fin', '' );
			if ( $kpibi_hero_fin ) {
				echo ' ' . esc_html( $kpibi_hero_fin );
			}
		?></h1>
		<p class="hero-sub"><?php echo nl2br( esc_html( kpibi_f( 'hero_sub', "Vos opérations sont complexes. Nos solutions, elles, ne le sont pas. Nous concevons des processus, des automatisations et des outils qui s'adaptent à votre réalité, pour que la performance devienne le résultat naturel de votre système, pas un effort quotidien." ) ) ); ?></p>
		<div class="hero-actions">
			<a href="<?php echo esc_url( kpibi_f( 'hero_cta1_url', '#cta' ) ); ?>" class="btn btn-primary"><?php echo esc_html( kpibi_f( 'hero_cta1_texte', 'Parler à un expert' ) ); ?></a>
			<a href="<?php echo esc_url( kpibi_link( kpibi_f( 'hero_cta2_url', '' ), 'cas-clients' ) ); ?>" class="btn btn-outline"><?php echo esc_html( kpibi_f( 'hero_cta2_texte', 'Voir nos réalisations' ) ); ?></a>
		</div>
	</div></div>
</section>

<!-- STATISTIQUES -->
<section class="section-stats">
	<div class="container"><div class="stats-grid">
		<div class="stat-item reveal"><p class="stat-num"><?php echo esc_html( kpibi_f( 'stat1_num', '15+' ) ); ?></p><p class="stat-label"><?php echo esc_html( kpibi_f( 'stat1_label', "ans d'expérience terrain" ) ); ?></p></div>
		<div class="stat-divider"></div>
		<div class="stat-item reveal reveal-delay-1"><p class="stat-num"><?php echo esc_html( kpibi_f( 'stat2_num', '3 000+' ) ); ?></p><p class="stat-label"><?php echo esc_html( kpibi_f( 'stat2_label', 'opérations automatisées chaque jour' ) ); ?></p></div>
		<div class="stat-divider"></div>
		<div class="stat-item reveal reveal-delay-2"><p class="stat-num" style="font-size:clamp(30px,4vw,44px);letter-spacing:-1px;"><?php echo esc_html( kpibi_f( 'stat3_num', 'Multisectoriel' ) ); ?></p><p class="stat-label"><?php echo esc_html( kpibi_f( 'stat3_label', 'manufacturier, municipal, santé, finance, distribution et plus' ) ); ?></p></div>
	</div></div>
</section>

<!-- PILIERS -->
<section class="section-piliers">
	<div class="container">
		<div class="section-header reveal">
			<p class="section-label"><?php echo esc_html( kpibi_f( 'piliers_label', 'Nos solutions' ) ); ?></p>
			<h2><?php echo esc_html( kpibi_f( 'piliers_titre', 'Quatre leviers qui travaillent' ) ); ?> <strong><?php echo esc_html( kpibi_f( 'piliers_titre_fort', 'ensemble' ) ); ?></strong></h2>
			<p><?php echo esc_html( kpibi_f( 'piliers_intro', 'Quatre leviers qui travaillent ensemble pour simplifier vos opérations et améliorer votre performance.' ) ); ?></p>
		</div>
		<div class="piliers-grid">
			<?php
			$kpibi_pilier_defaults = array(
				array( 'Optimisation des processus', "Des processus mieux conçus pour éliminer le gaspillage et les goulots d'étranglement, maximiser vos ressources et améliorer votre efficacité opérationnelle.", 'service-optimisation', 'optimisation' ),
				array( 'Tableaux de bord KPI', "Accédez à des indicateurs de performance fiables et à jour afin d'améliorer votre visibilité opérationnelle, de prendre de meilleures décisions et d'aligner vos équipes sur les bonnes priorités.", 'tableaux-de-bord', 'tableau_bord' ),
				array( 'Automatisation des processus', "Automatisez les tâches répétitives, qu'elles soient simples ou complexes, connectez vos systèmes et réduisez les délais afin de permettre à vos équipes de se concentrer sur les activités à valeur ajoutée.", 'service-automatisation', 'automatisation' ),
				array( 'Applications web sur mesure', 'Des applications sur mesure conçues autour de votre réalité opérationnelle pour compléter ou remplacer les fichiers Excel, les ERP et les CRM mal adaptés à vos processus.', 'service-applications', 'application' ),
			);
			for ( $i = 1; $i <= 4; $i++ ) :
				$d    = $kpibi_pilier_defaults[ $i - 1 ];
				$url  = kpibi_link( kpibi_f( "pilier{$i}_url", '' ), $d[2] );
				$pimg = kpibi_f( "pilier{$i}_image", '' );
				?>
				<a href="<?php echo esc_url( $url ); ?>" class="pilier-card reveal reveal-delay-<?php echo (int) $i; ?>">
					<?php if ( $pimg ) : ?>
						<img src="<?php echo esc_url( $pimg ); ?>" alt="<?php echo esc_attr( kpibi_img_alt( $pimg, kpibi_f( "pilier{$i}_titre", $d[0] ) ) ); ?>" class="pilier-img" loading="lazy">
					<?php else : ?>
						<div class="pilier-img" style="background:#ECEAE3;" aria-hidden="true"></div>
					<?php endif; ?>
					<div class="pilier-body">
						<div class="pilier-icon"><svg viewBox="0 0 24 24"><?php echo kpibi_icon( kpibi_f( "pilier{$i}_icon", $d[3] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></svg></div>
						<h3><?php echo esc_html( kpibi_f( "pilier{$i}_titre", $d[0] ) ); ?></h3>
						<p><?php echo esc_html( kpibi_f( "pilier{$i}_texte", $d[1] ) ); ?></p>
						<span class="pilier-link"><?php echo esc_html( kpibi__( 'En savoir plus' ) ); ?> <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"></path></svg></span>
					</div>
				</a>
			<?php endfor; ?>
		</div>
	</div>
</section>

<!-- POURQUOI -->
<section class="section-pourquoi">
	<div class="container"><div class="pourquoi-inner">
		<div class="pourquoi-visual reveal">
			<?php $kpibi_pourquoi_img = kpibi_f( 'pourquoi_image', '' ); ?>
			<?php if ( $kpibi_pourquoi_img ) : ?>
				<img src="<?php echo esc_url( $kpibi_pourquoi_img ); ?>" alt="<?php echo esc_attr( kpibi_img_alt( $kpibi_pourquoi_img, kpibi__( 'Illustration de la section « Pourquoi KPIBI »' ) ) ); ?>" class="pourquoi-img" loading="lazy">
			<?php else : ?>
				<div class="pourquoi-img" style="background:#1A1A1A;" aria-hidden="true"></div>
			<?php endif; ?>
			<div class="pourquoi-badge"><p class="pourquoi-badge-num"><?php echo esc_html( kpibi_f( 'pourquoi_badge_num', '3 000+' ) ); ?></p><p class="pourquoi-badge-label"><?php echo esc_html( kpibi_f( 'pourquoi_badge_label', 'opérations automatisées chaque jour' ) ); ?></p></div>
		</div>
		<div class="pourquoi-content reveal reveal-delay-1">
			<p class="section-label"><?php echo esc_html( kpibi_f( 'pourquoi_label', 'Pourquoi KPIBI' ) ); ?></p>
			<h2><?php
				echo esc_html( kpibi_f( 'pourquoi_titre', 'Pourquoi' ) ) . ' ';
				echo '<strong>' . esc_html( kpibi_f( 'pourquoi_titre_fort', 'KPIBI' ) ) . '</strong>';
				echo esc_html( kpibi_f( 'pourquoi_titre_fin', '?' ) );
			?></h2>
			<p><?php echo esc_html( kpibi_f( 'pourquoi_intro', "La plupart des firmes s'arrêtent aux recommandations. Les intégrateurs, eux, s'arrêtent à la technologie. Chez KPIBI, on fait le pont entre les deux : on analyse vos processus, on conçoit les bons outils et on les implante. Ensemble, ces leviers créent des systèmes où vos équipes peuvent enfin travailler comme elles devraient." ) ); ?></p>
			<div class="diff-numbered">
				<?php
				$kpibi_diff_defaults = array(
					array( 'Performance naturelle', "Les organisations les plus performantes ne demandent pas des efforts héroïques à leurs équipes : elles s'appuient sur des systèmes bien conçus. Nous agissons sur les processus, les outils et l'environnement de travail pour que les bonnes pratiques deviennent naturelles." ),
					array( "De la stratégie à l'implantation", "La plupart des consultants livrent un rapport, la plupart des intégrateurs livrent un outil. Nous livrons des solutions complètes sur mesure, avec des gains mesurables, et on s'assure que ça fonctionne dans votre réalité." ),
					array( "Partenaire d'amélioration continue", "Grâce à notre modèle de forfait mensuel, nous continuons d'améliorer, d'adapter et de soutenir vos solutions à mesure que votre organisation évolue." ),
					array( 'Résultats mesurables', "Chaque initiative est liée à des objectifs clairs, des indicateurs de performance et des résultats observables, pour concentrer les efforts là où ils créent le plus de valeur." ),
				);
				for ( $i = 1; $i <= 4; $i++ ) :
					$d = $kpibi_diff_defaults[ $i - 1 ];
					?>
					<div class="diff-item-num"><span class="diff-num"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></span><div class="diff-content"><strong><?php echo esc_html( kpibi_f( "diff{$i}_titre", $d[0] ) ); ?></strong><span><?php echo esc_html( kpibi_f( "diff{$i}_texte", $d[1] ) ); ?></span></div></div>
				<?php endfor; ?>
			</div>
			<div class="rapport-teaser">
				<div class="rapport-icon"><svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line><line x1="3" y1="20" x2="21" y2="20"></line></svg></div>
				<div class="rapport-text"><strong><?php echo esc_html( kpibi_f( 'rapport_titre', 'Analyse comparative offerte à la consultation' ) ); ?></strong><span><?php echo esc_html( kpibi_f( 'rapport_texte', 'Repartez avec une feuille de route claire et une analyse comparative financière de votre industrie.' ) ); ?></span></div>
			</div>
		</div>
	</div></div>
</section>

<!-- TÉMOIGNAGES -->
<section class="section-temoignages">
	<div class="container">
		<div class="section-header reveal">
			<p class="section-label"><?php echo esc_html( kpibi_f( 'temo_label', 'Ce que disent nos clients' ) ); ?></p>
			<h2><?php echo esc_html( kpibi_f( 'temo_titre', 'Des organisations qui ont' ) ); ?> <strong><?php echo esc_html( kpibi_f( 'temo_titre_fort', 'fait le saut' ) ); ?></strong></h2>
			<?php $kpibi_temo_intro = kpibi_f( 'temo_intro', '' ); ?>
			<?php if ( $kpibi_temo_intro ) : ?>
				<p><?php echo esc_html( $kpibi_temo_intro ); ?></p>
			<?php endif; ?>
		</div>
		<div class="temoignages-grid">
			<?php
			$kpibi_temo_defaults = array(
				array( 'Brass Plomberie', 'Grâce à KPIBI, nous avons maintenant des KPI clairs, utiles et faciles à suivre au quotidien, regroupés dans un tableau de bord automatisé connecté à notre ERP et à notre logiciel comptable. Nous avons une meilleure visibilité sur nos opérations et une information plus structurée pour soutenir nos décisions.', 'Stéphanie Girard', 'CoPropriétaire, Stratégie et Optimisation des projets, Brass Plomberie', 'SG' ),
				array( 'N.V. Cloutier', 'Avant KPIBI, notre suivi client était éclaté entre des notes, des appels et des souvenirs. Aujourd\'hui, tout est centralisé, nos représentants travaillent efficacement sur le terrain et nous avons une visibilité complète sur les ventes, les activités et les opportunités.', 'Charles Martineau', 'CoPropriétaire, Directeur des opérations fixes, N.V. Cloutier', 'CM' ),
				array( 'Bravad', 'KPIBI se distingue par sa capacité à comprendre rapidement les réalités d\'affaires et à transformer des défis opérationnels complexes en solutions concrètes. Leur équipe nous accompagne sur une variété d\'initiatives, de l\'amélioration des processus à l\'automatisation, toujours avec une approche pragmatique ancrée dans la réalité du terrain.', 'Pierre-Philippe Rousseau', 'Vice-Président Finance et administration, Bravad', 'PR' ),
			);
			for ( $i = 1; $i <= 3; $i++ ) :
				$d        = $kpibi_temo_defaults[ $i - 1 ];
				$nom      = kpibi_f( "temo{$i}_nom", $d[2] );
				$initials = $d[4];
				?>
				<article class="temoignage-card reveal reveal-delay-<?php echo (int) $i; ?>">
					<div class="client-logo-placeholder"><?php echo esc_html( kpibi_f( "temo{$i}_client", $d[0] ) ); ?></div>
					<?php echo $kpibi_stars; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<blockquote><?php echo esc_html( kpibi_f( "temo{$i}_quote", $d[1] ) ); ?></blockquote>
					<div class="temoignage-author"><div class="author-avatar"><?php echo esc_html( $initials ); ?></div><div class="author-info"><strong><?php echo esc_html( $nom ); ?></strong><span><?php echo esc_html( kpibi_f( "temo{$i}_role", $d[3] ) ); ?></span></div></div>
				</article>
			<?php endfor; ?>
		</div>
	</div>
</section>

<!-- APPEL À L'ACTION -->
<section class="section-cta" id="cta" aria-labelledby="cta-heading">
	<div class="container">
		<p class="cta-label"><?php echo esc_html( kpibi_f( 'cta_label', 'Première étape' ) ); ?></p>
		<h2 id="cta-heading"><?php echo esc_html( kpibi_f( 'cta_titre', 'Une heure avec nous.' ) ); ?><br><strong><?php echo esc_html( kpibi_f( 'cta_titre_fort', 'Une feuille de route pour vous.' ) ); ?></strong></h2>
		<p><?php echo esc_html( kpibi_f( 'cta_texte', "Planifiez une consultation gratuite, sans engagement. Vous repartirez avec une feuille de route claire, les premiers leviers d'amélioration identifiés et une analyse comparative financière de votre industrie." ) ); ?></p>
		<div class="cta-actions">
			<a href="<?php echo esc_url( kpibi_f( 'cta_btn1_url', 'mailto:' . get_theme_mod( 'kpibi_email', 'info@kpibi.com' ) ) ); ?>" class="btn btn-primary" style="font-size:16px;padding:14px 32px;"><?php echo esc_html( kpibi_f( 'cta_btn1_texte', 'Planifier une consultation gratuite' ) ); ?></a>
			<a href="<?php echo esc_url( kpibi_link( kpibi_f( 'cta_btn2_url', '' ), 'cas-clients' ) ); ?>" class="btn btn-outline" style="font-size:16px;padding:14px 32px;"><?php echo esc_html( kpibi_f( 'cta_btn2_texte', 'Voir nos réalisations' ) ); ?></a>
		</div>
		<p class="cta-guarantee"><?php echo esc_html( kpibi_f( 'cta_garantie', 'Sans engagement · Feuille de route claire · Analyse comparative de votre industrie' ) ); ?></p>
	</div>
</section>

<?php get_footer(); ?>
