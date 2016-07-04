<div class="game">
	<input type="hidden" id="playerId" value="<?php echo $player->id; ?>">
	<div class="board">
		<?php for($i = 0; $i < 10; $i ++) : ?>
			<div class="board-row">
			<?php for($j = 0; $j < 10; $j ++) : ?>
				<?php
					$disallowed = $game->config->disallowed[$i][$j];
				?>
				<div class="board-cell cell-<?php echo $i . '-' .  $j; ?> <?php if($disallowed) echo 'disallowed' ?>" 
					 data-cell-x="<?php echo $i; ?>"
					 data-cell-y="<?php echo $j; ?>">
					<?php 
					if($game->boardState[$i][$j] !== null) : 
						$cell = $game->boardState[$i][$j];
					?>
					<div class="unit inBoard" 
						 style="background:<?php echo $cell->player->color;?>"
						 data-player='<?php echo json_encode($cell->player); ?>'
						 data-unit='<?php echo json_encode($cell->unit); ?>'>
						<p><?php echo $cell->unit->name; ?></p>
					</div>
					<?php endif; ?>
				</div>
			<?php endfor; ?>
			</div>
		<?php endfor; ?>
	</div>
</div>
