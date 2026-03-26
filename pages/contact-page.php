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
    <link rel="stylesheet" href="/assets/css/contact.css">
</head>
<body class="contact-body">
    <div class="contact-shell">
        <?php
        $navbarActivePath = '/contact';
        $navbarBackLink = '/';
        $navbarBackLabel = 'Back to home';
        require dirname(__DIR__) . '/templates/navbar.php';
        ?>

        <main class="contact-main">
            <header class="contact-header" data-init-contact="heading">
                <h1 class="contact-title" data-en="Let's Connect" data-id="Mari Terhubung">Let's Connect</h1>
                <p class="contact-copy" data-en="I'm always open to thoughtful collaborations, interesting products, and conversations with people who care about building things well." data-id="Saya selalu terbuka untuk kolaborasi yang matang, produk yang menarik, dan percakapan dengan orang-orang yang peduli membangun sesuatu dengan baik.">I'm always open to thoughtful collaborations, interesting products, and conversations with people who care about building things well.</p>
            </header>

            <section class="contact-card" data-init-contact="card" aria-label="Contact card">
                <div class="contact-avatar">
                    <img src="/assets/images/photos/bart.png" alt="Profile portrait of Bima">
                </div>

                <div class="contact-identity">
                    <h2 class="contact-name">Bima</h2>
                    <p class="contact-role" data-en="Fullstack Developer" data-id="Fullstack Developer">Fullstack Developer</p>
                </div>

                <div class="contact-actions" aria-label="Primary contact actions">
                    <a class="contact-action" href="mailto:bm.santoso123@gmail.com" data-en="Drop an E-Mail" data-id="Kirim E-Mail">Drop an E-Mail</a>
                    <a class="contact-action" href="/preview-cv" data-en="Download My CV" data-id="Unduh CV Saya">Download My CV</a>
                    <a class="contact-action" href="/preview-resume" data-en="Download My Resume" data-id="Unduh Resume Saya">Download My Resume</a>
                </div>
            </section>

            <nav class="contact-socials" data-init-contact="links" aria-label="Social links">
                <a href="https://www.instagram.com/bartolomeusbima/" class="contact-social-link" target="_blank" rel="noreferrer">Instagram</a>
                <a href="https://id.linkedin.com/in/bartolomeus-bima-santoso" class="contact-social-link" target="_blank" rel="noreferrer">LinkedIn</a>
            </nav>
        </main>
    </div>

    <script src="/assets/js/ui-controls.js"></script>
    <script src="/assets/js/reveal.js"></script>
    <script src="/assets/js/contact.js"></script>
</body>
</html>







