<?php
/**
 * KPIBI — fonctions du thème
 *
 * @package KPIBI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Sécurité : pas d'accès direct.
}

define( 'KPIBI_VERSION', '1.3.18' );

/**
 * Réglages de base du thème.
 */
function kpibi_setup() {
	load_theme_textdomain( 'kpibi', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	// Logo du site éditable dans Personnaliser › Identité du site.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 40,
			'width'       => 180,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );

	// Emplacements de menus gérables dans Apparence › Menus.
	register_nav_menus(
		array(
			'primary'         => __( 'Menu principal', 'kpibi' ),
			'footer_solutions' => __( 'Pied de page — Colonne 1', 'kpibi' ),
			'footer_kpibi'    => __( 'Pied de page — Colonne 2', 'kpibi' ),
		)
	);
}
add_action( 'after_setup_theme', 'kpibi_setup' );

/**
 * Retire de l'en-tête deux liens que WordPress émet par défaut et qui pointent
 * vers des ressources absentes sur ce site — relevés en 404 par le scan de QA
 * (2 erreurs sur 168 URLs vérifiées) :
 *
 * 1. « RSD » (Really Simple Discovery), /xmlrpc.php?rsd — un mécanisme de
 *    découverte destiné aux clients de publication distants (Windows Live
 *    Writer et consorts). Obsolète, et inutile ici puisque le contenu se gère
 *    dans wp-admin. Le lien renvoie 404, l'accès à xmlrpc.php étant fermé.
 *
 * 2. Le flux RSS des COMMENTAIRES, /comments/feed/. Les commentaires sont
 *    désactivés sur ce site : le flux n'existe pas, d'où le 404 sur la version
 *    anglaise (/en/comments/feed/).
 *
 * Le flux PRINCIPAL des articles est conservé — il est légitime pour le blogue.
 * Deux mécanismes distincts produisent des flux de commentaires, d'où deux
 * traitements :
 *   - feed_links() émet le flux global des commentaires du site en même temps
 *     que le flux principal. On ne peut donc pas le retirer en désactivant le
 *     hook sans perdre aussi le flux du blogue : c'est le filtre
 *     `feed_links_show_comments_feed` qui permet de ne désactiver que lui.
 *   - feed_links_extra() émet les flux secondaires (commentaires d'un article,
 *     par catégorie, par auteur), tous inutiles ici.
 */
function kpibi_nettoyer_entete() {
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
}
add_action( 'init', 'kpibi_nettoyer_entete' );
add_filter( 'feed_links_show_comments_feed', '__return_false' );

/**
 * Image de partage social par défaut (og:image / twitter:image).
 *
 * Constat de QA : aucune balise og:image n'était émise, et l'aperçu de partage
 * Facebook affichait le logo mal cadré. Yoast n'a pas d'image sociale par
 * défaut configurée, et son réglage n'est pas accessible autrement que par son
 * interface — on le pose donc ici, dans le thème, où il est versionné.
 *
 * L'image est retrouvée par son SLUG plutôt que par un ID numérique : les ID de
 * pièces jointes changent d'un environnement à l'autre (dev / prod), alors que
 * le slug survit à une réimportation de la médiathèque. Résultat mémorisé pour
 * ne pas refaire la requête à chaque appel.
 *
 * Ne s'applique QUE si aucune image n'est déjà définie pour la page courante :
 * une image mise en avant ou une image sociale saisie dans Yoast reste
 * prioritaire.
 *
 * À revoir : l'idéal pour le partage social est un visuel dédié au format
 * 1200 × 630 (ratio 1.91:1) portant le logo et une accroche. L'image utilisée
 * ici est une photo du site (1800 × 1200, ratio 1.5) : elle sera légèrement
 * recadrée en haut et en bas par les réseaux sociaux.
 */
function kpibi_url_image_partage() {
	static $url = null;
	if ( null === $url ) {
		// get_page_by_path() ne convient PAS ici : pour une pièce jointe
		// rattachée à une publication, le « chemin » attendu inclut le slug du
		// parent, si bien qu'une recherche sur le seul slug du fichier ne
		// renvoie rien (vérifié : aucune balise produite). On interroge donc
		// directement par post_name, avec le statut « inherit » propre aux
		// pièces jointes.
		$ids = get_posts(
			array(
				'name'           => 'kpibi-tableau-de-bord-portable',
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'numberposts'    => 1,
				'fields'         => 'ids',
				'no_found_rows'  => true,
			)
		);
		$url = $ids ? (string) wp_get_attachment_image_url( $ids[0], 'full' ) : '';
	}
	return $url;
}

/**
 * Émet og:image et twitter:image quand aucune image de partage n'existe.
 *
 * Le filtre `wpseo_opengraph_image` n'a PAS fonctionné (vérifié : aucune balise
 * produite) — depuis Yoast 14, le présentateur d'image est simplement ignoré
 * quand il n'y a aucune image, et le filtre n'est donc jamais appliqué. On émet
 * la balise nous-mêmes, à une priorité postérieure à celle de Yoast.
 *
 * GARDE-FOU CONTRE LE DOUBLON : on n'émet rien si la page a une image mise en
 * avant ou une image sociale saisie dans Yoast — ce sont précisément les deux
 * cas où Yoast produit déjà la balise. Priorité au contenu de la page.
 */
