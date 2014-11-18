jQuery(document).ready(function($){
	
	//-----------------------------------------------------------------
	// NectarLove
	//-----------------------------------------------------------------
	
	$('body').on('click','.nectar-love', function() {
			

			var $loveLink = $(this);
			var $id = $(this).attr('id');
			var $that = $(this);
			
			if($loveLink.hasClass('loved')) return false;
			if($(this).hasClass('inactive')) return false;
			
			var $dataToPass = {
				action: 'nectar-love', 
				loves_id: $id 
			}
			
			$.post(nectarLove.ajaxurl, $dataToPass, function(data){
				$loveLink.find('span').html(data);
				$loveLink.addClass('loved').attr('title','You already love this!');
				$loveLink.find('span').css({'opacity': 1,'width':'auto'});
				//ascend
				if($('body').hasClass('ascend')){
					$loveLink.find('.icon-salient-heart.loved').show().transition({ scale: 1 },800,'cubic-bezier(0.15, 0.84, 0.35, 1.5)');
					setTimeout(function(){ $loveLink.find('.icon-salient-heart-2').css('opacity','0'); },400);
				}
			});
			
			$(this).addClass('inactive');
			
			return false;
	});
	
	
});