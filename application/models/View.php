<?php
require_once __DIR__ . '/Execute.php';
require_once __DIR__ . '/../configs/env_loader.php';

class View
{
    private $exec;
    private const ACTIVE_BLOG_STATUS = array('Y', 'P');

    public function __construct($config = array())
    {
        $dbConfig = $this->resolveDbConfig($config);
        $this->exec = null;

        try {
            $this->exec = new Execute($dbConfig);
        } catch (Throwable $e) {
            $this->exec = null;
        }
    }

    private function resolveDbConfig($config)
    {
        if (!is_array($config)) {
            $config = array();
        }

        loadAppEnvFiles(dirname(__DIR__, 2));

        return array(
            'host' => $config['host'] ?? getenv('DB_HOST') ?: '',
            'dbname' => $config['dbname'] ?? getenv('DB_NAME') ?: '',
            'username' => $config['username'] ?? getenv('DB_USER') ?: '',
            'password' => $config['password'] ?? getenv('DB_PASS') ?: '',
            'port' => $config['port'] ?? getenv('DB_PORT') ?: '3306',
            'driver' => $config['driver'] ?? getenv('DB_DRIVER') ?: 'mysql',
            'charset' => $config['charset'] ?? getenv('DB_CHARSET') ?: 'utf8mb4',
        );
    }

    private function decodeStructuredField($value, $fallback = array())
    {
        if (!is_string($value) || trim($value) === '') {
            return $fallback;
        }

        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : $fallback;
    }

    private function mapWorkProjectRow($row)
    {
        if (!is_array($row)) {
            return null;
        }

        $row['company'] = array(
            'mwc_id' => $row['company_mwc_id'] ?? null,
            'mwc_slug' => $row['company_mwc_slug'] ?? null,
            'mwc_name' => $row['company_mwc_name'] ?? null,
            'mwc_title_en' => $row['company_mwc_title_en'] ?? null,
            'mwc_title_id' => $row['company_mwc_title_id'] ?? null,
            'mwc_employment_type' => $row['company_mwc_employment_type'] ?? null,
            'mwc_role_en' => $row['company_mwc_role_en'] ?? null,
            'mwc_role_id' => $row['company_mwc_role_id'] ?? null,
            'mwc_overview_en' => $row['company_mwc_overview_en'] ?? null,
            'mwc_overview_id' => $row['company_mwc_overview_id'] ?? null,
            'mwc_summary_en' => $row['company_mwc_summary_en'] ?? null,
            'mwc_summary_id' => $row['company_mwc_summary_id'] ?? null,
            'mwc_thumbnail' => $row['company_mwc_thumbnail'] ?? null,
            'mwc_year_start' => $row['company_mwc_year_start'] ?? null,
            'mwc_year_end' => $row['company_mwc_year_end'] ?? null,
            'mwc_status' => $row['company_mwc_status'] ?? null,
        );

        unset(
            $row['company_mwc_id'],
            $row['company_mwc_slug'],
            $row['company_mwc_name'],
            $row['company_mwc_title_en'],
            $row['company_mwc_title_id'],
            $row['company_mwc_employment_type'],
            $row['company_mwc_role_en'],
            $row['company_mwc_role_id'],
            $row['company_mwc_overview_en'],
            $row['company_mwc_overview_id'],
            $row['company_mwc_summary_en'],
            $row['company_mwc_summary_id'],
            $row['company_mwc_thumbnail'],
            $row['company_mwc_year_start'],
            $row['company_mwc_year_end'],
            $row['company_mwc_status']
        );

        $row['mwp_responsibilities_en'] = $this->decodeStructuredField($row['mwp_responsibilities_en'] ?? '[]');
        $row['mwp_responsibilities_id'] = $this->decodeStructuredField($row['mwp_responsibilities_id'] ?? '[]');
        $row['mwp_problem_solution_en'] = $this->decodeStructuredField($row['mwp_problem_solution_en'] ?? '{}', array());
        $row['mwp_problem_solution_id'] = $this->decodeStructuredField($row['mwp_problem_solution_id'] ?? '{}', array());
        $row['mwp_application_flow_en'] = $this->decodeStructuredField($row['mwp_application_flow_en'] ?? '[]');
        $row['mwp_application_flow_id'] = $this->decodeStructuredField($row['mwp_application_flow_id'] ?? '[]');
        $row['mwp_technical_notes_en'] = $this->decodeStructuredField($row['mwp_technical_notes_en'] ?? '{}', array());
        $row['mwp_technical_notes_id'] = $this->decodeStructuredField($row['mwp_technical_notes_id'] ?? '{}', array());

        return $row;
    }

