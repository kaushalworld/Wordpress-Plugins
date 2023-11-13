(function($) {
	"use strict";
	var WidgetCarouselRemoteHandler = function ($scope, $) {		
		
		var $target = $('.theplus-carousel-remote', $scope),
		dotdiv = $target.find('.tp-carousel-dots .tp-carodots-item'),
		remote_uid=$target.data("id"),
		acttab = $('.'+remote_uid+'.tp-tabs-wrapper').find(' li .tp-tab-header.active'),
        activetab = acttab.data('tab');
		
		if($target.length){
			$(".theplus-carousel-remote .custom-nav-remote").on("click", function(e){
				e.preventDefault();
				
				var remote_uid=$(this).data("id");
				var remote_type = $(this).closest(".theplus-carousel-remote").data("remote");
				
				if(remote_uid!='' && remote_uid!=undefined && remote_type=='carousel'){	
				
					var carousel_slide=$(this).data("nav");
					
					if(carousel_slide=='next'){
						$('.'+remote_uid+' > .post-inner-loop').slick("slickNext");
					} else if(carousel_slide=='prev'){
						$('.'+remote_uid+' > .post-inner-loop').slick("slickPrev");
					}
					
				}else if(remote_uid!='' && remote_uid!=undefined && remote_type=='switcher'){
					
					var switcher_toggle=$(this).data("nav");
					
					var switch_toggle = $('#'+remote_uid).find('.switch-toggle');
					var switch_1_toggle = $('#'+remote_uid).find('.switch-1');
					var switch_2_toggle = $('#'+remote_uid).find('.switch-2');
					
					$(".theplus-carousel-remote .custom-nav-remote").removeClass("active");
					$(this).addClass("active");
					
					if(switcher_toggle=='next'){
						switch_2_toggle.trigger("click");							
					} else if(switcher_toggle=='prev'){	
						switch_1_toggle.trigger("click");
					}
				}
			});
			
			if(dotdiv.length > 0){
				dotdiv.on('click', function() {
					$(this).closest(".tp-carousel-dots").find(".tp-carodots-item").removeClass('active default-active').addClass('inactive');
					$(this).removeClass('inactive').addClass('active');
					
                    var Connection=$(this).closest(".theplus-carousel-remote").data('connection'),
                        tab_index=$(this).data("tab"),
						extrId = $(this).closest(".theplus-carousel-remote").data("extra-conn");
					if(Connection!='' && Connection!=undefined && $("#"+Connection).length){
						tp_dot_connection(tab_index,Connection);
                    }
					if(extrId!='' && extrId!=undefined && $("."+extrId).length){
                        tp_dotex_connection(tab_index,extrId);
                    }
                    if($(".carousel-pagination").length){
						var ctab = tab_index + 1;
						$(this).closest(".theplus-carousel-remote").find(".carousel-pagination ul.pagination-list li.pagination-list-in.active").html('0'+ctab);
					}
				});
			}
		}
	};	
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/tp-carousel-remote.default', WidgetCarouselRemoteHandler);
	});
})(jQuery);
function tp_dot_connection(tab_index,Connection){
	var $=jQuery;
	if(Connection!='' && $("#"+Connection).length==1){
		var current=$('#'+Connection+' > .post-inner-loop,#'+Connection+'.post-inner-loop').slick('slickCurrentSlide');
		if(current!=(tab_index)){
			$('#'+Connection+' > .post-inner-loop,#'+Connection+'.post-inner-loop').slick('slickGoTo', tab_index);
		}
	}
}
function tp_dotex_connection(tab_index,id){
	var $=jQuery;
	if(id!='' && $("."+id+'.tp-tabs-wrapper').length==1){		
		if(!$("."+id).find('li .tp-tab-header[data-tab="'+parseInt(tab_index+1)+'"]').hasClass("active")){
			$("."+id).find('li .tp-tab-header[data-tab="'+parseInt(tab_index+1)+'"]').trigger("click");
		}
	}
}