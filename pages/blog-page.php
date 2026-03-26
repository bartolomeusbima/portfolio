<?php
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
    <link rel="stylesheet" href="/assets/css/blog.css">
</head>
<body class="blog-body">
    <?php
    require_once dirname(__DIR__) . '/application/models/View.php';
    $view = new View();
    $blogList = $view->getBlogList();
    $articles = $blogList['data'] ?? array();
    ?>
    <div class="blog-shell">
        <?php
        $navbarActivePath = '/blog';
        $navbarBackLink = '/';
        $navbarBackLabel = 'Back to home';
        require dirname(__DIR__) . '/templates/navbar.php';
        ?>

        <main class="blog-main">
            <header class="blog-header" data-init-blog="heading">
                <p class="blog-kicker" data-en="Notes, process, and reflections" data-id="Catatan, proses, dan refleksi">Notes, process, and reflections</p>
                <h1 class="blog-title" data-en="Thoughts" data-id="Pemikiran">Thoughts</h1>
            </header>

            <section class="blog-list" aria-label="Blog posts">
                <?php foreach ($articles as $article): ?>
                    <a class="blog-card" href="/blog/<?php echo htmlspecialchars($article['mbh_slug'], ENT_QUOTES, 'UTF-8'); ?>" data-init-blog="card">
                        <div class="blog-card-media">
                            <img src="<?php echo htmlspecialchars($article['mbh_image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Preview image for blog article">
                        </div>
                        <div class="blog-card-content">
                            <h2 class="blog-card-title" data-en="<?php echo htmlspecialchars($article['mbh_title_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?php echo htmlspecialchars($article['mbh_title_id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($article['mbh_title_en'], ENT_QUOTES, 'UTF-8'); ?></h2>
                            <p class="blog-card-meta">
                                <span data-en="<?php echo htmlspecialchars($article['mbh_type_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?php echo htmlspecialchars($article['mbh_type_id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($article['mbh_type_en'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <span aria-hidden="true">&bull;</span>
                                <span><?php echo htmlspecialchars(date('d/m/Y', strtotime($article['mbh_create_date'])), ENT_QUOTES, 'UTF-8'); ?></span>
                            </p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </section>
        </main>
    </div>

    <script src="/assets/js/ui-controls.js"></script>
    <script src="/assets/js/reveal.js"></script>
    <script src="/assets/js/blog.js"></script>
</body>
</html>





