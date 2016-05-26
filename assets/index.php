<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="assets/lib/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="assets/lib/bootstrap/css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="assets/lib/jquery-ui/jquery-ui.min.css">
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	</head>
	<body>
		<div class="game">
			<div class="pieces">
				<div class="player-one">
				</div>
				<div class="player-two">
				</div>
			</div>
			<div class="board">
				<?php for($i = 0; $i < 10; $i ++) : ?>
					<div class="board-row">
					<?php for($j = 0; $j < 10; $j ++) : ?>
						<div class="board-cell cell-<?php echo $i . '-' .  $j; ?>">
						</div>
					<?php endfor; ?>
					</div>
				<?php endfor; ?>
			</div>
		</div>

		<script type="text/javascript" src="assets/lib/jquery/jquery-1.12.4.min.js"></script>
		<script type="text/javascript" src="assets/lib/jquery-ui/jquery-ui.min.js"></script>
		<script type="text/javascript" src="assets/lib/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/js/main.js"></script>
	</body>
</html>