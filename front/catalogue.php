<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/head.php';

$rdv_success = false;
$rdv_error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'prendre_rdv') {
    $lastname   = trim($_POST['lastname']   ?? '');
    $firstname  = trim($_POST['firstname']  ?? '');
    $email      = trim($_POST['email']      ?? '');
    $tel        = trim($_POST['tel']        ?? '');
    $date       = trim($_POST['date']       ?? '');
    $service_id = (int)($_POST['service_id'] ?? 0) ?: null;
    $house_id   = (int)($_POST['house_id']   ?? 0) ?: null;

    if (!$lastname || !$firstname || !$email || !$tel || !$date) {
        $rdv_error = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        $date_obj = DateTime::createFromFormat('Y-m-d\TH:i', $date);
        $min_date = new DateTime('+24 hours');

        if (!$date_obj) {
            $rdv_error = 'Format de date invalide.';
        } elseif ($date_obj < $min_date) {
            $rdv_error = 'Le rendez-vous doit être pris au moins 24 h à l\'avance.';
        } elseif ($date_obj->format('N') == 7) {
            $rdv_error = 'Nous sommes fermés le dimanche. Merci de choisir un autre jour.';
        } elseif ((int)$date_obj->format('H') < 9 || (int)$date_obj->format('H') >= 19) {
            $rdv_error = 'Les rendez-vous sont disponibles de 9h à 19h uniquement.';
        }
    }

    if (!$rdv_error) {
        $uuid = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            random_int(0, 0xffff), random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0x0fff) | 0x4000,
            random_int(0, 0x3fff) | 0x8000,
            random_int(0, 0xffff), random_int(0, 0xffff), random_int(0, 0xffff)
        );
        $code_mail = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $stmt = $pdo->prepare("
            INSERT INTO `request`
                (`uuid`, `lastname`, `firstname`, `email`, `tel`, `date`, `status`, `code_mail`, `service_id`, `house_id`)
            VALUES
                (:uuid, :lastname, :firstname, :email, :tel, :date, :status, :code_mail, :service_id, :house_id)
        ");
        $stmt->execute([
            ':uuid'       => $uuid,
            ':lastname'   => $lastname,
            ':firstname'  => $firstname,
            ':email'      => $email,
            ':tel'        => $tel,
            ':date'       => $date,
            ':status'     => 'pas traité',
            ':code_mail'  => $code_mail,
            ':service_id' => $service_id,
            ':house_id'   => $house_id,
        ]);
        $rdv_success = true;
    }
}

$per_page    = 6;
$page        = max(1, (int)($_GET['page'] ?? 1));
$offset      = ($page - 1) * $per_page;
$total_stmt  = $pdo->query("SELECT COUNT(*) FROM `home`");
$total       = (int)$total_stmt->fetchColumn();
$total_pages = (int)ceil($total / $per_page);

