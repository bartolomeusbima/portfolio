<?php
require_once dirname(__DIR__) . '/application/models/View.php';

function renderWorkProjectNotFoundPage()
{
    require dirname(__DIR__) . '/pages/not-found.php';
}

function monthLabelEn($month)
{
    $labels = array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
    return $labels[(int) $month] ?? '';
}

function monthLabelId($month)
{
    $labels = array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des');
    return $labels[(int) $month] ?? '';
}

function formatProjectPeriod($date, $language)
{
    if (!$date) {
        return '';
    }

    $month = (int) substr($date, 5, 2);
    $year = substr($date, 0, 4);
    $monthLabel = $language === 'id' ? monthLabelId($month) : monthLabelEn($month);

    return trim($monthLabel . ' ' . $year);
}

function buildProjectPeriodRange($startDate, $endDate)
{
    $startEn = formatProjectPeriod($startDate, 'en');
    $startId = formatProjectPeriod($startDate, 'id');
    $endEn = formatProjectPeriod($endDate, 'en');
    $endId = formatProjectPeriod($endDate, 'id');

    if ($startEn === '') {
        return array('en' => '', 'id' => '');
    }

    if ($endEn === '' || $endEn === $startEn) {
        return array('en' => $startEn, 'id' => $startId);
    }

    return array(
        'en' => $startEn . ' - ' . $endEn,
        'id' => $startId . ' - ' . $endId,
    );
}

function slugToBreadcrumbLabel($slug)
{
    return str_replace('-', ' ', (string) $slug);
}

function projectTypeMeta($type, $language)
{
    $map = array(
        'MD' => array('en' => 'Legacy modernization', 'id' => 'Modernisasi sistem legacy'),
        'EN' => array('en' => 'Product enhancement', 'id' => 'Pengembangan lanjutan produk'),
        'ND' => array('en' => 'New product development', 'id' => 'Pengembangan produk baru'),
    );

    $key = (string) $type;
    return $map[$key][$language] ?? ($language === 'id' ? 'Project delivery' : 'Project delivery');
}

$companySlug = $workCompanySlug ?? '';
$projectSlug = $workProjectSlug ?? '';
$viewModel = new View();
$project = $viewModel->getWorkProjectBySlugs($companySlug, $projectSlug)['data'];

if ($project === null) {
    renderWorkProjectNotFoundPage();
    return;
}

$company = $project['company'] ?? array();
$techStacks = $viewModel->getSkillsByProjectId($project['mwp_id'])['data'];
$exploreProjectRows = $viewModel->getExploreProjects($project['mwp_id'], 4)['data'];
$periodLabels = buildProjectPeriodRange($project['mwp_start_date'] ?? null, $project['mwp_end_date'] ?? null);
$techStackKeys = implode(',', array_map(function ($item) {
    return $item['msk_slug'];
}, $techStacks));

$projectDestination = array(
    'label_en' => 'Project Link',
    'label_id' => 'Project Link',
);

if (($project['mwp_is_internal'] ?? 'N') === 'Y' || empty($project['mwp_destination_url'])) {
    $projectDestination['disabled'] = true;
    $projectDestination['tooltip_en'] = 'Access to this project is restricted because it runs in an internal environment.';
    $projectDestination['tooltip_id'] = 'Akses ke project ini dibatasi karena berjalan di environment internal.';
} else {
    $projectDestination['href'] = $project['mwp_destination_url'];
}

$ogImage = $project['mwp_thumbnail'] ?? '/assets/images/photos/bart-opengraph.png';
$ogType = 'article';

$exploreProjects = array_map(function ($item) {
    $company = $item['company'] ?? array();
    return array(
        'href' => '/work/' . ($company['mwc_slug'] ?? '') . '/' . ($item['mwp_slug'] ?? ''),
        'image' => $item['mwp_thumbnail'] ?? '',
        'image_alt' => ($item['mwp_title_en'] ?? 'Project') . ' preview',
        'title_en' => $item['mwp_title_en'] ?? '',
        'title_id' => $item['mwp_title_id'] ?? ($item['mwp_title_en'] ?? ''),
        'meta_en' => ($company['mwc_name'] ?? '') . ' | ' . projectTypeMeta($item['mwp_type'] ?? '', 'en'),
        'meta_id' => ($company['mwc_name'] ?? '') . ' | ' . projectTypeMeta($item['mwp_type'] ?? '', 'id'),
    );
}, $exploreProjectRows);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require dirname(__DIR__) . '/templates/opengraph-meta.php'; ?>
    <title>Bartolomeus Bima | Official Portfolio</title>
    <link rel="stylesheet" href="/assets/css/fonts.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"/>
    <link rel="stylesheet" href="/assets/css/home.css">
    <link rel="stylesheet" href="/assets/css/navbar.css">
    <link rel="stylesheet" href="/assets/css/project.css">