function kpibi_meta_image_partage() {
	if ( is_singular() ) {
		$id = get_queried_object_id();
		if ( has_post_thumbnail( $id ) ) {
			return;
		}
		if ( get_post_meta( $id, '_yoast_wpseo_opengraph-image', true ) ) {
			return;
		}
	}
	$url = kpibi_url_image_partage();
	if ( ! $url ) {
		return;
	}
	printf(
		"<meta property=\"og:image\" content=\"%1\$s\" />\n<meta name=\"twitter:image\" content=\"%1\$s\" />\n",
		esc_url( $url )
	);
}
add_action( 'wp_head', 'kpibi_meta_image_partage', 20 );

/**
 * Chargement des styles, polices et scripts.
 */
function kpibi_assets() {
	// Police Google : Manrope uniquement.
	//
	// L'URL demandait aussi « Dubai », qui n'est PAS au catalogue Google Fonts
	// (police Microsoft, non libre) : `?family=Dubai:wght@400` seule renvoie
	// HTTP 400.
	//
	// CE QUI N'EST PAS ARRIVÉ, contrairement à ce qu'on pouvait craindre : une
	// famille inconnue ne fait PAS échouer une requête multi-familles. Google
	// l'ignore en silence et sert les autres. Mesuré sur l'ancienne URL complète :
	// HTTP 200, 30 @font-face, toutes « Manrope », zéro « Dubai » — et dans un
	// navigateur réel sur les pages du site, document.fonts.check() répond true
	// pour 400/500/600/700 et le même .woff2 de 24 605 o est téléchargé qu'après
	// correction. Manrope était donc DÉJÀ servie : le corps de texte n'a jamais
	// été en police système. Seuls les titres le sont, parce que le CSS déclare
	// "Dubai" et que cette police n'existe pas côté web — c'est un problème de
	// CSS, pas d'URL, et sa résolution est une décision de design hors de cette
	// story (44 déclarations font-family recensées, dont 38 en "Dubai").
	//
	// CE QUE CETTE CORRECTION APPORTE RÉELLEMENT : une URL qui dit ce qu'elle
	// fait, et la 800 en moins — relevée inutilisée au getComputedStyle sur
	// chaque élément des 12 pages (FR + EN), pseudo-éléments compris, plutôt que
	// recopiée de l'ancienne liste. Le gain d'octets est marginal et il faut le
	// dire : la CSS passe de 10 895 à 8 715 o (1 219 → 1 185 o sur le fil), et le
	// poids des polices téléchargées ne bouge PAS. Google sert Manrope en fonte
	// VARIABLE : les 4 graisses pointent le même fichier, une graisse de moins
	// n'est donc pas un téléchargement de moins. Le vrai gain de cette story est
	// le preconnect ci-dessous.
	//
	// Graisses retenues : 400, 500, 600, 700 (aucun élément du thème n'appelle la
	// 800 ; la 300 n'apparaît que sur des sélecteurs en "Dubai").
	wp_enqueue_style(
		'kpibi-fonts',
		'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	// Feuille de style principale (extraite de la maquette).
	wp_enqueue_style(
		'kpibi-main',
		get_template_directory_uri() . '/assets/css/style.css',
		array(),
		KPIBI_VERSION
	);

	// JavaScript (menu mobile, dropdowns, animations au défilement).
	wp_enqueue_script(
		'kpibi-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		KPIBI_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'kpibi_assets' );

/**
 * Preconnect vers les deux hôtes de Google Fonts.
 *
 * WordPress n'ajoute de lui-même qu'un dns-prefetch vers fonts.googleapis.com,
 * qui ne résout que le DNS. Le preconnect ouvre en plus la connexion TCP et la
 * poignée de main TLS pendant l'analyse du document. Les deux hôtes comptent :
 * googleapis.com sert la feuille CSS, gstatic.com sert les .woff2, et c'est
 * gstatic.com qui est sur le chemin critique du premier rendu du texte.
 *
 * crossorigin est OBLIGATOIRE sur gstatic.com et seulement sur lui : les
 * polices sont récupérées en mode anonyme (CORS), et une connexion préouverte
 * sans ce drapeau ne serait pas réutilisée — on paierait la poignée de main
 * deux fois au lieu de zéro. googleapis.com sert du CSS, sans CORS : lui
 * ajouter crossorigin produirait la même connexion inutilisée.
 */
function kpibi_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.googleapis.com' );
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => '',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'kpibi_resource_hints', 10, 2 );

/**
 * En-têtes de sécurité essentiels (recommandation « Santé du site »).
 * Ajoutés côté front (pas dans l'admin). HSTS uniquement en HTTPS, donc
 * s'activera automatiquement en production (kpibi.com). CSP limité à
 * « upgrade-insecure-requests » pour ne rien casser (polices, CF7, Complianz).
 */
function kpibi_security_headers() {
	if ( is_admin() ) {
		return;
	}
	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	header( 'Permissions-Policy: geolocation=(), camera=(), microphone=(), interest-cohort=()' );
	header( 'X-XSS-Protection: 1; mode=block' );
	header( 'Content-Security-Policy: upgrade-insecure-requests;' );
	if ( is_ssl() ) {
		header( 'Strict-Transport-Security: max-age=31536000; includeSubDomains' );
	}
}
add_action( 'send_headers', 'kpibi_security_headers' );

/**
 * Helper : typographie française — espace insécable avant $, %, : et ;.
 *
 * La règle est volontairement étroite : on ne remplace QUE l'espace ordinaire
 * (U+0020) qui précède immédiatement le symbole. Cette seule condition suffit à
 * protéger tout ce qu'il ne faut pas toucher, sans liste d'exclusion à tenir :
 *
 * - URL : dans `https://` ou `mailto:info@…`, le « : » suit une lettre, jamais
 *   une espace — la chaîne est laissée intacte.
 * - Valeurs CSS : dans `center 20%`, le « % » suit le chiffre, pas une espace.
 * - Entités HTML : dans `&amp;` ou `&#8217;`, le « ; » suit une lettre ou un
 *   chiffre. La transformation s'applique de toute façon AVANT l'échappement,
 *   donc sur du texte brut où aucune entité n'a encore été produite.
 *
 * @param mixed $texte Valeur à traiter (les non-chaînes sont retournées telles quelles).
 * @return mixed
 */
function kpibi_typo( $texte ) {
	if ( ! is_string( $texte ) || '' === $texte ) {
		return $texte;
	}
	// U+00A0. Le drapeau /u traite la chaîne en UTF-8 (accents du contenu FR).
	return preg_replace( '/ (?=[$%:;])/u', "\xC2\xA0", $texte );
}

/**
 * Helper : applique kpibi_typo() en profondeur (répéteurs ACF, tableaux de
 * valeurs par défaut). Les clés ne sont jamais touchées, seulement les chaînes.
 *
 * @param mixed $valeur Chaîne, tableau imbriqué, ou toute autre valeur.
 * @return mixed
 */
function kpibi_typo_deep( $valeur ) {
	if ( is_array( $valeur ) ) {
		return array_map( 'kpibi_typo_deep', $valeur );
	}
	return kpibi_typo( $valeur );
}

/**
 * Helper : retourne un champ ACF, ou une valeur par défaut si ACF est absent ou le champ vide.
 * Permet au thème de fonctionner même avant l'installation d'ACF (affiche le contenu par défaut).
 *
 * La typographie française est appliquée ici, au point de passage unique de
 * tout le contenu éditorial : le texte que le client saisira demain en profite
 * sans qu'on ait à retoucher un gabarit. La valeur par défaut y passe aussi,
 * pour que le rendu soit identique que le champ soit rempli ou non.
 *
 * @param string $name    Nom du champ ACF.
 * @param string $default Valeur par défaut.
 * @return string
 */
function kpibi_f( $name, $default = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return kpibi_typo( $default );
	}
	$value = get_field( $name );
	return kpibi_typo_deep( ( null !== $value && '' !== $value ) ? $value : $default );
}

/**
 * Helper : URL d'une image du thème.
 *
 * @param string $file Nom de fichier dans assets/img/.
 * @return string
 */
function kpibi_img( $file ) {
	return get_template_directory_uri() . '/assets/img/' . $file;
}

/**
 * Helper : texte alternatif d'une image, à partir de son URL.
 *
 * Lit le champ « texte alternatif » NATIF de la médiathèque WordPress
 * (`_wp_attachment_image_alt`) plutôt qu'un champ ACF par image : le client
 * saisit le texte une seule fois, à l'endroit où WordPress l'attend, et il
 * suit l'image partout où elle est réutilisée. Repli sur $default quand la
 * médiathèque ne contient rien, pour ne jamais produire d'`alt` vide.
 *
 * `attachment_url_to_postid()` fait une requête BD à chaque appel et les mêmes
 * images reviennent d'une page à l'autre : le résultat est mémoïsé par URL
 * pour la durée de la requête.
 *
 * @param string $url     URL de l'image (format retourné par les champs image ACF).
 * @param string $default Texte alternatif de repli si aucun n'est défini en médiathèque.
 * @return string
 */
function kpibi_img_alt( $url, $default = '' ) {
	static $cache = array();

	$url = trim( (string) $url );
	if ( '' === $url ) {
		return $default;
	}

	if ( ! array_key_exists( $url, $cache ) ) {
		$alt           = '';
		$attachment_id = attachment_url_to_postid( $url );
		if ( $attachment_id ) {
			$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );
		}
		// On mémoïse aussi la chaîne vide : une image sans texte alternatif en
		// médiathèque ne doit pas relancer la requête à chaque affichage.
		$cache[ $url ] = $alt;
	}

	return '' !== $cache[ $url ] ? $cache[ $url ] : $default;
}

