$(document).ready(function(){
	var updateFunctions = {
		boardStateUpdate : function(x, y, val) {
			boardState[x][y] = val;
			$('#playerBoardState').val(JSON.stringify(boardState));
		}
	}

	//Setup of the game
	if(gameState == 'setup') {
		$('.unit').draggable({ 
			revert: function(is_valid_drop){
				if(is_valid_drop === false)
				{
					parent = $(this).parent();
					if($(this).parent().hasClass('available'))
					{
						var unitId = $(this).data('unit-id');
						updateFunctions.boardStateUpdate(parent.data('cell-x'), parent.data('cell-y'), {unitId: unitId, playerId: playerId, damaged:0});
					}
					return true;
				}
			},
			start: function() {
				var parent = $(this).parent(); 
				if(parent.hasClass('available'))
					updateFunctions.boardStateUpdate(parent.data('cell-x'), parent.data('cell-y'), null);
			}
		});

		$( ".available" ).droppable({
	      activeClass: "setup-drop-available",
	      hoverClass: "setup-hover-available",
	      accept : function (el) {
	      	return boardState[$(this).data('cell-x')][$(this).data('cell-y')] === null;
	      },
	      drop: function( ev, ui ) {
	      	var dropped = ui.draggable;
	      	var unitContainer = dropped.parent();
	        var droppedOn = $(this);
	        $(dropped).detach().css({top: 0,left: 0}).appendTo(droppedOn);

	        var unitId = dropped.data('unit-id');
	        if(unitContainer.hasClass('units')) {
	        	var amount = parseInt($('.unit-id-amount-' + unitId).html());
		        var newAmount = amount - 1 >= 0 ? amount - 1 : 0;
		        $('.unit-id-amount-' + unitId).text(newAmount);
	        }

	        updateFunctions.boardStateUpdate(droppedOn.data('cell-x'), droppedOn.data('cell-y'), {unitId: unitId, playerId: playerId, damaged:0});
	      }
	    });
	}
});