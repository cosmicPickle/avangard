<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feed extends CI_Controller {

	public function gameState($gameId = NULL)
	{	
		if(!$gameId) {
			echo json_encode(['error' => 'No such game.']);
			exit(1);
		}
		$this->_manageGameState($gameId);

		//Loading the models
		$this->load->model('GameModel');

		//Loading the game
		$this->game = $this->GameModel->loadGame($gameId);

		echo json_encode(['ok' => 1, 'gameState' => $this->game->gameState]);
	}

	private function _manageGameState($gameId) {

		$error = null;
		//If this player doesn't have a session he is not part of the game.
		if(!$this->session->playerId) {
			$error = json_encode(['error' => 'You are not part of this game.']);
		}

		$this->load->model('PlayerModel');
		$this->load->model('GameModel');

		//Update this player's last connection
		$this->PlayerModel->updateLastConnection($this->session->playerId);

		//Check for dropped players and set the game state to 'waiting'
		if($droppedPlayers = $this->PlayerModel->playerDroppedOut($gameId)) {
			foreach($droppedPlayers as $p) {
				$this->PlayerModel->drop($p->id);
			}

			$this->GameModel->updateState($gameId, 'waiting');
		}

		$allReady = $this->GameModel->allReady($gameId);
		$allJoined = $this->GameModel->allJoined($gameId);

		if(!$allJoined) {

			if($this->PlayerModel->getPlayer($this->session->playerId) === null) {
				$this->session->unset_userdata('playerId');
				$error = json_encode(['error' => 'You were disconnected from the game.', 'reload' => 1]);
			}
		}

		//If not everyone is ready but not all are joined set to 'waiting'
		if((!$allReady && !$allJoined) || ($allReady && !$allJoined))
			$this->GameModel->updateState($gameId, 'waiting');

		//If not everyone is ready put the game back to 'setup'
		if(!$allReady && $allJoined)
			$this->GameModel->updateState($gameId, 'setup');

		//If everyone is ready and the game is left in 'setup' state put it to 'play'
		if($allReady && $allJoined)
			$this->GameModel->updateState($gameId, 'play');

		if($error !== null) {
			echo $error;
			exit(1);
		}
	}
}
