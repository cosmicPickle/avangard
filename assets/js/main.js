$(document).ready(function(){

	var gameState = $('#gameState').val();
	//Setup of the game
	if(gameState == 'setup') {
		$('.unit').draggable({ revert: "invalid" });

		$( ".available" ).droppable({
	      activeClass: "setup-drop-available",
	      hoverClass: "setup-hover-available",
	      drop: function( ev, ui ) {
	      	var dropped = ui.draggable;
	        var droppedOn = $(this);
	        $(dropped).detach().css({top: 0,left: 0}).appendTo(droppedOn);

	        var unitId = dropped.data('unit-id');
	        var amount = parseInt($('.unit-id-amount-' + unitId).html());
	        var newAmount = amount - 1 >= 0 ? amount - 1 : 0;
	        $('.unit-id-amount-' + unitId).text(newAmount);
	      }
	    });

	}
});