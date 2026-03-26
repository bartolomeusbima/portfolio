<?php
$exploreCompanyBackLink = '/work';
$exploreCompanyBackLabelEn = 'View All Work';
$exploreCompanyBackLabelId = 'Lihat Semua Work';

$exploreCompanies = $exploreCompanies ?? [];
?>
<?php if (!empty($exploreCompanies)): ?>
<section class="company-explore-section" data-init-work="card" aria-label="Explore more companies">
    <div class="company-explore-top">
        <div class="company-explore-header">
            <h2 class="company-section-title" data-en="Explore More Companies" data-id="Jelajahi Company Lainnya">Explore More Companies</h2>
            <p class="company-explore-intro" data-en="A few more work chapters from the portfolio that show adjacent product, platform, and operational experience." data-id="Beberapa chapter kerja lain di portfolio yang menunjukkan pengalaman produk, platform, dan operasional yang berdekatan.">A few more work chapters from the portfolio that show adjacent product, platform, and operational experience.</p>
        </div>
        <a class="company-explore-back" href="<?= htmlspecialchars($exploreCompanyBackLink, ENT_QUOTES, 'UTF-8'); ?>" data-en="<?= htmlspecialchars($exploreCompanyBackLabelEn, ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($exploreCompanyBackLabelId, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($exploreCompanyBackLabelEn, ENT_QUOTES, 'UTF-8'); ?></a>
    </div>

    <div class="company-explore-grid">
        <?php foreach ($exploreCompanies as $item): ?>
            <a class="company-explore-card" href="<?= htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8'); ?>">
                <span class="company-explore-media">
                    <img src="<?= htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($item['image_alt'], ENT_QUOTES, 'UTF-8'); ?>">
                </span>
                <span class="company-explore-body">
                    <span class="company-explore-title" data-en="<?= htmlspecialchars($item['title_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($item['title_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($item['title_en'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="company-explore-employment" data-en="<?= htmlspecialchars($item['employment_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($item['employment_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($item['employment_en'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="company-explore-role" data-en="<?= htmlspecialchars($item['role_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($item['role_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($item['role_en'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="company-explore-description" data-en="<?= htmlspecialchars($item['description_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($item['description_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($item['description_en'], ENT_QUOTES, 'UTF-8'); ?></span>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

