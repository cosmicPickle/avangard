<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/bootstrap/css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/jquery-ui/jquery-ui.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
	</head>
	<body>
		<!-- Game Configuration -->
		<input type="hidden" id="baseUrl" value="<?php echo base_url(); ?>">
		<input type="hidden" id="feedUrl" value="<?php echo site_url('feed'); ?>/">
		<input type="hidden" id="gameId" value="<?php echo $game->id; ?>">
		<input type="hidden" id="gameState" value="<?php echo $game->gameState; ?>">
		<input type="hidden" id="gameConfig" value='<?php echo json_encode($game->config); ?>'>
		<input type="hidden" id="boardState" value='<?php echo json_encode($game->boardState); ?>'>