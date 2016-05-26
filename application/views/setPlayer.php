<div class="container">

	<div class="col-md-6 col-md-offset-3">
		<h1>Please select a player</h1>
		<form action="" method="POST">
			<div class="form-group">
			    <select name="player" id="player" class="form-control">
					<?php foreach($players as $player) : ?>
					<option value="<?php echo $player->id; ?>"><?php echo $player->name; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
			    <input type="submit" class="btn btn-primary btn-block" value="Select">
			</div>
		</form>
	</div>
</div>