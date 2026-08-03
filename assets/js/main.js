const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add("visible"); observer.unobserve(e.target); } });
}, { threshold: 0.1, rootMargin: "0px 0px -40px 0px" });
document.querySelectorAll(".reveal").forEach(el => observer.observe(el));
const hBtn = document.getElementById("hamburger-btn");
const mMenu = document.getElementById("mobile-menu");
const cBtn = document.getElementById("mobile-menu-close");
function openMenu() { mMenu.classList.add("open"); hBtn.setAttribute("aria-expanded","true"); cBtn.focus(); document.body.style.overflow="hidden"; }
function closeMenu() { mMenu.classList.remove("open"); hBtn.setAttribute("aria-expanded","false"); hBtn.focus(); document.body.style.overflow=""; }
hBtn.addEventListener("click", openMenu);
cBtn.addEventListener("click", closeMenu);
document.addEventListener("keydown", e => { if (e.key==="Escape" && mMenu.classList.contains("open")) closeMenu(); });
document.querySelectorAll(".nav-dropdown").forEach(dd => {
  const t = dd.querySelector(".nav-dropdown-trigger");
  t.addEventListener("click", e => {
    e.stopPropagation();
    const open = dd.classList.contains("open");
    document.querySelectorAll(".nav-dropdown.open").forEach(d => { d.classList.remove("open"); d.querySelector(".nav-dropdown-trigger").setAttribute("aria-expanded","false"); });
    if (!open) { dd.classList.add("open"); t.setAttribute("aria-expanded","true"); }
  });
  document.addEventListener("click", () => { dd.classList.remove("open"); t.setAttribute("aria-expanded","false"); });
  dd.addEventListener("keydown", e => { if (e.key==="Escape") { dd.classList.remove("open"); t.setAttribute("aria-expanded","false"); t.focus(); } });
});

/* ===== MODALE DU FORMULAIRE DE CONSULTATION =====
   Les boutons CTA ouvrent le formulaire dans une fenêtre modale au lieu de
   faire défiler vers #cta ou d'ouvrir le client courriel. Ne s'active que si
   la modale existe (Contact Form 7 actif). */
