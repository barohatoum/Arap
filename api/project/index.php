<?php

	header('Content-type: application/json');

	$actions = ['new-project', 'delete-project'];

	$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : null;

	if (!in_array($action, $actions)) {
		echo json_encode(['success' => false, 'error' => 'Invalid action. Contact the developer of this project to resolve this issue.']);
		exit();
	}

	$request_method = $_SERVER['REQUEST_METHOD'];

	switch ($action) {
		case 'new-project':
			if ($request_method !== 'POST') {
				echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
				exit();
			}

			$project_data = json_decode(json_encode($_POST));

			if (file_exists('../../../' . $project_data->{'project-title'})) {
				echo json_encode(['success' => false, 'error' => 'Project already exists']);
				exit();
			}

			mkdir('../../../' . $project_data->{'project-title'});

			$fp = fopen('../../../' . $project_data->{'project-title'} . '/project.json', 'w');
			fwrite($fp, json_encode($project_data));
			fclose($fp);

			echo json_encode(['success' => true]);

			break;
		default:
			echo json_encode(['success' => false, 'error' => 'Invalid action. Contact the developer of this project to resolve this issue.']);
			break;
	}