/**
 * Helper : texte alternatif de l'image mise en avant d'une publication.
 *
 * Variante de kpibi_img_alt() pour les vignettes : l'ID de la pièce jointe est
 * déjà connu, on lit donc la médiathèque directement, sans requête de
 * résolution d'URL. C'est aussi la seule façon correcte de procéder ici, car
 * les vignettes sont rendues à une taille intermédiaire (« large »,
 * « medium_large ») dont l'URL suffixée `-800x600` n'est PAS résoluble par
 * attachment_url_to_postid() : passer par l'URL ignorerait silencieusement le
 * texte alternatif saisi en médiathèque.
 *
 * @param int    $post_id ID de la publication portant l'image mise en avant.
 * @param string $default Texte alternatif de repli (en pratique : son titre).
 * @return string
 */
function kpibi_thumb_alt( $post_id, $default = '' ) {
	$thumbnail_id = get_post_thumbnail_id( $post_id );
	if ( $thumbnail_id ) {
		$alt = trim( (string) get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ) );
		if ( '' !== $alt ) {
			return $alt;
		}
	}
	return $default;
}

/**
 * Affiche le logo du site : le logo téléversé dans le Personnalisateur s'il
 * existe, sinon le logo par défaut (pictogramme SVG + mot-symbole « KPIBI »).
 * Rend le logo éditable depuis le CMS sans casser le rendu actuel.
 *
 * @param int $svg_size Taille du pictogramme SVG de repli (px).
 */
