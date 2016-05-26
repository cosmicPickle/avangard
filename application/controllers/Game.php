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
	public function play($gameId = NULL)
	{	
		if(!$gameId)
			return null;

		//Loading the header
		$this->load->view('gameHeader');

		$this->load->model('PlayerModel');
		$this->load->model('GameModel');
		$this->load->model('UnitsModel');

		//Settign the player in session if there is POST
		if($this->input->post('player')) {
			$this->session->playerId = $this->input->post('player');
			$this->PlayerModel->joinToGame($this->session->playerId);

			if($this->GameModel->allJoined($gameId))
				$this->GameModel->updateState($gameId, 'setup');
		}

		//Checking if the user has been set
		if(!$this->session->playerId)
			$this->load->view('setPlayer', ['players' => $this->PlayerModel->getPlayers($gameId)]);
		else {

			$game = $this->GameModel->loadGame($gameId);
			$game->config = json_decode($game->config);
			$game->boardState = json_decode($game->boardState);

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
			$this->load->view('gamePlay', ['game' => $game, 'player' => $player, 'units' => $units]);
		}

		$this->load->view('gameFooter');
	}
}
