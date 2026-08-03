<?php
/* Template Name: Page cas clients */
/**
 * Gabarit de la page « Cas clients ».
 * Contenu principal (liste des cas) issu du Custom Post Type « cas_client »
 * (voir inc/cpt-cas-clients.php et inc/acf-fields-cas-client-cpt.php) : un
 * article = un cas client, géré par Phil dans wp-admin (Cas clients >
 * Ajouter), sans plus manipuler de gros repeater ACF.
 *
 * Repli PHP : si aucun post « cas_client » n'existe encore en base (site
 * neuf, ou juste après cette migration avant que Phil n'ait recréé les cas
 * dans wp-admin), on affiche les 3 cas de démo d'origine (Brass Plomberie,
 * N.V. Cloutier, distributeur national) en dur, pour que la page ne soit
 * jamais vide en développement local ou en attendant la migration manuelle
 * des contenus. Dès qu'au moins un post « cas_client » existe, ce repli est
 * ignoré et seuls les vrais posts s'affichent.
 *
 * @package KPIBI
 */

get_header();

// Note : le helper kpibi_cas_lines() est défini globalement dans
// functions.php (partagé avec single-cas_client.php), pas ici.

/**
 * Repli PHP : contenu réel de la maquette cas-clients.html, utilisé tant que
 * Phil n'a pas (encore) configuré le repeater « cas_clients » dans wp-admin.
 * Chaque cas = tag, image, titre (2 parties), liste de paragraphes de contexte,
 * liste de paragraphes de solution, résultats chiffrés (sous-repeater),
 * liste de résultats à puces, citation + auteur.
 */
