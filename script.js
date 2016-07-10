var SnakeOil = function(){};
SnakeOil.prototype.setActionListeners = function(){
	$('.get-word-card').click(function() {
		SnakeOil.prototype.getCards('newWordCard', 2, false);
	});
	$('.get-full-set').click(function() {
		SnakeOil.prototype.getCards('newWordCard', 6, true);
	});
	$('.get-customer').click(function() {
		SnakeOil.prototype.getCards('newCustomerCard', 1, true);
	});
	$('.new-game').click(function() {
		SnakeOil.prototype.getCards('newWordCard', 6, true);
		SnakeOil.prototype.getCards('newCustomerCard', 1, true);
	});
};

SnakeOil.prototype.getCards = function(method, number, deleteCurrentCards){
	$.ajax({
		type: "GET",
		url: 'server.php?'+method+'='+number,
		success: function(data) {
			if (deleteCurrentCards){
				$('.'+method+'-cards').empty();
			}
			$.each(data.cards, function(index, card) {
				$('.'+method+'-cards').append('<div class="'+method+'-card" data-type="'+method+'"><span>'+card+'</span><button type="button" class="remove-card">x</button></div>');
			});
			// TODO: do this better
			$('.remove-card').unbind();
			$('.remove-card').click(function() {
				var div = $(this).closest('div');
				var method = div.attr('data-type');
				SnakeOil.prototype.getCards(method, 1, false);
				div.remove();
			});
		},
		error: function(data){
			if (data.message){
				alert(data.message);
			}else{
				alert("An unknown error occured.");
			}
		}
	});
}


$(document).ready(function(){
	var snakeOil = new SnakeOil();
	snakeOil.setActionListeners();
});