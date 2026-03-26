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
    <link rel="stylesheet" href="/assets/css/about.css">
</head>
<body class="about-body">
    <div class="about-shell">
        <?php
        $navbarActivePath = '/about';
        $navbarBackLink = '/';
        $navbarBackLabel = 'Back to home';
        require dirname(__DIR__) . '/templates/navbar.php';
        ?>

        <main class="about-main">
            <header class="about-header" data-init-about="heading">
                <h1 class="about-title" data-en="Meet Bima" data-id="Kenalan dengan Bima">Meet Bima</h1>
            </header>

            <figure class="about-portrait" data-init-about="portrait">
                <img src="/assets/images/photos/bart-landscape.png" alt="Portrait of Bima">
            </figure>

            <section class="about-copy" data-init-about="copy">
                <p class="about-lead" data-en="I build digital products with a bias toward clarity, resilience, and systems that continue to make sense when real-world complexity starts showing up." data-id="Saya membangun produk digital dengan fokus pada kejelasan, ketahanan, dan sistem yang tetap masuk akal saat kompleksitas dunia nyata mulai muncul.">I build digital products with a bias toward clarity, resilience, and systems that continue to make sense when real-world complexity starts showing up.</p>
                <p data-en="Since 2020, I've been growing through backend-heavy implementation, internal tools, public-facing websites, and product problems that need both structure and pragmatism. I enjoy turning ambiguous requirements into systems that are easier to operate, maintain, and scale." data-id="Sejak 2020, saya berkembang lewat implementasi yang berat di backend, tools internal, website publik, dan problem produk yang membutuhkan struktur sekaligus pragmatisme. Saya menikmati proses mengubah requirement yang ambigu menjadi sistem yang lebih mudah dioperasikan, dirawat, dan dikembangkan.">Since 2020, I've been growing through backend-heavy implementation, internal tools, public-facing websites, and product problems that need both structure and pragmatism. I enjoy turning ambiguous requirements into systems that are easier to operate, maintain, and scale.</p>
            </section>

            <section class="about-stats" data-init-about="stats" aria-label="About statistics">
                <article class="about-stat">
                    <p class="about-stat-value">6</p>
                    <p class="about-stat-label" data-en="Years into coding" data-id="Tahun menekuni coding">Years into coding</p>
                </article>

                <article class="about-stat">
                    <p class="about-stat-value">10+</p>
                    <p class="about-stat-label" data-en="Projects" data-id="Proyek">Projects</p>
                </article>

                <article class="about-stat">
                    <p class="about-stat-value">6+</p>
                    <p class="about-stat-label" data-en="Technologies" data-id="Teknologi">Technologies</p>
                </article>
            </section>

            <section class="about-vision" data-init-about="vision">
                <h2 class="about-section-title" data-en="Vision" data-id="Visi">Vision</h2>

                <div class="about-vision-grid">
                    <article class="about-vision-card">
                        <h3 class="about-vision-title" data-en="For useful systems" data-id="Untuk sistem yang berguna">For useful systems</h3>
                        <p data-en="I care about building software that remains understandable after launch, not just impressive during delivery." data-id="Saya peduli membangun software yang tetap bisa dipahami setelah rilis, bukan hanya terlihat impresif saat proses delivery.">I care about building software that remains understandable after launch, not just impressive during delivery.</p>
                    </article>

                    <article class="about-vision-card">
                        <h3 class="about-vision-title" data-en="For practical collaboration" data-id="Untuk kolaborasi yang praktis">For practical collaboration</h3>
                        <p data-en="The best work usually happens when product thinking, engineering decisions, and communication quality move in the same direction." data-id="Pekerjaan terbaik biasanya terjadi saat product thinking, keputusan engineering, dan kualitas komunikasi bergerak ke arah yang sama.">The best work usually happens when product thinking, engineering decisions, and communication quality move in the same direction.</p>
                    </article>
                </div>
            </section>
        </main>
    </div>

    <script src="/assets/js/ui-controls.js"></script>
    <script src="/assets/js/reveal.js"></script>
    <script src="/assets/js/about.js"></script>
</body>
</html>





