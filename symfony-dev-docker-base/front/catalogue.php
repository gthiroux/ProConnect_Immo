<?php 
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/head.php'; 

$properties = getAllProperties($pdo);
?>
<link rel="stylesheet" href="assets/css/catalogue.css" />
<main class="page">  
    <div class="centre">
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

        <section class="search-section">
            <div class="search-bar">
                <div class="filter-group">
                    <label>LOCALISATION</label>
                    <select><option>Toute la France</option></select>
                </div>
                <div class="filter-group">
                    <label>TYPE DE BIEN</label>
                    <select><option>Tous types</option></select>
                </div>
                <div class="filter-group">
                    <label>BUDGET MAX</label>
                    <select><option>Illimité</option></select>
                </div>
                <button class="btn-search">Affiner la recherche</button>
            </div>
            
            <div class="tags-row">
                <button class="tag active">Tout</button>
                <button class="tag">Pied-à-terre</button>
                <button class="tag">Vue Mer</button>
                <button class="tag">Domaine Viticole</button>
                <button class="tag">Historique</button>
            </div>
        </section>

        <section class="properties-grid">
            <article class="card">
                <div class="card-image">
                    <span class="label-top">NOUVEAUTÉ</span>
                    <img src="https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=500&q=80" alt="Villa">
                    <div class="price-tag">3 450 000 €</div>
                </div>
                <div class="card-content">
                    <p class="location">SAINT-JEAN-CAP-FERRAT</p>
                    <h3>La Villa Sereine</h3>
                    <div class="details">420 m² • 5 Ch. • Piscine</div>
                    <button class="btn-details">VOIR LES DÉTAILS</button>
                </div>
            </article>

            <article class="card">
                <div class="card-image">
                    <span class="label-top gold">EXCLUSIVITÉ</span>
                    <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=500&q=80" alt="Appartement">
                    <div class="price-tag">1 890 000 €</div>
                </div>
                <div class="card-content">
                    <p class="location">PARIS VIIIe - TRIANGLE D'OR</p>
                    <h3>Appartement Médicis</h3>
                    <div class="details">155 m² • 3 Ch. • Balcon</div>
                    <button class="btn-details">VOIR LES DÉTAILS</button>
                </div>
            </article>

            <article class="card">
                <div class="card-image">
                    <img src="https://images.unsplash.com/photo-1518780664697-55e3ad937233?auto=format&fit=crop&w=500&q=80" alt="Chalet">
                    <div class="price-tag">5 200 000 €</div>
                </div>
                <div class="card-content">
                    <p class="location">MEGÈVE - MONT D'ARBOIS</p>
                    <h3>Le Chalet Boréal</h3>
                    <div class="details">380 m² • 6 Ch. • Spa Privé</div>
                    <button class="btn-details">VOIR LES DÉTAILS</button>
                </div>
            </article>
            </section>

        <div class="pagination">
            <span>&lsaquo;</span>
            <span class="active">01</span>
            <span>02</span>
            <span>03</span>
            <span>04</span>
            <span>&rsaquo;</span>
        </div>
    </div>
</main>
<?php require_once './includes/footer.php'; ?>
<script src="assets/js/script.js"></script>
</body>
</html>