function kpibi_logo( $svg_size = 38 ) {
	// Logo téléversé dans Personnaliser › Identité du site : rendu à la
	// hauteur demandée pour conserver la taille propre à chaque contexte
	// (en-tête 38 px, mobile/pied de page 32 px), largeur automatique.
	$logo_id = (int) get_theme_mod( 'custom_logo' );
	if ( $logo_id ) {
		$src = wp_get_attachment_image_url( $logo_id, 'full' );
		if ( $src ) {
			// `alt="KPIBI"` reste tel quel : c'est un nom propre, il ne se traduit pas.
			printf(
				'<a href="%1$s" class="logo" aria-label="%4$s"><img src="%2$s" alt="KPIBI" class="logo-img" style="height:%3$dpx;width:auto;display:block"></a>',
				esc_url( home_url( '/' ) ),
				esc_url( $src ),
				(int) $svg_size,
				esc_attr( kpibi__( 'KPIBI, accueil' ) )
			);
			return;
		}
	}
	$h = (int) $svg_size;
	$w = (int) round( $h * 3.1327 ); // ratio du logo (321.3 / 102.6)
	/*
	 * Le `aria-label="KPIBI"` du <svg> ci-dessous reste tel quel : nom propre,
	 * non traduisible. Ce commentaire est placé avant la fermeture de la balise
	 * PHP pour ne pas insérer de blanc supplémentaire dans le HTML rendu.
	 * (Il est en bloc et non en `//` : une fermeture de balise PHP écrite dans un
	 * commentaire de fin de ligne y met fin pour de vrai et laisserait fuir la
	 * suite du texte dans la page — vérifié.)
	 */
	?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" aria-label="<?php echo esc_attr( kpibi__( 'KPIBI, accueil' ) ); ?>">
		<svg class="logo-svg" width="<?php echo esc_attr( $w ); ?>" height="<?php echo esc_attr( $h ); ?>" viewBox="0 0 321.30573 102.56665" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="KPIBI">
			<g transform="translate(-16.848028,-52.407916)">
				<g transform="translate(8.2038142,6.4207679)">
					<g transform="translate(-2.2153)">
						<path fill="#d4af6a" d="M 101.8415,57.105828 57.570862,96.011941 41.826261,117.17425 63.042658,101.57305 Z"/>
						<path fill="#d4af6a" d="m 61.972775,52.407916 c -24.891431,0 -45.124747,20.11072 -45.124747,44.853818 0,24.743106 20.233316,44.855876 45.124747,44.855876 24.89142,0 45.122685,-20.11277 45.122685,-44.855876 0,-11.203731 -4.14813,-21.457956 -10.998582,-29.325177 l -3.553879,3.530167 c 5.934947,6.946543 9.512181,15.949016 9.512181,25.79501 0,22.034996 -17.915328,39.845146 -40.082405,39.845146 -22.167088,0 -40.082434,-17.81015 -40.082434,-39.845146 0,-22.034989 17.915346,-39.84359 40.082434,-39.84359 9.471837,0 18.167494,3.251463 25.020793,8.694793 l 3.563672,-3.53988 C 82.770639,56.222456 72.813595,52.407916 61.972775,52.407916 Z"/>
						<g transform="matrix(0.26458333,0,0,0.26458333,-22.144788,-11.2245)">
							<path fill="#ffffff" d="m 549.88204,477.86331 4.90592,-50.04041 104.98675,-133.44111 h 41.04623 z m -21.259,54.29222 V 294.38179 h 33.36027 v 237.77374 z m 141.29058,0 -75.55121,-126.89988 26.32845,-24.36608 90.10545,151.26596 z m 94.03019,-92.23135 v -31.72497 h 76.0418 q 16.35308,0 26.16493,-11.28363 9.97537,-11.28362 9.97537,-29.59906 v 0 q 0,-18.64251 -9.97537,-29.92614 -9.81185,-11.28362 -26.16493,-11.28362 h -76.0418 v -31.72497 h 74.89709 q 21.58606,0 37.61208,9.15773 16.02601,8.99419 24.85667,25.34727 8.99419,16.35307 8.99419,38.42973 v 0 q 0,21.91312 -8.99419,38.26619 -8.83066,16.35308 -24.85667,25.34727 -16.02602,8.9942 -37.61208,8.9942 z m -17.17073,92.23135 V 294.38179 h 33.36027 V 532.15553 Z M 985.36448,294.38179 V 532.15553 H 952.0042 V 294.38179 Z"/>
							<path fill="#d4af6a" d="m 1063.8592,532.15553 v -30.90732 h 64.4311 q 26.492,0 37.4486,-10.1389 11.1201,-10.13891 11.1201,-26.65552 v -0.49059 q 0,-17.66132 -9.4848,-28.12729 -9.3213,-10.6295 -30.9073,-10.6295 h -72.6077 v -30.08966 h 72.6077 q 18.479,0 27.8002,-8.66713 9.4848,-8.83067 9.4848,-25.67434 v 0 q 0,-17.82485 -10.466,-26.65551 -10.4659,-8.83066 -31.3979,-8.83066 h -68.0288 v -30.90732 h 74.0795 q 35.1591,0 52.3298,17.4978 17.1707,17.49779 17.1707,46.93333 v 0 q 0,17.82485 -10.4659,32.70615 -10.466,14.71777 -32.8697,18.80604 22.0766,3.27061 34.1779,19.46016 12.2648,16.18954 12.2648,37.12148 v 0.49059 q 0,29.10848 -18.806,46.93333 -18.8061,17.82486 -51.0216,17.82486 z m -19.6237,0 V 294.38179 h 33.1968 v 237.77374 z m 249.548,-237.77374 v 237.77374 h -33.3603 V 294.38179 Z"/>
						</g>
					</g>
				</g>
			</g>
		</svg>
	</a>
	<?php
}


