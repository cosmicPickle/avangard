<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlayerModel extends CI_Model {

	public function getPlayers($gameId, $joined = 0)
	{
		return $this->db->select('game_player.gameId, player.*')
						->where('gameId', $gameId)
						->where('game_player.joined', $joined)
						->from('game_player')
						->join('player', 'game_player.playerId = player.id')
						->get()->result();
	}

	public function getPlayer($playerId, $joined = 1)
	{
		return $this->db->select('game_player.gameId, game_player.joined, game_player.ready, player.*')
						->where('playerId', $playerId)
						->where('game_player.joined', $joined)
						->from('game_player')
						->join('player', 'game_player.playerId = player.id')
						->get()->row();
	}

	public function joinToGame($playerId) {
		return $this->db->where('playerId', $playerId)->update('game_player', ['joined' => 1]);
	}

	public function readyForGame($gameId, $playerId, $boardState) {
		$this->db->trans_start();
		$this->db->where('playerId', $playerId)->update('game_player', ['ready' => 1]);
		$this->db->where('id', $gameId)->update('game', ['boardState' => $boardState]);
		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	public function updateLastConnection($playerId) {
		return $this->db->where('playerId', $playerId)->set('lastConnection', 'NOW()', false)->update('game_player');
	}

	public function playerDroppedOut($gameId) {
		return $this->db->select('game_player.gameId, player.*')
						->where('gameId', $gameId)
						->where('game_player.lastConnection < DATE_SUB(NOW(),INTERVAL 10 SECOND)')
						->from('game_player')
						->join('player', 'game_player.playerId = player.id')
						->get()->result();
	}

	public function drop($playerId) {
		return $this->db->where('playerId', $playerId)->set('joined', 0)->update('game_player');
	}

	public function resetPlayers($gameId) {
		return $this->db->where('gameId', $gameId)->update('game_player', ['joined' => 0, 'ready' => 0]);
	}
}
