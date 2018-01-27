<?php


namespace Classes\Controller;

use Classes\Domain\Modal\Project;
use Classes\Domain\Repository\ProjectsRepository;
use Classes\Service\ProjectsService;
use Classes\Service\SqlConnectionService;
use Classes\Utility\GeneralUtility;

/**
 * Class ProjectsController
 * @package Classes\Controller
 */
class ProjectsController
{

	private $projectId = null;
	private $projectService;

	/**
	 * ProjectsController constructor.
	 */
	public function __construct()
	{

		$this->projectService = new ProjectsService();

		if (!empty($_GET["id"])) {
            $this->projectId = $_GET["id"];

            if (!$this->projectService->projectAccess($this->projectId, $_SESSION["uuid"])) {
                GeneralUtility::kill("Request denied.");
            }
        }


	}

	/**
     * Listing all the projects under a user
     *
     * @return array
     */
    public function listProjects()
    {

		$data = ProjectsRepository::findByUser($_SESSION["uuid"]);
		return array("data" => $data);

    }

    /**
     * Creating a new project
     */
    public function newProject()
    {

        GeneralUtility::checkReqFields(array("name"), $_POST);

        $project = new Project();
        $project->create($_POST["name"], $_SESSION["uuid"]);

    }

    /**
     * Breaking the project
     *
     */
    public function pauseProject()
    {
        $this->requireProjectId();
		$this->projectService->pauseProject($this->projectId);
    }

    /**
     * Starting the project
     *
     */
    public function startProject()
    {
        $this->requireProjectId();
        $this->projectService->startProject($this->projectId);

    }

    /**
     * Disabling / deactivating the project
     *
     */
    public function deactivateProject()
    {
        $this->requireProjectId();
        $this->projectService->deactivateProject($this->projectId);

    }

    /**
     * Requiring the project id
     */
    protected function requireProjectId() {
        if (empty($this->projectId) || !is_numeric($this->projectId)) {
            GeneralUtility::kill("Project id is required");
        }
    }

}
