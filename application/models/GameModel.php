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

	public function updateState($gameId, $status) {
		return $this->db->where('id', $gameId)->update('game', ['gameState' => $status]);
	}

	public function loadGame($gameId) {
		return $this->db->where('id', $gameId)->get('game')->row();
	}
}
