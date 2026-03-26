<?php
require_once dirname(__DIR__) . '/application/models/View.php';

$viewModel = new View();
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/work', PHP_URL_PATH) ?: '/work';
$isProjectView = $requestPath === '/work/projects';
$currentView = $isProjectView ? 'project' : 'company';
$toggleTargetHref = $isProjectView ? '/work' : '/work/projects';
$toggleLabelEn = $isProjectView ? 'Organized by Project' : 'Organized by Company';
$toggleLabelId = $isProjectView ? 'Diurutkan per Project' : 'Diurutkan per Company';
$toggleIcon = $isProjectView ? '/assets/images/icons/grid.svg' : '/assets/images/icons/briefcase.svg';

$companies = $viewModel->getWorkCompanyList()['data'];
$projects = $viewModel->getWorkProjectList()['data'];

function formatProjectCardYear($startDate, $endDate)
{
    $startYear = $startDate ? (int) substr($startDate, 0, 4) : null;
    $endYear = $endDate ? (int) substr($endDate, 0, 4) : $startYear;

    if ($startYear === null) {
        return '';
    }

    return $startYear === $endYear ? (string) $startYear : ($startYear . '-' . $endYear);
}

function formatEmploymentTypeLabel($value)
{
    $map = [
        'FT' => 'Full-time',
        'FL' => 'Freelance',
    ];

    return $map[trim((string) $value)] ?? trim((string) $value);
}
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
    <link rel="stylesheet" href="/assets/css/work.css">
</head>
<body class="work-body">
    <div class="work-shell">
        <?php
        $navbarActivePath = '/work';
        $navbarBackLink = '/';
        $navbarBackLabel = 'Back to home';
        require dirname(__DIR__) . '/templates/navbar.php';
        ?>

        <main class="work-main">
            <header class="work-header" data-init-work="heading">
                <p class="work-kicker" data-en="Selected Engagements" data-id="Kolaborasi Terpilih">Selected Engagements</p>
                <h1 class="work-title" data-en="Work" data-id="Pengalaman Kerja">Work</h1>
            </header>

            <div class="work-panels-toolbar" data-init-work="card">
                <a
                    class="work-organize-toggle"
                    href="<?= htmlspecialchars($toggleTargetHref, ENT_QUOTES, 'UTF-8'); ?>"
                    data-work-toggle
                    data-view="<?= htmlspecialchars($currentView, ENT_QUOTES, 'UTF-8'); ?>"
                    data-route-company="/work"
                    data-route-project="/work/projects"
                    data-label-company-en="Organized by Company"
                    data-label-company-id="Diurutkan per Company"
                    data-label-project-en="Organized by Project"
                    data-label-project-id="Diurutkan per Project"
                >
                    <img class="work-organize-toggle-icon" src="<?= htmlspecialchars($toggleIcon, ENT_QUOTES, 'UTF-8'); ?>" alt="" aria-hidden="true">
                    <span data-en="<?= htmlspecialchars($toggleLabelEn, ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($toggleLabelId, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($toggleLabelEn, ENT_QUOTES, 'UTF-8'); ?></span>
                </a>
            </div>

            <section class="work-panels" aria-label="Selected work">
                <div class="work-panel<?= $isProjectView ? '' : ' is-active'; ?>" data-work-panel="company"<?= $isProjectView ? ' hidden' : ''; ?>>
                    <div class="work-list">
                        <?php foreach ($companies as $company): ?>
                            <a class="work-card" href="/work/<?= htmlspecialchars($company['mwc_slug'], ENT_QUOTES, 'UTF-8'); ?>" data-init-work="card">
                                <div class="work-card-media">
                                    <img src="<?= htmlspecialchars($company['mwc_thumbnail'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars($company['mwc_name'] . ' work preview', ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <div class="work-card-body">
                                    <h2 class="work-card-title"><?= htmlspecialchars($company['mwc_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
                                    <?php $employmentLabel = formatEmploymentTypeLabel($company['mwc_employment_type'] ?? ''); ?>
                                    <p class="work-card-meta" data-en="<?= htmlspecialchars($employmentLabel, ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($employmentLabel, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($employmentLabel, ENT_QUOTES, 'UTF-8'); ?></p>
                                    <p class="work-card-tag" data-en="<?= htmlspecialchars($company['mwc_role_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($company['mwc_role_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($company['mwc_role_en'], ENT_QUOTES, 'UTF-8'); ?></p>
                                    <p class="work-card-copy" data-en="<?= htmlspecialchars($company['mwc_overview_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($company['mwc_overview_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($company['mwc_overview_en'], ENT_QUOTES, 'UTF-8'); ?></p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="work-panel<?= $isProjectView ? ' is-active' : ''; ?>" data-work-panel="project"<?= $isProjectView ? '' : ' hidden'; ?>>
                    <div class="work-project-grid">
                        <?php foreach ($projects as $project): ?>
                            <?php
                            $company = $project['company'] ?? array();
                            $projectYear = formatProjectCardYear($project['mwp_start_date'] ?? null, $project['mwp_end_date'] ?? null);
                            $projectMetaEn = trim(($company['mwc_name'] ?? '') . ' - ' . $projectYear);
                            ?>
                            <a class="work-project-card" href="/work/<?= htmlspecialchars($company['mwc_slug'] ?? '', ENT_QUOTES, 'UTF-8'); ?>/<?= htmlspecialchars($project['mwp_slug'], ENT_QUOTES, 'UTF-8'); ?>" data-init-work="card">
                                <span class="work-project-media">
                                    <img src="<?= htmlspecialchars($project['mwp_thumbnail'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?= htmlspecialchars(($project['mwp_title_en'] ?? 'Project') . ' preview', ENT_QUOTES, 'UTF-8'); ?>">
                                </span>
                                <span class="work-project-body">
                                    <span class="work-project-title" data-en="<?= htmlspecialchars($project['mwp_title_en'], ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($project['mwp_title_id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($project['mwp_title_en'], ENT_QUOTES, 'UTF-8'); ?></span>
                                    <span class="work-project-meta" data-en="<?= htmlspecialchars($projectMetaEn, ENT_QUOTES, 'UTF-8'); ?>" data-id="<?= htmlspecialchars($projectMetaEn, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($projectMetaEn, ENT_QUOTES, 'UTF-8'); ?></span>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="/assets/js/ui-controls.js"></script>
    <script src="/assets/js/reveal.js"></script>
    <script src="/assets/js/work.js"></script>
</body>
</html>





