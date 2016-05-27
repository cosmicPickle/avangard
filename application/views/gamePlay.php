<div class="game">
	<input type="hidden" id="playerId" value="<?php echo $player->id; ?>">
	<?php 
		if(isset($unitsSetup)) {
			echo $unitsSetup;
		}
	?>
	<div class="board">
		<?php for($i = 0; $i < 10; $i ++) : ?>
			<div class="board-row">
			<?php for($j = 0; $j < 10; $j ++) : ?>
				<?php 
					$disallowed = $game->config->disallowed[$i][$j];
					$availableForPlayerSetup = $game->config->playerSetup[$player->order][$i][$j];
				?>
				<div class="board-cell cell-<?php echo $i . '-' .  $j; ?> <?php if($disallowed) echo 'disallowed' ?> <?php if($availableForPlayerSetup && !$disallowed) echo 'available'; ?>" 
					 data-cell-x="<?php echo $i; ?>"
					 data-cell-y="<?php echo $j; ?>">
				</div>
			<?php endfor; ?>
			</div>
		<?php endfor; ?>
	</div>
</div>