<?php
$ogBaseUrl = 'https://bartolomeusbima.com';
$ogRequestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$ogTitleValue = 'Bartolomeus Bima | Official Portfolio';
$ogDescriptionValue = 'Portfolio of Bartolomeus Bima Santoso, featuring selected work, writing, and practical product-focused development.';
$ogTypeValue = trim((string) ($ogType ?? 'website'));
$ogImageValue = trim((string) ($ogImage ?? '/assets/images/photos/bart-opengraph.png'));
$ogUrlValue = trim((string) ($ogUrl ?? ($ogBaseUrl . $ogRequestPath)));

if ($ogImageValue !== '' && !preg_match('#^https?://#i', $ogImageValue)) {
    $ogImageValue = $ogBaseUrl . $ogImageValue;
}

if ($ogUrlValue !== '' && !preg_match('#^https?://#i', $ogUrlValue)) {
    $ogUrlValue = $ogBaseUrl . $ogUrlValue;
}
?>
    <meta name="description" content="<?= htmlspecialchars($ogDescriptionValue, ENT_QUOTES, 'UTF-8'); ?>">
    <link rel="canonical" href="<?= htmlspecialchars($ogUrlValue, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:site_name" content="Bartolomeus Bima">
    <meta property="og:type" content="<?= htmlspecialchars($ogTypeValue, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:title" content="<?= htmlspecialchars($ogTitleValue, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:description" content="<?= htmlspecialchars($ogDescriptionValue, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:url" content="<?= htmlspecialchars($ogUrlValue, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image" content="<?= htmlspecialchars($ogImageValue, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($ogTitleValue, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($ogDescriptionValue, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($ogImageValue, ENT_QUOTES, 'UTF-8'); ?>">
