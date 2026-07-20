<?php
/* Template Name: Page forfait */
/**
 * Gabarit de la page « Forfait » (partenariat KPIBI).
 * Tout le contenu provient des champs ACF (onglet « Page forfait KPIBI »),
 * avec repli sur le contenu d'origine de la maquette si un champ est vide
 * ou si ACF est absent.
 *
 * @package KPIBI
 */

get_header();
?>

<!-- Styles propres à cette page (repris de la maquette forfait.html) -->
<style>
	.faq-list{max-width:760px;margin:0 auto}
	.faq-item{border-bottom:1px solid var(--slate-200)}
	.faq-item summary{list-style:none;cursor:pointer;padding:22px 0;display:flex;justify-content:space-between;align-items:center;gap:20px;font-family:"Dubai",sans-serif;font-size:18px;font-weight:400;color:var(--slate-900)}
	.faq-item summary::-webkit-details-marker{display:none}
	.faq-item summary::after{content:"+";font-family:"Dubai",sans-serif;font-size:26px;color:var(--gold-600);line-height:1;flex-shrink:0}
	.faq-item[open] summary::after{content:"\2212"}
	.faq-a{font-size:15px;color:var(--slate-500);line-height:1.75;padding:0 0 24px}

	.invest-band{padding:88px 0;background:var(--black-900);text-align:center;position:relative}
	.invest-band h2{font-family:"Dubai",sans-serif;font-size:clamp(28px,3.6vw,42px);font-weight:300;color:#fff;letter-spacing:-.3px;line-height:1.15;margin:14px auto 16px;max-width:640px}
	.invest-band h2 strong{font-weight:500;color:var(--gold-400)}
	.invest-band>.container>p.lead{font-size:16px;color:rgba(255,255,255,.6);max-width:680px;margin:0 auto 44px;line-height:1.75}
	.invest-figures{display:grid;grid-template-columns:1fr 1px 1fr;align-items:center;max-width:840px;margin:0 auto}
	@media(max-width:640px){.invest-figures{grid-template-columns:1fr;row-gap:40px}.invest-figures .stat-divider{display:none}}
	.invest-figures .stat-divider{background:rgba(255,255,255,.10);height:96px;width:1px;justify-self:center}
	.invest-fig{padding:0 28px}
	.invest-fig .num{font-family:"Dubai",sans-serif;font-size:clamp(44px,6vw,72px);font-weight:300;color:var(--gold-400);line-height:1;letter-spacing:-2px;margin-bottom:14px}
	.invest-fig .num small{font-size:20px;color:rgba(255,255,255,.45);font-weight:400;letter-spacing:0}
	.invest-fig .cap{font-size:14px;color:rgba(255,255,255,.55);line-height:1.55;max-width:300px;margin:0 auto}
</style>

<?php while ( have_posts() ) : the_post(); ?>

	<!-- BANNIÈRE -->
	<section class="page-hero">
		<?php $kpibi_hero_img = kpibi_f( 'forfait_hero_image', '' ); ?>
		<?php if ( $kpibi_hero_img ) : ?>
			<div class="page-hero-bg" style="background-image:url('<?php echo esc_url( $kpibi_hero_img ); ?>');"></div>
		<?php endif; ?>
		<div class="page-hero-gradient"></div>
		<div class="container"><div class="page-hero-inner">
			<p class="page-hero-label"><?php echo esc_html( kpibi_f( 'forfait_hero_label', 'Le modèle KPIBI · Partenariat' ) ); ?></p>
			<h1><?php
				echo esc_html( kpibi_f( 'forfait_hero_titre', 'Vos priorités évoluent.' ) );
				echo '<br><strong>' . esc_html( kpibi_f( 'forfait_hero_titre_fort', 'Vos solutions devraient évoluer aussi.' ) ) . '</strong>';
			?></h1>
			<p class="page-hero-sub"><?php echo esc_html( kpibi_f( 'forfait_hero_sub', 'Avec KPIBI, nous concevons, opérons et faisons évoluer vos systèmes de performance.' ) ); ?></p>
			<div class="page-hero-actions">
				<a href="<?php echo esc_url( kpibi_f( 'forfait_hero_cta1_url', '#cta' ) ); ?>" class="btn btn-primary"><?php echo esc_html( kpibi_f( 'forfait_hero_cta1_texte', 'Planifier une consultation gratuite' ) ); ?></a>
				<a href="<?php echo esc_url( kpibi_link( kpibi_f( 'forfait_hero_cta2_url', '' ), 'cas-clients' ) ); ?>" class="btn btn-outline"><?php echo esc_html( kpibi_f( 'forfait_hero_cta2_texte', 'Voir nos réalisations' ) ); ?></a>
			</div>
		</div></div>
	</section>

	<!-- POURQUOI CETTE APPROCHE -->
	<section class="section-pourquoi">
		<div class="container"><div class="pourquoi-inner">
			<div class="pourquoi-visual reveal">
				<?php $kpibi_pourquoi_img = kpibi_f( 'forfait_pourquoi_image', '' ); ?>
				<?php if ( $kpibi_pourquoi_img ) : ?>
					<img src="<?php echo esc_url( $kpibi_pourquoi_img ); ?>" alt="" class="pourquoi-img" loading="lazy">
				<?php else : ?>
					<div class="pourquoi-img" style="background:#1A1A1A;" aria-hidden="true"></div>
				<?php endif; ?>
				<div class="pourquoi-badge"><p class="pourquoi-badge-num"><?php echo esc_html( kpibi_f( 'forfait_pourquoi_badge_num', '15+' ) ); ?></p><p class="pourquoi-badge-label"><?php echo esc_html( kpibi_f( 'forfait_pourquoi_badge_label', "ans d'expérience terrain" ) ); ?></p></div>
			</div>
			<div class="pourquoi-content reveal reveal-delay-1">
				<p class="section-label"><?php echo esc_html( kpibi_f( 'forfait_pourquoi_label', 'Le modèle' ) ); ?></p>
				<h2><?php
					echo esc_html( kpibi_f( 'forfait_pourquoi_titre', 'Pourquoi cette' ) ) . ' ';
					echo '<strong>' . esc_html( kpibi_f( 'forfait_pourquoi_titre_fort', 'approche' ) ) . '</strong>';
					echo esc_html( kpibi_f( 'forfait_pourquoi_titre_fin', '?' ) );
				?></h2>
				<p><?php echo esc_html( kpibi_f( 'forfait_pourquoi_texte1', "Les besoins d'une organisation évoluent constamment. Les priorités changent, les processus se transforment et de nouveaux objectifs émergent. Un tableau de bord révèle une nouvelle opportunité. Une automatisation demande des ajustements. Une application doit suivre la réalité du terrain." ) ); ?></p>
				<p><?php echo esc_html( kpibi_f( 'forfait_pourquoi_texte2', "Trop de projets génèrent des gains initiaux qui s'essoufflent quelques mois après leur déploiement. Le vrai défi n'est pas seulement l'implantation : c'est la capacité à maintenir, faire évoluer et améliorer les solutions pour qu'elles continuent de créer de la valeur." ) ); ?></p>
				<p><?php
					echo esc_html( kpibi_f( 'forfait_pourquoi_texte3_debut', "C'est pourquoi KPIBI privilégie un" ) ) . ' ';
					echo '<strong>' . esc_html( kpibi_f( 'forfait_pourquoi_texte3_fort', 'modèle de partenariat continu' ) ) . '</strong> ';
					echo esc_html( kpibi_f( 'forfait_pourquoi_texte3_fin', "plutôt qu'une approche traditionnelle par projet. Nous concevons, opérons et faisons évoluer vos systèmes de performance afin qu'ils génèrent de la valeur bien après leur mise en place." ) );
				?></p>
			</div>
		</div></div>
	</section>

	<!-- CE QUE COMPREND LE PARTENARIAT -->
	<section class="section-steps">
		<div class="container">
			<div class="section-header reveal">
				<p class="section-label"><?php echo esc_html( kpibi_f( 'forfait_compris_label', 'Le partenariat' ) ); ?></p>
				<h2><?php echo esc_html( kpibi_f( 'forfait_compris_titre', 'Ce que comprend un' ) ); ?> <strong><?php echo esc_html( kpibi_f( 'forfait_compris_titre_fort', 'partenariat KPIBI' ) ); ?></strong></h2>
				<p><?php echo esc_html( kpibi_f( 'forfait_compris_intro', 'Un cycle continu qui transforme vos objectifs en systèmes performants — et qui les fait évoluer avec vous.' ) ); ?></p>
			</div>
			<div class="steps-grid cols3">
				<?php
				$kpibi_cycle_defaults = array(
					array( 'Comprendre', "Nous analysons vos processus, vos systèmes, vos données et vos objectifs afin d'identifier les opportunités ayant le plus grand potentiel de valeur." ),
					array( 'Concevoir', 'Nous concevons les processus, indicateurs, automatisations et solutions nécessaires pour soutenir vos objectifs d\'affaires.' ),
					array( 'Implanter', 'Nous développons et déployons les solutions retenues de manière progressive et priorisée selon la valeur d\'affaires générée.' ),
					array( 'Opérer', 'Nous assurons le suivi des solutions afin d\'en maintenir la stabilité, la fiabilité et la performance.' ),
					array( 'Faire évoluer', "Nous continuons d'améliorer les solutions, dans le périmètre défini, à mesure que votre organisation évolue afin de maximiser leur impact." ),
				);
				foreach ( $kpibi_cycle_defaults as $i => $d ) :
					$n = $i + 1;
					?>
					<div class="step-card reveal<?php echo $i > 0 ? ' reveal-delay-' . (int) $i : ''; ?>">
						<h3><?php echo esc_html( kpibi_f( "forfait_cycle{$n}_titre", $d[0] ) ); ?></h3>
						<p><?php echo esc_html( kpibi_f( "forfait_cycle{$n}_texte", $d[1] ) ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- TRANSPARENCE -->
	<section class="section-split bg-light">
		<div class="container"><div class="split-inner">
			<?php $kpibi_split_img = kpibi_f( 'forfait_transparence_image', '' ); ?>
			<?php if ( $kpibi_split_img ) : ?>
				<img src="<?php echo esc_url( $kpibi_split_img ); ?>" alt="" class="split-img reveal" loading="lazy">
			<?php else : ?>
				<div class="split-img reveal" style="background:#ECEAE3;" aria-hidden="true"></div>
			<?php endif; ?>
			<div class="split-content reveal reveal-delay-1">
				<p class="section-label"><?php echo esc_html( kpibi_f( 'forfait_transparence_label', 'Transparence' ) ); ?></p>
				<h2><?php
					echo esc_html( kpibi_f( 'forfait_transparence_titre', 'Votre environnement. Vos licences.' ) ) . ' ';
					echo '<strong>' . esc_html( kpibi_f( 'forfait_transparence_titre_fort', 'Vos solutions.' ) ) . '</strong>';
				?></h2>
				<p><?php echo esc_html( kpibi_f( 'forfait_transparence_texte1', "Sauf exception, les solutions développées par KPIBI sont déployées directement dans vos environnements. Nous vous accompagnons dans la gestion de votre écosystème Microsoft — Power BI, Power Apps, Power Automate et Azure — pour concevoir une architecture simple, performante et adaptée à votre réalité." ) ); ?></p>
				<p><?php echo esc_html( kpibi_f( 'forfait_transparence_texte2', 'Cette approche vous offre une transparence complète sur les coûts, élimine les frais cachés et vous laisse le contrôle de votre environnement à long terme. Vous demeurez propriétaire de vos données, de vos solutions et de votre environnement, pendant que nous en assurons la conception, l\'évolution et l\'optimisation continue.' ) ); ?></p>
				<p style="margin-top:8px;">
					<strong style="color:var(--slate-900);"><?php echo esc_html( kpibi_f( 'forfait_transparence_badge1', 'Transparence des coûts' ) ); ?></strong> &nbsp;·&nbsp;
					<strong style="color:var(--slate-900);"><?php echo esc_html( kpibi_f( 'forfait_transparence_badge2', 'Vous restez propriétaire' ) ); ?></strong> &nbsp;·&nbsp;
					<strong style="color:var(--slate-900);"><?php echo esc_html( kpibi_f( 'forfait_transparence_badge3', 'Aucune dépendance fournisseur' ) ); ?></strong>
				</p>
			</div>
		</div></div>
	</section>

	<!-- L'INVESTISSEMENT -->
	<section class="invest-band">
		<div class="container">
			<p class="section-label section-label-light"><?php echo esc_html( kpibi_f( 'forfait_invest_label', "L'investissement" ) ); ?></p>
			<h2><?php echo esc_html( kpibi_f( 'forfait_invest_titre', 'Un investissement' ) ); ?> <strong><?php echo esc_html( kpibi_f( 'forfait_invest_titre_fort', 'orienté valeur' ) ); ?></strong></h2>
			<p class="lead"><?php echo esc_html( kpibi_f( 'forfait_invest_texte', "Les gains que nous observons — élimination de rapports manuels, automatisation, meilleures décisions — génèrent souvent des économies récurrentes de plusieurs milliers de dollars par mois. Chaque initiative est priorisée selon son potentiel de valeur et de retour sur investissement." ) ); ?></p>
			<div class="invest-figures">
				<div class="invest-fig">
					<p class="num"><?php echo esc_html( kpibi_f( 'forfait_invest_prix', '1 000 $' ) ); ?><small> <?php echo esc_html( kpibi_f( 'forfait_invest_prix_unite', '/ mois' ) ); ?></small></p>
					<p class="cap"><?php echo esc_html( kpibi_f( 'forfait_invest_prix_note', 'À partir de — forfait mensuel fixe, pour une prévisibilité budgétaire complète.' ) ); ?></p>
				</div>
				<div class="stat-divider"></div>
				<div class="invest-fig">
					<p class="num"><?php echo esc_html( kpibi_f( 'forfait_invest_ratio', '1 $ → 3 $' ) ); ?></p>
					<p class="cap"><?php echo esc_html( kpibi_f( 'forfait_invest_ratio_note', 'Chaque dollar investi vise à générer environ 3 $ de valeur créée ou d\'économies générées.' ) ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<!-- AIDE FINANCIÈRE -->
	<section class="section-steps section-aide">
		<div class="container">
			<div class="section-header reveal">
				<p class="section-label"><?php echo esc_html( kpibi_f( 'forfait_aide_label', 'Aide financière' ) ); ?></p>
				<h2><?php echo esc_html( kpibi_f( 'forfait_aide_titre', 'Des programmes qui peuvent' ) ); ?> <strong><?php echo esc_html( kpibi_f( 'forfait_aide_titre_fort', 'réduire votre investissement' ) ); ?></strong></h2>
				<p><?php echo esc_html( kpibi_f( 'forfait_aide_intro', "Plusieurs programmes gouvernementaux soutiennent l'adoption du numérique, l'automatisation et l'amélioration de la productivité. Nous vous aidons à identifier ceux auxquels vous pourriez être admissible. [Contenu à confirmer]" ) ); ?></p>
			</div>
			<div class="steps-grid tiles">
				<?php
				$kpibi_aide_defaults = array(
					array( 'Subventions et programmes', 'Programme d\'aide à confirmer — aide financière directe pour vos projets admissibles. [Placeholder]', '<path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>' ),
					array( "Crédits d'impôt", 'Programme d\'aide à confirmer — crédits applicables aux investissements technologiques. [Placeholder]', '<path d="M3 3v18h18"/><path d="M7 14l3-3 3 3 5-6"/>' ),
					array( 'Accompagnement', 'Nous vous orientons vers les bons programmes et facilitons les démarches. [Placeholder]', '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>' ),
				);
				foreach ( $kpibi_aide_defaults as $i => $d ) :
					$n = $i + 1;
					?>
					<div class="step-card reveal<?php echo $i > 0 ? ' reveal-delay-' . (int) $i : ''; ?>">
						<div class="benefit-icon" style="margin-bottom:16px;"><svg viewBox="0 0 24 24"><?php echo $d[2]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></svg></div>
						<h3><?php echo esc_html( kpibi_f( "forfait_aide{$n}_titre", $d[0] ) ); ?></h3>
						<p><?php echo esc_html( kpibi_f( "forfait_aide{$n}_texte", $d[1] ) ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
			<p class="aide-note"><?php echo esc_html( kpibi_f( 'forfait_aide_note', "Les programmes, montants et critères d'admissibilité varient et évoluent. Liste finale à valider et à mettre à jour." ) ); ?></p>
		</div>
	</section>

	<!-- LE PARCOURS -->
	<section class="section-steps" style="background:var(--slate-50);">
		<div class="container">
			<div class="section-header reveal">
				<p class="section-label"><?php echo esc_html( kpibi_f( 'forfait_parcours_label', 'Le parcours' ) ); ?></p>
				<h2><?php echo esc_html( kpibi_f( 'forfait_parcours_titre', 'Comment' ) ); ?> <strong><?php echo esc_html( kpibi_f( 'forfait_parcours_titre_fort', 'débuter' ) ); ?></strong></h2>
				<p><?php echo esc_html( kpibi_f( 'forfait_parcours_intro', 'Un démarrage clair, progressif et sans engagement.' ) ); ?></p>
			</div>
			<div class="steps-grid cols3">
				<?php
				$kpibi_parcours_defaults = array(
					array( 'Consultation gratuite', 'Une rencontre exploratoire pour comprendre votre réalité et vos opportunités. Vous repartez avec une ébauche de charte de mandat, des leviers d\'amélioration et une analyse comparative de votre industrie.' ),
					array( 'Diagnostic de faisabilité', 'Au besoin, pour les environnements complexes : une journée pour valider processus, systèmes, données et contraintes. Investissement typique : 1 000 $ à 3 000 $.' ),
					array( 'Sommaire commercial', 'Nous présentons les solutions proposées, les impacts mesurables, les livrables, les frais et modalités. Ce document sert de feuille de route commune.' ),
					array( 'Entente de partenariat', 'Une fois le sommaire approuvé, nous finalisons l\'entente qui encadre la collaboration, les responsabilités et les modalités.' ),
					array( 'Mobilisation et lancement', 'Le mandat débute généralement dans les 30 jours suivant la signature, pour une mise en œuvre rapide des premières priorités.' ),
				);
				foreach ( $kpibi_parcours_defaults as $i => $d ) :
					$n = $i + 1;
					?>
					<div class="step-card reveal<?php echo $i > 0 ? ' reveal-delay-' . (int) $i : ''; ?>">
						<h3><?php echo esc_html( kpibi_f( "forfait_parcours{$n}_titre", $d[0] ) ); ?></h3>
						<p><?php echo esc_html( kpibi_f( "forfait_parcours{$n}_texte", $d[1] ) ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- FAQ -->
	<section class="section-piliers">
		<div class="container">
			<div class="section-header reveal">
				<p class="section-label"><?php echo esc_html( kpibi_f( 'forfait_faq_label', 'Questions fréquentes' ) ); ?></p>
				<h2><?php echo esc_html( kpibi_f( 'forfait_faq_titre', 'Les réponses aux' ) ); ?> <strong><?php echo esc_html( kpibi_f( 'forfait_faq_titre_fort', 'questions courantes' ) ); ?></strong></h2>
			</div>
			<div class="faq-list">
				<?php
				$kpibi_faq_defaults = array(
					array(
						'question' => 'Combien de temps faut-il avant de voir des résultats?',
						'reponse'  => 'Cela dépend de la complexité du mandat et des systèmes impliqués. Nous visons généralement une première preuve de concept ou un premier livrable tangible dans un délai de 30 à 90 jours.',
					),
					array(
						'question' => "Quelle est la durée de l'engagement?",
						'reponse'  => "Les partenariats KPIBI sont généralement établis pour une période initiale de 12 mois, afin de permettre l'implantation, l'adoption et l'amélioration continue. Une révision annuelle valide les objectifs, les résultats et les priorités futures.",
					),
					array(
						'question' => 'Comment fonctionne la gouvernance du mandat?',
						'reponse'  => "Une rencontre de suivi mensuelle permet de réviser l'avancement des initiatives, les résultats obtenus, les priorités à venir et les nouvelles opportunités d'amélioration identifiées.",
					),
					array(
						'question' => 'Les licences logicielles sont-elles incluses?',
						'reponse'  => 'Non. Les licences, les infrastructures infonuagiques et les accès aux systèmes tiers (ERP, CRM, comptabilité) demeurent à la charge du client. Cela assure une transparence complète sur les coûts et vous laisse la pleine propriété de votre environnement.',
					),
					array(
						'question' => 'Que se passe-t-il si nos priorités changent en cours de mandat?',
						'reponse'  => "Les rencontres de gouvernance permettent de réviser les résultats, les besoins émergents et les priorités. Le périmètre demeure celui convenu au départ ; si de nouveaux besoins le dépassent, nous réévaluons ensemble les options et l'investissement requis.",
					),
					array(
						'question' => 'Êtes-vous limités aux tableaux de bord et à l\'automatisation?',
						'reponse'  => "Non. Selon le contexte, les mandats peuvent inclure l'optimisation des processus, les tableaux de bord KPI, l'automatisation, les applications sur mesure, l'intégration de systèmes, l'architecture de données et l'accompagnement stratégique.",
					),
					array(
						'question' => "Pourquoi ne travaillez-vous pas à l'heure?",
						'reponse'  => 'Parce que notre objectif est de créer le plus de valeur possible, et non de maximiser les heures facturées. Le modèle de partenariat à forfait favorise l\'amélioration continue, la prévisibilité budgétaire et l\'alignement sur les résultats.',
					),
					array(
						'question' => 'Puis-je annuler en tout temps?',
						'reponse'  => 'Les modalités de renouvellement et de résiliation sont définies dans l\'entente de service. Nos partenariats sont généralement établis pour une période initiale de 12 mois, avec une révision annuelle des résultats et des objectifs.',
					),
					array(
						'question' => 'Pourquoi exigez-vous parfois un diagnostic de faisabilité?',
						'reponse'  => "Certaines opportunités s'évaluent rapidement en consultation. Pour les environnements plus complexes, un diagnostic permet de valider les processus, les systèmes, les contraintes et le potentiel de ROI avant de recommander une solution.",
					),
				);
				$kpibi_faq_items = get_field( 'forfait_faq' ) ?: $kpibi_faq_defaults;
				foreach ( $kpibi_faq_items as $kpibi_faq_item ) :
					?>
					<details class="faq-item reveal">
						<summary class="faq-q"><?php echo esc_html( $kpibi_faq_item['question'] ); ?></summary>
						<div class="faq-a"><?php echo esc_html( $kpibi_faq_item['reponse'] ); ?></div>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- APPEL À L'ACTION -->
	<section class="section-cta" id="cta" aria-labelledby="forfait-cta-heading">
		<div class="container">
			<p class="cta-label"><?php echo esc_html( kpibi_f( 'forfait_cta_label', 'Première étape' ) ); ?></p>
			<h2 id="forfait-cta-heading"><?php echo esc_html( kpibi_f( 'forfait_cta_titre', 'Voyons si cette approche est' ) ); ?><br><strong><?php echo esc_html( kpibi_f( 'forfait_cta_titre_fort', 'adaptée à votre réalité.' ) ); ?></strong></h2>
			<p><?php echo esc_html( kpibi_f( 'forfait_cta_texte', 'Chaque organisation a ses contraintes, ses systèmes et ses priorités. Une première conversation nous permettra de voir si un partenariat avec KPIBI est la bonne option — et si oui, par où commencer.' ) ); ?></p>
			<div class="cta-actions">
				<a href="<?php echo esc_url( kpibi_f( 'forfait_cta_btn1_url', 'mailto:' . get_theme_mod( 'kpibi_email', 'info@kpibi.com' ) ) ); ?>" class="btn btn-primary" style="font-size:16px;padding:14px 32px;"><?php echo esc_html( kpibi_f( 'forfait_cta_btn1_texte', 'Planifier une consultation gratuite' ) ); ?></a>
				<a href="<?php echo esc_url( kpibi_link( kpibi_f( 'forfait_cta_btn2_url', '' ), 'cas-clients' ) ); ?>" class="btn btn-outline" style="font-size:16px;padding:14px 32px;"><?php echo esc_html( kpibi_f( 'forfait_cta_btn2_texte', 'Voir nos réalisations' ) ); ?></a>
			</div>
			<p class="cta-guarantee"><?php echo esc_html( kpibi_f( 'forfait_cta_garantie', 'Sans engagement · Feuille de route claire · Analyse comparative de votre industrie' ) ); ?></p>
		</div>
	</section>

<?php endwhile; ?>

<?php get_footer(); ?>
