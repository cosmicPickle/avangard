<div class="game">
	<!-- Game Configuration -->
	<input type="hidden" id="gameState" value="<?php echo $game->gameState; ?>">
	<div class="pieces">
		<?php foreach($player->units as $unit) : ?>
		<div class="units">
			<?php for($i = 0; $i < $unit->amount; $i++) : ?>
			<div class="unit" data-unit-id="<?php echo $unit->id ?>">
				<p><?php echo $unit->name; ?></p>
				<p>Amount: <span class="amount unit-id-amount-<?php echo $unit->id ?>"><?php echo $unit->amount; ?></span></p>
			</div>
			<?php endfor; ?>
		</div>
		<?php endforeach; ?>
	</div>
	<div class="board">
		<?php for($i = 0; $i < 10; $i ++) : ?>
			<div class="board-row">
			<?php for($j = 0; $j < 10; $j ++) : ?>
				<?php 
					$disallowed = $game->config->disallowed[$i][$j];
					$availableForPlayerSetup = $game->config->playerSetup[$player->order][$i][$j];
				?>
				<div class="board-cell cell-<?php echo $i . '-' .  $j; ?> <?php if($disallowed) echo 'disallowed' ?> <?php if($availableForPlayerSetup && !$disallowed) echo 'available'; ?>">
				</div>
			<?php endfor; ?>
			</div>
		<?php endfor; ?>
	</div>
</div>