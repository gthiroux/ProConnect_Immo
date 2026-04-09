<?php
function getAllProperties($pdo) {
    $sql = "SELECT `id`, `adress`, `image`, `title`, `surface`, `price`, `description` FROM `home` ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function formatPrice($price) {
    return number_format($price, 0, ',', ' ') . ' €';
}