    public function getWorkCompanyList()
    {
        if (!($this->exec instanceof Execute)) {
            return array('status' => true, 'message' => '', 'data' => array());
        }

        return $this->exec->executeSelect(
            "SELECT
                mwc_id,
                mwc_slug,
                mwc_name,
                mwc_title_en,
                mwc_title_id,
                mwc_employment_type,
                mwc_role_en,
                mwc_role_id,
                mwc_overview_en,
                mwc_overview_id,
                mwc_summary_en,
                mwc_summary_id,
                mwc_thumbnail,
                mwc_banner_1,
                mwc_banner_2,
                mwc_banner_3,
                mwc_banner_4,
                mwc_year_start,
                mwc_year_end,
                mwc_sort_order,
                mwc_status,
                mwc_create_date,
                mwc_update_date
            FROM ms_work_company
            WHERE mwc_status = ?
            ORDER BY mwc_sort_order ASC, mwc_id ASC",
            array('Y')
        );
    }

    public function getWorkCompanyBySlug($slug)
    {
        if (!($this->exec instanceof Execute)) {
            return array('status' => true, 'message' => '', 'data' => null);
        }

        $response = $this->exec->executeSelect(
            "SELECT
                mwc_id,
                mwc_slug,
                mwc_name,
                mwc_title_en,
                mwc_title_id,
                mwc_employment_type,
                mwc_role_en,
                mwc_role_id,
                mwc_overview_en,
                mwc_overview_id,
                mwc_summary_en,
                mwc_summary_id,
                mwc_thumbnail,
                mwc_banner_1,
                mwc_banner_2,
                mwc_banner_3,
                mwc_banner_4,
                mwc_year_start,
                mwc_year_end,
                mwc_sort_order,
                mwc_status,
                mwc_create_date,
                mwc_update_date
            FROM ms_work_company
            WHERE mwc_slug = ? AND mwc_status = ?
            LIMIT 1",
            array($slug, 'Y'),
            'row'
        );

        if ($response['status'] && $response['data'] === false) {
            $response['data'] = null;
        }

        return $response;
    }

    public function getWorkProjectsByCompanyId($companyId)
    {
        if (!($this->exec instanceof Execute)) {
            return array('status' => true, 'message' => '', 'data' => array());
        }

        $response = $this->exec->executeSelect(
            "SELECT
                p.*,
                c.mwc_id AS company_mwc_id,
                c.mwc_slug AS company_mwc_slug,
                c.mwc_name AS company_mwc_name,
                c.mwc_title_en AS company_mwc_title_en,
                c.mwc_title_id AS company_mwc_title_id,
                c.mwc_employment_type AS company_mwc_employment_type,
                c.mwc_role_en AS company_mwc_role_en,
                c.mwc_role_id AS company_mwc_role_id,
                c.mwc_overview_en AS company_mwc_overview_en,
                c.mwc_overview_id AS company_mwc_overview_id,
                c.mwc_summary_en AS company_mwc_summary_en,
                c.mwc_summary_id AS company_mwc_summary_id,
                c.mwc_thumbnail AS company_mwc_thumbnail,
                c.mwc_year_start AS company_mwc_year_start,
                c.mwc_year_end AS company_mwc_year_end,
                c.mwc_status AS company_mwc_status
            FROM ms_work_project p
            INNER JOIN ms_work_company c
                ON c.mwc_id = p.mwp_mwc_id
            WHERE p.mwp_mwc_id = ?
              AND p.mwp_status = ?
              AND c.mwc_status = ?
            ORDER BY p.mwp_sort_order ASC, p.mwp_id ASC",
            array($companyId, 'Y', 'Y')
        );

        if (!$response['status']) {
            return $response;
        }

        foreach ($response['data'] as &$row) {
            $row = $this->mapWorkProjectRow($row);
        }
        unset($row);

        return $response;
    }