/**
 * Normalise une valeur de champ « liste de paragraphes / puces » en tableau.
 * Accepte soit un tableau PHP natif (repli), soit une chaîne multiligne
 * provenant d'un champ ACF textarea (une ligne = un paragraphe ou une puce).
 *
 * Utilisée par template-cas-clients.php (liste des cas) et par
 * single-cas_client.php (affichage d'un cas individuel) — définie ici,
 * globalement, plutôt que dans un seul des deux gabarits, pour être
 * disponible dans les deux sans dépendre de l'ordre de chargement.
 *
 * @param mixed $value Valeur brute (tableau ou chaîne).
 * @return array
 */
function kpibi_cas_lines( $value ) {
	if ( empty( $value ) ) {
		return array();
	}
	if ( is_array( $value ) ) {
		return kpibi_typo_deep( $value );
	}
	$lines = preg_split( '/\r\n|\r|\n/', (string) $value );
	return kpibi_typo_deep( array_values( array_filter( array_map( 'trim', $lines ), 'strlen' ) ) );
}

/**
 * Helper : affiche un fragment de titre avec une partie en évidence (or).
 * Échappe le texte ; le balisage <strong> est ajouté autour de la partie « forte ».
 */
function kpibi_title( $before, $strong = '', $after = '', $break_before_strong = false, $break_after_strong = false ) {
	$html = esc_html( $before );
	if ( '' !== $strong ) {
		$html .= ( $break_before_strong ? '<br>' : ' ' ) . '<strong>' . esc_html( $strong ) . '</strong>';
	}
	if ( '' !== $after ) {
		$html .= ( $break_after_strong ? '<br>' : ' ' ) . esc_html( $after );
	}
	return $html;
}

/**
 * BIBLIOTHÈQUE D'ICÔNES
 * -------------------------------------------------------------------------
 * Jeu d'icônes SVG (trait, viewBox 0 0 24 24) réutilisables. Chaque entrée
 * est le contenu INTÉRIEUR d'un <svg> (paths). Les gabarits conservent leur
 * balise <svg> (classes/styles) et insèrent le contenu via kpibi_icon().
 * Permet de choisir l'icône de chaque carte depuis le CMS (champ select ACF)
 * sans coller de code, tout en gardant un style cohérent.
 *
 * @return array clé => balisage SVG interne.
 */
function kpibi_icons() {
	return array(
		'optimisation'   => '<path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
		'tableau_bord'   => '<path d="M3 3v18h18"/><path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"/>',
		'automatisation' => '<path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>',
		'application'    => '<rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>',
		'mobile'         => '<rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/>',
		'cube'           => '<path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/><path d="M3.27 6.96L12 12l8.73-5.04M12 22.08V12"/>',
		'document'       => '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6M9 13h6M9 17h6"/>',
		'calendrier'     => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
		'sync'           => '<path d="M21 2v6h-6M3 12a9 9 0 0115-6.7L21 8M3 22v-6h6M21 12a9 9 0 01-15 6.7L3 16"/>',
		'robot'          => '<rect x="4" y="4" width="16" height="16" rx="2"/><path d="M9 9h6v6H9z"/><path d="M9 2v2M15 2v2M9 20v2M15 20v2M2 9h2M2 15h2M20 9h2M20 15h2"/>',
		'check'          => '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>',
		'bouclier'       => '<path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
		'portail'        => '<path d="M4 7V4h16v3M9 20h6M12 4v16"/><path d="M6 12h.01M18 12h.01"/>',
		'barres'         => '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/><line x1="3" y1="20" x2="21" y2="20"/>',
		'cible'          => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
		'ampoule'        => '<path d="M9 18h6M10 22h4"/><path d="M12 2a7 7 0 00-4 12.7c.6.5 1 1.3 1 2.1h6c0-.8.4-1.6 1-2.1A7 7 0 0012 2z"/>',
		'engrenage'      => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 11-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 110-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 114 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 110 4h-.09a1.65 1.65 0 00-1.51 1z"/>',
		'equipe'         => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>',
		'horloge'        => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
		'eclair'         => '<path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>',
		'base_donnees'   => '<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>',
		'loupe'          => '<circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>',
	);
}

/**
 * Retourne le balisage interne SVG d'une icône de la bibliothèque.
 * Repli sur $fallback (clé) si la clé demandée est vide/inconnue.
 *
 * @param string $key      Clé d'icône choisie (champ CMS).
 * @param string $fallback Clé de repli si $key absent/inconnu.
 * @return string
 */
function kpibi_icon( $key, $fallback = 'cible' ) {
	$icons = kpibi_icons();
	if ( $key && isset( $icons[ $key ] ) ) {
		return $icons[ $key ];
	}
	return isset( $icons[ $fallback ] ) ? $icons[ $fallback ] : reset( $icons );
}

