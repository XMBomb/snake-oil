var SnakeOil = function(){};


SnakeOil.prototype.startGame = function(){
	SnakeOil.prototype.clearCards();
	SnakeOil.prototype.getCards('word', 6, true);
	SnakeOil.prototype.getCards('customer', 1, true);
};

SnakeOil.prototype.setActionListeners = function(){
	$('.new-game').click(function() {
		SnakeOil.prototype.startGame();
	});

	$(document).on('click','.remove-card',function() {
		var indexToRemove = $(this).attr('data-card-index');
		var cardTypeOfRemovedElement =  $(this).attr('data-card-type');
		switch(cardTypeOfRemovedElement){
			case 'word':
				SnakeOil.currentCards.words.splice(indexToRemove, 1);
				break;
			case 'customer':
				SnakeOil.currentCards.customers.splice(indexToRemove, 1);
				break;
			default:
				alert('Invalid card type found :(');
				break;
		}

		var cardDiv = $(this).closest('div');
		// cardDiv.addClass('bounceOutDown');

		SnakeOil.prototype.getCards(cardTypeOfRemovedElement, 1, false);
	});
};

SnakeOil.prototype.getCards = function(method, number, clearExistingCards){
	if (clearExistingCards){
		SnakeOil.prototype.clearCards();
	}
	$.ajax({
		type: "GET",
		url: 'server.php?'+method+'='+number,
		success: function(data) {
			SnakeOil.prototype.addCards(data.cards);
			SnakeOil.prototype.displayCards();
		},
		error: function(data){
			if (data.message){
				alert(data.message);
			}else{
				console.debug(data);
				// alert("An unknown error occured.");
			}
		}
	});
};

SnakeOil.prototype.clearCards = function(){
	SnakeOil.currentCards = {};
	SnakeOil.currentCards.words = [];
	SnakeOil.currentCards.customers = [];
};

SnakeOil.prototype.addCards = function(cards, index){
	console.debug(cards);
	switch(cards[0].type){
		case 'word':
			SnakeOil.currentCards.words = SnakeOil.currentCards.words.concat(cards);
			break;
		case 'customer':
			SnakeOil.currentCards.customers = SnakeOil.currentCards.customers.concat(cards);
			break;
		default:
			alert('Invalid card type found :(');
			break;
	}
	console.debug(SnakeOil.currentCards);
};

SnakeOil.prototype.displayCards = function(){
	var html = '';
	var cardType = '';
	// TODO: fix this redundant mess
	$.each(SnakeOil.currentCards.words, function(index, card) {
		html += SnakeOil.prototype.assembleCardHtml(card, index);
		cardType = card.type;
	});

	$('.'+cardType+'-cards').html(html);
	cardType = '';
	html = '';

	$.each(SnakeOil.currentCards.customers, function(index, card) {
		html += SnakeOil.prototype.assembleCardHtml(card, index);
		cardType = card.type;
	});

	$('.'+cardType+'-cards').html(html);
};

SnakeOil.prototype.assembleCardHtml = function(card, index){
	return ''+ 
		'<div class="card '+card.type+'-card" data-type="'+card.type+'" id="card-'+card.type+'-'+index+'">'+
			'<button type="button" class="close remove-card" data-card-type="'+card.type+'" data-card-index="'+index+'">&times;</button>'+
			'<span>'+card.name+'</span>'+
			'<img class="word-image" src="'+card.imageHtml+'">'+
		'</div>';
};

$(document).ready(function(){
	var snakeOil = new SnakeOil();
	snakeOil.setActionListeners();
	snakeOil.startGame();
});