    public function getFeaturedWorkProjectsByCompanyId($companyId)
    {
        if (!($this->exec instanceof Execute)) {
            return array('status' => true, 'message' => '', 'data' => array());
        }

        $response = $this->exec->executeSelect(
            "SELECT
                p.*,
                c.mwc_id AS company_mwc_id,
                c.mwc_slug AS company_mwc_slug,
                c.mwc_name AS company_mwc_name,
                c.mwc_title_en AS company_mwc_title_en,
                c.mwc_title_id AS company_mwc_title_id,
                c.mwc_employment_type AS company_mwc_employment_type,
                c.mwc_role_en AS company_mwc_role_en,
                c.mwc_role_id AS company_mwc_role_id,
                c.mwc_overview_en AS company_mwc_overview_en,
                c.mwc_overview_id AS company_mwc_overview_id,
                c.mwc_summary_en AS company_mwc_summary_en,
                c.mwc_summary_id AS company_mwc_summary_id,
                c.mwc_thumbnail AS company_mwc_thumbnail,
                c.mwc_year_start AS company_mwc_year_start,
                c.mwc_year_end AS company_mwc_year_end,
                c.mwc_status AS company_mwc_status
            FROM ms_work_project p
            INNER JOIN ms_work_company c
                ON c.mwc_id = p.mwp_mwc_id
            WHERE p.mwp_mwc_id = ?
              AND p.mwp_is_featured = ?
              AND p.mwp_status = ?
              AND c.mwc_status = ?
            ORDER BY p.mwp_sort_order ASC, p.mwp_id ASC",
            array($companyId, 'Y', 'Y', 'Y')
        );

        if (!$response['status']) {
            return $response;
        }

        foreach ($response['data'] as &$row) {
            $row = $this->mapWorkProjectRow($row);
        }
        unset($row);

        return $response;
    }