/**
 * Liste des choix d'icônes pour un champ select ACF (clé => libellé lisible).
 *
 * @return array
 */
function kpibi_icon_choices() {
	return array(
		'optimisation'   => 'Optimisation (maison/flux)',
		'tableau_bord'   => 'Tableau de bord (graphique)',
		'automatisation' => 'Automatisation (couches)',
		'application'    => 'Application (écran)',
		'mobile'         => 'Application mobile',
		'cube'           => 'Données / cube',
		'document'       => 'Document / rapport',
		'calendrier'     => 'Calendrier / planification',
		'sync'           => 'Synchronisation',
		'robot'          => 'Robot / RPA',
		'check'          => 'Validation (coche)',
		'bouclier'       => 'Fiabilité (bouclier)',
		'portail'        => 'Portail / intégration',
		'barres'         => 'Performance (barres)',
		'cible'          => 'Objectif (cible)',
		'ampoule'        => 'Idée (ampoule)',
		'engrenage'      => 'Réglage (engrenage)',
		'equipe'         => 'Équipe / personnes',
		'horloge'        => 'Temps / rapidité',
		'eclair'         => 'Vitesse (éclair)',
		'base_donnees'   => 'Base de données',
		'loupe'          => 'Analyse (loupe)',
	);
}

/**
 * Retourne le permalien d'une page à partir de son slug FR, traduit dans la
 * langue courante si Polylang est actif. Sert à remplacer les vieux liens
 * « .html » hérités de la maquette statique par de vraies URL WordPress.
 *
 * @param string $slug_fr Slug de la page FR (ex. « cas-clients », « forfait »).
 * @return string URL absolue (repli : accueil).
 */
function kpibi_page_url( $slug_fr ) {
	$page = get_page_by_path( $slug_fr );
	if ( ! $page ) {
		return home_url( '/' );
	}
	$id = $page->ID;
	if ( function_exists( 'pll_get_post' ) && function_exists( 'pll_current_language' ) ) {
		$lang = pll_current_language();
		if ( $lang ) {
			$tr = pll_get_post( $id, $lang );
			if ( $tr ) {
				$id = $tr;
			}
		}
	}
	return get_permalink( $id );
}

/**
 * Résout un lien de bouton : garde la valeur saisie si c'est une vraie URL,
 * sinon (vide ou ancien lien « .html » de maquette) renvoie le permalien
 * WordPress de la page correspondante dans la bonne langue.
 *
 * @param string $val     Valeur du champ (peut être vide ou « xxx.html »).
 * @param string $slug_fr Slug FR de la page cible.
 * @return string
 */
function kpibi_link( $val, $slug_fr ) {
	$val = trim( (string) $val );

	// « ?page_id=N » : URL non réécrite, saisie avant que les permaliens soient
	// propres (relevée en QA sur 3 boutons). On la convertit en permalien de la
	// page N — SURTOUT PAS en repli sur $slug_fr : la destination saisie n'est
	// pas toujours celle du repli. Exemple réel : sur Tableaux de bord, le
	// bouton « Voir nos cas clients » porte ?page_id=32 (cas clients) alors que
	// son repli est « forfait » ; rabattre sur le repli enverrait le visiteur
	// à l'opposé de ce que le libellé annonce.
	//
	// La traduction est prise en compte : sur une page anglaise, on suit la
	// version traduite de la cible si elle existe, plutôt que de renvoyer vers
	// la page française.
	if ( preg_match( '/[?&]page_id=(\d+)/', $val, $m ) ) {
		$cible = (int) $m[1];
		if ( function_exists( 'pll_get_post' ) ) {
			$traduite = pll_get_post( $cible );
			if ( $traduite ) {
				$cible = (int) $traduite;
			}
		}
		$permalien = get_permalink( $cible );
		if ( $permalien ) {
			return $permalien;
		}
	}

	// « xxx.html » : liens de la maquette statique d'origine.
	if ( '' !== $val && '.html' !== substr( $val, -5 ) ) {
		return $val;
	}
	return kpibi_page_url( $slug_fr );
}

/**
 * Devine l'icône la plus pertinente pour une carte « bénéfice » à partir de
 * son titre (repli utilisé seulement si aucune icône n'est choisie au CMS).
 * Premier mot-clé trouvé = icône retournée ; l'ordre gère les priorités.
 *
 * @param string $titre Titre de la carte bénéfice.
 * @return string Clé d'icône de la bibliothèque.
 */
