<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../models/View.php';

$view = new View();
$mode = isset($_GET['mode']) ? trim((string) $_GET['mode']) : 'company-list';

try {
    if ($mode === 'project-list') {
        echo json_encode($view->getWorkProjectList());
        exit;
    }

    echo json_encode($view->getWorkCompanyList());
} catch (Throwable $e) {
    error_log($e->getMessage());
    echo json_encode(array('status' => false, 'message' => 'Internal server error.'));
}