const kpibiModal = document.getElementById("kpibi-form-modal");
if (kpibiModal) {
  const kpibiDialog = kpibiModal.querySelector(".kpibi-modal-dialog");
  let kpibiLastFocus = null;
  let kpibiScrollY = 0;

  /* Verrou de défilement de l'arrière-plan.
     `body { overflow: hidden }` seul ne retient PAS le défilement tactile sur
     Safari iOS. On fixe donc le corps de page en le décalant de sa position de
     défilement courante, ce qui l'immobilise réellement, puis on restaure la
     position exacte à la fermeture (sinon la page saute en haut). */
  const kpibiLockScroll = () => {
    kpibiScrollY = window.scrollY || window.pageYOffset || 0;
    document.body.style.position = "fixed";
    document.body.style.top = `-${kpibiScrollY}px`;
    document.body.style.left = "0";
    document.body.style.right = "0";
    document.body.style.width = "100%";
    document.body.style.overflow = "hidden";
  };
  const kpibiUnlockScroll = () => {
    document.body.style.position = "";
    document.body.style.top = "";
    document.body.style.left = "";
    document.body.style.right = "";
    document.body.style.width = "";
    document.body.style.overflow = "";
    window.scrollTo(0, kpibiScrollY);
  };

  /* Hauteur de la modale alignée sur le viewport RÉELLEMENT visible.
     Le clavier virtuel ne réduit ni `vh` ni `dvh` : il ne rétrécit que le
     « visual viewport ». Sans cette synchronisation, la modale garde toute sa
     hauteur, son bas reste caché sous le clavier, et comme un conteneur ne
     défile jamais au-delà de sa propre fin, le bouton d'envoi est hors
     d'atteinte — c'est le défaut principal du ticket. En suivant
     visualViewport, la modale rétrécit avec le clavier et le bouton redevient
     accessible au défilement. Sans l'API, la CSS retombe sur dvh puis vh. */
  const kpibiVV = window.visualViewport || null;
  const kpibiSyncHeight = () => {
    if (!kpibiVV) return;
    kpibiModal.style.setProperty("--kpibi-modal-h", `${Math.round(kpibiVV.height)}px`);
  };
  const kpibiClearHeight = () => kpibiModal.style.removeProperty("--kpibi-modal-h");

  /* Éléments focalisables du dialogue, dans l'ordre du document. Le dialogue
     lui-même porte tabindex="-1" et est donc exclu — il reçoit le focus par
     script, pas par tabulation. */
  const KPIBI_FOCUSABLE = 'a[href], button:not([disabled]), input:not([disabled]):not([type="hidden"]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';
  const kpibiFocusables = () => Array.from(kpibiDialog.querySelectorAll(KPIBI_FOCUSABLE))
    .filter(el => el.offsetWidth > 0 || el.offsetHeight > 0 || el.getClientRects().length > 0);

  /* `declencheur` est passé explicitement : un clic tactile ne donne pas
     forcément le focus au lien (c'est le cas sur iOS Safari), donc
     `document.activeElement` ne permet pas de retrouver de façon fiable l'élément
     à qui rendre le focus à la fermeture. */
  const openModal = (declencheur) => {
    kpibiLastFocus = declencheur || document.activeElement;
    kpibiModal.classList.add("is-open");
    kpibiModal.setAttribute("aria-hidden", "false");
    kpibiLockScroll();
    kpibiSyncHeight();
    if (kpibiVV) {
      kpibiVV.addEventListener("resize", kpibiSyncHeight);
      kpibiVV.addEventListener("scroll", kpibiSyncHeight);
    }
    /* On NE met PAS le focus sur un champ de saisie : sur iOS/Android cela ouvre
       le clavier virtuel, qui recouvre la moitié basse de l'écran et masquait le
       bouton d'envoi. Le focus va sur le dialogue : le lecteur d'écran annonce
       bien le rôle et le titre, sans clavier. */
    if (kpibiDialog) setTimeout(() => kpibiDialog.focus(), 50);
  };
  const closeModal = () => {
    kpibiModal.classList.remove("is-open");
    kpibiModal.setAttribute("aria-hidden", "true");
    kpibiUnlockScroll();
    if (kpibiVV) {
      kpibiVV.removeEventListener("resize", kpibiSyncHeight);
      kpibiVV.removeEventListener("scroll", kpibiSyncHeight);
    }
    kpibiClearHeight();
    if (kpibiLastFocus && typeof kpibiLastFocus.focus === "function") kpibiLastFocus.focus();
  };
  // Déclencheurs : bouton CTA de nav, boutons #cta, boutons courriel (.btn mailto).
  const kpibiCtaSelector = ".nav-cta, a.btn[href='#cta'], a.btn[href$='/#cta'], a.btn[href^='mailto:']";
  document.querySelectorAll(kpibiCtaSelector).forEach(btn => {
    btn.addEventListener("click", e => {
      e.preventDefault();
      /* Le menu mobile contient lui aussi un CTA « Consultation gratuite ». On le
         referme avant d'ouvrir la modale : deux conteneurs aria-modal ouverts en
         même temps sont invalides, et son propre verrou de défilement entrerait en
         conflit avec celui de la modale. */
      if (mMenu && mMenu.classList.contains("open")) closeMenu();
      openModal(btn);
    });
  });
  kpibiModal.querySelectorAll("[data-kpibi-close]").forEach(el => el.addEventListener("click", closeModal));

  document.addEventListener("keydown", e => {
    if (!kpibiModal.classList.contains("is-open")) return;
    if (e.key === "Escape") { closeModal(); return; }
    /* Piège à focus : le dialogue déclare aria-modal="true", la tabulation doit
       donc y rester confinée — sinon la déclaration est fausse et l'utilisateur
       au clavier se retrouve dans la page derrière, sans repère. */
    if (e.key !== "Tab") return;
    const list = kpibiFocusables();
    if (!list.length) { e.preventDefault(); if (kpibiDialog) kpibiDialog.focus(); return; }
    const first = list[0];
    const last = list[list.length - 1];
    const active = document.activeElement;
    if (e.shiftKey) {
      if (active === first || active === kpibiDialog || !kpibiDialog.contains(active)) {
        e.preventDefault();
        last.focus();
      }
    } else if (active === last) {
      e.preventDefault();
      first.focus();
    }
  });

  /* Le bandeau de réponse de Contact Form 7 est rendu en BAS du formulaire :
     sur petit écran il tombe hors du champ de vision et l'utilisateur ne sait pas
     si son envoi a fonctionné. On l'amène dans la vue après chaque issue possible.
     `block: "nearest"` défile le conteneur de la modale, pas la page. */
  const kpibiSoftScroll = !window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  ["wpcf7invalid", "wpcf7spam", "wpcf7mailfailed", "wpcf7mailsent"].forEach(evt => {
    document.addEventListener(evt, () => {
      const out = kpibiModal.querySelector(".wpcf7-response-output");
      if (!out) return;
      requestAnimationFrame(() => {
        out.scrollIntoView({ block: "nearest", behavior: kpibiSoftScroll ? "smooth" : "auto" });
      });
    });
  });

  // Fermer automatiquement après un envoi réussi — délai laissé pour lire le message.
  document.addEventListener("wpcf7mailsent", () => setTimeout(closeModal, 2500));
}