$kpibi_cas_defaults = array(
	array(
		'tag'            => 'Tableaux de bord KPI · Connecteurs sur mesure',
		'image'          => kpibi_img( 'img-pilier-dashboards.jpg' ),
		'titre'          => 'Brass Plomberie —',
		'titre_fort'     => "Une visibilité stratégique qui s'autofinance",
		'contexte'       => array(
			"Brass Plomberie, une entreprise d'environ 50 employés, disposait de beaucoup de données, mais manquait d'une vue claire sur ses finances et ses opérations.",
			"Les données étaient déjà dans ProgressionLive et QuickBooks Online, mais elles étaient éparpillées un peu partout. Chaque mois, l'équipe devait sortir les chiffres manuellement, les copier dans des Excel, les modifier plusieurs fois et essayer de tout comprendre. Ça prenait 20 à 30 heures par mois, ça augmentait les risques d'erreurs et ça rendait les décisions plus difficiles et plus lentes.",
		),
		'solution'       => array(
			"KPIBI a créé une solution qui connecte automatiquement ProgressionLive et QuickBooks Online. On a développé des connecteurs sur mesure pour récupérer les données des deux systèmes, y compris certaines informations qui n'étaient pas accessibles de façon standard ou qui nécessitaient auparavant plusieurs manipulations manuelles. Toutes les informations sont maintenant rassemblées dans un seul tableau de bord Power BI, clair et facile à comprendre pour l'équipe de direction.",
			"On a même ajouté le calendrier des fêtes des employés directement dans le tableau de bord, mis à jour par la partie RH du ERP. Aujourd'hui, le tableau s'affiche sur un grand écran au bureau : tout le monde peut voir comment va l'entreprise en un coup d'œil.",
		),
		'resultats_chiffres' => array(
			array( 'num' => '20–30 h', 'label' => 'Économisées par mois' ),
			array( 'num' => '0', 'label' => 'Erreur de saisie manuelle' ),
			array( 'num' => '1', 'label' => 'Tableau de bord unifié' ),
		),
		'resultats_liste' => array(
			"20 à 30 heures de moins par mois à préparer et vérifier des rapports — des gains récurrents qui contribuent directement à financer l'investissement.",
			"Élimination des risques d'erreurs liés à la manipulation manuelle des données.",
			"Toutes les informations financières et opérationnelles sont maintenant à jour et fiables.",
			"On peut facilement suivre les tendances dans le temps.",
			"Des rencontres stratégiques mensuelles avec KPIBI pour revoir les indicateurs (KPI) ensemble et ajuster le tir rapidement.",
			"Meilleure prise de décision, surtout pendant les périodes de croissance.",
			"Une architecture de données évolutive capable de soutenir la croissance future de l'entreprise.",
		),
		'citation'       => "Grâce à KPIBI, on a maintenant des KPI clairs, utiles et faciles à suivre au quotidien. Tout est regroupé dans un tableau de bord automatique connecté à notre système de gestion et à notre comptabilité. On a une bien meilleure vue sur nos opérations et on prend de meilleures décisions.",
		'citation_fort'  => 'bien meilleure vue sur nos opérations',
		'auteur_nom'     => 'Stéphanie Girard',
		'auteur_role'    => 'Copropriétaire, Stratégie et optimisation des projets, Brass Plomberie',
		'img_position'   => 'center',
	),
	array(
		'tag'            => 'Application sur mesure · CRM mobile',
		'image'          => kpibi_img( 'img-pilier-apps.jpg' ),
		'titre'          => 'N.V. Cloutier —',
		'titre_fort'     => 'Une plateforme de croissance conçue pour le terrain',
		'contexte'       => array(
			"N.V. Cloutier dessert plus de 700 garages et carrosseries à travers tout le Québec. Malgré sa croissance, les représentants n'avaient aucun outil centralisé : pas de place pour noter leurs activités, consulter l'historique des clients ou gérer les opportunités pendant leurs déplacements.",
			"L'information était éparpillée, les suivis dépendaient de la mémoire de chacun, et la direction avait très peu de visibilité sur ce qui se passait réellement sur la route. Ça freinait la croissance, compliquait le transfert de connaissances et faisait perdre des ventes.",
		),
		'solution'       => array(
			"KPIBI a conçu et déployé en moins de 60 jours une plateforme CRM mobile sur Microsoft Power Apps et Azure, bâtie sur mesure pour la réalité des représentants sur la route. Déployée rapidement pour répondre à un besoin immédiat, la plateforme a ensuite évolué de façon continue pour accompagner la croissance de l'organisation.",
			'Avec le temps, cette plateforme est devenue le cœur des opérations commerciales :',
		),
		'solution_liste' => array(
			"Synchronisation quotidienne avec l'ERP pour voir l'historique d'achats des clients.",
			'Géolocalisation des visites pour optimiser les routes et les territoires.',
			'Catalogue de plus de 22 000 pièces et lubrifiants mis à jour automatiquement.',
			'Génération automatique de propositions de commandes avec acceptation par courriel.',
			'Tableau de bord Power BI pour que la direction suive les ventes, les interactions clients et les opportunités en temps réel.',
			"Suivi de la performance des représentants pour encourager l'amélioration continue.",
		),
		'solution_apres' => array(
			'Aujourd\'hui, tout est centralisé, mobile et conçu pour que les représentants passent plus de temps avec les clients et moins dans la paperasse.',
		),
		'resultats_chiffres' => array(
			array( 'num' => '< 60 j', 'label' => 'Déploiement complet' ),
			array( 'num' => '700+', 'label' => 'Clients sur une seule plateforme' ),
			array( 'num' => '5 → 3', 'label' => 'Représentants, croissance maintenue' ),
		),
		'resultats_liste' => array(
			"Passage de 5 à 3 représentants à la suite de départs naturels non remplacés, tout en poursuivant la croissance de l'entreprise.",
			'Déploiement complet en moins de 60 jours.',
			'Plus de 700 clients desservis via une seule plateforme centralisée.',
			'Réduction majeure du temps passé sur les tâches administratives.',
			'Visibilité complète sur les activités commerciales quotidiennes.',
			'Meilleure exploitation des données clients pour trouver de nouvelles opportunités.',
			'Processus de vente standardisés et beaucoup plus efficaces.',
			'Plateforme devenue essentielle au cœur des opérations.',
			"Nouvelle phase en cours : automatisation robotisée du traitement des commandes dans l'ERP pour continuer à grandir sans ajouter de ressources administratives.",
		),
		'citation'       => "Avant KPIBI, notre suivi client était éparpillé entre des notes, des appels et des souvenirs. Aujourd'hui, tout est centralisé, nos représentants sont efficaces sur la route et on a une visibilité complète sur les ventes, les activités et les opportunités.",
		'citation_fort'  => 'tout est centralisé',
		'auteur_nom'     => 'Charles Martineau',
		'auteur_role'    => 'Copropriétaire, Directeur des opérations fixes, N.V. Cloutier',
		'img_position'   => 'center 20%',
	),
	array(
		'tag'            => 'Automatisation des processus · RPA',
		'image'          => kpibi_img( 'img-pilier-automatisation.jpg' ),
		'titre'          => 'Distributeur national (confidentiel) —',
		'titre_fort'     => "Automatiser un processus qui n'aurait jamais dû être manuel",
		'contexte'       => array(
			"Cette entreprise gère un très grand volume de transactions. Chaque transaction a une valeur importante pour l'entreprise, mais le processus d'exécution lui-même n'apportait aucune valeur ajoutée.",
			"Les systèmes numériques existants ne communiquaient pas entre eux. Il n'y avait aucune automatisation réelle : tout reposait sur des manipulations manuelles répétitives, des saisies multiples, des validations, des reprises d'information et des corrections. À cela s'ajoutait une forte variabilité du volume de transactions, ce qui rendait la planification des ressources humaines très difficile et créait des goulots d'étranglement importants pendant les périodes de pointe.",
		),
		'solution'       => array(
			"KPIBI a d'abord repensé et simplifié l'ensemble du processus en appliquant des principes d'amélioration continue, de simplification, de standardisation et d'ingénierie des systèmes humains.",
			"On a ensuite développé une plateforme centralisée sur Microsoft Power Platform qui unifie les systèmes. Finalement, on a déployé un robot logiciel (RPA) capable d'interagir directement avec les plateformes des fournisseurs et d'exécuter la grande majorité des transactions de façon autonome. Résultat : le processus d'exécution, qui n'apportait aucune valeur ajoutée, est maintenant presque entièrement automatisé. Les humains interviennent uniquement pour les exceptions et les tâches à haute valeur.",
		),
		'resultats_chiffres' => array(
			array( 'num' => '5 → 1', 'label' => 'Ressources + un robot' ),
			array( 'num' => '77 s', 'label' => 'Par transaction complexe' ),
			array( 'num' => '~0', 'label' => 'Erreur manuelle' ),
		),
		'resultats_liste' => array(
			"Réduction de la main-d'œuvre nécessaire : l'équivalent de 5 ressources à temps plein ramené à environ 1 ressource et un robot.",
			'Élimination presque totale des erreurs causées par les manipulations manuelles.',
			'Des transactions complexes exécutées automatiquement en 77 secondes.',
			'Traitement des commandes beaucoup plus rapide, uniforme et prévisible, même en période de pointe.',
			'Libération des équipes pour se concentrer sur des activités à plus haute valeur ajoutée.',
			'Visibilité complète sur tout le processus, de la vente jusqu\'à l\'exécution.',
			'Une plateforme évolutive qui absorbe facilement les variations de volume sans devoir ajouter du personnel.',
		),
		'citation'       => 'La vitesse est hallucinante, voire déconcertante […] et c\'est de l\'ordre du totalement impossible pour un humain d\'aller à cette vitesse-là. On vient finalement de dénouer le goulot.',
		'citation_fort'  => 'dénouer le goulot',
		'auteur_nom'     => 'Client confidentiel',
		'auteur_role'    => 'Distributeur national',
		'img_position'   => 'center',
	),
);

