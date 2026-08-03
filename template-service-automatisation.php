<?php
/* Template Name: Page service — Automatisation */
/**
 * Gabarit dédié à la page « Automatisation des processus ».
 *
 * Contrairement aux 2 autres pages service qui utilisent le gabarit générique
 * (template-service.php), cette page a 3 sections uniques en plus des
 * sections communes : le split « L'automatisation commence là où la valeur
 * ajoutée s'arrête », la grille des 6 tuiles « Ce que nous automatisons » et
 * le split « Une automatisation robuste et intégrée » (technologie Microsoft).
 *
 * Sections uniques : champs ACF préfixés `svcauto_` (groupe ACF
 * « Page service — Automatisation (sections uniques) », inc/acf-fields-services-extra.php).
 * Sections communes (bannière, approche, étapes, pour qui, bénéfices, cta) :
 * mêmes champs ACF `service_hero_*` / `approche_*` / `etapes_*` / `pourqui_*` /
 * `benefits_*` / `service_cta_*` que template-service.php (groupe
 * « Page service KPIBI », inc/acf-fields-services.php) — réutilisés tels quels,
 * pas redéfinis.
 *
 * Valeurs par défaut PHP = contenu réel de service-automatisation.html
 * (maquette approuvée), pour que la page affiche déjà le bon contenu dès sa
 * création.
 *
 * @package KPIBI
 */

get_header();

