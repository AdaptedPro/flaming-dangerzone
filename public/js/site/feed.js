$(function() {
	var feed_check = function(){
		$.post('/rover/ajax',data,function(m) {
			console.log(m);
		});
	};
		
	setInterval(feed_check, 60000);	
});