$stmt = $pdo->prepare("
    SELECT `id`, `adress`, `image`, `title`, `surface`, `price`, `description`
    FROM `home`
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit',  $per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset,   PDO::PARAM_INT);
$stmt->execute();
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

$services = $pdo->query("SELECT `id`, `name` FROM `service` ORDER BY `name`")->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="assets/css/catalogue.css" />

<main class="page">
    <div class="centre">
        <?php if ($rdv_success): ?>
            <div class="alert alert-success" style="margin: 1.5rem 0;">
                ✓ Votre demande a bien été enregistrée. Nous vous contacterons sous 24 h.
            </div>
        <?php elseif ($rdv_error): ?>
            <div class="alert alert-error" style="margin: 1.5rem 0;">
                <?= htmlspecialchars($rdv_error) ?>
            </div>
        <?php endif; ?> 
        <section class="hero">
            <div class="hero-text">
                <h1>Curations <span>D'Exception</span></h1>
                <p>Une sélection rigoureuse des plus belles demeures françaises, où l'architecture rencontre l'art de vivre.</p>
            </div>
            <div class="hero-image-container">
                <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=800&q=80" alt="Villa de luxe" class="hero-img">
                <div class="hero-badge">
                    <span class="badge-tag">TENDANCE ACTUELLE</span>
                    <h3>L'Éveil Provençal</h3>
                    <p>Découvrez nos nouvelles acquisitions dans l'arrière-pays cannois.</p>
                </div>
            </div>
        </section>
        <section class="properties-grid">
            <?php if (empty($properties)): ?>
                <div class="no-properties">Aucune propriété disponible pour le moment.</div>
            <?php else: ?>
                <?php foreach ($properties as $p): ?>
                <article class="card">
                    <div class="card-image">
                        <?php
                            $img = !empty($p['image'])
                                ? htmlspecialchars($p['image'])
                                : 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=600&q=80';
                        ?>
                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($p['title']) ?>">
                        <div class="price-tag">
                            <?= number_format((float)$p['price'], 0, ',', ' ') ?> €
                        </div>
                    </div>
                    <div class="card-content">
                        <p class="location"><?= htmlspecialchars($p['adress']) ?></p>
                        <h3><?= htmlspecialchars($p['title']) ?></h3>
                        <div class="details"><?= htmlspecialchars($p['surface']) ?> m²</div>
                        <div class="desc"><?= nl2br(htmlspecialchars($p['description'])) ?></div>
                        <button
                            class="btn-rdv-card"
                            onclick="openRdv(<?= (int)$p['id'] ?>, '<?= htmlspecialchars(addslashes($p['title'])) ?>')"
                        >
                            Prendre Rendez-Vous
                        </button>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
        <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <?php if ($page <= 1): ?>
                <span class="disabled">&lsaquo;</span>
            <?php else: ?>
                <a href="?page=<?= $page - 1 ?>">&lsaquo;</a>
            <?php endif; ?>
            <?php
            $window = 2;
            for ($i = 1; $i <= $total_pages; $i++):
                if ($i === 1 || $i === $total_pages || abs($i - $page) <= $window):
                    if ($i === $page):
            ?>
                        <span class="active"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></span>
            <?php   else: ?>
                        <a href="?page=<?= $i ?>"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></a>
            <?php
                    endif;
                elseif (abs($i - $page) === $window + 1):
            ?>
                    <span>…</span>
            <?php   endif; endfor; ?>
            <?php if ($page >= $total_pages): ?>
                <span class="disabled">&rsaquo;</span>
            <?php else: ?>
                <a href="?page=<?= $page + 1 ?>">&rsaquo;</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</main>
<div class="modal-overlay" id="rdvModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal">
        <div class="modal-deco">
            <div>
                <div class="modal-deco-label">Agence Prestige</div>
                <h2>Planifiez votre <em>visite</em> privée</h2>
                <p>Notre équipe de conseillers vous accueille sur rendez-vous pour vous faire découvrir chaque propriété dans les meilleures conditions.</p>
            </div>
            <div class="modal-deco-property" id="decoProperty">&mdash;</div>
        </div>
        <div class="modal-form-wrap">
            <div class="modal-header">
                <div class="modal-header-title">Formulaire de demande</div>
                <button class="modal-close" onclick="closeRdv()" aria-label="Fermer">&times;</button>
            </div>
            <form method="POST" action="?page=<?= $page ?>">
                <?php if ($rdv_success): ?>
                    <div class="alert alert-success" style="margin: 1.5rem 0;">
                        ✓ Votre demande a bien été enregistrée. Nous vous contacterons sous 24 h.
                    </div>
                <?php elseif ($rdv_error): ?>
                    <div class="alert alert-error" style="margin: 1.5rem 0;">
                        <?= htmlspecialchars($rdv_error) ?>
                    </div>
                <?php endif; ?> 
                <input type="hidden" name="action"     value="prendre_rdv">
                <input type="hidden" name="house_id"   id="house_id_field"   value="">
                <input type="hidden" name="service_id" id="service_id_field" value="">
                <div class="form-row">
                    <div class="form-group">
                        <label for="rdv_lastname">Nom *</label>
                        <input type="text" id="rdv_lastname" name="lastname" value="<?= htmlspecialchars($_POST['lastname'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="rdv_firstname">Prénom *</label>
                        <input type="text" id="rdv_firstname" name="firstname" value="<?= htmlspecialchars($_POST['firstname'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="rdv_email">Email *</label>
                        <input type="email" id="rdv_email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="rdv_tel">Téléphone *</label>
                        <input type="tel" id="rdv_tel" name="tel" value="<?= htmlspecialchars($_POST['tel'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="rdv_date">Date du rendez-vous</label>
                        <input type="datetime-local" id="rdv_date" name="date" value="<?= htmlspecialchars($_POST['date'] ?? '') ?>" required>
                        <small id="rdv_error_msg" style="color:#d32f2f;display:block;margin-top:5px;min-height:1em;"></small>
                    </div>
                    <div class="form-group">
                        <label for="rdv_service">Service</label>
                        <select id="rdv_service" name="service_id">
                            <option value="">— Choisir un service —</option>
                            <?php foreach ($services as $svc): ?>
                                <option value="<?= (int)$svc['id'] ?>"
                                    <?= (isset($_POST['service_id']) && (int)$_POST['service_id'] === (int)$svc['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($svc['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn-submit">Confirmer la demande &rarr;</button>
            </form>
        </div>
    </div>
</div>
<?php require_once './includes/footer.php'; ?>
<script src="./assets/js/script.js"></script>
<script>
    function openRdv(propertyId, propertyTitle) {
        document.getElementById('house_id_field').value         = propertyId;
        document.getElementById('service_id_field').value       = '';
        document.getElementById('rdv_service').value            = '';
        document.getElementById('decoProperty').textContent     = propertyTitle || '—';
        document.getElementById('rdvModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeRdv() {
        document.getElementById('rdvModal').classList.remove('open');
        document.body.style.overflow = '';
    }

    // Fermer en cliquant en dehors
    document.getElementById('rdvModal').addEventListener('click', function (e) {
        if (e.target === this) closeRdv();
    });

    // Fermer avec Échap
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeRdv();
    });

    // Sync select → champ hidden
    document.getElementById('rdv_service').addEventListener('change', function () {
        document.getElementById('service_id_field').value = this.value;
    });

    // ── Ré-ouvrir la modale uniquement en cas d'erreur ──
    <?php if ($rdv_error): ?>
    (function () {
        document.getElementById('rdvModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    })();
    <?php endif; ?>
</script>
</body>
</html>