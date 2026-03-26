<?php
require_once dirname(__DIR__) . '/application/models/View.php';

$slug = isset($blogSlug) ? trim((string) $blogSlug) : '';
$view = new View();
$blogHead = $view->getBlogHeadBySlug($slug);

if (!$blogHead['status'] || empty($blogHead['data'])) {
    require dirname(__DIR__) . '/pages/not-found.php';
    return;
}

$blog = $blogHead['data'];
$blogSections = $view->getBlogDetailByHeadId($blog['mbh_id']);
$sections = $blogSections['data'] ?? array();
$blogDate = date('d/m/Y', strtotime($blog['mbh_create_date']));
$firstSection = $sections[0] ?? array();
$ogType = 'article';
$ogImage = $blog['mbh_image'] ?? '/assets/images/photos/bart-opengraph.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require dirname(__DIR__) . '/templates/opengraph-meta.php'; ?>
    <title>Bartolomeus Bima | Official Portfolio</title>
    <link rel="stylesheet" href="/assets/css/fonts.css">
    <link rel="stylesheet" href="/assets/css/home.css">
    <link rel="stylesheet" href="/assets/css/navbar.css">
    <link rel="stylesheet" href="/assets/css/blog-post.css">
</head>
<body class="blog-post-body">
    <div class="blog-post-shell">
        <?php
        $navbarActivePath = '/blog';
        $navbarBackLink = '/blog';
        $navbarBackLabel = 'Back to blog';
        require dirname(__DIR__) . '/templates/navbar.php';
        ?>

        <main class="blog-post-main">
            <header class="blog-post-hero" data-init-blog-article="hero">
                <h1 class="blog-post-title" data-en="<?php echo htmlspecialchars($blog['mbh_title_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?php echo htmlspecialchars($blog['mbh_title_id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($blog['mbh_title_en'], ENT_QUOTES, 'UTF-8'); ?></h1>
                <p class="blog-post-date"><?php echo htmlspecialchars($blogDate, ENT_QUOTES, 'UTF-8'); ?></p>
            </header>

            <figure class="blog-post-cover" data-init-blog-article="cover">
                <img src="<?php echo htmlspecialchars($blog['mbh_image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Editorial cover image for blog article">
            </figure>

            <?php require dirname(__DIR__) . '/templates/blog-detail-content.php'; ?>
        </main>
    </div>

    <script src="/assets/js/ui-controls.js"></script>
    <script src="/assets/js/reveal.js"></script>
    <script src="/assets/js/blog-article.js"></script>
</body>
</html>