    public function getWorkCompanyTimelineByCompanyId($companyId)
    {
        if (!($this->exec instanceof Execute)) {
            return array('status' => true, 'message' => '', 'data' => array());
        }

        $response = $this->exec->executeSelect(
            "SELECT
                t.mwt_mwc_id,
                t.mwt_sort_order,
                t.mwt_type,
                t.mwt_mwp_id,
                t.mwt_title_en,
                t.mwt_title_id,
                t.mwt_body_en,
                t.mwt_body_id,
                t.mwt_date_label,
                t.mwt_create_date,
                t.mwt_update_date,
                p.mwp_id,
                p.mwp_mwc_id,
                p.mwp_slug,
                p.mwp_title_en,
                p.mwp_title_id,
                p.mwp_subtitle_en,
                p.mwp_subtitle_id,
                p.mwp_type,
                p.mwp_start_date,
                p.mwp_end_date,
                p.mwp_role_en,
                p.mwp_role_id,
                p.mwp_destination_url,
                p.mwp_is_internal,
                p.mwp_thumbnail,
                p.mwp_overview_en,
                p.mwp_overview_id,
                p.mwp_collaboration_en,
                p.mwp_collaboration_id,
                p.mwp_responsibilities_en,
                p.mwp_responsibilities_id,
                p.mwp_problem_solution_en,
                p.mwp_problem_solution_id,
                p.mwp_application_flow_en,
                p.mwp_application_flow_id,
                p.mwp_technical_notes_en,
                p.mwp_technical_notes_id,
                p.mwp_outcome_en,
                p.mwp_outcome_id,
                p.mwp_sort_order,
                p.mwp_is_featured,
                p.mwp_status
            FROM ms_work_company_timeline t
            LEFT JOIN ms_work_project p
                ON p.mwp_id = t.mwt_mwp_id
               AND p.mwp_status = ?
            WHERE t.mwt_mwc_id = ?
            ORDER BY t.mwt_sort_order ASC",
            array('Y', $companyId)
        );

        if (!$response['status']) {
            return $response;
        }

        foreach ($response['data'] as &$row) {
            $linkedProject = null;

            if (!empty($row['mwp_id'])) {
                $linkedProject = array(
                    'mwp_id' => $row['mwp_id'],
                    'mwp_mwc_id' => $row['mwp_mwc_id'],
                    'mwp_slug' => $row['mwp_slug'],
                    'mwp_title_en' => $row['mwp_title_en'],
                    'mwp_title_id' => $row['mwp_title_id'],
                    'mwp_subtitle_en' => $row['mwp_subtitle_en'],
                    'mwp_subtitle_id' => $row['mwp_subtitle_id'],
                    'mwp_type' => $row['mwp_type'],
                    'mwp_start_date' => $row['mwp_start_date'],
                    'mwp_end_date' => $row['mwp_end_date'],
                    'mwp_role_en' => $row['mwp_role_en'],
                    'mwp_role_id' => $row['mwp_role_id'],
                    'mwp_destination_url' => $row['mwp_destination_url'],
                    'mwp_is_internal' => $row['mwp_is_internal'],
                    'mwp_thumbnail' => $row['mwp_thumbnail'],
                    'mwp_overview_en' => $row['mwp_overview_en'],
                    'mwp_overview_id' => $row['mwp_overview_id'],
                    'mwp_collaboration_en' => $row['mwp_collaboration_en'],
                    'mwp_collaboration_id' => $row['mwp_collaboration_id'],
                    'mwp_responsibilities_en' => $this->decodeStructuredField($row['mwp_responsibilities_en'] ?? '[]'),
                    'mwp_responsibilities_id' => $this->decodeStructuredField($row['mwp_responsibilities_id'] ?? '[]'),
                    'mwp_problem_solution_en' => $this->decodeStructuredField($row['mwp_problem_solution_en'] ?? '{}', array()),
                    'mwp_problem_solution_id' => $this->decodeStructuredField($row['mwp_problem_solution_id'] ?? '{}', array()),
                    'mwp_application_flow_en' => $this->decodeStructuredField($row['mwp_application_flow_en'] ?? '[]'),
                    'mwp_application_flow_id' => $this->decodeStructuredField($row['mwp_application_flow_id'] ?? '[]'),
                    'mwp_technical_notes_en' => $this->decodeStructuredField($row['mwp_technical_notes_en'] ?? '{}', array()),
                    'mwp_technical_notes_id' => $this->decodeStructuredField($row['mwp_technical_notes_id'] ?? '{}', array()),
                    'mwp_outcome_en' => $row['mwp_outcome_en'],
                    'mwp_outcome_id' => $row['mwp_outcome_id'],
                    'mwp_sort_order' => $row['mwp_sort_order'],
                    'mwp_is_featured' => $row['mwp_is_featured'],
                    'mwp_status' => $row['mwp_status'],
                );
            }

            $row['project'] = $linkedProject;
            unset(
                $row['mwp_id'],
                $row['mwp_mwc_id'],
                $row['mwp_slug'],
                $row['mwp_title_en'],
                $row['mwp_title_id'],
                $row['mwp_subtitle_en'],
                $row['mwp_subtitle_id'],
                $row['mwp_type'],
                $row['mwp_start_date'],
                $row['mwp_end_date'],
                $row['mwp_role_en'],
                $row['mwp_role_id'],
                $row['mwp_destination_url'],
                $row['mwp_is_internal'],
                $row['mwp_thumbnail'],
                $row['mwp_overview_en'],
                $row['mwp_overview_id'],
                $row['mwp_collaboration_en'],
                $row['mwp_collaboration_id'],
                $row['mwp_responsibilities_en'],
                $row['mwp_responsibilities_id'],
                $row['mwp_problem_solution_en'],
                $row['mwp_problem_solution_id'],
                $row['mwp_application_flow_en'],
                $row['mwp_application_flow_id'],
                $row['mwp_technical_notes_en'],
                $row['mwp_technical_notes_id'],
                $row['mwp_outcome_en'],
                $row['mwp_outcome_id'],
                $row['mwp_sort_order'],
                $row['mwp_is_featured'],
                $row['mwp_status']
            );
        }
        unset($row);

        return $response;
    }

