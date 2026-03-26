<?php
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

$routes = [
    '/' => __DIR__ . '/pages/home-page.php',
    '/api/blog' => __DIR__ . '/application/controllers/Blog.php',
    '/api/work' => __DIR__ . '/application/controllers/Work.php',
    '/api/work/company' => __DIR__ . '/application/controllers/WorkCompany.php',
    '/api/work/project' => __DIR__ . '/application/controllers/WorkProject.php',
    '/blog' => __DIR__ . '/pages/blog-page.php',
    '/about' => __DIR__ . '/pages/about-page.php',
    '/contact' => __DIR__ . '/pages/contact-page.php',
    '/work' => __DIR__ . '/pages/work-page.php',
    '/work/projects' => __DIR__ . '/pages/work-page.php',
    '/preview-cv' => __DIR__ . '/pages/preview-cv.php',
    '/preview-resume' => __DIR__ . '/pages/preview-resume.php',
];

if (strpos($path, '/blog/') === 0) {
    $blogSlug = trim(substr($path, strlen('/blog/')), '/');
    if ($blogSlug !== '') {
        require __DIR__ . '/pages/blog-detail.php';
        return;
    }
}

if (strpos($path, '/work/') === 0) {
    $workPath = trim(substr($path, strlen('/work/')), '/');

    if ($workPath !== '' && $workPath !== 'projects') {
        $segments = array_values(array_filter(explode('/', $workPath), 'strlen'));

        if (count($segments) === 1) {
            $workCompanySlug = $segments[0];
            require __DIR__ . '/pages/work-company.php';
            return;
        }

        if (count($segments) === 2) {
            $workCompanySlug = $segments[0];
            $workProjectSlug = $segments[1];
            require __DIR__ . '/pages/work-project.php';
            return;
        }
    }
}

$legacyProjectAliases = [
    '/alfamart-pin-reset' => ['alfamart', 'pin-reset'],
    '/alfamart-pin-reset.php' => ['alfamart', 'pin-reset'],
    '/alfamart-pin-reset-bangladesh' => ['alfamart', 'pin-reset-bangladesh'],
    '/alfamart-pin-reset-bangladesh.php' => ['alfamart', 'pin-reset-bangladesh'],
];

if (isset($legacyProjectAliases[$path])) {
    [$workCompanySlug, $workProjectSlug] = $legacyProjectAliases[$path];
    require __DIR__ . '/pages/work-project.php';
    return;
}

if (!isset($routes[$path])) {
    require __DIR__ . '/pages/not-found.php';
    return;
}

require $routes[$path];

