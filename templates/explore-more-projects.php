<?php
$exploreBackLink = '/work/projects';
$exploreBackLabelEn = 'View All Projects';
$exploreBackLabelId = 'Lihat Semua Project';

$exploreProjects = $exploreProjects ?? [
    [
        'href' => '/work/brill-hepa-filter/landing-page',
        'image' => '/assets/images/photos/work/brill-hepa-filter/project-landing-page.png',
        'image_alt' => 'Brill landing page preview',
        'title_en' => 'Brill Landing Page',
        'title_id' => 'Brill Landing Page',
        'meta_en' => 'Brill Hepa Filter • Customer-facing website',
        'meta_id' => 'Brill Hepa Filter • Website customer-facing',
    ],
    [
        'href' => '/work/alfamart/pin-reset',
        'image' => '/assets/images/photos/work/alfamart/project-pin-reset.png',
        'image_alt' => 'PIN Reset preview',
        'title_en' => 'PIN Reset',
        'title_id' => 'PIN Reset',
        'meta_en' => 'Alfamart • Internal support workflow',
        'meta_id' => 'Alfamart • Alur support internal',
    ],
    [
        'href' => '/work/alfamart/store-incentive-processing-system',
        'image' => '/assets/images/photos/work/alfamart/project-store-incentive-processing-system.png',
        'image_alt' => 'Store incentive processing system preview',
        'title_en' => 'Store Incentive Processing System',
        'title_id' => 'Sistem Pengolahan Insentif Toko',
        'meta_en' => 'Alfamart • Backend automation',
        'meta_id' => 'Alfamart • Otomasi backend',
    ],
    [
        'href' => '/work/alfamart/helpdesk-access-control-migration',
        'image' => '/assets/images/photos/work/alfamart/project-helpdesk-access-control-migration.png',
        'image_alt' => 'Helpdesk access control migration preview',
        'title_en' => 'Helpdesk Access Control Migration',
        'title_id' => 'Migrasi Helpdesk Access Control',
        'meta_en' => 'Alfamart • Legacy modernization',
        'meta_id' => 'Alfamart • Modernisasi sistem legacy',
    ],
];
?>
<section class="project-accordion-section project-explore-section" data-aos="fade-up">
    <div class="project-explore-top">
        <div class="project-accordion-header">
            <h2 class="project-accordion-title" data-en="Explore More Projects" data-id="Jelajahi Proyek Lainnya">Explore More Projects</h2>
            <p class="project-accordion-intro" data-en="A few more top picks that show adjacent product, platform, and operations work across the portfolio." data-id="Beberapa pilihan proyek lain yang menunjukkan kerja produk, platform, dan operasional lain di dalam portfolio ini.">A few more top picks that show adjacent product, platform, and operations work across the portfolio.</p>
        </div>
        <a class="project-explore-back" href="<?= htmlspecialchars($exploreBackLink, ENT_QUOTES, 'UTF-8'); ?>" data-en="<?= htmlspecialchars($exploreBackLabelEn, ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($exploreBackLabelId, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($exploreBackLabelEn, ENT_QUOTES, 'UTF-8'); ?></a>
    </div>

    <div class="project-explore-grid">
        <?php foreach ($exploreProjects as $project): ?>
            <a class="project-explore-card" href="<?= htmlspecialchars($project['href'], ENT_QUOTES, 'UTF-8'); ?>">
                <span class="project-explore-media">
                    <img src="<?= htmlspecialchars($project['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($project['image_alt'], ENT_QUOTES, 'UTF-8'); ?>">
                </span>
                <span class="project-explore-body">
                    <span class="project-explore-title" data-en="<?= htmlspecialchars($project['title_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($project['title_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($project['title_en'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="project-explore-meta" data-en="<?= htmlspecialchars($project['meta_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($project['meta_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($project['meta_en'], ENT_QUOTES, 'UTF-8'); ?></span>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</section>