    public function getWorkProjectList()
    {
        if (!($this->exec instanceof Execute)) {
            return array('status' => true, 'message' => '', 'data' => array());
        }

        $response = $this->exec->executeSelect(
            "SELECT
                p.*,
                c.mwc_id AS company_mwc_id,
                c.mwc_slug AS company_mwc_slug,
                c.mwc_name AS company_mwc_name,
                c.mwc_title_en AS company_mwc_title_en,
                c.mwc_title_id AS company_mwc_title_id,
                c.mwc_employment_type AS company_mwc_employment_type,
                c.mwc_role_en AS company_mwc_role_en,
                c.mwc_role_id AS company_mwc_role_id,
                c.mwc_overview_en AS company_mwc_overview_en,
                c.mwc_overview_id AS company_mwc_overview_id,
                c.mwc_summary_en AS company_mwc_summary_en,
                c.mwc_summary_id AS company_mwc_summary_id,
                c.mwc_thumbnail AS company_mwc_thumbnail,
                c.mwc_year_start AS company_mwc_year_start,
                c.mwc_year_end AS company_mwc_year_end,
                c.mwc_status AS company_mwc_status
            FROM ms_work_project p
            INNER JOIN ms_work_company c
                ON c.mwc_id = p.mwp_mwc_id
            WHERE p.mwp_status = ?
              AND c.mwc_status = ?
            ORDER BY p.mwp_sort_order ASC, p.mwp_id ASC",
            array('Y', 'Y')
        );

        if (!$response['status']) {
            return $response;
        }

        foreach ($response['data'] as &$row) {
            $row = $this->mapWorkProjectRow($row);
        }
        unset($row);

        return $response;
    }

    public function getWorkProjectBySlugs($companySlug, $projectSlug)
    {
        if (!($this->exec instanceof Execute)) {
            return array('status' => true, 'message' => '', 'data' => null);
        }

        $response = $this->exec->executeSelect(
            "SELECT
                p.*,
                c.mwc_id AS company_mwc_id,
                c.mwc_slug AS company_mwc_slug,
                c.mwc_name AS company_mwc_name,
                c.mwc_title_en AS company_mwc_title_en,
                c.mwc_title_id AS company_mwc_title_id,
                c.mwc_employment_type AS company_mwc_employment_type,
                c.mwc_role_en AS company_mwc_role_en,
                c.mwc_role_id AS company_mwc_role_id,
                c.mwc_overview_en AS company_mwc_overview_en,
                c.mwc_overview_id AS company_mwc_overview_id,
                c.mwc_summary_en AS company_mwc_summary_en,
                c.mwc_summary_id AS company_mwc_summary_id,
                c.mwc_thumbnail AS company_mwc_thumbnail,
                c.mwc_year_start AS company_mwc_year_start,
                c.mwc_year_end AS company_mwc_year_end,
                c.mwc_status AS company_mwc_status
            FROM ms_work_project p
            INNER JOIN ms_work_company c
                ON c.mwc_id = p.mwp_mwc_id
            WHERE c.mwc_slug = ?
              AND p.mwp_slug = ?
              AND p.mwp_status = ?
              AND c.mwc_status = ?
            LIMIT 1",
            array($companySlug, $projectSlug, 'Y', 'Y'),
            'row'
        );

        if (!$response['status']) {
            return $response;
        }

        if ($response['data'] === false) {
            $response['data'] = null;
        }

        if (empty($response['data'])) {
            return $response;
        }

        $response['data'] = $this->mapWorkProjectRow($response['data']);
        return $response;
    }

    public function getSkillList()
    {
        if (!($this->exec instanceof Execute)) {
            return array('status' => true, 'message' => '', 'data' => array());
        }

        return $this->exec->executeSelect(
            "SELECT
                msk_id,
                msk_slug,
                msk_name,
                msk_icon,
                msk_type,
                msk_sort_order,
                msk_status,
                msk_create_date,
                msk_update_date
            FROM ms_skill
            WHERE msk_status = ?
            ORDER BY msk_sort_order ASC, msk_id ASC",
            array('Y')
        );
    }

    public function getSkillsByProjectId($projectId)
    {
        if (!($this->exec instanceof Execute)) {
            return array('status' => true, 'message' => '', 'data' => array());
        }

        return $this->exec->executeSelect(
            "SELECT
                s.msk_id,
                s.msk_slug,
                s.msk_name,
                s.msk_icon,
                s.msk_type,
                s.msk_sort_order,
                s.msk_status,
                s.msk_create_date,
                s.msk_update_date
            FROM ms_work_project_skill ps
            INNER JOIN ms_skill s
                ON s.msk_id = ps.mps_msk_id
            WHERE ps.mps_mwp_id = ?
              AND s.msk_status = ?
            ORDER BY ps.mps_sort_order ASC, s.msk_sort_order ASC, s.msk_id ASC",
            array($projectId, 'Y')
        );
    }