</head>
<body class="project-body">
    <?php
    $navbarActivePath = '/work';
    $navbarBackLink = '/work/' . ($company['mwc_slug'] ?? '');
    $navbarBackLabel = 'Back to ' . ($company['mwc_name'] ?? 'Work');
    require dirname(__DIR__) . '/templates/navbar.php';
    ?>

    <div class="container project-shell">
        <section class="hero">
            <nav class="project-breadcrumb" aria-label="Breadcrumb">
                <a class="project-breadcrumb-link" href="/work">work</a>
                <span class="project-breadcrumb-separator" aria-hidden="true">/</span>
                <a class="project-breadcrumb-link" href="/work/<?= htmlspecialchars($company['mwc_slug'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($company['mwc_slug'] ?? '', ENT_QUOTES, 'UTF-8'); ?></a>
                <span class="project-breadcrumb-separator" aria-hidden="true">/</span>
                <span class="project-breadcrumb-current" data-en="<?= htmlspecialchars(slugToBreadcrumbLabel($project['mwp_slug']), ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars(slugToBreadcrumbLabel($project['mwp_slug']), ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars(slugToBreadcrumbLabel($project['mwp_slug']), ENT_QUOTES, 'UTF-8'); ?></span>
            </nav>
            <h1 class="title" data-en="<?= htmlspecialchars($project['mwp_title_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($project['mwp_title_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($project['mwp_title_en'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <div class="subtitle subtitle-meta">
                <div class="subtitle-meta-row">
                    <img class="subtitle-meta-icon" src="/assets/images/icons/time.svg" alt="" aria-hidden="true">
                    <p data-en="<?= htmlspecialchars($periodLabels['en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($periodLabels['id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($periodLabels['en'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <div class="subtitle-meta-row">
                    <img class="subtitle-meta-icon" src="/assets/images/icons/person.svg" alt="" aria-hidden="true">
                    <p data-en="<?= htmlspecialchars($project['mwp_role_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($project['mwp_role_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($project['mwp_role_en'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <?php require dirname(__DIR__) . '/templates/project-destination-cta.php'; ?>
            </div>
            <div class="hero-banner" data-aos="fade-up" data-aos-delay="100">
                <div class="hero-banner-item">
                    <img src="<?= htmlspecialchars($project['mwp_thumbnail'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($project['mwp_title_en'] . ' thumbnail', ENT_QUOTES, 'UTF-8'); ?>">
                </div>
            </div>

            <section class="tech-stack-section" data-aos="fade-up" data-aos-delay="0">
                <div class="tech-stack-label" data-en="Tech Stack" data-id="Tech Stack">Tech Stack</div>
                <div class="tech-stack-marquee" data-tech-stack="<?= htmlspecialchars($techStackKeys, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Tech stack preview"></div>
            </section>
        </section>

        <section class="grid grid-single">
            <div>
                <div class="card" data-aos="fade-up">
                    <h2 data-en="Overview" data-id="Gambaran Umum">Overview</h2>
                    <p data-en="<?= htmlspecialchars($project['mwp_overview_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($project['mwp_overview_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($project['mwp_overview_en'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="overview-collab" data-en="<?= htmlspecialchars($project['mwp_collaboration_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($project['mwp_collaboration_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($project['mwp_collaboration_en'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>

                <div class="card" data-aos="fade-up">
                    <h2 data-en="Responsibilities" data-id="Tanggung Jawab">Responsibilities</h2>
                    <ul class="list">
                        <?php foreach (($project['mwp_responsibilities_en'] ?? array()) as $index => $itemEn): ?>
                            <?php $itemId = $project['mwp_responsibilities_id'][$index] ?? $itemEn; ?>
                            <li data-en="<?= htmlspecialchars($itemEn, ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($itemId, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($itemEn, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="card" data-aos="fade-up">
                    <h2 data-en="Outcome" data-id="Hasil">Outcome</h2>
                    <p data-en="<?= htmlspecialchars($project['mwp_outcome_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($project['mwp_outcome_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($project['mwp_outcome_en'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
        </section>

        <section class="project-accordion-section" data-aos="fade-up">
            <div class="project-accordion-header">
                <h2 class="project-accordion-title" data-en="Detailed Breakdown" data-id="Detail Lengkap">Detailed Breakdown</h2>
                <p class="project-accordion-intro" data-en="The section above is optimized for fast recruiter review. If you want the full implementation context, open the details below." data-id="Bagian atas dioptimalkan untuk review cepat oleh recruiter. Jika ingin melihat konteks implementasi lengkap, buka detail di bawah.">The section above is optimized for fast recruiter review. If you want the full implementation context, open the details below.</p>
            </div>

            <div class="project-accordion-list">
                <article class="project-accordion-item">
                    <button class="project-accordion-trigger" type="button" data-accordion-trigger aria-expanded="false"><span class="project-accordion-label" data-en="Problem &amp; Solution" data-id="Masalah &amp; Solusi">Problem &amp; Solution</span><span class="project-accordion-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m6.75 9.5 5.25 5.25 5.25-5.25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/></svg></span></button>
                    <div class="project-accordion-content"><div class="project-accordion-inner"><div class="project-accordion-body">
                        <p data-en="<?= htmlspecialchars($project['mwp_problem_solution_en']['problem'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($project['mwp_problem_solution_id']['problem'] ?? ($project['mwp_problem_solution_en']['problem'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($project['mwp_problem_solution_en']['problem'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                        <p data-en="<?= htmlspecialchars($project['mwp_problem_solution_en']['solution'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($project['mwp_problem_solution_id']['solution'] ?? ($project['mwp_problem_solution_en']['solution'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($project['mwp_problem_solution_en']['solution'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    </div></div></div>
                </article>

                <article class="project-accordion-item">
                    <button class="project-accordion-trigger" type="button" data-accordion-trigger aria-expanded="false"><span class="project-accordion-label" data-en="Application Flow" data-id="Alur Aplikasi">Application Flow</span><span class="project-accordion-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m6.75 9.5 5.25 5.25 5.25-5.25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/></svg></span></button>
                    <div class="project-accordion-content"><div class="project-accordion-inner"><div class="project-accordion-body">
                        <?php foreach (($project['mwp_application_flow_en'] ?? array()) as $groupIndex => $groupEn): ?>
                            <?php $groupId = $project['mwp_application_flow_id'][$groupIndex] ?? $groupEn; ?>
                            <p class="flow-label" data-en="<?= htmlspecialchars($groupEn['label'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($groupId['label'] ?? ($groupEn['label'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($groupEn['label'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                            <div class="flow">
                                <?php foreach (($groupEn['steps'] ?? array()) as $stepIndex => $stepEn): ?>
                                    <?php $stepId = $groupId['steps'][$stepIndex] ?? $stepEn; ?>
                                    <div class="flow-item"><div class="step"><?= str_pad((string) ($stepIndex + 1), 2, '0', STR_PAD_LEFT); ?></div><p data-en="<?= htmlspecialchars($stepEn, ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($stepId, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($stepEn, ENT_QUOTES, 'UTF-8'); ?></p></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div></div></div>
                </article>

                <article class="project-accordion-item">
                    <button class="project-accordion-trigger" type="button" data-accordion-trigger aria-expanded="false"><span class="project-accordion-label" data-en="Technical Notes" data-id="Catatan Teknis">Technical Notes</span><span class="project-accordion-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m6.75 9.5 5.25 5.25 5.25-5.25" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"/></svg></span></button>
                    <div class="project-accordion-content"><div class="project-accordion-inner"><div class="project-accordion-body">
                        <p data-en="<?= htmlspecialchars($project['mwp_technical_notes_en']['intro'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($project['mwp_technical_notes_id']['intro'] ?? ($project['mwp_technical_notes_en']['intro'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($project['mwp_technical_notes_en']['intro'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                        <?php foreach (($project['mwp_technical_notes_en']['implementation_flow'] ?? array()) as $groupIndex => $groupEn): ?>
                            <?php $groupId = $project['mwp_technical_notes_id']['implementation_flow'][$groupIndex] ?? $groupEn; ?>
                            <p class="flow-label" data-en="<?= htmlspecialchars($groupEn['label'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($groupId['label'] ?? ($groupEn['label'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($groupEn['label'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                            <div class="flow">
                                <?php foreach (($groupEn['steps'] ?? array()) as $stepIndex => $stepEn): ?>
                                    <?php $stepId = $groupId['steps'][$stepIndex] ?? $stepEn; ?>
                                    <div class="flow-item"><div class="step"><?= str_pad((string) ($stepIndex + 1), 2, '0', STR_PAD_LEFT); ?></div><p data-en="<?= htmlspecialchars($stepEn, ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($stepId, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($stepEn, ENT_QUOTES, 'UTF-8'); ?></p></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                        <p class="flow-label" data-en="Implementation Details" data-id="Detail Implementasi">Implementation Details</p>
                        <ul class="list">
                            <?php foreach (($project['mwp_technical_notes_en']['implementation_details'] ?? array()) as $detailIndex => $detailEn): ?>
                                <?php $detailId = $project['mwp_technical_notes_id']['implementation_details'][$detailIndex] ?? $detailEn; ?>
                                <li data-en="<?= htmlspecialchars($detailEn, ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($detailId, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($detailEn, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <p data-en="<?= htmlspecialchars($project['mwp_technical_notes_en']['outro'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($project['mwp_technical_notes_id']['outro'] ?? ($project['mwp_technical_notes_en']['outro'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($project['mwp_technical_notes_en']['outro'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    </div></div></div>
                </article>
            </div>
        </section>
        <?php require dirname(__DIR__) . '/templates/explore-more-projects.php'; ?>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="/assets/js/ui-controls.js"></script>
    <script src="/assets/js/project.js"></script>
</body>
</html>




