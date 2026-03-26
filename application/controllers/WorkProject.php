<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../models/View.php';

$view = new View();
$companySlug = isset($_GET['company_slug']) ? trim((string) $_GET['company_slug']) : '';
$projectSlug = isset($_GET['project_slug']) ? trim((string) $_GET['project_slug']) : '';
$projectId = isset($_GET['project_id']) ? trim((string) $_GET['project_id']) : '';
$mode = isset($_GET['mode']) ? trim((string) $_GET['mode']) : 'detail';
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 4;

try {
    if ($mode === 'explore') {
        echo json_encode($view->getExploreProjects($projectId !== '' ? $projectId : null, $limit));
        exit;
    }

    if ($companySlug === '' || $projectSlug === '') {
        echo json_encode(array('status' => false, 'message' => 'Company slug and project slug are required.'));
        exit;
    }

    $project = $view->getWorkProjectBySlugs($companySlug, $projectSlug);
    if (!$project['status']) {
        echo json_encode($project);
        exit;
    }

    if (empty($project['data'])) {
        echo json_encode(array('status' => false, 'message' => 'Work project not found.'));
        exit;
    }

    if ($mode === 'skills') {
        echo json_encode($view->getSkillsByProjectId($project['data']['mwp_id']));
        exit;
    }

    echo json_encode($project);
} catch (Throwable $e) {
    error_log($e->getMessage());
    echo json_encode(array('status' => false, 'message' => 'Internal server error.'));
}
