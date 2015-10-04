<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title>Araneum Projects</title>
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900">
	<link rel="stylesheet" type="text/css" href="assets/css/app.css">
</head>
<body>
	<div class="uk-container uk-container-center">
		<header>
			<h1 class="uk-h1">Araneum<strong>Projects</strong></h1>
			<p>
				All projects are developed and maintained by Ibrahim Hatoum.
				<br>
				<span class="uk-margin-right"><i class="uk-icon-twitter uk-margin-small-right"></i><a href="http://twitter.com/barohatoum" target="_blank">@barohatoum</a></span> |
				<span class="uk-margin-left uk-margin-right"><i class="uk-icon-github uk-margin-small-right"></i><a href="http://github.com/barohatoum" target="_blank">@barohatoum</a></span> |
				<span class="uk-margin-left"><i class="uk-icon-envelope-o uk-margin-small-right"></i><a href="mailto:ibrahim.hatoum@gmail.com">ibrahim.hatoum@gmail.com</a></span>
			</p>
		</header>

		<main>
			<article>
				<p class="new-project-link">
					<a href="#" id="create-new-project-link"><i class="uk-icon-plus uk-margin-small-right"></i>Create project</a>
				</p>
				<?php $projects = scandir('./../'); ?>
				<?php $projects = array_filter($projects, function($value) { return !preg_match('/_|\.|araneum/', $value); }); ?>
				<?php if (count($projects)) : ?>
					<ul class="uk-list uk-list-space uk-list-line uk-margin-large-top">
						<?php foreach ($projects as $project) : ?>
							<?php $project_info = (file_exists('../' . $project . '/project.json')) ? json_decode(file_get_contents('../' . $project . '/project.json')) : []; ?>
							<li>
								<p>
									<span class="title"><i class="uk-icon-globe uk-margin-small-right"></i><?= $project_info->title; ?></span>
									<span class="description"><?= $project_info->description; ?></span>
								</p>
								<p>
									<span>Developers</span>
									<ul class="uk-list">
										<?php foreach ($project_info->developers as $developer) : ?>
											<li class="developer">
												<?= $developer->name; ?> &lt;<?= $developer->email; ?>&gt;
											</li>
										<?php endforeach; ?>
									</ul>
								</p>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php else: ?>
					<p class="notice">No projects found.</p>
				<?php endif; ?>
			</article>
		</main>
	</div>

	<div id="new-project-form-container" class="new-project-form-container">
		<form id="new-project-form" class="uk-form">
			<legend>Start a new project</legend>
			<div class="uk-form-row">
				<div class="uk-form-controls">
					<input type="text" name="project-title" placeholder="Title" required>
				</div>
			</div>
			<div class="uk-form-row">
				<div class="uk-form-controls">
					<textarea name="project-description" placeholder="Description..."></textarea>
				</div>
			</div>
			<div class="uk-form-row">
				<div class="uk-form-controls">
					<select name="project-language">
						<option value="0">Programming language</option>
						<option value="PHP">PHP</option>
						<option value="Python">Python</option>
						<option value="JavaScript">JavaScript</option>
						<option value="Ruby">Ruby</option>
						<option value="Node.js">Node.js</option>
						<option value="ASP.Net">ASP.Net</option>
					</select>
				</div>
			</div>
			<div class="uk-form-row">
				<div class="uk-form-controls">
					<input type="text" name="project-contributors" placeholder="Contributors">
					<p class="uk-form-help-block">A comma seperated list of project's contributors (i.e: Ibrahim Hatoum (ibrahim.hatoum@gmail.com), John Appleseed (john@appleseed.com))</p>
				</div>
			</div>
			<div class="uk-form-row">
				<div class="uk-form-controls">
					<button type="submit">Create Project</button>
					<button type="button" id="cancel-create-project">Cancel</button>
				</div>
			</div>
			<input type="hidden" name="action" value="new-project">
		</form>
	</div>

	<script type="text/javascript" src="assets/js/vendor/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/vendor/uikit.min.js"></script>
	<script type="text/javascript">
		$(function() {
			'use strict';

			var $new_project = $('#create-new-project-link');
			var $cancel_project = $('#cancel-create-project');
			var $project_form = $('#new-project-form');
			var $new_project_container = $('#new-project-form-container');

			$new_project.on('click', function(e) {
				e.preventDefault();

				$new_project_container.animate({ top: 0 });
			});

			$cancel_project.on('click', function() {
				$new_project_container.animate({ top: '-100%' }, function() {
					$project_form.trigger('reset');
				});
			});

			$project_form.on('submit', function(e) {
				e.preventDefault();

				$.post('api/project/', $project_form.serialize()).done(function(response) {
					if (response.success) {
						window.location.reload();
					} else {
						alert(response.error);
					}
				});
			});
		});
	</script>
</body>
</html>
