<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feed extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if(!$this->session->playerId) {
			echo json_encode(['error' => 'No such player.']);
			exit(1);
		}
		
		$this->load->model('PlayerModel');
		$this->load->model('GameModel');

		$player = $this->PlayerModel->getPlayer($this->session->playerId);
		$this->PlayerModel->updateLastConnection($player->id);
		$gameId = $player->gameId;
		

		if($droppedPlayers = $this->PlayerModel->playerDroppedOut($gameId)) {
			foreach($droppedPlayers as $p) {
				$this->PlayerModel->drop($p->id);
			}

			$this->GameModel->updateState($gameId, 'waiting');
		}
	}
	public function gameState($gameId = NULL)
	{	
		if(!$gameId) {
			echo json_encode(['error' => 'No such game.']);
			exit(1);
		}

		//Loading the models
		$this->load->model('GameModel');

		//Loading the game
		$this->game = $this->GameModel->loadGame($gameId);

		echo json_encode(['ok' => 1, 'gameState' => $this->game->gameState]);
	}
}
