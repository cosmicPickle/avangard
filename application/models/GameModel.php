<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GameModel extends CI_Model {

	public function allJoined($gameId) {
		return $this->db->select('game_player.gameId, player.*')
						->where('gameId', $gameId)
						->where('game_player.joined', 0)
						->from('game_player')
						->join('player', 'game_player.playerId = player.id')
						->count_all_results() == 0;
	}

	public function allReady($gameId) {
		return $this->db->select('game_player.gameId, player.*')
						->where('gameId', $gameId)
						->where('game_player.ready', 0)
						->from('game_player')
						->join('player', 'game_player.playerId = player.id')
						->count_all_results() == 0;
	}

	public function updateState($gameId, $status) {
		return $this->db->where('id', $gameId)->update('game', ['gameState' => $status]);
	}

	public function loadGame($gameId) {
		return $this->db->where('id', $gameId)->get('game')->row();
	}

	public function resetBoard($gameId) {
		$default = [];

		for($i = 0; $i < 10; $i++) {
			$default[$i] = [];
			for($j = 0; $j < 10; $j++)
				$default[$i][$j] = null;
		}

		$this->db->where('id', $gameId)->update('game', ['boardState' => json_encode($default)]);
	}
}
