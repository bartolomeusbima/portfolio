<?php
require_once dirname(__DIR__) . '/application/models/View.php';

function resumeTextLength($text)
{
    return function_exists('mb_strlen') ? mb_strlen($text) : strlen($text);
}

function resumeTextSlice($text, $start, $length = null)
{
    if (function_exists('mb_substr')) {
        return $length === null ? mb_substr($text, $start) : mb_substr($text, $start, $length);
    }

    return $length === null ? substr($text, $start) : substr($text, $start, $length);
}

function resumeNormalizeSpace($text)
{
    return trim(preg_replace('/\s+/', ' ', (string) $text));
}

function resumeTrimText($text, $limit = 180)
{
    $text = resumeNormalizeSpace($text);
    if ($text === '') {
        return '';
    }

    if (resumeTextLength($text) <= $limit) {
        return $text;
    }

    return rtrim(resumeTextSlice($text, 0, $limit - 3)) . '...';
}

function resumeRole($value)
{
    return trim(str_replace('Role:', '', (string) $value));
}

function resumeYearFromDate($value)
{
    $value = trim((string) $value);
    if ($value === '') {
        return '';
    }

    return substr($value, 0, 4);
}

function resumeCompanyPeriod($company)
{
    $start = trim((string) ($company['mwc_year_start'] ?? ''));
    $end = trim((string) ($company['mwc_year_end'] ?? ''));

    if ($start === '') {
        return $end !== '' ? $end : 'present';
    }

    return $start . ' - ' . ($end !== '' ? $end : 'present');
}

function resumeStatusFromProjects($projects)
{
    foreach ($projects as $project) {
        if (empty($project['mwp_end_date'])) {
            return 'On-Going';
        }
    }

    return 'Done';
}

function resumePublicLinkFromProjects($projects)
{
    foreach ($projects as $project) {
        $url = trim((string) ($project['mwp_destination_url'] ?? ''));
        if ($url === '') {
            continue;
        }

        $host = parse_url($url, PHP_URL_HOST);
        if (is_string($host) && $host !== '') {
            return preg_replace('/^www\./', '', $host);
        }

        return $url;
    }

    return '<<private>>';
}

$view = new View();
$companies = $view->getWorkCompanyList()['data'] ?? [];
$projects = $view->getWorkProjectList()['data'] ?? [];
$skillList = $view->getSkillList()['data'] ?? [];

$projectsByCompanyId = [];
foreach ($projects as $project) {
    $companyId = $project['mwp_mwc_id'] ?? null;
    if ($companyId === null) {
        continue;
    }

    if (!isset($projectsByCompanyId[$companyId])) {
        $projectsByCompanyId[$companyId] = [];
    }

    $projectsByCompanyId[$companyId][] = $project;
}

$corporateCompanies = [];
$freelanceCompanies = [];

foreach ($companies as $company) {
    $employmentType = trim((string) ($company['mwc_employment_type'] ?? ''));
    if ($employmentType === 'FT') {
        $corporateCompanies[] = $company;
    } elseif ($employmentType === 'FL') {
        $freelanceCompanies[] = $company;
    }
}

$freelanceCompaniesPageOne = array_slice($freelanceCompanies, 0, 2);
$freelanceCompaniesOverflow = array_slice($freelanceCompanies, 2);

$personal = [
    'full_name' => 'Bartolomeus Bima Santoso',
    'location' => 'Banten, Indonesia 15334',
    'email' => 'bm.santoso123@gmail.com',
    'phone' => '(+62) 87889384936',
    'linkedin' => 'linkedin.com/in/bartolomeus-bima-santoso',
    'profile' => 'IT professional specializing in backend development, databases, and cloud deployment. Experienced in modernizing enterprise HR systems and delivering full-stack web apps as a freelancer. Skilled in Python, PHP, SQL (PostgreSQL, Oracle), and GCP, with proven results such as cutting onboarding time by 95% and boosting system performance by 90%.',
];

$skillLabels = [
    'PL' => 'Programming',
    'DB' => 'Database',
    'CD' => 'Cloud & DevOps',
    'LT' => 'Libraries & Tools',
    'WS' => 'Web',
];

