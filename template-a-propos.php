<?php
/* Template Name: Page à propos */
/**
 * Page « À propos ».
 * Tout le contenu provient des champs ACF (onglet « Page à propos KPIBI »),
 * avec repli sur le contenu d'origine si un champ est vide ou si ACF est absent.
 *
 * @package KPIBI
 */

get_header();

while ( have_posts() ) :
	the_post();

	$kpibi_hero_img = kpibi_f( 'apropos_hero_image', '' );
	?>

	<main>
		<!-- BANNIÈRE -->
		<section class="page-hero">
			<?php if ( $kpibi_hero_img ) : ?>
				<div class="page-hero-bg" style="background-image:url('<?php echo esc_url( $kpibi_hero_img ); ?>');"></div>
			<?php endif; ?>
			<div class="page-hero-gradient"></div>
			<div class="container"><div class="page-hero-inner">
				<p class="page-hero-label"><?php echo esc_html( kpibi_f( 'apropos_hero_label', 'Notre firme · Québec' ) ); ?></p>
				<h1><?php
					echo esc_html( kpibi_f( 'apropos_hero_titre', 'Derrière KPIBI,' ) );
					echo '<br><strong>' . esc_html( kpibi_f( 'apropos_hero_titre_fort', 'il y a une conviction simple.' ) ) . '</strong>';
				?></h1>
				<p class="page-hero-sub"><?php echo esc_html( kpibi_f( 'apropos_hero_sub', "Les résultats d'une organisation dépendent d'abord de la qualité de ses systèmes — pas de l'effort individuel. Toute notre approche en découle." ) ); ?></p>
				<div class="page-hero-actions">
					<a href="<?php echo esc_url( kpibi_f( 'apropos_hero_cta1_url', '#cta' ) ); ?>" class="btn btn-primary"><?php echo esc_html( kpibi_f( 'apropos_hero_cta1_texte', 'Planifier une consultation gratuite' ) ); ?></a>
					<a href="<?php echo esc_url( kpibi_link( kpibi_f( 'apropos_hero_cta2_url', '' ), 'forfait' ) ); ?>" class="btn btn-outline"><?php echo esc_html( kpibi_f( 'apropos_hero_cta2_texte', 'Voir notre forfait' ) ); ?></a>
				</div>
			</div></div>
		</section>

		<!-- FONDATEUR -->
		<section class="section-split bg-light">
			<div class="container"><div class="split-inner">
				<?php $kpibi_fondateur_img = kpibi_f( 'fondateur_image', '' ); ?>
				<?php if ( $kpibi_fondateur_img ) : ?>
					<img src="<?php echo esc_url( $kpibi_fondateur_img ); ?>" alt="<?php echo esc_attr( kpibi_f( 'fondateur_image_alt', 'Phil Bexton, fondateur et président de KPIBI' ) ); ?>" class="split-img reveal" loading="lazy" style="object-position:center 35%;">
				<?php else : ?>
					<div class="split-img reveal" style="background:#ECEAE3;" aria-hidden="true"></div>
				<?php endif; ?>
				<div class="split-content reveal reveal-delay-1">
					<p class="section-label"><?php echo esc_html( kpibi_f( 'fondateur_label', 'Le fondateur' ) ); ?></p>
					<h2><?php
						echo esc_html( kpibi_f( 'fondateur_titre', 'Phil Bexton,' ) ) . ' ';
						echo '<strong>' . esc_html( kpibi_f( 'fondateur_titre_fort', 'fondateur et président' ) ) . '</strong>';
					?></h2>
					<p><?php echo esc_html( kpibi_f( 'fondateur_texte1', "Phil Bexton est le fondateur et président de KPIBI. Depuis plus de 15 ans, il aide les organisations à simplifier leurs opérations, améliorer leur visibilité et concevoir des environnements où la performance devient le résultat naturel du système." ) ); ?></p>
					<p><?php echo esc_html( kpibi_f( 'fondateur_texte2', "Son parcours couvre les deux solitudes de l'amélioration organisationnelle : la stratégie et l'exécution. Il a dirigé des initiatives touchant les opérations, la finance, les ressources humaines, les ventes, l'administration et la logistique. Ancien pionnier de l'intelligence d'affaires chez Bombardier Aéronautique, puis cadre supérieur dans les secteurs public et privé, il combine une expertise en Lean Six Sigma, en architecture d'entreprise et en technologies d'affaires pour transformer des objectifs stratégiques en résultats concrets." ) ); ?></p>
					<p><?php echo esc_html( kpibi_f( 'fondateur_texte3', "KPIBI est née d'un constat répété : trop d'organisations investissent dans des outils ou des conseils qui ne changent rien sur le terrain. Pas parce que les gens manquent de volonté, mais parce que le système n'est pas conçu pour les soutenir. Cette conviction guide chacune des interventions de KPIBI." ) ); ?></p>
				</div>
			</div></div>
		</section>

		<!-- MISSION & PHILOSOPHIE -->
		<section class="section-mission">
			<div class="container"><div class="mission-inner">
				<div class="mission-content reveal">
					<p class="section-label"><?php echo esc_html( kpibi_f( 'mission_label', 'Notre mission' ) ); ?></p>
					<h2><?php
						echo esc_html( kpibi_f( 'mission_titre', 'Rendre la performance' ) );
						echo '<br><strong>' . esc_html( kpibi_f( 'mission_titre_fort', 'naturelle' ) ) . '</strong>';
					?></h2>
					<p><?php echo esc_html( kpibi_f( 'mission_texte', "Notre mission est de concevoir des systèmes de travail où les processus, les outils, les indicateurs et l'environnement opérationnel rendent la performance naturelle." ) ); ?></p>
				</div>
				<div class="mission-content reveal reveal-delay-1">
					<p class="section-label"><?php echo esc_html( kpibi_f( 'philosophie_label', 'Notre philosophie' ) ); ?></p>
					<h2><?php
						echo esc_html( kpibi_f( 'philosophie_titre', 'La qualité du système' ) );
						echo '<br><strong>' . esc_html( kpibi_f( 'philosophie_titre_fort', "avant l'effort individuel" ) ) . '</strong>';
					?></h2>
					<p><?php echo esc_html( kpibi_f( 'philosophie_texte', "Nous croyons que les résultats d'une organisation sont principalement déterminés par la qualité de ses systèmes plutôt que par l'effort individuel. Lorsque les processus, les outils et l'environnement de travail sont bien conçus, les bonnes décisions deviennent plus faciles, les erreurs diminuent et la performance émerge naturellement." ) ); ?></p>
				</div>
			</div></div>
		</section>

		<!-- VALEURS -->
		<section class="section-pourquoi">
			<div class="container">
				<div class="section-header reveal">
					<p class="section-label section-label-light"><?php echo esc_html( kpibi_f( 'valeurs_label', 'Nos valeurs' ) ); ?></p>
					<h2 style="font-family:'Dubai',sans-serif;font-weight:300;color:var(--white);font-size:clamp(28px,3.8vw,44px);line-height:1.15;"><?php
						echo esc_html( kpibi_f( 'valeurs_titre', 'Ce qui guide' ) ) . ' ';
						echo '<strong style="font-weight:500;color:var(--gold-400);">' . esc_html( kpibi_f( 'valeurs_titre_fort', 'chacune de nos interventions' ) ) . '</strong>';
					?></h2>
				</div>
				<div class="benefits-grid" style="margin-top:0;">
					<?php
					$kpibi_valeurs_defaults = array(
						array(
							'titre' => 'Terrain avant théorie',
							'texte' => 'Les meilleures solutions naissent d\'une compréhension profonde de la réalité opérationnelle, pas de présentations PowerPoint.',
							'icone' => 'loupe',
						),
						array(
							'titre' => 'Simplicité comme discipline',
							'texte' => 'La vraie expertise, c\'est de rendre les choses plus simples. Pas plus complexes.',
							'icone' => 'cible',
						),
						array(
							'titre' => 'Des résultats, pas des livrables',
							'texte' => 'Un rapport n\'est pas un résultat. Une automatisation qui tourne à 3 h du matin et libère deux heures par jour à votre équipe, oui.',
							'icone' => 'barres',
						),
					);

					$kpibi_valeurs = kpibi_f( 'valeurs', array() );
					if ( ! is_array( $kpibi_valeurs ) || empty( $kpibi_valeurs ) ) {
						$kpibi_valeurs = $kpibi_valeurs_defaults;
					}

					foreach ( $kpibi_valeurs as $kpibi_i => $kpibi_valeur ) :
						$kpibi_n     = $kpibi_i + 1;
						$kpibi_icone = isset( $kpibi_valeur['icone'] ) && $kpibi_valeur['icone'] ? $kpibi_valeur['icone'] : $kpibi_valeurs_defaults[ $kpibi_i % 3 ]['icone'];
						?>
						<div class="benefit-card reveal reveal-delay-<?php echo (int) min( $kpibi_n, 4 ); ?>">
							<div class="benefit-icon"><svg viewBox="0 0 24 24"><?php echo kpibi_icon( $kpibi_icone ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></svg></div>
							<h3><?php echo esc_html( $kpibi_valeur['titre'] ); ?></h3>
							<p><?php echo esc_html( $kpibi_valeur['texte'] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<!-- STATISTIQUES -->
		<section class="section-stats">
			<div class="container">
				<div class="stats-grid">
					<div class="stat-item reveal"><p class="stat-num"><?php echo esc_html( kpibi_f( 'apropos_stat1_num', '15+' ) ); ?></p><p class="stat-label"><?php echo esc_html( kpibi_f( 'apropos_stat1_label', "Ans d'expérience terrain" ) ); ?></p></div>
					<div class="stat-divider"></div>
					<div class="stat-item reveal reveal-delay-1"><p class="stat-num"><?php echo esc_html( kpibi_f( 'apropos_stat2_num', '3 000+' ) ); ?></p><p class="stat-label"><?php echo esc_html( kpibi_f( 'apropos_stat2_label', 'Opérations automatisées chaque jour' ) ); ?></p></div>
					<div class="stat-divider"></div>
					<div class="stat-item reveal reveal-delay-2"><p class="stat-num"><?php echo esc_html( kpibi_f( 'apropos_stat3_num', '6' ) ); ?></p><p class="stat-label"><?php echo esc_html( kpibi_f( 'apropos_stat3_label', "Axes transversaux d'intervention" ) ); ?></p></div>
				</div>
				<div style="text-align:center;margin-top:48px;max-width:720px;margin-left:auto;margin-right:auto;">
					<p style="font-size:14px;color:rgba(255,255,255,0.50);line-height:1.7;"><?php
						echo esc_html( kpibi_f( 'apropos_stats_texte', 'Opérations, Finance, RH, Ventes, TI, Gouvernance et gestion des risques — soutenus par' ) ) . ' ';
						echo '<strong style="color:var(--gold-400);font-weight:600;">' . esc_html( kpibi_f( 'apropos_stats_texte_fort', '3 piliers d\'expertise combinés' ) ) . '</strong>';
						echo ' ' . esc_html( kpibi_f( 'apropos_stats_texte_fin', ': Stratégie · Architecture · Exécution.' ) );
					?></p>
				</div>
			</div>
		</section>

		<!-- NOTRE FORCE -->
		<section class="section-split bg-light">
			<div class="container"><div class="split-inner">
				<div class="split-content reveal">
					<p class="section-label"><?php echo esc_html( kpibi_f( 'force_label', 'Notre force' ) ); ?></p>
					<h2><?php
						echo esc_html( kpibi_f( 'force_titre', 'Une expertise ancrée dans la' ) ) . ' ';
						echo '<strong>' . esc_html( kpibi_f( 'force_titre_fort', 'réalité terrain' ) ) . '</strong>';
					?></h2>
					<p><?php echo esc_html( kpibi_f( 'force_texte1', "La différence entre une solution qui fonctionne sur papier et une qui fonctionne sur le terrain, c'est la connaissance de ce terrain. C'est pourquoi nous nous entourons de professionnels ayant eux-mêmes conçu, implanté et optimisé des processus, des systèmes et des outils qui ont généré des gains de performance concrets et mesurables." ) ); ?></p>
					<p><?php echo esc_html( kpibi_f( 'force_texte2', "Qu'il s'agisse d'opérations, de finance, d'ingénierie, de logistique, de ressources humaines, de technologies ou de gestion des risques, nous privilégions une compréhension profonde des réalités quotidiennes des organisations. Nous combinons cette expérience pratique à une solide expertise des technologies d'affaires afin de transformer les défis en leviers de performance." ) ); ?></p>
					<p style="margin-top:8px;"><strong style="color:var(--slate-900);"><?php echo esc_html( kpibi_f( 'force_texte3_fort', 'Notre force :' ) ); ?></strong> <?php echo esc_html( kpibi_f( 'force_texte3', 'comprendre à la fois où l\'organisation veut aller et ce qui se passe vraiment sur le plancher. C\'est ce qui nous permet de livrer des résultats tangibles, rapidement visibles et durables.' ) ); ?></p>
				</div>
				<?php $kpibi_force_img = kpibi_f( 'force_image', '' ); ?>
				<?php if ( $kpibi_force_img ) : ?>
					<img src="<?php echo esc_url( $kpibi_force_img ); ?>" alt="" class="split-img reveal reveal-delay-1" loading="lazy">
				<?php else : ?>
					<div class="split-img reveal reveal-delay-1" style="background:#ECEAE3;" aria-hidden="true"></div>
				<?php endif; ?>
			</div></div>
		</section>

		<!-- APPEL À L'ACTION -->
		<section class="section-cta" id="cta" aria-labelledby="cta-heading">
			<div class="container">
				<p class="cta-label"><?php echo esc_html( kpibi_f( 'apropos_cta_label', 'Première étape' ) ); ?></p>
				<h2 id="cta-heading"><?php
					echo esc_html( kpibi_f( 'apropos_cta_titre', 'Parlons de' ) ) . ' ';
					echo '<strong>' . esc_html( kpibi_f( 'apropos_cta_titre_fort', 'votre réalité.' ) ) . '</strong>';
				?></h2>
				<p><?php echo esc_html( kpibi_f( 'apropos_cta_texte', "Chaque organisation est différente. Prenons le temps de discuter de votre réalité, de vos priorités et des leviers qui pourraient créer le plus de valeur pour votre équipe." ) ); ?></p>
				<div class="cta-actions">
					<a href="<?php echo esc_url( kpibi_f( 'apropos_cta_btn_url', 'mailto:' . get_theme_mod( 'kpibi_email', 'info@kpibi.com' ) ) ); ?>" class="btn btn-primary" style="font-size:16px;padding:14px 32px;"><?php echo esc_html( kpibi_f( 'apropos_cta_btn_texte', 'Planifier une consultation gratuite — sans engagement' ) ); ?></a>
				</div>
				<p class="cta-guarantee"><?php echo esc_html( kpibi_f( 'apropos_cta_garantie', "Vous repartirez avec une feuille de route claire, les premiers leviers d'amélioration identifiés et une analyse comparative financière de votre industrie." ) ); ?></p>
			</div>
		</section>
	</main>

	<?php
endwhile;

get_footer();