function kpibi_guess_benefit_icon( $titre ) {
	$s = function_exists( 'mb_strtolower' ) ? mb_strtolower( $titre ) : strtolower( $titre );
	// Mots-clés FR + EN. Premier trouvé = icône retournée ; l'ordre gère les priorités.
	$map = array(
		'temps réel'   => 'tableau_bord',
		'real-time'    => 'tableau_bord',
		'roi'          => 'barres',
		'rendement'    => 'barres',
		'action'       => 'cible',
		'seconde'      => 'eclair',
		'second'       => 'eclair',
		'minute'       => 'eclair',
		'speed'        => 'eclair',
		'busywork'     => 'eclair',
		'24/7'         => 'robot',
		'automat'      => 'robot',
		'délai'        => 'horloge',
		'temps'        => 'horloge',
		'time'         => 'horloge',
		'économis'     => 'horloge',
		'admin'        => 'check',
		'fit'          => 'check',
		'équipe'       => 'equipe',
		'team'         => 'equipe',
		'higher-value' => 'equipe',
		'aligné'       => 'check',
		'align'        => 'check',
		'erreur'       => 'bouclier',
		'error'        => 'bouclier',
		'risque'       => 'bouclier',
		'risk'         => 'bouclier',
		'fiab'         => 'bouclier',
		'reliab'       => 'bouclier',
		'quality'      => 'bouclier',
		'volume'       => 'optimisation',
		'capacité'     => 'engrenage',
		'capacity'     => 'engrenage',
		'productiv'    => 'engrenage',
		'visib'        => 'tableau_bord',
		'kpi'          => 'tableau_bord',
		'dashboard'    => 'tableau_bord',
		'décision'     => 'tableau_bord',
		'decision'     => 'tableau_bord',
		'débat'        => 'cible',
		'debate'       => 'cible',
		'concurren'    => 'cible',
		'competit'     => 'cible',
		'avantage'     => 'cible',
		'advantage'    => 'cible',
		'report'       => 'document',
		'connaissance' => 'base_donnees',
		'knowledge'    => 'base_donnees',
		'donnée'       => 'base_donnees',
		'data'         => 'base_donnees',
		'expérience'   => 'ampoule',
		'experience'   => 'ampoule',
		'intuiti'      => 'ampoule',
		'enjoy'        => 'ampoule',
		'utilisateur'  => 'ampoule',
		'tâche'        => 'eclair',
		'task'         => 'eclair',
		'processus'    => 'optimisation',
		'process'      => 'optimisation',
		'système'      => 'optimisation',
		'system'       => 'optimisation',
		'évolu'        => 'optimisation',
		'evolve'       => 'optimisation',
		'scal'         => 'optimisation',
		'croissance'   => 'optimisation',
		'grow'         => 'optimisation',
		'concret'      => 'document',
		'cas'          => 'document',
	);
	foreach ( $map as $kw => $icon ) {
		if ( false !== mb_strpos( $s, $kw ) ) {
			return $icon;
		}
	}
	return 'barres';
}

/**
 * SITE BILINGUE (Polylang)
 * -------------------------------------------------------------------------
 * Le contenu des pages (titres, ACF) est déjà multilingue nativement dès
 * qu'on crée une version anglaise de chaque page dans Polylang — chaque
 * traduction est un post distinct avec ses propres champs ACF.
 * Les chaînes CODÉES EN DUR dans le thème (boutons du menu, titres de
 * colonnes du pied de page, etc.) ne le sont pas automatiquement : on les
 * enregistre ci-dessous comme « chaînes de thème » Polylang, traduisibles
 * dans Langues › Traductions des chaînes (aucune traduction saisie = le
 * texte français d'origine s'affiche partout, donc rien ne casse si
 * Polylang n'est pas encore actif).
 */
function kpibi_register_strings() {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}
	$kpibi_strings = array(
		'nav_cta'           => 'Consultation gratuite',
		'footer_col1_titre' => 'Nos solutions',
		'footer_col2_titre' => 'KPIBI',
		'footer_legal_confidentialite' => 'Politique de confidentialité',
		'footer_legal_conditions'      => "Conditions d'utilisation",
		'nav_lang_switch_label'        => 'Choix de la langue',
		'blog_titre'        => 'Blogue',
		'blog_vide'         => 'Aucun article pour le moment.',
		'blog_lire'         => 'Lire',
		'blog_retour'       => 'Retour au blogue',
		'cas_resultats'     => 'Résultats',
		'cas_retour'        => 'Retour aux cas clients',
		'pilier_en_savoir'  => 'En savoir plus',
		'note_5_etoiles'    => '5 étoiles sur 5',
		/*
		 * Titres du bloc « cas client » (KPIBI-10). « Résultats » était déjà
		 * enregistré ci-dessus et rendait donc « Results » en anglais, alors que
		 * les deux titres qui le précèdent restaient en français : l'incohérence
		 * se voyait à l'écran sur /en/case-studies/.
		 * Traductions à saisir : Context / The KPIBI solution.
		 */
		'cas_contexte'      => 'Contexte',
		'cas_solution'      => 'La solution KPIBI',
		/*
		 * Libellés d'accessibilité (KPIBI-10). Invisibles à l'écran mais LUS par
		 * les lecteurs d'écran : un visiteur anglophone à la synthèse vocale les
		 * entendait en français. Traductions à saisir en regard de chaque entrée.
		 */
		'aria_nav_principale'   => 'Navigation principale',        // Main navigation
		'aria_linkedin'         => 'KPIBI sur LinkedIn',           // KPIBI on LinkedIn
		'aria_ouvrir_menu'      => 'Ouvrir le menu',               // Open the menu
		'aria_menu_navigation'  => 'Menu de navigation',           // Navigation menu
		'aria_fermer_menu'      => 'Fermer le menu',               // Close the menu
		'aria_pied_de_page'     => 'Pied de page',                 // Footer
		'aria_liens_legaux'     => 'Liens légaux',                 // Legal links
		'aria_logo_accueil'     => 'KPIBI, accueil',               // KPIBI, home
	);
	foreach ( $kpibi_strings as $kpibi_string_name => $kpibi_string_value ) {
		pll_register_string( $kpibi_string_name, $kpibi_string_value, 'KPIBI — Thème', false );
	}
}
add_action( 'init', 'kpibi_register_strings' );