while ( have_posts() ) :
	the_post();

	$kpibi_bg = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : kpibi_f( 'service_hero_image', '' );

	/* ----- Valeurs par défaut des sections UNIQUES (contenu de service-automatisation.html) ----- */

	$kpibi_svcauto_depart_img = kpibi_f( 'svcauto_depart_image', '' );
	$kpibi_svcauto_techno_img = kpibi_f( 'svcauto_techno_image', '' );

	$kpibi_svcauto_tuiles_defaults = array(
		array(
			'titre' => 'Soumissions et propositions',
			'texte' => 'Génération automatique de soumissions et de propositions commerciales, prêtes à envoyer.',
			'icone' => 'document',
		),
		array(
			'titre' => 'Traitement des commandes',
			'texte' => "Traitement complet des commandes, du CRM à l'ERP jusqu'aux fournisseurs.",
			'icone' => 'cube',
		),
		array(
			'titre' => 'Synchronisation des systèmes',
			'texte' => 'Synchronisation intelligente entre vos systèmes : ERP, CRM, comptabilité, etc.',
			'icone' => 'sync',
		),
		array(
			'titre' => 'Flux de travail et approbations',
			'texte' => 'Workflows d\'approbation multi-étapes, fluides et entièrement traçables.',
			'icone' => 'check',
		),
		array(
			'titre' => 'Rapports et KPI',
			'texte' => 'Création, distribution et archivage automatisés de vos rapports et indicateurs.',
			'icone' => 'tableau_bord',
		),
		array(
			'titre' => 'Automatisation sans API (RPA)',
			'texte' => 'Interaction avec des portails web et des systèmes sans API grâce à la robotisation (RPA).',
			'icone' => 'robot',
		),
	);
	$kpibi_svcauto_tuiles_items = kpibi_typo_deep( get_field( 'svcauto_tuiles' ) ?: $kpibi_svcauto_tuiles_defaults );

	/* ----- Valeurs par défaut des sections COMMUNES (contenu de service-optimisation.html) ----- */

	$kpibi_approche_defaults = array(
		array(
			'titre' => 'Clarté des objectifs',
			'texte' => 'Savoir précisément ce que le système doit produire.',
		),
		array(
			'titre' => 'Processus',
			'texte' => 'Des façons de faire simples, standardisées et prévisibles.',
		),
		array(
			'titre' => 'Outils et systèmes',
			'texte' => 'Les bons outils, bien intégrés à la réalité du terrain.',
		),
		array(
			'titre' => 'Automatisation',
			'texte' => "Libérer les équipes des tâches répétitives à faible valeur.",
		),
		array(
			'titre' => 'Mesure et amélioration continue',
			'texte' => 'Des KPI clairs pour faire évoluer le système dans le temps.',
		),
	);
	$kpibi_approche_items = kpibi_typo_deep( get_field( 'approche_items' ) ?: $kpibi_approche_defaults );

	$kpibi_etapes_defaults = array(
		array(
			'titre' => 'Comprendre le système actuel',
			'texte' => 'On plonge dans vos processus, données et réalités terrain.',
		),
		array(
			'titre' => 'Identifier les leviers à haut impact',
			'texte' => 'On cible ce qui bloque vraiment la performance.',
		),
		array(
			'titre' => 'Concevoir le futur état',
			'texte' => 'Solutions simples, efficaces et adaptées à votre contexte.',
		),
		array(
			'titre' => 'Implanter et automatiser',
			'texte' => 'On livre des outils concrets qui fonctionnent rapidement.',
		),
		array(
			'titre' => 'Améliorer continuellement',
			'texte' => 'Suivi, mesures et évolution du système dans le temps.',
		),
	);
	$kpibi_etapes_items = kpibi_typo_deep( get_field( 'etapes_items' ) ?: $kpibi_etapes_defaults );

	$kpibi_benefits_defaults = array(
		array(
			'titre' => 'ROI supérieur à 200 %',
			'texte' => "Sur les initiatives implantées, le retour sur investissement dépasse souvent 200 %.",
		),
		array(
			'titre' => '77 secondes',
			'texte' => 'Des transactions complexes exécutées automatiquement en 77 secondes, sans intervention humaine.',
		),
		array(
			'titre' => 'Équipes réaffectées',
			'texte' => 'Libérées des tâches répétitives et réaffectées à des activités qui créent réellement de la valeur.',
		),
		array(
			'titre' => 'Moins de temps administratif',
			'texte' => 'Réduction majeure du temps passé sur les tâches administratives et répétitives.',
		),
		array(
			'titre' => "Moins d'erreurs",
			'texte' => 'Diminution importante des erreurs et des reprises grâce à des processus plus stables.',
		),
		array(
			'titre' => 'Capacité accrue',
			'texte' => 'Augmentation de capacité sans ajout proportionnel de ressources.',
		),
		array(
			'titre' => 'Meilleure visibilité',
			'texte' => 'Décisions plus rapides grâce à des KPI clairs et à jour. Moins de dépendance aux « héros » et à la mémoire individuelle.',
		),
		array(
			'titre' => 'Systèmes évolutifs',
			'texte' => 'Processus plus simples, plus rapides et beaucoup plus prévisibles, qui accompagnent la croissance de l\'entreprise.',
		),
	);
	$kpibi_benefits_items = kpibi_typo_deep( get_field( 'benefits_items' ) ?: $kpibi_benefits_defaults );
	?>

	<!-- BANNIÈRE -->
	<section class="page-hero">
		<?php if ( $kpibi_bg ) : ?>
			<div class="page-hero-bg" style="background-image:url('<?php echo esc_url( $kpibi_bg ); ?>');"></div>
		<?php endif; ?>
		<div class="page-hero-gradient"></div>
		<div class="container"><div class="page-hero-inner">
			<p class="page-hero-label"><?php echo esc_html( kpibi_f( 'service_hero_label', 'Power Automate · RPA · Automatisation des processus' ) ); ?></p>
			<h1><?php
				echo esc_html( kpibi_f( 'service_hero_titre', 'Créer de la capacité' ) ) . '<br>';
				echo '<strong>' . esc_html( kpibi_f( 'service_hero_titre_fort', 'sans ajouter de ressources.' ) ) . '</strong>';
			?></h1>
			<p class="page-hero-sub"><?php echo esc_html( kpibi_f( 'service_hero_sub', "Nous simplifions, standardisons puis automatisons tout ce qui n'apporte pas de valeur ajoutée. Vos équipes se concentrent enfin sur les clients, les décisions et la croissance." ) ); ?></p>
			<div class="page-hero-actions">
				<a href="<?php echo esc_url( kpibi_f( 'service_hero_cta1_url', '#cta' ) ); ?>" class="btn btn-primary"><?php echo esc_html( kpibi_f( 'service_hero_cta1_texte', 'Consultation gratuite' ) ); ?></a>
				<a href="<?php echo esc_url( kpibi_link( kpibi_f( 'service_hero_cta2_url', '' ), 'forfait' ) ); ?>" class="btn btn-outline"><?php echo esc_html( kpibi_f( 'service_hero_cta2_texte', 'Voir le forfait' ) ); ?></a>
			</div>
		</div></div>
	</section>

	<!-- SECTION UNIQUE 1 — LE POINT DE DÉPART -->
	<section class="section-split bg-light">
		<div class="container"><div class="split-inner">
			<div class="split-content reveal">
				<p class="section-label"><?php echo esc_html( kpibi_f( 'svcauto_depart_label', 'Le point de départ' ) ); ?></p>
				<h2><?php
					echo esc_html( kpibi_f( 'svcauto_depart_titre', "L'automatisation commence là où la" ) ) . ' ';
					echo '<strong>' . esc_html( kpibi_f( 'svcauto_depart_titre_fort', "valeur ajoutée s'arrête" ) ) . '</strong>';
				?></h2>
				<p><?php echo esc_html( kpibi_f( 'svcauto_depart_texte1', "Combien d'heures votre équipe passe-t-elle cette semaine à copier des données d'un système à l'autre? La plupart des entreprises perdent un temps fou sur des tâches répétitives qui n'apportent aucune valeur réelle : doubles saisies, validations manuelles, transferts de données, rapports, suivis, etc." ) ); ?></p>
				<p><?php echo esc_html( kpibi_f( 'svcauto_depart_texte2', "Chez KPIBI, nous ne nous contentons pas d'automatiser pour automatiser. Nous commençons par simplifier et standardiser les processus, puis nous automatisons tout ce qui n'apporte pas de valeur ajoutée. Résultat : vos équipes se concentrent enfin sur ce qui compte vraiment, les clients, les décisions et la croissance." ) ); ?></p>
				<p style="margin-bottom:0;"><strong style="color:var(--slate-900);"><?php echo esc_html( kpibi_f( 'svcauto_depart_texte3_fort', "L'objectif est clair :" ) ); ?></strong> <?php echo esc_html( kpibi_f( 'svcauto_depart_texte3_fin', 'augmenter votre capacité, réduire vos coûts et améliorer votre prévisibilité, sans devoir embaucher proportionnellement.' ) ); ?></p>
			</div>
			<?php if ( $kpibi_svcauto_depart_img ) : ?>
				<img src="<?php echo esc_url( $kpibi_svcauto_depart_img ); ?>" alt="<?php echo esc_attr( kpibi_img_alt( $kpibi_svcauto_depart_img, kpibi__( "Illustration du point de départ d'une automatisation" ) ) ); ?>" class="split-img reveal reveal-delay-1" loading="lazy">
			<?php else : ?>
				<div class="split-img reveal reveal-delay-1" style="background:#ECEAE3;" aria-hidden="true"></div>
			<?php endif; ?>
		</div></div>
	</section>

	<!-- SECTION UNIQUE — GRILLE DES 6 TUILES : CE QUE NOUS AUTOMATISONS -->
	<section class="section-steps">
		<div class="container">
			<div class="section-header reveal">
				<p class="section-label"><?php echo esc_html( kpibi_f( 'svcauto_tuiles_label', "Notre champ d'action" ) ); ?></p>
				<h2><?php
					echo esc_html( kpibi_f( 'svcauto_tuiles_titre', 'Ce que nous' ) ) . ' ';
					echo '<strong>' . esc_html( kpibi_f( 'svcauto_tuiles_titre_fort', 'automatisons' ) ) . '</strong>';
				?></h2>
				<p><?php echo esc_html( kpibi_f( 'svcauto_tuiles_intro', 'Des processus complets, orchestrés de bout en bout, dans votre environnement existant.' ) ); ?></p>
			</div>
			<?php
			// Au-delà de 4 tuiles, on force un maximum de 3 par rangée (cols3) pour éviter
			// une répartition inégale (ex. 4+2 au lieu de 3+3) ; voir commentaire dans style.css.
			$kpibi_tuiles_class = ( count( $kpibi_svcauto_tuiles_items ) > 4 ) ? 'steps-grid tiles cols3' : 'steps-grid tiles';
			?>
			<div class="<?php echo esc_attr( $kpibi_tuiles_class ); ?>">
				<?php foreach ( $kpibi_svcauto_tuiles_items as $kpibi_i => $kpibi_item ) : ?>
					<?php $kpibi_icone = ! empty( $kpibi_item['icone'] ) ? $kpibi_item['icone'] : $kpibi_svcauto_tuiles_defaults[ $kpibi_i % 6 ]['icone']; ?>
					<div class="step-card reveal<?php echo $kpibi_i > 0 ? ' reveal-delay-' . esc_attr( min( $kpibi_i, 4 ) ) : ''; ?>">
						<div class="benefit-icon" style="margin-bottom:16px;">
							<svg viewBox="0 0 24 24"><?php echo kpibi_icon( $kpibi_icone ); /* phpcs:ignore -- bibliothèque d'icônes interne, pas d'entrée utilisateur libre */ ?></svg>
						</div>
						<h3><?php echo esc_html( $kpibi_item['titre'] ); ?></h3>
						<p><?php echo esc_html( $kpibi_item['texte'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- SECTION UNIQUE 2 — LA TECHNOLOGIE -->
	<section class="section-split">
		<div class="container"><div class="split-inner">
			<?php if ( $kpibi_svcauto_techno_img ) : ?>
				<img src="<?php echo esc_url( $kpibi_svcauto_techno_img ); ?>" alt="<?php echo esc_attr( kpibi_img_alt( $kpibi_svcauto_techno_img, kpibi__( 'Illustration des technologies utilisées' ) ) ); ?>" class="split-img reveal" loading="lazy">
			<?php else : ?>
				<div class="split-img reveal" style="background:#ECEAE3;" aria-hidden="true"></div>
			<?php endif; ?>
			<div class="split-content reveal reveal-delay-1">
				<p class="section-label"><?php echo esc_html( kpibi_f( 'svcauto_techno_label', 'La technologie' ) ); ?></p>
				<h2><?php
					echo esc_html( kpibi_f( 'svcauto_techno_titre', 'Une automatisation robuste et' ) ) . ' ';
					echo '<strong>' . esc_html( kpibi_f( 'svcauto_techno_titre_fort', 'intégrée' ) ) . '</strong>';
				?></h2>
				<p><?php echo esc_html( kpibi_f( 'svcauto_techno_texte1', "Nous utilisons principalement Microsoft Power Automate (cloud et RPA), Power Query pour l'automatisation et la transformation de données, ainsi que Power Apps et Azure." ) ); ?></p>
				<p><?php echo esc_html( kpibi_f( 'svcauto_techno_texte2', "Cette combinaison nous permet de créer des automatisations fiables qui s'intègrent parfaitement à votre environnement existant, même lorsque les systèmes ne communiquent pas nativement." ) ); ?></p>
				<p style="margin-bottom:0;"><?php echo esc_html( kpibi_f( 'svcauto_techno_texte3', 'Nous ne choisissons pas la technologie la plus complexe. Nous choisissons celle qui fonctionne le mieux pour éliminer le travail sans valeur.' ) ); ?></p>
			</div>
		</div></div>
	</section>

	<!-- APPROCHE -->
	<section class="section-split bg-light">
		<div class="container"><div class="split-inner">
			<div class="split-content reveal">
				<p class="section-label"><?php echo esc_html( kpibi_f( 'approche_label', 'Notre approche' ) ); ?></p>
				<h2><?php
					echo esc_html( kpibi_f( 'approche_titre', 'Un système bien conçu crée' ) ) . ' ';
					echo '<strong>' . esc_html( kpibi_f( 'approche_titre_fort', 'plus de performance' ) ) . '</strong>';
					$kpibi_approche_titre_fin = kpibi_f( 'approche_titre_fin', "qu'un effort supplémentaire" );
					if ( $kpibi_approche_titre_fin ) {
						echo ' ' . esc_html( $kpibi_approche_titre_fin );
					}
				?></h2>
				<p><?php echo esc_html( kpibi_f( 'approche_texte1', 'Vos employés travaillent fort. Pourtant, les mêmes erreurs reviennent, les délais s\'accumulent et la croissance crée plus de friction qu\'elle n\'en résout.' ) ); ?></p>
				<p><?php echo esc_html( kpibi_f( 'approche_texte2', "Lorsqu'un problème survient, la réaction naturelle consiste souvent à ajouter de la formation, du contrôle ou des procédures. Notre approche est différente : nous cherchons d'abord à comprendre comment les processus, les outils, l'information et l'environnement de travail influencent les comportements et les résultats." ) ); ?></p>
				<p><?php echo esc_html( kpibi_f( 'approche_texte3', "Parce qu'un système bien conçu crée généralement plus de performance qu'un effort humain supplémentaire." ) ); ?></p>
				<?php $kpibi_approche_btn_url = kpibi_f( 'approche_btn_url', '#demarche' ); ?>
				<?php $kpibi_approche_btn_texte = kpibi_f( 'approche_btn_texte', 'Voir notre démarche' ); ?>
				<?php if ( $kpibi_approche_btn_texte ) : ?>
					<a href="<?php echo esc_url( $kpibi_approche_btn_url ); ?>" class="btn btn-outline-dark" style="margin-top:8px;"><?php echo esc_html( $kpibi_approche_btn_texte ); ?></a>
				<?php endif; ?>
			</div>
			<div class="reveal reveal-delay-1">
				<div class="approche-timeline" style="margin-bottom:0;">
					<?php foreach ( $kpibi_approche_items as $kpibi_i => $kpibi_item ) : ?>
						<div class="approche-timeline-item"><span class="approche-timeline-num"><?php echo esc_html( $kpibi_i + 1 ); ?></span><div class="approche-timeline-content"><strong><?php echo esc_html( $kpibi_item['titre'] ); ?></strong><span><?php echo esc_html( $kpibi_item['texte'] ); ?></span></div></div>
					<?php endforeach; ?>
				</div>
				<div class="rapport-teaser" style="background:rgba(122,94,26,0.06);border-color:rgba(122,94,26,0.22);margin-top:24px;">
					<div class="rapport-icon" style="background:rgba(122,94,26,0.10);border-color:rgba(122,94,26,0.25);"><svg viewBox="0 0 24 24" style="stroke:var(--gold-600);"><path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg></div>
					<div class="rapport-text"><strong style="color:var(--slate-900);"><?php echo esc_html( kpibi_f( 'service_rapport_titre', 'Les fondations de la performance' ) ); ?></strong><span style="color:var(--slate-500);"><?php echo esc_html( kpibi_f( 'service_rapport_texte', "L'automatisation d'un mauvais processus accélère rarement les bons résultats. C'est pourquoi nous intervenons dans cet ordre." ) ); ?></span></div>
				</div>
			</div>
		</div></div>
	</section>

	<!-- ÉTAPES -->
	<section class="section-steps" id="demarche">
		<div class="container">
			<div class="section-header reveal">
				<p class="section-label"><?php echo esc_html( kpibi_f( 'etapes_label', 'Ce qu\'on fait concrètement' ) ); ?></p>
				<h2><?php
					echo esc_html( kpibi_f( 'etapes_titre', 'Faire en sorte que la performance devienne' ) ) . ' ';
					echo '<strong>' . esc_html( kpibi_f( 'etapes_titre_fort', 'le résultat naturel du système' ) ) . '</strong>';
				?></h2>
				<p><?php echo esc_html( kpibi_f( 'etapes_intro', "On agit sur les vraies causes des frictions, puis on met en place les bons leviers — pas un effort de plus, mais un système qui travaille pour vous." ) ); ?></p>
			</div>
			<?php
			$kpibi_etapes_count = count( $kpibi_etapes_items );
			// Au-delà de 4 cartes, on force un maximum de 3 par rangée (cols3) pour éviter
			// une répartition inégale (ex. 4+2) ; voir commentaire dans style.css.
			$kpibi_etapes_class = ( $kpibi_etapes_count > 4 ) ? 'steps-grid cols3' : 'steps-grid';
			?>
			<div class="<?php echo esc_attr( $kpibi_etapes_class ); ?>">
				<?php foreach ( $kpibi_etapes_items as $kpibi_i => $kpibi_item ) : ?>
					<div class="step-card reveal<?php echo $kpibi_i > 0 ? ' reveal-delay-' . esc_attr( min( $kpibi_i, 4 ) ) : ''; ?>">
						<h3><?php echo esc_html( $kpibi_item['titre'] ); ?></h3>
						<p><?php echo esc_html( $kpibi_item['texte'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- POUR QUI -->
	<section class="section-split">
		<div class="container"><div class="split-inner">
			<?php $kpibi_pourqui_img = kpibi_f( 'pourqui_image', '' ); ?>
			<?php if ( $kpibi_pourqui_img ) : ?>
				<img src="<?php echo esc_url( $kpibi_pourqui_img ); ?>" alt="<?php echo esc_attr( kpibi_img_alt( $kpibi_pourqui_img, kpibi__( 'Illustration de la section « Pour qui »' ) ) ); ?>" class="split-img reveal" loading="lazy">
			<?php else : ?>
				<div class="split-img reveal" style="background:#ECEAE3;" aria-hidden="true"></div>
			<?php endif; ?>
			<div class="split-content reveal reveal-delay-1">
				<p class="section-label"><?php echo esc_html( kpibi_f( 'pourqui_label', 'Pour qui nous travaillons' ) ); ?></p>
				<h2><?php
					echo esc_html( kpibi_f( 'pourqui_titre', 'Des dirigeants qui veulent' ) ) . ' ';
					echo '<strong>' . esc_html( kpibi_f( 'pourqui_titre_fort', 'grandir sans alourdir' ) ) . '</strong>';
				?></h2>
				<p><?php echo esc_html( kpibi_f( 'pourqui_texte1', 'Nous travaillons avec des dirigeants qui veulent augmenter leur capacité sans nécessairement embaucher, réduire leurs coûts opérationnels ou soutenir une croissance qui commence à créer plus de friction que de valeur.' ) ); ?></p>
				<p><?php echo esc_html( kpibi_f( 'pourqui_texte2', 'Nos clients viennent de secteurs très variés : fabrication, distribution, construction, services professionnels, santé, technologies, commerce de détail et secteur municipal. Ce qu\'ils ont en commun, c\'est que leur croissance ou leur complexité exige des processus et des systèmes mieux structurés.' ) ); ?></p>
			</div>
		</div></div>
	</section>

	<!-- BÉNÉFICES -->
	<section class="section-benefits">
		<div class="container">
			<div class="section-header reveal">
				<p class="section-label section-label-light"><?php echo esc_html( kpibi_f( 'benefits_label', 'Résultats types' ) ); ?></p>
				<h2 style="color:var(--white);"><?php
					echo esc_html( kpibi_f( 'benefits_titre', 'Ce que nos clients' ) ) . ' ';
					echo '<strong style="color:var(--gold-400);">' . esc_html( kpibi_f( 'benefits_titre_fort', 'obtiennent réellement' ) ) . '</strong>';
				?></h2>
				<p style="color:rgba(255,255,255,0.52);"><?php echo esc_html( kpibi_f( 'benefits_intro', 'Des gains concrets, mesurables et durables — pas des promesses, des systèmes qui livrent.' ) ); ?></p>
			</div>
			<div class="benefits-grid">
				<?php
					foreach ( $kpibi_benefits_items as $kpibi_i => $kpibi_item ) :
						$kpibi_bicon = ! empty( $kpibi_item['icone'] ) ? $kpibi_item['icone'] : kpibi_guess_benefit_icon( isset( $kpibi_item['titre'] ) ? $kpibi_item['titre'] : '' );
					?>
					<div class="benefit-card reveal<?php echo $kpibi_i > 0 ? ' reveal-delay-' . esc_attr( min( $kpibi_i, 4 ) ) : ''; ?>">
						<div class="benefit-icon"><svg viewBox="0 0 24 24"><?php echo kpibi_icon( $kpibi_bicon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></svg></div>
						<h3><?php echo esc_html( $kpibi_item['titre'] ); ?></h3>
						<p><?php echo esc_html( $kpibi_item['texte'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- APPEL À L'ACTION -->
	<section class="section-cta" id="cta" aria-labelledby="cta-heading">
		<div class="container">
			<p class="cta-label"><?php echo esc_html( kpibi_f( 'service_cta_label', 'Et si la réponse était déjà là?' ) ); ?></p>
			<h2 id="cta-heading"><?php echo esc_html( kpibi_f( 'service_cta_titre', 'Votre prochain avantage concurrentiel se cache peut-être' ) ); ?><br><strong><?php echo esc_html( kpibi_f( 'service_cta_titre_fort', 'déjà dans vos processus.' ) ); ?></strong></h2>
			<p><?php echo esc_html( kpibi_f( 'service_cta_texte', 'Discutons de votre réalité et identifions ensemble les opportunités qui pourraient transformer votre performance.' ) ); ?></p>
			<div class="cta-actions">
				<a href="<?php echo esc_url( kpibi_f( 'service_cta_btn1_url', 'mailto:' . get_theme_mod( 'kpibi_email', 'info@kpibi.com' ) ) ); ?>" class="btn btn-primary" style="font-size:16px;padding:14px 32px;"><?php echo esc_html( kpibi_f( 'service_cta_btn1_texte', 'Planifier une consultation gratuite' ) ); ?></a>
				<a href="<?php echo esc_url( kpibi_link( kpibi_f( 'service_cta_btn2_url', '' ), 'forfait' ) ); ?>" class="btn btn-outline" style="font-size:16px;padding:14px 32px;"><?php echo esc_html( kpibi_f( 'service_cta_btn2_texte', 'Voir le forfait' ) ); ?></a>
			</div>
			<p class="cta-guarantee"><?php echo esc_html( kpibi_f( 'service_cta_garantie', 'Sans engagement · Feuille de route claire · Analyse comparative de votre industrie' ) ); ?></p>
		</div>
	</section>

	<?php
endwhile;

get_footer();
