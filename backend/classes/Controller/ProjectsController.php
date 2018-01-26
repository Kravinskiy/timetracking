<?php


namespace Classes\Controller;

use Classes\Modal\Repository\ProjectsRepository;
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

	/**
	 * ProjectsController constructor.
	 */
	public function __construct()
	{

		$this->projectService = new ProjectsService();

		if (empty($_GET["id"])) {
			GeneralUtility::kill("Project id is required.");
		} else {
			$this->projectId = $_GET["id"];
		}

		if ($this->projectService->projectAccess($this->projectId, $_SESSION["uuid"]))
			GeneralUtility::kill("Request denied.");

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
        $this->projectService->newProject($_POST["name"], $_SESSION["uuid"]);



    }

    /**
     * Breaking the project
     *
     */
    public function pauseProject()
    {

		$this->projectService->pauseProject($this->projectId);

    }

    /**
     * Starting the project
     *
     */
    public function startProject()
    {

        $this->projectService->startProject($this->projectId);

    }

    /**
     * Disabling / deactivating the project
     *
     */
    public function deactivateProject()
    {

        $this->projectService->deactivateProject($this->projectId);

    }

}
