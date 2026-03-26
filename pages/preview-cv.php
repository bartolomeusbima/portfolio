<?php
require_once dirname(__DIR__) . '/application/models/View.php';

function cvYearRange($startYear, $endYear)
{
    $startYear = trim((string) $startYear);
    $endYear = trim((string) $endYear);

    if ($startYear === '') {
        return $endYear !== '' ? $endYear : 'Present';
    }

    if ($endYear === '' || $startYear === $endYear) {
        return $startYear;
    }

    return $startYear . ' - ' . $endYear;
}

function cvEmploymentTypeLabel($value)
{
    $map = [
        'FT' => 'Full-time',
        'FL' => 'Freelance',
    ];

    return $map[trim((string) $value)] ?? trim((string) $value);
}

$view = new View();
$companies = $view->getWorkCompanyList()['data'] ?? [];
$projects = $view->getWorkProjectList()['data'] ?? [];
$companyProjects = [];

foreach ($projects as $project) {
    $companyId = $project['mwp_mwc_id'] ?? null;
    $projectTitle = trim((string) ($project['mwp_title_en'] ?? ''));
    $isFeatured = ($project['mwp_is_featured'] ?? 'N') === 'Y';

    if ($companyId === null || $projectTitle === '' || !$isFeatured) {
        continue;
    }

    if (!isset($companyProjects[$companyId])) {
        $companyProjects[$companyId] = [];
    }

    $companyProjects[$companyId][] = $projectTitle;
}

$techMap = [];
foreach ($projects as $project) {
    $projectTech = $view->getSkillsByProjectId($project['mwp_id'])['data'] ?? [];
    foreach ($projectTech as $tech) {
        $slug = $tech['msk_slug'] ?? null;
        if ($slug === null || isset($techMap[$slug])) {
            continue;
        }
        $techMap[$slug] = $tech['msk_name'] ?? $slug;
    }
}
$techNames = array_values($techMap);
sort($techNames, SORT_NATURAL | SORT_FLAG_CASE);

$personal = [
    'full_name' => 'Bartolomeus Bima Santoso',
    'headline' => 'Fullstack Developer',
    'location' => 'Banten, Indonesia 15334',
    'email' => 'bm.santoso123@gmail.com',
    'phone' => '(+62) 87889384936',
    'website' => 'bartolomeusbima.com',
    'linkedin' => 'linkedin.com/in/bartolomeus-bima-santoso',
    'summary' => 'Backend-focused fullstack developer experienced in internal systems, web apps, databases, and cloud deployment using Python, PHP, SQL, and GCP.',
];

$ogImage = '/assets/images/photos/bart-opengraph.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require dirname(__DIR__) . '/templates/opengraph-meta.php'; ?>
    <title>Bartolomeus Bima | Official Portfolio</title>
    <link rel="stylesheet" href="/assets/css/fonts.css">    <link rel="stylesheet" href="/assets/css/cv.css">
</head>
<body>
    <div class="cv-preview-shell">
        <div class="cv-preview-toolbar">
            <div class="cv-preview-actions">
                <a class="cv-preview-action" href="/contact">Back to Contact</a>
                <button class="cv-preview-action cv-preview-action-primary" type="button" onclick="window.print()">Print / Save PDF</button>
            </div>
        </div>

        <main class="cv-sheet">
            <aside class="cv-navbar">
                <div class="cv-photo">
                    <img src="/assets/images/photos/bart.png" alt="Profile portrait">
                </div>

                <h1 class="cv-name"><?= htmlspecialchars($personal['full_name'], ENT_QUOTES, 'UTF-8'); ?></h1>
                <p class="cv-headline"><?= htmlspecialchars($personal['headline'], ENT_QUOTES, 'UTF-8'); ?></p>

                <section class="cv-section">
                    <h2 class="cv-section-title">Personal Profile</h2>
                    <p class="cv-copy"><?= htmlspecialchars($personal['summary'], ENT_QUOTES, 'UTF-8'); ?></p>
                </section>

                <section class="cv-section">
                    <h2 class="cv-section-title">Contact</h2>
                    <ul class="cv-contact-list">
                        <li><span class="cv-contact-label">Location</span><span class="cv-contact-value"><?= htmlspecialchars($personal['location'], ENT_QUOTES, 'UTF-8'); ?></span></li>
                        <li><span class="cv-contact-label">Email</span><span class="cv-contact-value"><?= htmlspecialchars($personal['email'], ENT_QUOTES, 'UTF-8'); ?></span></li>
                        <li><span class="cv-contact-label">Phone</span><span class="cv-contact-value"><?= htmlspecialchars($personal['phone'], ENT_QUOTES, 'UTF-8'); ?></span></li>
                        <li><span class="cv-contact-label">Website</span><span class="cv-contact-value"><?= htmlspecialchars($personal['website'], ENT_QUOTES, 'UTF-8'); ?></span></li>
                        <li><span class="cv-contact-label">LinkedIn</span><span class="cv-contact-value"><?= htmlspecialchars($personal['linkedin'], ENT_QUOTES, 'UTF-8'); ?></span></li>
                    </ul>
                </section>

                <section class="cv-section">
                    <h2 class="cv-section-title">Languages</h2>
                    <ul class="cv-language-list">
                        <li><span class="cv-contact-label">Indonesian</span><span class="cv-language-copy">Native</span></li>
                        <li><span class="cv-contact-label">English</span><span class="cv-language-copy">Reading and comprehension good, speaking basic conversational</span></li>
                    </ul>
                </section>

                <section class="cv-section">
                    <h2 class="cv-section-title">Education</h2>
                    <p class="cv-copy"><strong>Universitas Kristen Satya Wacana</strong><br>Bachelor of Computer Science<br>Aug 2018 - Oct 2022<br>GPA: 3.96 / 4.00</p>
                </section>
            </aside>

            <section class="cv-main">
                <header class="cv-main-header">
                    <div>
                        <p class="cv-main-title">Curriculum Vitae Preview</p>

                    </div>
                </header>

                <section class="cv-grid">
                    <div class="cv-card">
                        <h2 class="cv-card-title">Professional Experience</h2>
                        <?php foreach ($companies as $company): ?>
                            <?php $projectNames = $companyProjects[$company['mwc_id']] ?? []; ?>
                            <article class="cv-entry">
                                <div class="cv-entry-header">
                                    <div>
                                        <h3 class="cv-entry-title"><?= htmlspecialchars($company['mwc_name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                        <p class="cv-entry-subtitle"><?= htmlspecialchars(cvEmploymentTypeLabel($company['mwc_employment_type'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
                                    </div>
                                    <span class="cv-entry-period"><?= htmlspecialchars(cvYearRange($company['mwc_year_start'] ?? '', $company['mwc_year_end'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></span>
                                </div>
                                <p class="cv-entry-copy"><?= htmlspecialchars(trim((string) ($company['mwc_overview_en'] ?? '')), ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php if (!empty($projectNames)): ?>
                                    <ul class="cv-project-list">
                                        <?php foreach ($projectNames as $projectName): ?>
                                            <li class="cv-project-item"><?= htmlspecialchars($projectName, ENT_QUOTES, 'UTF-8'); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <div class="cv-card">
                        <h2 class="cv-card-title">Skills &amp; Tools</h2>
                        <div class="cv-skill-list">
                            <?php foreach (array_slice($techNames, 0, 10) as $techName): ?>
                                <span class="cv-skill-chip"><?= htmlspecialchars($techName, ENT_QUOTES, 'UTF-8'); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            </section>
        </main>
    </div>
</body>
</html>




