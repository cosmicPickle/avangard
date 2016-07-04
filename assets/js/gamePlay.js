$(document).ready(function(){
	var gameFunctions = {
		getAvailableMoves : function($unitObj) {
			var $cellObj = $unitObj.parent();

			var unit = $unitObj.data('unit');
			var player = $unitObj.data('player');

			var coord = {
				x : parseInt($cellObj.data('cell-x')), 
				y : parseInt($cellObj.data('cell-y'))
			};
			var radius = parseInt(unit.speed);

			var available = [];
			for(var i = coord.x; i <= coord.x + radius; i++) {
				for(var j = coord.y; j <= coord.y + radius; j ++) {
					if(i == coord.x && j == coord.y)
						continue;

					var diff = [i - coord.x, j - coord.y];

					if(gameFunctions.checkCell(i, j))
					available.push([i, j]);

					if(gameFunctions.checkCell(i, 2*coord.y-j))
						available.push([i, 2*coord.y-j]);

					if(gameFunctions.checkCell(2*coord.x-i, j))
						available.push([2*coord.x-i, j]);

					if(gameFunctions.checkCell(2*coord.x-i, 2*coord.y-j))
						available.push([2*coord.x-i, 2*coord.y-j]);


				}
			}
			return available;
		},
		checkCell : function(x, y) {
			if(x < 0 || y < 0 || x > boardSize || y > boardSize)
				return false;

			if($('.cell-' + x + '-' + y).hasClass('disallowed'))
				return false;

			if($('.cell-' + x + '-' + y).children('.unit').length > 0)
				return false;

			return true;
		} 
	}

	$('.unit').on('click', function() {
		var moves = gameFunctions.getAvailableMoves($(this));

		moves.forEach(function(move){
			$('.cell-' + move[0] + '-' + move[1]).css({background : '#b3ffb3'});
		});

		$(this).css({border : '1px solid #004d00'});
	});
});