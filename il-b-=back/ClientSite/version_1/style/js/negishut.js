var negishut_font_level = 0;
var negishut_open = 0;
function show_negishut(){
	jQuery("#negishut_wrap").show(); 
	jQuery("#negishut_door a").drags();
	var n_f_cookie = negishut_getCookie("negishut_font_size");
	var n_c_cookie = negishut_getCookie("negishut_contrast");
	var n_news_cookie = negishut_getCookie("stop_news_marquee");
	if(n_f_cookie != "0" && n_f_cookie != ""){
		negishut_font_size(n_f_cookie);
	}
	if(n_c_cookie != "0" && n_c_cookie != ""){
		negishut_contrast(n_c_cookie);
	}
	if(n_news_cookie == "1"){
		stop_news_marquee();
	}	
}

function negishut_getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

function open_negishut_menu(){
	if(negishut_open == 0){
		jQuery("#negishut-content").show(300); 
		negishut_open = 1;
	}
	else{
		jQuery("#negishut-content").hide(300); 
		negishut_open = 0;		
	}
}
function negishut_font_bigger(){
	if(negishut_font_level < 4){
		negishut_font_level++;
		negishut_font_size(negishut_font_level);
	}
}

function negishut_font_smaller(){
	if(negishut_font_level > 0){
		negishut_font_level--;
		negishut_font_size(negishut_font_level);
	}
}

function negishut_font_size(font_level){
	var bt = jQuery("body"); 
	bt.removeClass("negishut_f"); 
	bt.removeClass("negishut_f_1"); 
	bt.removeClass("negishut_f_2");  

	bt.removeClass("negishut_f_3");  
	bt.removeClass("negishut_f_4");
	if(font_level > 0){
		bt.addClass("negishut_f"); 
		bt.addClass("negishut_f_"+font_level);
	}
	document.cookie = "negishut_font_size=" + font_level + ";domain=" + negishut_domain + ";path=/;expires=" + negishut_date;
}

function negishut_contrast(contrast_type){
	var bt = jQuery("body"); 
	bt.removeClass("negishut_c");
	bt.removeClass("negishut_c_1");
	bt.removeClass("negishut_c_2");
	bt.removeClass("negishut_c_3");
	if(contrast_type != 0){
		bt.addClass("negishut_c");
		bt.addClass("negishut_c_"+contrast_type);
	}
	console.log(negishut_domain);
	document.cookie = "negishut_contrast=" + contrast_type + ";domain=" + negishut_domain + ";path=/;expires=" + negishut_date;
}

function stop_news_marquee(){
	jQuery("#marqueecontainer").attr("onmouseover",""); 
	jQuery("#marqueecontainer").attr("onmouseout",""); 
	copyspeed=pausespeed;
	var bt = jQuery("body"); 
	bt.addClass("negishut_stop_movements");
	document.cookie = "stop_news_marquee=1" + ";domain=" + negishut_domain + ";path=/;expires=" + negishut_date;
}

function run_news_marquee(){
	jQuery("#marqueecontainer").attr("onmouseover","copyspeed=pausespeed"); 
	jQuery("#marqueecontainer").attr("onmouseout","copyspeed=marqueespeed"); 
	copyspeed=marqueespeed;
	var bt = jQuery("body"); 
	bt.removeClass("negishut_stop_movements");
	document.cookie = "stop_news_marquee=0" + ";domain=" + negishut_domain + ";path=/;expires=" + negishut_date;
}

function negishut_goto(content_area){
jQuery(function($){	
$('html, body').animate({
    scrollTop: $('#'+content_area).offset().top
}, 1000);	
	});
	open_negishut_menu();
	var bt = jQuery("body"); 
	bt.addClass("negishut_use_navigation");
}




(function($) {
    $.fn.drags = function(opt) {

        opt = $.extend({handle:"",cursor:"move"}, opt);

        if(opt.handle === "") {
            var $el = this;
        } else {
            var $el = this.find(opt.handle);
        }

        return $el.css('cursor', opt.cursor).on("mousedown", function(e) {
            if(opt.handle === "") {
                var $drag = $(this).addClass('draggable');
            } else {
                var $drag = $(this).addClass('active-handle').parent().addClass('draggable');
            }
            var z_idx = $drag.css('z-index'),
                drg_h = $drag.outerHeight(),
                drg_w = $drag.outerWidth(),
                pos_y = $drag.offset().top + drg_h - e.pageY,
                pos_x = $drag.offset().left + drg_w - e.pageX;
            $drag.css('z-index', 1000).parents().on("mousemove", function(e) {
                $('.draggable').offset({
                    top:e.pageY + pos_y - drg_h,
                    left:e.pageX + pos_x - drg_w
                }).on("mouseup", function() {
                    $(this).removeClass('draggable').css('z-index', z_idx);
                });
            });
            e.preventDefault(); // disable selection
        }).on("mouseup", function() {
            if(opt.handle === "") {
                $(this).removeClass('draggable');
            } else {
                $(this).removeClass('active-handle').parent().removeClass('draggable');
            }
        });

    }
})(jQuery);