<?php require_once __DIR__ . '/includes/head.php'; ?>
<link rel="stylesheet" href="assets/css/document.css" />
<main class="page">

  <!-- ——— HERO ACCÈS SÉCURISÉ ——— -->
  <section class="doc-hero" id="acces">
    <div class="doc-hero-left">
      <span class="etiquette">Espace Sécurisé</span>
      <h1 class="titre-hero">Accès à votre<br><span class="accent">patrimoine.</span></h1>
      <p class="sous-titre">Consultez vos documents confidentiels, rapports de visite et actes notariés dans un environnement hautement sécurisé.</p>
      <div class="agents">
        <div class="avatars">
          <img src="https://soena.students-talents.fr/assets/img/profil.jpg" alt="Agent">
          <img src="https://media.licdn.com/dms/image/v2/D5603AQG3blCz-IjWeQ/profile-displayphoto-scale_200_200/B56Zud181qKYAY-/0/1767879726073?e=1777507200&v=beta&t=FKCF0lbauiWueZTqfPdCFMzKwcS7Vgt0aihJpGhcQ_k" alt="Agent">
          <img src="https://i.pravatar.cc/40?img=32" alt="Agent">
          <img src="https://i.pravatar.cc/40?img=32" alt="Agent">
          <img src="https://i.pravatar.cc/40?img=32" alt="Agent">
        </div>
        <span class="agents-label">Agents certifiés L'Atelier</span>
      </div>
    </div>

    <div class="doc-hero-right">
      <div class="badge-certif">Authentification<br>certifiée</div>
      <div class="acces-card" id="acces-card">
        <p class="acces-label">Code d'accès</p>
        <input type="password" class="acces-input" id="code-input" placeholder="••••••••" maxlength="8" autocomplete="off" />
        <button class="btn-deverrouiller" id="btn-deverrouiller">
          Déverrouiller le document
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 9.9-1"/></svg>
        </button>
        <p class="acces-erreur" id="acces-erreur"></p>
        <a href="#" class="acces-aide">Besoin d'assistance ?</a>
      </div>
      <div class="acces-deco"></div>
    </div>
  </section>

  <!-- ——— SECTION DOCUMENTS (déverrouillée) ——— -->
  <section class="doc-section centre" id="doc-section" style="display:none">
    <div class="doc-section-header">
      <div>
        <p class="etiquette">Espace privé</p>
        <h2 class="titre-section">Vos documents</h2>
      </div>
      <div class="doc-actions">
        <div class="doc-search-wrap">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          <input type="text" placeholder="Rechercher un document…" class="doc-search" id="doc-search" />
        </div>
        <button class="btn-sombre btn-sm" id="btn-verrouiller">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          Verrouiller
        </button>
      </div>
    </div>

    <div class="doc-filtres" id="doc-filtres">
      <button class="filtre actif" data-filtre="tous">Tous</button>
      <button class="filtre" data-filtre="contrat">Contrats</button>
      <button class="filtre" data-filtre="rapport">Rapports</button>
      <button class="filtre" data-filtre="acte">Actes notariés</button>
      <button class="filtre" data-filtre="fiscal">Fiscal</button>
    </div>

    <div class="doc-grille" id="doc-grille">

      <div class="doc-card" data-cat="contrat">
        <div class="doc-card-icon contrat">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </div>
        <div class="doc-card-info">
          <span class="doc-card-type">Contrat</span>
          <h4 class="doc-card-titre">Mandat de vente exclusif</h4>
          <span class="doc-card-meta">Le Pavillon de Verre — 12 mars 2025</span>
        </div>
        <div class="doc-card-actions">
          <button class="doc-btn" title="Télécharger"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></button>
          <button class="doc-btn" title="Aperçu"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
        </div>
      </div>

      <div class="doc-card" data-cat="rapport">
        <div class="doc-card-icon rapport">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </div>
        <div class="doc-card-info">
          <span class="doc-card-type">Rapport de visite</span>
          <h4 class="doc-card-titre">Rapport de visite — Appartement Médicis</h4>
          <span class="doc-card-meta">Paris VIIIe — 28 février 2025</span>
        </div>
        <div class="doc-card-actions">
          <button class="doc-btn" title="Télécharger"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></button>
          <button class="doc-btn" title="Aperçu"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
        </div>
      </div>

      <div class="doc-card" data-cat="acte">
        <div class="doc-card-icon acte">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M12 18v-6"/><path d="m9 15 3 3 3-3"/></svg>
        </div>
        <div class="doc-card-info">
          <span class="doc-card-type">Acte notarié</span>
          <h4 class="doc-card-titre">Acte authentique de vente</h4>
          <span class="doc-card-meta">Chalet Boréal, Megève — 5 janvier 2025</span>
        </div>
        <div class="doc-card-actions">
          <button class="doc-btn" title="Télécharger"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></button>
          <button class="doc-btn" title="Aperçu"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
        </div>
      </div>

      <div class="doc-card" data-cat="fiscal">
        <div class="doc-card-icon fiscal">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
        </div>
        <div class="doc-card-info">
          <span class="doc-card-type">Fiscal</span>
          <h4 class="doc-card-titre">Simulation fiscale IFI 2025</h4>
          <span class="doc-card-meta">Patrimoine global — 20 janvier 2025</span>
        </div>
        <div class="doc-card-actions">
          <button class="doc-btn" title="Télécharger"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></button>
          <button class="doc-btn" title="Aperçu"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
        </div>
      </div>

      <div class="doc-card" data-cat="rapport">
        <div class="doc-card-icon rapport">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </div>
        <div class="doc-card-info">
          <span class="doc-card-type">Rapport</span>
          <h4 class="doc-card-titre">Rapport d'expertise — Villa Sereine</h4>
          <span class="doc-card-meta">Saint-Jean-Cap-Ferrat — 15 mars 2025</span>
        </div>
        <div class="doc-card-actions">
          <button class="doc-btn" title="Télécharger"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></button>
          <button class="doc-btn" title="Aperçu"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
        </div>
      </div>

      <div class="doc-card" data-cat="contrat">
        <div class="doc-card-icon contrat">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </div>
        <div class="doc-card-info">
          <span class="doc-card-type">Contrat</span>
          <h4 class="doc-card-titre">Contrat de gestion locative</h4>
          <span class="doc-card-meta">Appartement Médicis — 3 avril 2025</span>
        </div>
        <div class="doc-card-actions">
          <button class="doc-btn" title="Télécharger"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></button>
          <button class="doc-btn" title="Aperçu"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
        </div>
      </div>

    </div>
    <p class="doc-vide" id="doc-vide" style="display:none">Aucun document ne correspond à votre recherche.</p>
  </section>

