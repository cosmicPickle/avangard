<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


	public function resetGame($gameId) {
		$this->load->model('PlayerModel');
		$this->load->model('GameModel');

		$this->PlayerModel->resetPlayers($gameId);
		$this->GameModel->resetBoard($gameId);
	}

	public function play($gameId = NULL)
	{	
		if(!$gameId)
			return null;

		//Loading the models
		$this->load->model('PlayerModel');
		$this->load->model('GameModel');
		$this->load->model('UnitsModel');

		//Loading the game
		$this->game = $this->GameModel->loadGame($gameId);
		$this->game->config = json_decode($this->game->config);
		$this->game->boardState = json_decode($this->game->boardState);

		//Loading the header
		$this->load->view('gameHeader', ['game' => $this->game]);

		if(method_exists($this, '_' . $this->game->gameState))
			$this->{'_' . $this->game->gameState}();

		$this->load->view('gameFooter', ['game' => $this->game]);
	}

	private function _waiting() {
		//Setting the player in session if there is POST
		if($this->input->post('player')) {
			$this->session->playerId = $this->input->post('player');
			$this->PlayerModel->joinToGame($this->session->playerId);

			if($this->GameModel->allJoined($this->game->id))
				$this->GameModel->updateState($this->game->id, 'setup');
		}

		//Checking if the user has been set
		if(!$this->session->playerId)
			$this->load->view('setPlayer', ['players' => $this->PlayerModel->getPlayers($this->game->id)]);
		else
			$this->load->view('waitingForPlayers');
	}

	private function _setup() {
		$units = $this->UnitsModel->load();
		$player = $this->PlayerModel->getPlayer($this->session->playerId);
		$player->units = json_decode($player->units);

		foreach($player->units as $key => $unit) {
			$amount = $unit->amount;
			foreach($units as $u)
				if($u->id == $unit->id)
					$unit = $u;
			$unit->amount = $amount;

			$player->units[$key] = $unit;
		}

		if($this->input->post('playerBoardState')) {
			$playerBoardState = $this->input->post('playerBoardState');
			foreach(json_decode($playerBoardState) as $x => $row)
				foreach($row as $y => $cell) {
					if($cell != null)
						$this->game->boardState[$x][$y] = $cell;
				}

			if($this->PlayerModel->readyForGame($this->game->id, $player->id, json_encode($this->game->boardState)))
				$player->ready = true;
			
			if($this->GameModel->allReady($this->game->id))
			  	$this->GameModel->updateState($this->game->id, 'play');
		}

		if(!$player->ready) 
			$this->load->view('gameSetup', [
				'game' => $this->game, 
				'player' => $player, 
				'units' => $units
			]);
		else
			$this->load->view('waitingForPlayers');
	}

	private function _play() {
		$units = $this->UnitsModel->load();
		$players = $this->PlayerModel->getPlayers($this->game->id, 1);

		$player = array_filter($players, function($p) {
			return $p->id == $this->session->playerId;
		});
		$player = reset($player);

		foreach($this->game->boardState as $rkey => $row) {
			foreach($row as $ckey => $cell) {
				if($cell === null)
					continue;

				$cell->player = array_filter($players, function($p) use (&$cell){
					return $p->id == $cell->playerId;
				});
				$cell->player = reset($cell->player);

				$cell->unit = array_filter($units, function($p) use (&$cell){
					return $p->id == $cell->unitId;
				});
				$cell->unit = reset($cell->unit);
			}
		}
		$this->load->view('gamePlay', [
			'game' => $this->game, 
			'players' => $players, 
			'player' => $player,
			'units' => $units
		]);
	}
}
