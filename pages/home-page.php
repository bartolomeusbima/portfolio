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
</head>
<body>
    <div class="page-shell">
        <?php
        $navbarActivePath = '/';
        require dirname(__DIR__) . '/templates/navbar.php';
        ?>

        <main class="hero">
            <h1 class="hero-title">
                <span class="hero-title-line hero-title-line-primary" data-init="hero-primary">
                    <span data-en="Hey, I'm" data-id="Hai, aku">Hey, I'm</span>
                    <span class="avatar" aria-hidden="true"><img src="/assets/images/photos/bart.png" alt=""></span>
                    <span data-en="Bima." data-id="Bima.">Bima.</span>
                </span>
                <span class="hero-title-line hero-title-line-secondary" data-init="hero-secondary" data-en="How can I help you?" data-id="Ada yang bisa kubantu?">How can I help you?</span>
            </h1>

            <div class="prompt-list">
                <a class="prompt-card" href="/work" data-card data-init="prompt">
                    <span class="prompt-key">A</span>
                    <span class="prompt-copy" data-en="I heard you are designing great apps &amp; websites!" data-id="Katanya kamu bikin aplikasi &amp; website yang keren!">I heard you are designing great apps &amp; websites!</span>
                    <span class="prompt-arrow" aria-hidden="true">
                        <svg fill="#aaa" width="24px" height="24px" viewBox="0 0 1.08 1.08" version="1.1" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" transform="rotate(90)"><path d="M0.83 0.468 0.54 0.18l-0.29 0.288A0.03 0.03 0 1 0 0.292 0.51L0.51 0.294v0.574a0.03 0.03 0 1 0 0.06 0V0.294L0.787 0.51a0.03 0.03 0 0 0 0.042 -0.043Z"/><path x="0" y="0" width="36" height="36" fill-opacity="0" d="M0 0H1.08V1.08H0V0z"/></svg>
                    </span>
                </a>

                <a class="prompt-card" href="/blog" data-card data-init="prompt">
                    <span class="prompt-key">B</span>
                    <span class="prompt-copy" data-en="I like reading about design &amp; technology!" data-id="Aku suka baca soal desain &amp; teknologi!">I like reading about design &amp; technology!</span>
                    <span class="prompt-arrow" aria-hidden="true">
                        <svg fill="#aaa" width="24px" height="24px" viewBox="0 0 1.08 1.08" version="1.1" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" transform="rotate(90)"><path d="M0.83 0.468 0.54 0.18l-0.29 0.288A0.03 0.03 0 1 0 0.292 0.51L0.51 0.294v0.574a0.03 0.03 0 1 0 0.06 0V0.294L0.787 0.51a0.03 0.03 0 0 0 0.042 -0.043Z"/><path x="0" y="0" width="36" height="36" fill-opacity="0" d="M0 0H1.08V1.08H0V0z"/></svg>
                    </span>
                </a>

                <a class="prompt-card" href="/about" data-card data-init="prompt">
                    <span class="prompt-key">C</span>
                    <span class="prompt-copy" data-en="Bima, who?!" data-id="Bima, siapa?!">Bima, who?!</span>
                    <span class="prompt-arrow" aria-hidden="true">
                        <svg fill="#aaa" width="24px" height="24px" viewBox="0 0 1.08 1.08" version="1.1" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" transform="rotate(90)"><path d="M0.83 0.468 0.54 0.18l-0.29 0.288A0.03 0.03 0 1 0 0.292 0.51L0.51 0.294v0.574a0.03 0.03 0 1 0 0.06 0V0.294L0.787 0.51a0.03 0.03 0 0 0 0.042 -0.043Z"/><path x="0" y="0" width="36" height="36" fill-opacity="0" d="M0 0H1.08V1.08H0V0z"/></svg>
                    </span>
                </a>
            </div>

            <p class="hero-note" data-init="hero-note">
                <a class="ghost-link" href="/contact" data-en="Never Mind - Just Say Hi" data-id="Tidak Apa - Hanya Ingin Menyapa">Never Mind - Just Say Hi</a>
            </p>
        </main>
    </div>

    <script src="/assets/js/ui-controls.js"></script>
    <script src="/assets/js/reveal.js"></script>
    <script src="/assets/js/home.js"></script>
    <script src="/assets/js/init-animation.js"></script>
</body>
</html>






