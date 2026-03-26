<?php
require_once dirname(__DIR__) . '/application/models/View.php';

function renderWorkNotFoundPage()
{
    require dirname(__DIR__) . '/pages/not-found.php';
}

function splitWorkParagraphs($text)
{
    $parts = preg_split("/\\R{2,}/", (string) $text);
    return array_values(array_filter(array_map('trim', $parts), function ($item) {
        return $item !== '';
    }));
}

function timelineDateLabel($item)
{
    if (!empty($item['mwt_date_label'])) {
        return $item['mwt_date_label'];
    }

    $project = $item['project'] ?? null;
    if (!$project) {
        return '';
    }

    return trim((string) ($project['mwp_start_date'] ?? '') . ' - ' . (string) ($project['mwp_end_date'] ?? ''));
}

function timelineEyebrowClass($type)
{
    $map = [
        'ND' => 'new-development',
        'MD' => 'modernization',
        'EN' => 'enhancement',
    ];

    $normalized = $map[trim((string) $type)] ?? 'new-development';
    if ($normalized === 'new-development' || $normalized === 'modernization' || $normalized === 'enhancement') {
        return 'company-timeline-eyebrow-' . $normalized;
    }

    return 'company-timeline-eyebrow-new-development';
}

function formatEmploymentTypeLabel($value)
{
    $map = [
        'FT' => 'Full-time',
        'FL' => 'Freelance',
    ];

    return $map[trim((string) $value)] ?? trim((string) $value);
}

$companySlug = $workCompanySlug ?? '';
$viewModel = new View();
$company = $viewModel->getWorkCompanyBySlug($companySlug)['data'];

if ($company === null) {
    renderWorkNotFoundPage();
    return;
}

$mediaItems = array_values(array_filter([
    [
        'image' => $company['mwc_banner_1'] ?? null,
        'alt' => ($company['mwc_name'] ?? 'Company') . ' preview 1',
    ],
    [
        'image' => $company['mwc_banner_2'] ?? null,
        'alt' => ($company['mwc_name'] ?? 'Company') . ' preview 2',
    ],
    [
        'image' => $company['mwc_banner_3'] ?? null,
        'alt' => ($company['mwc_name'] ?? 'Company') . ' preview 3',
    ],
    [
        'image' => $company['mwc_banner_4'] ?? null,
        'alt' => ($company['mwc_name'] ?? 'Company') . ' preview 4',
    ],
], function ($item) {
    return !empty($item['image']);
}));
$featuredProjects = $viewModel->getFeaturedWorkProjectsByCompanyId($company['mwc_id'])['data'];
$timelineItems = $viewModel->getWorkCompanyTimelineByCompanyId($company['mwc_id'])['data'];
$allCompanies = $viewModel->getWorkCompanyList()['data'];
$exploreCompanies = array();

foreach ($allCompanies as $companyItem) {
    if (($companyItem['mwc_id'] ?? null) === ($company['mwc_id'] ?? null)) {
        continue;
    }

    $exploreCompanies[] = array(
        'href' => '/work/' . ($companyItem['mwc_slug'] ?? ''),
        'image' => $companyItem['mwc_thumbnail'] ?? '/assets/images/photos/bart-opengraph.png',
        'image_alt' => ($companyItem['mwc_name'] ?? 'Company') . ' preview',
        'title_en' => $companyItem['mwc_name'] ?? 'Company',
        'title_id' => $companyItem['mwc_name'] ?? 'Company',
        'employment_en' => formatEmploymentTypeLabel($companyItem['mwc_employment_type'] ?? ''),
        'employment_id' => formatEmploymentTypeLabel($companyItem['mwc_employment_type'] ?? ''),
        'role_en' => $companyItem['mwc_role_en'] ?? '',
        'role_id' => $companyItem['mwc_role_id'] ?? '',
        'description_en' => $companyItem['mwc_overview_en'] ?? '',
        'description_id' => $companyItem['mwc_overview_id'] ?? '',
    );
}

$exploreCompanies = array_slice($exploreCompanies, 0, 4);
$summaryParagraphsEn = splitWorkParagraphs($company['mwc_summary_en'] ?? '');
$summaryParagraphsId = splitWorkParagraphs($company['mwc_summary_id'] ?? '');
$ogImage = $company['mwc_thumbnail'] ?? '/assets/images/photos/bart-opengraph.png';
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
    <link rel="stylesheet" href="/assets/css/company.css">