/**
 * Charge les cas clients depuis le CPT « cas_client » et les normalise dans
 * la même forme de tableau que l'ancien repeater ACF (mêmes clés : tag,
 * image, titre, titre_fort, contexte, solution, solution_liste,
 * solution_apres, resultats_chiffres, resultats_liste, citation,
 * citation_fort, auteur_nom, auteur_role, img_position). Ainsi, la boucle de
 * rendu ci-dessous (HTML/CSS) n'a besoin d'aucune modification : seule la
 * SOURCE des données change.
 */
$kpibi_cas_posts = get_posts(
	array(
		'post_type'      => 'cas_client',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order date',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	)
);

$kpibi_cas_clients = array();
// Garde-fou : si ACF Pro est absent, get_field() n'existe pas — on affiche
// alors seulement le titre/l'image natifs de chaque post, sans planter.
$kpibi_has_acf = function_exists( 'get_field' );
foreach ( $kpibi_cas_posts as $kpibi_cas_post ) {
	$kpibi_post_id = $kpibi_cas_post->ID;
	// Seul le TEXTE passe par la typographie française. L'URL de l'image et la
	// valeur CSS `img_position` sont ajoutées après, hors de kpibi_typo_deep() :
	// ce ne sont pas des phrases, elles n'ont rien à y gagner.
	$kpibi_cas_item = kpibi_typo_deep(
		array(
			'tag'                => $kpibi_has_acf ? get_field( 'ccpt_tag', $kpibi_post_id ) : '',
			'titre'              => get_the_title( $kpibi_post_id ),
			'titre_fort'         => $kpibi_has_acf ? get_field( 'ccpt_titre_fort', $kpibi_post_id ) : '',
			'contexte'           => $kpibi_has_acf ? get_field( 'ccpt_contexte', $kpibi_post_id ) : '',
			'solution'           => $kpibi_has_acf ? get_field( 'ccpt_solution', $kpibi_post_id ) : '',
			'solution_liste'     => $kpibi_has_acf ? get_field( 'ccpt_solution_liste', $kpibi_post_id ) : '',
			'solution_apres'     => $kpibi_has_acf ? get_field( 'ccpt_solution_apres', $kpibi_post_id ) : '',
			'resultats_chiffres' => $kpibi_has_acf ? get_field( 'ccpt_resultats_chiffres', $kpibi_post_id ) : array(),
			'resultats_liste'    => $kpibi_has_acf ? get_field( 'ccpt_resultats_liste', $kpibi_post_id ) : '',
			'citation'           => $kpibi_has_acf ? get_field( 'ccpt_citation', $kpibi_post_id ) : '',
			'citation_fort'      => $kpibi_has_acf ? get_field( 'ccpt_citation_fort', $kpibi_post_id ) : '',
			'auteur_nom'         => $kpibi_has_acf ? get_field( 'ccpt_auteur_nom', $kpibi_post_id ) : '',
			'auteur_role'        => $kpibi_has_acf ? get_field( 'ccpt_auteur_role', $kpibi_post_id ) : '',
			// Texte alternatif résolu ici, où l'ID du post est connu : l'URL de la
			// vignette est une taille intermédiaire, non résoluble depuis l'URL seule.
			'image_alt'          => kpibi_thumb_alt( $kpibi_post_id, '' ),
		)
	);
	$kpibi_cas_item['image']        = get_the_post_thumbnail_url( $kpibi_post_id, 'large' );
	$kpibi_cas_item['img_position'] = ( $kpibi_has_acf && get_field( 'ccpt_img_position', $kpibi_post_id ) ) ? get_field( 'ccpt_img_position', $kpibi_post_id ) : 'center';
	$kpibi_cas_clients[]            = $kpibi_cas_item;
}

// Repli : aucun post « cas_client » en base — affiche les 3 cas de démo
// d'origine plutôt que de laisser la section vide (voir note en tête de fichier).
if ( empty( $kpibi_cas_clients ) ) {
	$kpibi_cas_clients = kpibi_typo_deep( $kpibi_cas_defaults );
}

while ( have_posts() ) :
	the_post();
	?>

	<!-- BANNIÈRE -->
	<section class="page-hero">
		<?php $kpibi_hero_img = kpibi_f( 'banniere_image', kpibi_img( 'img-pilier-dashboards.jpg' ) ); ?>
		<div class="page-hero-bg" style="background-image:url('<?php echo esc_url( $kpibi_hero_img ); ?>');"></div>
		<div class="page-hero-gradient"></div>
		<div class="container"><div class="page-hero-inner">
			<p class="page-hero-label"><?php echo esc_html( kpibi_f( 'banniere_label', 'Cas clients · Résultats réels' ) ); ?></p>
			<h1><?php
				echo esc_html( kpibi_f( 'banniere_titre', 'Ce que ça donne, concrètement, pour des entreprises' ) );
				echo ' <strong>' . esc_html( kpibi_f( 'banniere_titre_fort', 'comme la vôtre.' ) ) . '</strong>';
			?></h1>
			<p class="page-hero-sub"><?php echo esc_html( kpibi_f( 'banniere_sous_titre', 'Trois mandats, trois réalités différentes. Le même fil conducteur : des opérations simplifiées, des données fiables et des gains mesurables qui durent.' ) ); ?></p>
			<div class="page-hero-actions">
				<a href="<?php echo esc_url( kpibi_f( 'banniere_cta1_url', '#cta' ) ); ?>" class="btn btn-primary"><?php echo esc_html( kpibi_f( 'banniere_cta1_texte', 'Planifier une consultation gratuite' ) ); ?></a>
				<a href="<?php echo esc_url( kpibi_link( kpibi_f( 'banniere_cta2_url', '' ), 'forfait' ) ); ?>" class="btn btn-outline"><?php echo esc_html( kpibi_f( 'banniere_cta2_texte', 'Voir le forfait' ) ); ?></a>
			</div>
		</div></div>
	</section>

	<!-- CAS CLIENTS -->
	<section class="section-cas">
		<div class="container">

			<?php foreach ( $kpibi_cas_clients as $kpibi_cas ) : ?>
				<?php
				$kpibi_tag         = isset( $kpibi_cas['tag'] ) ? $kpibi_cas['tag'] : '';
				$kpibi_image       = isset( $kpibi_cas['image'] ) ? $kpibi_cas['image'] : '';
				$kpibi_titre       = isset( $kpibi_cas['titre'] ) ? $kpibi_cas['titre'] : '';
				$kpibi_titre_fort  = isset( $kpibi_cas['titre_fort'] ) ? $kpibi_cas['titre_fort'] : '';
				$kpibi_contexte    = kpibi_cas_lines( isset( $kpibi_cas['contexte'] ) ? $kpibi_cas['contexte'] : array() );
				$kpibi_solution    = kpibi_cas_lines( isset( $kpibi_cas['solution'] ) ? $kpibi_cas['solution'] : array() );
				$kpibi_solution_liste = kpibi_cas_lines( isset( $kpibi_cas['solution_liste'] ) ? $kpibi_cas['solution_liste'] : array() );
				$kpibi_solution_apres = kpibi_cas_lines( isset( $kpibi_cas['solution_apres'] ) ? $kpibi_cas['solution_apres'] : array() );
				$kpibi_chiffres    = isset( $kpibi_cas['resultats_chiffres'] ) ? (array) $kpibi_cas['resultats_chiffres'] : array();
				$kpibi_resultats   = kpibi_cas_lines( isset( $kpibi_cas['resultats_liste'] ) ? $kpibi_cas['resultats_liste'] : array() );
				$kpibi_citation    = isset( $kpibi_cas['citation'] ) ? $kpibi_cas['citation'] : '';
				$kpibi_citation_fort = isset( $kpibi_cas['citation_fort'] ) ? $kpibi_cas['citation_fort'] : '';
				$kpibi_auteur_nom  = isset( $kpibi_cas['auteur_nom'] ) ? $kpibi_cas['auteur_nom'] : '';
				$kpibi_auteur_role = isset( $kpibi_cas['auteur_role'] ) ? $kpibi_cas['auteur_role'] : '';
				$kpibi_img_pos     = isset( $kpibi_cas['img_position'] ) ? $kpibi_cas['img_position'] : 'center';
				// Repli du texte alternatif : le titre du cas client (ses deux
				// moitiés telles qu'affichées), ou un libellé générique s'il est vide.
				$kpibi_img_alt_repli = trim( $kpibi_titre . ' ' . $kpibi_titre_fort );
				if ( '' === $kpibi_img_alt_repli ) {
					$kpibi_img_alt_repli = kpibi__( 'Cas client KPIBI' );
				}
				// Cas venant du CPT : alt déjà résolu depuis l'image mise en avant.
				// Cas de démonstration : l'image est un fichier du thème, absent de la
				// médiathèque — kpibi_img_alt() retombera donc sur le titre.
				$kpibi_cas_img_alt = ! empty( $kpibi_cas['image_alt'] )
					? $kpibi_cas['image_alt']
					: kpibi_img_alt( $kpibi_image, $kpibi_img_alt_repli );
				?>
				<article class="cas-card reveal">
					<?php if ( $kpibi_image ) : ?>
						<img src="<?php echo esc_url( $kpibi_image ); ?>" alt="<?php echo esc_attr( $kpibi_cas_img_alt ); ?>" class="cas-card-img" loading="lazy" style="object-position:<?php echo esc_attr( $kpibi_img_pos ); ?>;">
					<?php endif; ?>
					<div class="cas-card-body">
						<?php if ( $kpibi_tag ) : ?>
							<span class="cas-tag"><?php echo esc_html( $kpibi_tag ); ?></span>
						<?php endif; ?>
						<h3><?php echo esc_html( $kpibi_titre ); ?><br><strong><?php echo esc_html( $kpibi_titre_fort ); ?></strong></h3>

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
							<blockquote style="font-style:italic;font-size:16px;color:var(--slate-700);border-left:3px solid var(--gold-400);padding-left:20px;margin:0;">
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
					</div>
				</article>
			<?php endforeach; ?>

		</div>
	</section>

	<!-- APPEL À L'ACTION -->
	<section class="section-cta" id="cta" aria-labelledby="cta-heading">
		<div class="container">
			<p class="cta-label"><?php echo esc_html( kpibi_f( 'cas_cta_label', 'À votre tour' ) ); ?></p>
			<h2 id="cta-heading"><?php echo esc_html( kpibi_f( 'cas_cta_titre', 'Vous venez de lire des résultats concrets.' ) ); ?><br><strong><?php echo esc_html( kpibi_f( 'cas_cta_titre_fort', 'Voyons ce qui est possible pour vous.' ) ); ?></strong></h2>
			<p><?php echo esc_html( kpibi_f( 'cas_cta_texte', "Vous repartirez avec une feuille de route claire, les premiers leviers d'amélioration identifiés et une analyse comparative financière de votre industrie." ) ); ?></p>
			<div class="cta-actions">
				<a href="<?php echo esc_url( kpibi_f( 'cas_cta_btn1_url', 'mailto:' . get_theme_mod( 'kpibi_email', 'info@kpibi.com' ) ) ); ?>" class="btn btn-primary" style="font-size:16px;padding:14px 32px;"><?php echo esc_html( kpibi_f( 'cas_cta_btn1_texte', 'Planifier une consultation gratuite' ) ); ?></a>
				<a href="<?php echo esc_url( kpibi_link( kpibi_f( 'cas_cta_btn2_url', '' ), 'forfait' ) ); ?>" class="btn btn-outline" style="font-size:16px;padding:14px 32px;"><?php echo esc_html( kpibi_f( 'cas_cta_btn2_texte', 'Voir le forfait' ) ); ?></a>
			</div>
			<p class="cta-guarantee"><?php echo esc_html( kpibi_f( 'cas_cta_garantie', 'Sans engagement · Réponse en moins de 24h · Expertise locale québécoise' ) ); ?></p>
		</div>
	</section>

<?php
endwhile;
get_footer();
