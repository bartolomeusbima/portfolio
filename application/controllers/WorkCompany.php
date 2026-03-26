<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../models/View.php';

$view = new View();
$slug = isset($_GET['slug']) ? trim((string) $_GET['slug']) : '';
$mode = isset($_GET['mode']) ? trim((string) $_GET['mode']) : 'detail';

try {
    if ($slug === '') {
        echo json_encode(array('status' => false, 'message' => 'Slug is required.'));
        exit;
    }

    $company = $view->getWorkCompanyBySlug($slug);
    if (!$company['status']) {
        echo json_encode($company);
        exit;
    }

    if (empty($company['data'])) {
        echo json_encode(array('status' => false, 'message' => 'Work company not found.'));
        exit;
    }

    $companyId = $company['data']['mwc_id'];

    if ($mode === 'projects') {
        echo json_encode($view->getWorkProjectsByCompanyId($companyId));
        exit;
    }

    if ($mode === 'featured') {
        echo json_encode($view->getFeaturedWorkProjectsByCompanyId($companyId));
        exit;
    }

    if ($mode === 'timeline') {
        echo json_encode($view->getWorkCompanyTimelineByCompanyId($companyId));
        exit;
    }

    echo json_encode($company);
} catch (Throwable $e) {
    error_log($e->getMessage());
    echo json_encode(array('status' => false, 'message' => 'Internal server error.'));
}
