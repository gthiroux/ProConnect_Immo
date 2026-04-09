<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/head.php';
$uuid       = trim($_GET['uuid'] ?? '');
$uuid_valid = (bool) preg_match(
    '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
    $uuid
);
$request    = null;
$uuid_error = '';
if (!$uuid) {
    $uuid_error = 'Aucun identifiant de demande fourni. Veuillez utiliser le lien reçu par e-mail.';
} elseif (!$uuid_valid) {
    $uuid_error = 'L\'identifiant fourni est invalide.';
} else {
    $stmt = $pdo->prepare("SELECT `id`, `code_mail`, `house_id`, `firstname`, `lastname` FROM `request` WHERE `uuid` = :uuid LIMIT 1");
    $stmt->execute([':uuid' => $uuid]);
    $request = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$request) {
        $uuid_error = 'Aucune demande ne correspond à cet identifiant.';
    }
}
$code_error = '';
$unlocked   = false;
$documents  = [];

if (!$uuid_error && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'verify_code') {
    $code_input = trim($_POST['code_mail'] ?? '');

    if (!$code_input) {
        $code_error = 'Veuillez saisir votre code d\'accès.';
    } elseif ($code_input !== $request['code_mail']) {
        $code_error = 'Code incorrect. Veuillez réessayer.';
    } else {
        $unlocked = true;

        $stmt = $pdo->prepare("
            SELECT `id`, `doc`, `home_id`
            FROM `document`
            WHERE `request_id` = :request_id
              AND `home_id`    = :home_id
        ");
        $stmt->execute([
            ':request_id' => $request['id'],
            ':home_id'    => $request['house_id'],
        ]);
        $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<link rel="stylesheet" href="assets/css/document.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
<main class="page">
  <?php if ($uuid_error): ?>
  <section class="doc-hero" id="acces">
    <div class="doc-hero-left">
      <span class="etiquette">Accès impossible</span>
      <h1 class="titre-hero">Lien <span class="accent">invalide.</span></h1>
      <p class="sous-titre"><?= htmlspecialchars($uuid_error) ?></p>
      <a href="index.php" class="btn-deverrouiller" style="display:inline-flex;align-items:center;gap:.5rem;text-decoration:none;margin-top:1rem;">
        <i class="fa-solid fa-arrow-left"></i> Retour à l'accueil
      </a>
    </div>
    <div class="doc-hero-right">
      <div class="acces-deco"></div>
    </div>
  </section>
  <?php elseif (!$unlocked): ?>
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
      <div class="acces-card" id="acces-card">
        <p class="acces-label">
          <i class="fa-solid fa-user-shield"></i>
          Bonjour <?= htmlspecialchars($request['firstname'] . ' ' . $request['lastname']) ?>, saisissez votre code d'accès
        </p>
        <?php if ($code_error): ?>
          <p class="acces-erreur" style="display:block;">
            <i class="fa-solid fa-circle-exclamation"></i>
            <?= htmlspecialchars($code_error) ?>
          </p>
        <?php endif; ?>
        <form method="POST" action="?uuid=<?= urlencode($uuid) ?>" id="form-code">
          <input type="hidden" name="action" value="verify_code">
          <input type="text" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" class="acces-input <?= $code_error ? 'erreur' : '' ?>" id="code-input" name="code_mail" placeholder="••••••" autocomplete="off" required />
          <button type="submit" class="btn-deverrouiller">
            Déverrouiller le document
            <i class="fa-solid fa-lock-open"></i>
          </button>
        </form>
        <a href="#" class="acces-aide">
          <i class="fa-regular fa-circle-question"></i> Besoin d'assistance ?
        </a>
      </div>
      <div class="acces-deco"></div>
    </div>
  </section>
  <?php else: ?>
  <section class="doc-section centre" id="doc-section">
    <div class="doc-section-header">
      <div>
        <p class="etiquette">Espace privé</p>
        <h2 class="titre-section">Vos documents</h2>
      </div>
      <div class="doc-actions">
        <div class="doc-search-wrap">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" placeholder="Rechercher un document…" class="doc-search" id="doc-search" />
        </div>
        <a href="?uuid=<?= urlencode($uuid) ?>" class="btn-sombre btn-sm">
          <i class="fa-solid fa-lock"></i> Verrouiller
        </a>
      </div>
    </div>
    <div class="doc-grille" id="doc-grille">
      <?php if (empty($documents)): ?>
        <p class="doc-vide" style="display:block;">
          <i class="fa-regular fa-folder-open"></i> Aucun document disponible pour cette demande.
        </p>
      <?php else: ?>
        <?php foreach ($documents as $doc):
            $filename  = basename($doc['doc']);
            $ext       = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $ext_label = strtoupper($ext);
            $fa_icon = match($ext) {
                'pdf'              => 'fa-file-pdf',
                'doc', 'docx'      => 'fa-file-word',
                'xls', 'xlsx'      => 'fa-file-excel',
                'jpg', 'jpeg',
                'png', 'webp'      => 'fa-file-image',
                'zip', 'rar', '7z' => 'fa-file-zipper',
                default            => 'fa-file-lines',
            };
            $cat   = 'contrat';
            $lower = strtolower($filename);
            if (str_contains($lower, 'rapport') || str_contains($lower, 'expertise')) $cat = 'rapport';
            elseif (str_contains($lower, 'acte') || str_contains($lower, 'notari'))   $cat = 'acte';
            elseif (str_contains($lower, 'fiscal') || str_contains($lower, 'ifi'))    $cat = 'fiscal';
        ?>
        <div class="doc-card" data-cat="<?= $cat ?>">
          <div class="doc-card-icon <?= $cat ?>">
            <i class="fa-regular <?= $fa_icon ?>"></i>
          </div>
          <div class="doc-card-info">
            <span class="doc-card-type"><?= $ext_label ?></span>
            <h4 class="doc-card-titre"><?= htmlspecialchars($filename) ?></h4>
            <span class="doc-card-meta">Document #<?= (int)$doc['id'] ?></span>
          </div>
          <div class="doc-card-actions">
            <a class="doc-btn" href="<?= htmlspecialchars($doc['doc']) ?>" download title="Télécharger">
              <i class="fa-solid fa-download"></i>
            </a>
            <a class="doc-btn" href="<?= htmlspecialchars($doc['doc']) ?>" target="_blank" rel="noopener" title="Aperçu">
              <i class="fa-regular fa-eye"></i>
            </a>
          </div>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <p class="doc-vide" id="doc-vide" style="display:none;">
      <i class="fa-regular fa-folder-open"></i> Aucun document ne correspond à votre recherche.
    </p>
  </section>
  <?php endif; ?>
</main>
<?php require_once './includes/footer.php'; ?>
<script src="assets/js/script.js"></script>
<?php if ($unlocked): ?>
<script>
document.getElementById('doc-search').addEventListener('input', function () {
  const q     = this.value.toLowerCase();
  const cards = document.querySelectorAll('.doc-card');
  let visible = 0;
  cards.forEach(card => {
    const show = card.innerText.toLowerCase().includes(q);
    card.style.display = show ? '' : 'none';
    if (show) visible++;
  });
  document.getElementById('doc-vide').style.display = visible === 0 ? 'block' : 'none';
});
</script>
<?php endif; ?>
</body>
</html>