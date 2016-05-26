<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlayerModel extends CI_Model {

	public function getPlayers($gameId)
	{
		return $this->db->select('game_player.gameId, player.*')
						->where('gameId', $gameId)
						->where('game_player.joined', 0)
						->from('game_player')
						->join('player', 'game_player.playerId = player.id')
						->get()->result();
	}

	public function getPlayer($playerId)
	{
		return $this->db->select('game_player.gameId, player.*')
						->where('playerId', $playerId)
						->where('game_player.joined', 1)
						->from('game_player')
						->join('player', 'game_player.playerId = player.id')
						->get()->row();
	}

	public function joinToGame($playerId) {
		return $this->db->where('playerId', $playerId)->update('game_player', ['joined' => 1]);
	}
}
