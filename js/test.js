$("document").ready(function(){
	$(".likes").click(function(){
		var article_id = $(this).attr('id');
	//passar in id siffran till php filen för att kalla på den
		$.post('ajax/like_add.php',{article_id:article_id}, function(data){
		if("success"){
			like_get(article_id);
		}
		else{
			alert(data);
		}
		});
	});

	function like_get(article_id){
		$.post('ajax/like_get.php', {article_id:article_id}, function(data){
			$('#article_'+ article_id +'_likes').text(data);
		});
	}
});


$("document").ready(function(){
	$(".likes").click(function(){
		var article_id = $(this).attr('id');
	//passar in id siffran till php filen för att kalla på den
		$.post('ajax/like_add.php',{article_id:article_id}, function(data){
		if("success"){
			like_get(article_id);
		}
		else{
			alert(data);
		}
		});
	});

	function like_get(article_id){
		$.post('ajax/like_get.php', {article_id:article_id}, function(data){
			$('#article_'+ article_id +'_likes').text(data);
		});
	}
});

//Html kod
<a class="likes" href="#" id="$article['article_id']">Like</a>