/* ===== EFFETS SIGNATURE =====
   Regroupe les micro-interactions ajoutées pour donner une touche premium au
   thème sans jamais nuire à la lisibilité : tout est désactivé d'un bloc si
   l'utilisateur a demandé moins de mouvement (prefers-reduced-motion). */
const kpibiReduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
const kpibiFinePointer = window.matchMedia("(hover: hover) and (pointer: fine)").matches;

/* Barre de progression de lecture. */
if (!kpibiReduceMotion) {
  const progressBar = document.createElement("div");
  progressBar.className = "scroll-progress";
  document.body.appendChild(progressBar);
  const updateProgress = () => {
    const doc = document.documentElement;
    const scrollable = doc.scrollHeight - doc.clientHeight;
    const ratio = scrollable > 0 ? Math.min(doc.scrollTop / scrollable, 1) : 0;
    progressBar.style.transform = `scaleX(${ratio})`;
  };
  document.addEventListener("scroll", updateProgress, { passive: true });
  updateProgress();
}

/* Compteurs animés sur les statistiques chiffrées (.stat-num). Ignore
   silencieusement les valeurs non numériques (ex. « Multisectoriel ») et
   restaure le texte exact d'origine à la fin pour ne jamais désynchroniser
   l'espacement/le « + » du contenu ACF réel. */
function kpibiAnimateStat(el) {
  const raw = el.textContent.trim();
  const match = raw.match(/[\d\s ]+/);
  if (!match) return;
  const target = parseInt(match[0].replace(/[\s ]/g, ""), 10);
  if (!target || isNaN(target)) return;
  const prefix = raw.slice(0, match.index);
  const suffix = raw.slice(match.index + match[0].length);
  const duration = 1300;
  const startTime = performance.now();
  const format = n => n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
  function step(now) {
    const p = Math.min((now - startTime) / duration, 1);
    const eased = 1 - Math.pow(1 - p, 3);
    el.textContent = prefix + format(Math.round(target * eased)) + suffix;
    if (p < 1) requestAnimationFrame(step);
    else el.textContent = raw;
  }
  requestAnimationFrame(step);
}
if (!kpibiReduceMotion) {
  const statObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { kpibiAnimateStat(e.target); statObserver.unobserve(e.target); } });
  }, { threshold: 0.4 });
  document.querySelectorAll(".stat-num").forEach(el => statObserver.observe(el));
}

/* Lueur ambiante qui suit le curseur dans les sections héro sombres. */
if (!kpibiReduceMotion && kpibiFinePointer) {
  document.querySelectorAll(".hero, .page-hero").forEach(hero => {
    const glow = document.createElement("div");
    glow.className = "hero-glow";
    hero.appendChild(glow);
    hero.addEventListener("mousemove", e => {
      const r = hero.getBoundingClientRect();
      glow.style.transform = `translate(${e.clientX - r.left}px, ${e.clientY - r.top}px)`;
      glow.classList.add("active");
    });
    hero.addEventListener("mouseleave", () => glow.classList.remove("active"));
  });
}

/* Masquer les sections sans équivalent maquette (ex-snippet WPCode #430).
   Appliqué aux pages FR ET à leurs équivalents EN pour une UI identique
   dans les deux langues. */
(function () {
  function hideAfterComment(label) {
    var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_COMMENT);
    var node;
    while ((node = walker.nextNode())) {
      if (node.textContent.trim() === label) {
        var el = node.nextElementSibling;
        if (el) el.style.display = "none";
      }
    }
  }
  function hide(sel) { var e = document.querySelector(sel); if (e) e.style.display = "none"; }
  var cls = document.body.className;
  // Applications : FR 52 / EN 490
  if (/\bpage-id-(52|490)\b/.test(cls)) { hideAfterComment("POUR QUI"); hide(".rapport-teaser"); hide(".approche-timeline"); }
  // Automatisation : FR 56 / EN 496
  if (/\bpage-id-(56|496)\b/.test(cls)) { hideAfterComment("APPROCHE"); hide("#demarche"); }
  // Tableaux de bord : FR 71 / EN 485
  if (/\bpage-id-(71|485)\b/.test(cls)) { hideAfterComment("POUR QUI"); hide(".rapport-teaser"); hide(".approche-timeline"); }
})();