</main>

<?php require_once './includes/footer.php'; ?>
<script src="assets/js/script.js"></script>
<script>
const CODE = '1234';
const btnDev  = document.getElementById('btn-deverrouiller');
const input   = document.getElementById('code-input');
const erreur  = document.getElementById('acces-erreur');
const section = document.getElementById('doc-section');
const hero    = document.getElementById('acces');

function deverrouiller() {
  if (input.value === CODE) {
    hero.style.display = 'none';
    section.style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
  } else {
    erreur.textContent = 'Code incorrect. Veuillez réessayer.';
    input.classList.add('erreur');
    setTimeout(() => { input.classList.remove('erreur'); erreur.textContent = ''; }, 2000);
  }
}
btnDev.addEventListener('click', deverrouiller);
input.addEventListener('keydown', e => { if (e.key === 'Enter') deverrouiller(); });

document.getElementById('btn-verrouiller').addEventListener('click', () => {
  section.style.display = 'none';
  hero.style.display = '';
  input.value = '';
  window.scrollTo({ top: 0, behavior: 'smooth' });
});

document.querySelectorAll('.filtre').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.filtre').forEach(b => b.classList.remove('actif'));
    btn.classList.add('actif');
    filtrer();
  });
});
document.getElementById('doc-search').addEventListener('input', filtrer);

function filtrer() {
  const cat   = document.querySelector('.filtre.actif').dataset.filtre;
  const q     = document.getElementById('doc-search').value.toLowerCase();
  const cards = document.querySelectorAll('.doc-card');
  let visible = 0;
  cards.forEach(card => {
    const show = (cat === 'tous' || card.dataset.cat === cat) && card.innerText.toLowerCase().includes(q);
    card.style.display = show ? '' : 'none';
    if (show) visible++;
  });
  document.getElementById('doc-vide').style.display = visible === 0 ? 'block' : 'none';
}
</script>
</body>
</html>
