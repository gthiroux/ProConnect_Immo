<?php $page_courante = basename($_SERVER['PHP_SELF']); ?>
<nav class="nav">
  <div class="nav-contenu">
    <a href="index.php" class="nav-logo">L'ATELIER IMMO</a>
    <ul class="nav-liens">
      <li><a href="accueil.php"     class="nav-lien <?= $page_courante === 'accueil.php'     ? 'actif' : '' ?>">Accueil</a></li>
      <li><a href="catalogue.php" class="nav-lien <?= $page_courante === 'catalogue.php' ? 'actif' : '' ?>">Catalogue</a></li>
      <li><a href="document.php"  class="nav-lien <?= $page_courante === 'document.php'  ? 'actif' : '' ?>">Documents</a></li>
    </ul>
    <button class="nav-menu" aria-label="Menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>