$skills = [];
foreach ($skillLabels as $type => $label) {
    $skills[$label] = [];
}

foreach ($skillList as $skill) {
    $type = trim((string) ($skill['msk_type'] ?? ''));
    $name = trim((string) ($skill['msk_name'] ?? ''));
    if ($name === '' || !isset($skillLabels[$type])) {
        continue;
    }

    $skills[$skillLabels[$type]][] = $name;
}

$skills = array_filter($skills, function ($items) {
    return !empty($items);
});

$languages = [
    ['label' => 'English', 'value' => 'Reading and comprehension - good; speaking - basic conversational'],
    ['label' => 'Indonesian', 'value' => 'Native'],
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
    <link rel="stylesheet" href="/assets/css/resume.css">
</head>
<body>
    <div class="preview-shell">
        <div class="preview-toolbar">
            <div class="preview-actions">
                <a class="preview-action" href="/contact">Back to Contact</a>
                <button class="preview-action preview-action-primary" type="button" onclick="window.print()">Print / Save PDF</button>
            </div>
        </div>

        <div class="resume-stack">
            <main class="resume-page">
                <header class="resume-header">
                    <h1 class="resume-name"><?= htmlspecialchars($personal['full_name'], ENT_QUOTES, 'UTF-8'); ?></h1>
                    <div class="resume-contact-line">
                        <?= htmlspecialchars($personal['location'], ENT_QUOTES, 'UTF-8'); ?>
                        &nbsp;|&nbsp; Email: <?= htmlspecialchars($personal['email'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <div class="resume-contact-line">
                        Phone: <?= htmlspecialchars($personal['phone'], ENT_QUOTES, 'UTF-8'); ?>
                        &nbsp;|&nbsp; <?= htmlspecialchars($personal['linkedin'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                </header>

                <section class="resume-section">
                    <h2 class="resume-section-title">Personal Profile</h2>
                    <p class="resume-paragraph"><?= htmlspecialchars($personal['profile'], ENT_QUOTES, 'UTF-8'); ?></p>
                </section>

                <section class="resume-section">
                    <h2 class="resume-section-title">Professional Experiences</h2>

                    <?php foreach ($corporateCompanies as $company): ?>
                        <?php $companyProjects = array_slice($projectsByCompanyId[$company['mwc_id']] ?? [], 0, 5); ?>
                        <article class="experience-item">
                            <div class="experience-head">
                                <h3 class="experience-title"><?= htmlspecialchars(resumeRole($company['mwc_role_en'] ?? $company['mwc_name']), ENT_QUOTES, 'UTF-8'); ?></h3>
                                <div class="experience-period"><?= htmlspecialchars(resumeCompanyPeriod($company), ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                            <p class="experience-company"><?= htmlspecialchars($company['mwc_name'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <ul class="experience-bullets">
                                <?php foreach ($companyProjects as $project): ?>
                                    <li><strong><?= htmlspecialchars($project['mwp_title_en'] ?? '', ENT_QUOTES, 'UTF-8'); ?>:</strong> <?= htmlspecialchars(resumeTrimText($project['mwp_overview_en'] ?? '', 150), ENT_QUOTES, 'UTF-8'); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </article>
                    <?php endforeach; ?>

                    <?php if (!empty($freelanceCompaniesPageOne)): ?>
                        <article class="experience-item">
                            <div class="experience-head">
                                <h3 class="experience-title">Freelance Website Developer</h3>
                                <div class="experience-period">2023 - present</div>
                            </div>
                            <ul class="experience-bullets">
                                <?php foreach ($freelanceCompaniesPageOne as $company): ?>
                                    <?php $companyProjects = array_slice($projectsByCompanyId[$company['mwc_id']] ?? [], 0, 5); ?>
                                    <?php $primaryProject = $companyProjects[0] ?? null; ?>
                                    <li class="project-entry">
                                        <div class="project-title"><?= htmlspecialchars($company['mwc_name'], ENT_QUOTES, 'UTF-8'); ?></div>
                                        <ul class="meta-bullets">
                                            <li><strong>Role :</strong> <?= htmlspecialchars(resumeRole(($primaryProject['mwp_role_en'] ?? null) ?: ($company['mwc_role_en'] ?? '')), ENT_QUOTES, 'UTF-8'); ?></li>
                                            <li><strong>Status :</strong> <?= htmlspecialchars(resumeStatusFromProjects($companyProjects), ENT_QUOTES, 'UTF-8'); ?></li>
                                            <li><strong>Link :</strong> <?= htmlspecialchars(resumePublicLinkFromProjects($companyProjects), ENT_QUOTES, 'UTF-8'); ?></li>
                                        </ul>
                                        <ul class="project-bullets">
                                            <?php foreach ($companyProjects as $project): ?>
                                                <li><strong><?= htmlspecialchars($project['mwp_title_en'] ?? '', ENT_QUOTES, 'UTF-8'); ?>:</strong> <?= htmlspecialchars(resumeTrimText($project['mwp_overview_en'] ?? '', 145), ENT_QUOTES, 'UTF-8'); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </article>
                    <?php endif; ?>
                </section>
            </main>

            <main class="resume-page page-break">
                <?php if (!empty($freelanceCompaniesOverflow)): ?>
                    <section class="resume-section resume-section-first">
                        <ul class="experience-bullets experience-bullets-continued">
                            <?php foreach ($freelanceCompaniesOverflow as $company): ?>
                                <?php $companyProjects = array_slice($projectsByCompanyId[$company['mwc_id']] ?? [], 0, 5); ?>
                                <?php $primaryProject = $companyProjects[0] ?? null; ?>
                                <li class="project-entry">
                                    <div class="project-title"><?= htmlspecialchars($company['mwc_name'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    <ul class="meta-bullets">
                                        <li><strong>Role :</strong> <?= htmlspecialchars(resumeRole(($primaryProject['mwp_role_en'] ?? null) ?: ($company['mwc_role_en'] ?? '')), ENT_QUOTES, 'UTF-8'); ?></li>
                                        <li><strong>Status :</strong> <?= htmlspecialchars(resumeStatusFromProjects($companyProjects), ENT_QUOTES, 'UTF-8'); ?></li>
                                        <li><strong>Link :</strong> <?= htmlspecialchars(resumePublicLinkFromProjects($companyProjects), ENT_QUOTES, 'UTF-8'); ?></li>
                                    </ul>
                                    <ul class="project-bullets">
                                        <?php foreach ($companyProjects as $project): ?>
                                            <li><strong><?= htmlspecialchars($project['mwp_title_en'] ?? '', ENT_QUOTES, 'UTF-8'); ?>:</strong> <?= htmlspecialchars(resumeTrimText($project['mwp_overview_en'] ?? '', 145), ENT_QUOTES, 'UTF-8'); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                <?php endif; ?>

                <section class="resume-section">
                    <h2 class="resume-section-title">Education</h2>
                    <div class="education-row">
                        <div>
                            <strong>Universitas Kristen Satya Wacana</strong>
                            <div><em>Bachelor of Computer Science - Teknik Informatika.</em></div>
                            <div>(GPA: 3.96 / 4.00)</div>
                        </div>
                        <div>August 2018 - October 2022</div>
                    </div>
                </section>

                <section class="resume-section">
                    <h2 class="resume-section-title">Skills &amp; Tools</h2>
                    <ul class="skill-list">
                        <?php foreach ($skills as $label => $items): ?>
                            <li><strong><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>:</strong> <?= htmlspecialchars(implode(', ', $items), ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>

                <section class="resume-section">
                    <h2 class="resume-section-title">Language and Additional Skills</h2>
                    <?php foreach ($languages as $language): ?>
                        <div class="language-row">
                            <div class="language-label"><strong><?= htmlspecialchars($language['label'], ENT_QUOTES, 'UTF-8'); ?></strong></div>
                            <div><?= htmlspecialchars($language['value'], ENT_QUOTES, 'UTF-8'); ?></div>
                        </div>
                    <?php endforeach; ?>
                </section>
            </main>
        </div>
    </div>
</body>
</html>