    public function getExploreProjects($currentProjectId = null, $limit = 4)
    {
        if (!($this->exec instanceof Execute)) {
            return array('status' => true, 'message' => '', 'data' => array());
        }

        $limit = max(0, (int) $limit);
        if ($limit === 0) {
            return array('status' => true, 'message' => '', 'data' => array());
        }

        $params = array('Y', 'Y');
        $whereCurrent = '';
        if ($currentProjectId !== null && $currentProjectId !== '') {
            $whereCurrent = " AND p.mwp_id <> ?";
            $params[] = $currentProjectId;
        }

        $response = $this->exec->executeSelect(
            "SELECT
                p.*,
                c.mwc_id AS company_mwc_id,
                c.mwc_slug AS company_mwc_slug,
                c.mwc_name AS company_mwc_name,
                c.mwc_title_en AS company_mwc_title_en,
                c.mwc_title_id AS company_mwc_title_id,
                c.mwc_employment_type AS company_mwc_employment_type,
                c.mwc_role_en AS company_mwc_role_en,
                c.mwc_role_id AS company_mwc_role_id,
                c.mwc_overview_en AS company_mwc_overview_en,
                c.mwc_overview_id AS company_mwc_overview_id,
                c.mwc_summary_en AS company_mwc_summary_en,
                c.mwc_summary_id AS company_mwc_summary_id,
                c.mwc_thumbnail AS company_mwc_thumbnail,
                c.mwc_year_start AS company_mwc_year_start,
                c.mwc_year_end AS company_mwc_year_end,
                c.mwc_status AS company_mwc_status
            FROM ms_work_project p
            INNER JOIN ms_work_company c
                ON c.mwc_id = p.mwp_mwc_id
            WHERE p.mwp_status = ?
              AND c.mwc_status = ?" . $whereCurrent . "
            ORDER BY p.mwp_end_date DESC, p.mwp_start_date DESC, p.mwp_sort_order ASC, p.mwp_id ASC
            LIMIT " . $limit,
            $params
        );

        if (!$response['status']) {
            return $response;
        }

        foreach ($response['data'] as &$row) {
            $row = $this->mapWorkProjectRow($row);
        }
        unset($row);

        return $response;
    }

    public function getBlogList()
    {
        if (!($this->exec instanceof Execute)) {
            return array('status' => true, 'message' => '', 'data' => array());
        }

        $response = $this->exec->executeSelect(
            "SELECT
                mbh_id,
                mbh_slug,
                mbh_title_en,
                mbh_title_id,
                mbh_type_en,
                mbh_type_id,
                mbh_image,
                mbh_create_date
            FROM ms_blog_head
            WHERE mbh_status IN (?, ?)
            ORDER BY mbh_create_date DESC, mbh_id DESC",
            self::ACTIVE_BLOG_STATUS
        );

        if ($response['status'] && $response['data'] === null) {
            $response['data'] = array();
        }

        return $response;
    }

    public function getBlogHeadBySlug($slug)
    {
        if (!($this->exec instanceof Execute)) {
            return array('status' => true, 'message' => '', 'data' => null);
        }

        $response = $this->exec->executeSelect(
            "SELECT
                mbh_id,
                mbh_slug,
                mbh_title_en,
                mbh_title_id,
                mbh_type_en,
                mbh_type_id,
                mbh_image,
                mbh_status,
                mbh_create_date,
                mbh_update_date
            FROM ms_blog_head
            WHERE mbh_slug = ? AND mbh_status IN (?, ?)
            LIMIT 1",
            array_merge(array($slug), self::ACTIVE_BLOG_STATUS),
            'row'
        );

        if ($response['status'] && $response['data'] === false) {
            $response['data'] = null;
        }

        return $response;
    }

    public function getBlogDetailByHeadId($blogHeadId)
    {
        if (!($this->exec instanceof Execute)) {
            return array('status' => true, 'message' => '', 'data' => array());
        }

        return $this->exec->executeSelect(
            "SELECT
                mbd_mbh_id,
                mbd_sort_order,
                mbd_title_en,
                mbd_title_id,
                mbd_body_en,
                mbd_body_id,
                mbd_create_date,
                mbd_update_date
            FROM ms_blog_detail
            WHERE mbd_mbh_id = ?
            ORDER BY mbd_sort_order ASC",
            array($blogHeadId)
        );
    }
}
