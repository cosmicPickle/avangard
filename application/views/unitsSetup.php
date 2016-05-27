<div class="pieces">
	<?php foreach($player->units as $unit) : ?>
	<div class="units">
		<?php for($i = 0; $i < $unit->amount; $i++) : ?>
		<div class="unit" style="background: <?php echo $player->color; ?>" data-unit-id="<?php echo $unit->id ?>">
			<p><?php echo $unit->name; ?></p>
			<p>Amount: <span class="amount unit-id-amount-<?php echo $unit->id ?>"><?php echo $unit->amount; ?></span></p>
		</div>
		<?php endfor; ?>
	</div>
	<?php endforeach; ?>

	<form action="" method="POST">
		<input type="hidden" name="playerBoardState" id="playerBoardState" value="<?php echo json_encode($game->boardState); ?>">
		<button class="btn btn-primary btn-block"> Ready </button>
	</form>
</div>