</head>
<body class="company-body">
    <?php
    $navbarActivePath = '/work';
    $navbarBackLink = '/work';
    $navbarBackLabel = 'Back to work';
    require dirname(__DIR__) . '/templates/navbar.php';
    ?>

    <main class="company-main">
        <section class="company-hero" data-init-work="heading">
            <div class="company-hero-top">
                <div class="company-hero-head">
                    <nav class="company-breadcrumb" aria-label="Breadcrumb">
                        <a class="company-breadcrumb-link" href="/work">work</a>
                        <span class="company-breadcrumb-separator" aria-hidden="true">/</span>
                        <span class="company-breadcrumb-current" data-en="<?= htmlspecialchars($company['mwc_slug'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($company['mwc_slug'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($company['mwc_slug'], ENT_QUOTES, 'UTF-8'); ?></span>
                    </nav>
                    <h1 class="company-title" data-en="<?= htmlspecialchars($company['mwc_title_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($company['mwc_title_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($company['mwc_title_en'], ENT_QUOTES, 'UTF-8'); ?></h1>
                </div>
            </div>

            <div class="company-media-card" data-company-carousel>
                <button class="company-media-nav company-media-nav-prev" type="button" aria-label="Previous image" data-carousel-prev>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14.75 6.75 9.5 12l5.25 5.25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/></svg>
                </button>

                <div class="company-media-frame">
                    <div class="company-media-track" data-carousel-track>
                        <?php foreach ($mediaItems as $media): ?>
                            <div class="company-media-slide">
                                <img src="<?= htmlspecialchars($media['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($media['alt'], ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <button class="company-media-nav company-media-nav-next" type="button" aria-label="Next image" data-carousel-next>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9.25 6.75 14.5 12l-5.25 5.25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/></svg>
                </button>

                <div class="company-media-dots" aria-label="Carousel pagination">
                    <?php foreach ($mediaItems as $index => $media): ?>
                        <button class="company-media-dot<?= $index === 0 ? ' active' : ''; ?>" type="button" aria-label="Go to image <?= $index + 1; ?>" aria-current="<?= $index === 0 ? 'true' : 'false'; ?>" data-carousel-dot></button>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="company-copy" aria-label="<?= htmlspecialchars($company['mwc_name'], ENT_QUOTES, 'UTF-8'); ?> summary">
            <div class="company-copy-block" data-init-work="card">
                <h2 class="company-section-title" data-en="Summary" data-id="Ringkasan">Summary</h2>
                <?php foreach ($summaryParagraphsEn as $index => $paragraphEn): ?>
                    <?php $paragraphId = $summaryParagraphsId[$index] ?? $paragraphEn; ?>
                    <p data-en="<?= htmlspecialchars($paragraphEn, ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($paragraphId, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($paragraphEn, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="company-featured-section" aria-label="Featured projects" data-init-work="card">
            <div class="company-featured-header">
                <h2 class="company-section-title" data-en="Featured Projects" data-id="Project Unggulan">Featured Projects</h2>
                <p class="company-featured-intro" data-en="A selection of the strongest project stories from this work chapter." data-id="Pilihan project yang paling mewakili chapter kerja ini.">A selection of the strongest project stories from this work chapter.</p>
            </div>

            <div class="company-featured-grid">
                <?php foreach ($featuredProjects as $project): ?>
                    <div class="company-featured-item">
                        <div class="company-featured-card" data-featured-accordion>
                            <button class="company-featured-trigger" type="button" data-featured-trigger aria-expanded="false">
                                <div class="company-featured-main">
                                    <p class="company-featured-role" data-en="<?= htmlspecialchars($project['mwp_role_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($project['mwp_role_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($project['mwp_role_en'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <h3 class="company-featured-title" data-en="<?= htmlspecialchars($project['mwp_title_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($project['mwp_title_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($project['mwp_title_en'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                </div>
                                <span class="company-featured-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24"><path d="m6.75 9.5 5.25 5.25 5.25-5.25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/></svg>
                                </span>
                            </button>
                            <div class="company-featured-content">
                                <div class="company-featured-content-inner">
                                    <p class="company-featured-summary" data-en="<?= htmlspecialchars($project['mwp_overview_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($project['mwp_overview_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($project['mwp_overview_en'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <a class="company-featured-inline-action" href="/work/<?= htmlspecialchars($company['mwc_slug'], ENT_QUOTES, 'UTF-8'); ?>/<?= htmlspecialchars($project['mwp_slug'], ENT_QUOTES, 'UTF-8'); ?>" data-en="View Project Detail" data-id="Lihat Detail Project">View Project Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="company-timeline-section" aria-label="<?= htmlspecialchars($company['mwc_name'], ENT_QUOTES, 'UTF-8'); ?> timeline" data-init-work="card">
            <div class="company-timeline-header">
                <h2 class="company-timeline-title" data-en="Work Timeline" data-id="Timeline Pekerjaan">Timeline Pekerjaan</h2>
                <p class="company-timeline-intro" data-en="A horizontal timeline of role milestones and project chapters in this work experience." data-id="Timeline horizontal dari milestone peran dan chapter project pada pengalaman kerja ini.">A horizontal timeline of role milestones and project chapters in this work experience.</p>
            </div>

            <div class="company-timeline-scroll">
                <div class="company-timeline-track">
                    <?php foreach ($timelineItems as $item): ?>
                        <?php $dateLabel = timelineDateLabel($item); ?>
                        <?php if (($item['mwt_type'] ?? '') === 'P' && !empty($item['project'])): ?>
                            <?php $project = $item['project']; ?>
                            <article class="company-timeline-item company-timeline-item-project">
                                <div class="company-timeline-card">
                                    <span class="company-timeline-eyebrow <?= htmlspecialchars(timelineEyebrowClass($project['mwp_type'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></span>
                                    <h3 data-en="<?= htmlspecialchars($item['mwt_title_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($item['mwt_title_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($item['mwt_title_en'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                    <p data-en="<?= htmlspecialchars($item['mwt_body_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($item['mwt_body_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($item['mwt_body_en'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <a class="company-timeline-link" href="/work/<?= htmlspecialchars($company['mwc_slug'], ENT_QUOTES, 'UTF-8'); ?>/<?= htmlspecialchars($project['mwp_slug'], ENT_QUOTES, 'UTF-8'); ?>" data-en="View Project Detail" data-id="Lihat Detail Project">View Project Detail</a>
                                </div>
                                <div class="company-timeline-node" aria-hidden="true"></div>
                                <span class="company-timeline-date"><?= htmlspecialchars($dateLabel, ENT_QUOTES, 'UTF-8'); ?></span>
                            </article>
                        <?php else: ?>
                            <?php $isMarker = stripos((string) ($item['mwt_title_en'] ?? ''), 'made it past') === 0; ?>
                            <article class="company-timeline-item <?= $isMarker ? 'company-timeline-item-marker' : 'company-timeline-item-info'; ?>"<?= $isMarker ? ' aria-label="New year milestone"' : ''; ?>>
                                <div class="company-timeline-milestone">
                                    <span class="company-timeline-milestone-icon" aria-hidden="true">
                                        <img src="<?= $isMarker ? '/assets/images/icons/party.svg' : '/assets/images/icons/deal.svg'; ?>" alt="">
                                    </span>
                                    <div class="company-timeline-milestone-copy">
                                        <p class="company-timeline-milestone-title" data-en="<?= htmlspecialchars($item['mwt_title_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($item['mwt_title_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($item['mwt_title_en'], ENT_QUOTES, 'UTF-8'); ?></p>
                                        <p class="company-timeline-milestone-text" data-en="<?= htmlspecialchars($item['mwt_body_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($item['mwt_body_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($item['mwt_body_en'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    </div>
                                </div>
                                <div class="company-timeline-node" aria-hidden="true"></div>
                                <span class="company-timeline-date"><?= htmlspecialchars($dateLabel, ENT_QUOTES, 'UTF-8'); ?></span>
                            </article>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="company-timeline-legend" aria-label="Timeline legend">
                <div class="company-timeline-legend-item">
                    <span class="company-timeline-legend-line is-modernization" aria-hidden="true"></span>
                    <span data-en="Modernization" data-id="Modernization">Modernization</span>
                </div>
                <div class="company-timeline-legend-item">
                    <span class="company-timeline-legend-line is-enhancement" aria-hidden="true"></span>
                    <span data-en="Enhancement" data-id="Enhancement">Enhancement</span>
                </div>
                <div class="company-timeline-legend-item">
                    <span class="company-timeline-legend-line is-new-development" aria-hidden="true"></span>
                    <span data-en="New Development" data-id="New Development">New Development</span>
                </div>
            </div>
        </section>

        <?php require dirname(__DIR__) . '/templates/explore-more-companies.php'; ?>
    </main>

    <script src="/assets/js/ui-controls.js"></script>
    <script src="/assets/js/reveal.js"></script>
    <script src="/assets/js/work.js"></script>
</body>
</html>







