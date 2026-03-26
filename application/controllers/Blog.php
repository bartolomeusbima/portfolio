<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../models/View.php';

$view = new View();
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
$mode = isset($_GET['mode']) ? trim($_GET['mode']) : 'list';

try {
    if ($mode === 'detail') {
        if ($slug === '') {
            echo json_encode(array('status' => false, 'message' => 'Slug is required.'));
            exit;
        }

        $blogHead = $view->getBlogHeadBySlug($slug);
        if (!$blogHead['status']) {
            echo json_encode($blogHead);
            exit;
        }

        if (empty($blogHead['data'])) {
            echo json_encode(array('status' => false, 'message' => 'Blog article not found.'));
            exit;
        }

        $blogDetail = $view->getBlogDetailByHeadId($blogHead['data']['mbh_id']);
        if (!$blogDetail['status']) {
            echo json_encode($blogDetail);
            exit;
        }

        echo json_encode(array(
            'status' => true,
            'data' => array(
                'head' => $blogHead['data'],
                'sections' => $blogDetail['data']
            )
        ));
        exit;
    }

    $blogList = $view->getBlogList();
    echo json_encode($blogList);
} catch (Throwable $e) {
    error_log($e->getMessage());
    echo json_encode(array('status' => false, 'message' => 'Internal server error.'));
}