/**
 * Helper : traduit une chaîne de thème enregistrée ci-dessus si Polylang
 * est actif, sinon retourne le texte français d'origine tel quel.
 *
 * @param string $string Texte source (français), tel qu'enregistré dans kpibi_register_strings().
 * @return string
 */
function kpibi__( $string ) {
	return function_exists( 'pll__' ) ? pll__( $string ) : $string;
}

/**
 * Affiche le sélecteur de langue FR / EN (si Polylang est actif et qu'au
 * moins une autre langue existe). N'affiche rien sinon.
 *
 * @param string $class Classe CSS du conteneur.
 */
function kpibi_language_switcher( $class = 'lang-switcher' ) {
	if ( ! function_exists( 'pll_the_languages' ) ) {
		return;
	}
	$kpibi_langs = pll_the_languages( array( 'raw' => 1, 'hide_if_empty' => 1 ) );
	if ( empty( $kpibi_langs ) || count( $kpibi_langs ) < 2 ) {
		return;
	}
	echo '<div class="' . esc_attr( $class ) . '" role="group" aria-label="' . esc_attr( kpibi__( 'Choix de la langue' ) ) . '">';
	foreach ( $kpibi_langs as $kpibi_lang ) {
		$kpibi_active = ! empty( $kpibi_lang['current_lang'] );
		echo '<a href="' . esc_url( $kpibi_lang['url'] ) . '" class="lang-link' . ( $kpibi_active ? ' active' : '' ) . '"' . ( $kpibi_active ? ' aria-current="true"' : '' ) . '>' . esc_html( strtoupper( $kpibi_lang['slug'] ) ) . '</a>';
	}
	echo '</div>';
}

/**
 * HELPERS DE CHAMPS ACF (partagés par tous les fichiers inc/acf-fields-*.php)
 * -------------------------------------------------------------------------
 * Extraits ici (plutôt que redéfinis en closures dans chaque fichier de
 * champs) pour que toutes les pages du site aient exactement le même
 * comportement de repli, de longueur maximale et d'instructions.
 */

/**
 * Champ texte court, avec limite de caractères optionnelle.
 */
function kpibi_field_text( $name, $label, $default = '', $max = 0, $instr = '' ) {
	$f = array(
		'key'           => 'field_kpibi_' . $name,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'text',
		'default_value' => $default,
		'instructions'  => $instr,
	);
	if ( $max > 0 ) {
		$f['maxlength']   = $max;
		$f['instructions'] = trim( $instr . ' (max ' . $max . ' caractères)' );
	}
	return $f;
}

/**
 * Champ texte long (paragraphe), avec limite de caractères optionnelle.
 */
function kpibi_field_area( $name, $label, $default = '', $max = 0 ) {
	$f = array(
		'key'           => 'field_kpibi_' . $name,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'textarea',
		'default_value' => $default,
		// Valeur brute (avec \n) : les gabarits gèrent l'affichage. Éviter
		// 'br' ici : ACF insérerait des <br /> que esc_html() afficherait
		// littéralement. Les retours voulus sont rendus via nl2br() au gabarit.
		'new_lines'     => '',
		'rows'          => 3,
		'instructions'  => '',
	);
	if ( $max > 0 ) {
		$f['maxlength']   = $max;
		$f['instructions'] = 'Max ' . $max . ' caractères — un texte plus long sera coupé visuellement sur le site.';
	}
	return $f;
}

/**
 * Champ image (retourne une URL directement, plus simple à consommer que le tableau complet).
 */
function kpibi_field_image( $name, $label, $instr = '' ) {
	return array(
		'key'           => 'field_kpibi_' . $name,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'image',
		'return_format' => 'url',
		'preview_size'  => 'medium',
		'library'       => 'all',
		'instructions'  => trim( $instr . ' (laisser vide = emplacement neutre)' ),
	);
}

/**
 * Onglet (regroupe les champs dans l'éditeur ACF par section visuelle).
 */
function kpibi_field_tab( $name, $label ) {
	return array(
		'key'   => 'field_kpibi_tab_' . $name,
		'label' => $label,
		'type'  => 'tab',
	);
}

/**
 * Champ SELECT « choix d'icône » (menu déroulant depuis la bibliothèque).
 * Rend l'icône d'une carte modifiable depuis le CMS sans coller de code.
 */
function kpibi_field_icon( $name, $label, $default = 'cible' ) {
	return array(
		'key'           => 'field_kpibi_' . $name,
		'label'         => $label,
		'name'          => $name,
		'type'          => 'select',
		'choices'       => kpibi_icon_choices(),
		'default_value' => $default,
		'ui'            => 1,
		'allow_null'    => 0,
		'return_format' => 'value',
		'instructions'  => 'Choisissez une icône dans la liste.',
	);
}

// Inclusions.
require get_template_directory() . '/inc/nav-walkers.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/acf-fields.php';
require get_template_directory() . '/inc/acf-fields-services.php';
require get_template_directory() . '/inc/acf-fields-services-extra.php';
require get_template_directory() . '/inc/acf-fields-forfait.php';
require get_template_directory() . '/inc/acf-fields-a-propos.php';
require get_template_directory() . '/inc/acf-fields-cas-clients.php';
require get_template_directory() . '/inc/acf-fields-blogue.php';
require get_template_directory() . '/inc/cpt-cas-clients.php';
require get_template_directory() . '/inc/acf-fields-cas-client-cpt.php';







