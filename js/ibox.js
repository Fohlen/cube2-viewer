// ibox image zoomer plugin // roXon
// http://www.roxon.in/
(function($) {
    $.fn.ibox = function( htmlcode, callback ) {
        
        // set zoom ratio //
        resize = 50;
        ////////////////////
        var img = this;
        $('body').append('<div id="ibox" />');
        var ibox = $('#ibox');
        var elX = 0;
        var elY = 0;

        img.each(function() {
            var el = $(this);
			var content = '';
			el.siblings().each(function () {
				if($(this).attr('class')!=undefined){
					content += '<div class="' + $(this).attr('class') + '">' + $(this).children('.content').html() + '</div>';
					
					if($(this).children('.c' + $(this).attr('class')).css('width')!=undefined){
						content += '<div class="c' + $(this).attr('class') + 'b" style="width: ' + $(this).children('.c' + $(this).attr('class')).css('width') + ';">' + $(this).children('.content').html() + '</div>';
					}
				}
			});
            el.mouseenter(function() {
                ibox.html('');
                var elH = el.height();
                elX = el.position().left - 6; // 6 = CSS#ibox padding+border
                elY = el.position().top - 6;
                var h = el.height();
                var w = el.width();
                var wh;
                checkwh = (h < w) ? (wh = (w / h * resize) / 2) : (wh = (w * resize / h) / 2);

                $(this).clone().prependTo(ibox);
                ibox.css({
                    top: elY + 'px',
                    left: elX + 'px'
                });
                ibox.stop().fadeTo(200, 1, function() {
                    if($(this).offset().left<wh){
                        wh = $(this).offset().left;
                    }
					$(this).append(content);
					$('#ibox').children('div').css('display', 'none');
					var index = el.parent().index();
					if(index==1||index==2){
                    	$(this).animate({top: '-='+(resize/2), left:'-='+$(this).width()/2},400).children('img').animate({width:$(this).width()*2,height:$(this).width()*2},400, 'swing', function () {
							$('#ibox').children('.clear').slideDown(200);
							$('#ibox').children('div').fadeIn(200);
						});
					}else if(index==0){
                    	$(this).animate({top: '-='+(resize/2)},400).children('img').animate({width:$(this).width()*2,height:$(this).width()*2}, 'swing', function () {
							$('#ibox').children('.clear').slideDown(200);
							$('#ibox').children('div').fadeIn(200);
						});
					}else{
                    	$(this).animate({top: '-='+(resize/2), left:'-='+$(this).width()},400).children('img').animate({width:$(this).width()*2,height:$(this).width()*2}, 'swing', function () {
							$('#ibox').children('.clear').slideDown(200);
							$('#ibox').children('div').fadeIn(200);
						});
					}
				});
            });

            ibox.mouseleave(function() {
                ibox.html('').hide();
            });
        });
    };
})(jQuery);

$(document).ready(function() {
    $('.row img').ibox(function () {
		// alert('hallo');
	});
});