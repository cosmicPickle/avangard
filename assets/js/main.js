var baseUrl = $('#baseUrl').val();
var feedUrl = $('#feedUrl').val();
var playerId = $('#playerId').val();
var gameId = $('#gameId').val();
var gameState = $('#gameState').val();
var gameConfig = $.parseJSON($('#gameConfig').val());
var boardState = $.parseJSON($('#boardState').val());

var updateGameStateInterval = 3000;
var updateBoardStateInterval = 3000;

var updateGameStateIntervalObject = null;

$(document).ready(function(){

	var lifecycle = {
		updateGameStateInterval : function() {
			$.ajax({
				url : feedUrl + 'gameState/' + gameId,
				success : function(data) {
					data = $.parseJSON(data);
					if(data.ok && gameState != data.gameState)
						window.location.reload();
				}
			})
		}
	}
	updateGameStateIntervalObject = setInterval(lifecycle.updateGameStateInterval, updateGameStateInterval);
});