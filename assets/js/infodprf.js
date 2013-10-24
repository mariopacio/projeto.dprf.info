(function ($, window, document, undefined) {

        $.fn.extend({
                removeCss: function (cssName) {
                        return this.each(function () {
                                var curDom = $(this);
                                jQuery.grep(cssName.split(","),

                                function (cssToBeRemoved) {
                                        curDom.css(cssToBeRemoved, '');
                                });
                                return curDom;
                        });
                }
        });

        var $window = $(window)
        window.prettyPrint && prettyPrint();

        // SIDEBAR RESIZE - CONVERT NAV
        // ------------------------------------------------------------------------------------------------ * --> 
        $(window).resize(function () {
                if($(window).width() < 767) {
                        $('.sidebar').addClass('collapse')
                        $('.sidebar, .footer-sidebar').removeCss('display');
                }
                if($(window).width() > 767) {
                        $('.sidebar').removeClass('collapse');
                        $('.sidebar').removeCss('height');

                        if(!$('body').hasClass('sidebar-hidden')) {
                                $('.sidebar, .footer-sidebar').css({
                                        'display': 'block'
                                });
                        } else {
                                $('.sidebar, .footer-sidebar').css({
                                        'display': 'none'
                                });
                        }
                }
        });
        $(function () {
                if($(window).width() < 767) {
                        $('.sidebar').addClass('collapse');
                }
                if($(window).width() > 767) {
                        $('.sidebar').removeClass('collapse');
                        $('.sidebar').removeCss('height');
                }
        });


        $("#btnToggleSidebar").click(function () {
                $(this).toggleClass('fontello-icon-resize-full-2 fontello-icon-resize-small-2');
                $(this).toggleClass('active');
                $('#main-sidebar, #footer-sidebar').animate({
                        width: 'toggle'
                }, 0);
                //$('body').toggleClass('sidebar-display sidebar-hidden');
                if($('body').hasClass('sidebar-hidden')) {
                        showSidebar();
                } else {
                        hideSidebar();
                }
        });
        
        $('#input_busca_topo').typeahead({
            source: function (query, process) {
            return $.getJSON(
		      '/infodprf/infodprf.busca.json.php',
                { query: query },
                function (data) {
                    return process(data);
                });
            }
		});	

        // SCROLL - NICESCROLL
        // ------------------------------------------------------------------------------------------------ * -->
        // The document page (body)
        /**/$("html").niceScroll({
					cursoropacitymin:0.2,
					cursoropacitymax:0.9,
					cursorcolor:"#ee9700",
					cursorwidth:"8px",
					cursorborder:"",
					cursorborderradius:"8px",
					usetransition:600,
					background:"",
					railoffset:{top:10,left:-3}	
				}); 
				
				$("#main-sidebar").niceScroll({
					cursoropacitymin:0.1,
					cursoropacitymax:0.9,
					cursorcolor:"#adafb5",
					cursorwidth:"6px",
					cursorborder:"",
					cursorborderradius:"6px",
					usetransition:600,
					background:"",
					railoffset:{top:10,left:-1}
				});
				/*
				$(".bodyscroll").niceScroll({
					autohidemode: false,
					cursoropacitymin:0.9,
					cursoropacitymax:0.9,
					cursorcolor:"#adafb5",
					cursorwidth:"6px",
					cursorborder:"",
					cursorborderradius:"6px",
					usetransition:600,
					railoffset:{top:10,left:-1,bottom:-10}
				});
				*/

        // CHANGE wrapper to table - ONLY DEMO
        // ------------------------------------------------------------------------------------------------ * -->
        $("#btnChangeWrapper1, #btnChangeWrapper2").click(function () {
                $('.widget').toggleClass('widget-simple widget-box');
        });

        // COLLAPSE - WIDGET HEADER
        // ------------------------------------------------------------------------------------------------ * -->
        $('.widget-content.collapse')
                .on('shown', function (e) {
                $(e.target)
                        .parent('.widget-collapsible')
                        .children('.widget-header')
                        .removeClass('collapsed');
                $(e.target)
                        .prev('.widget-header')
                        .find('.widget-toggle')
                        .toggleClass('fontello-icon-publish fontello-icon-window');
        });

        $('.widget-content.collapse')
                .on('hidden', function (e) {
                $(e.target)
                        .parent('.widget-collapsible')
                        .children('.widget-header')
                        .addClass('collapsed');
                $(e.target)
                        .prev('.widget-header')
                        .find('.widget-toggle')
                        .toggleClass('fontello-icon-window fontello-icon-publish');
        });

        // BREADCRUMBS
        // ------------------------------------------------------------------------------------------------ * -->
        $('#breadcrumbs').xBreadcrumbs();

        // BOOTSTRAP BUTTON TOGGLE CHANGE COLOR ON ACTIVE
        // ------------------------------------------------------------------------------------------------ * -->
        $('.btn-group > .btn, .btn[data-toggle="button"]').click(function () {

                if($(this).attr('class-toggle') != undefined && !$(this).hasClass('disabled')) {
                        var btnGroup = $(this).parent('.btn-group');

                        if(btnGroup.attr('data-toggle') == 'buttons-radio') {
                                btnGroup.find('.btn').each(function () {
                                        $(this).removeClass($(this).attr('class-toggle'));
                                });
                                $(this).addClass($(this).attr('class-toggle'));
                        }

                        if(btnGroup.attr('data-toggle') == 'buttons-checkbox' || $(this).attr('data-toggle') == 'button') {
                                if($(this).hasClass('active')) {
                                        $(this).removeClass($(this).attr('class-toggle'));
                                } else {
                                        $(this).addClass($(this).attr('class-toggle'));
                                }
                        }
                }
        });

        // BOOTSTRAP TOOLTIP
        // ------------------------------------------------------------------------------------------------ * -->
        $("a[rel=tooltip], input[rel=tooltip] ").tooltip()

        $('.Ttip').tooltip({
                placement: 'top'
        });
        $('.Rtip').tooltip({
                placement: 'right'
        });
        $('.Btip').tooltip({
                placement: 'bottom'
        });
        $('.Ltip').tooltip({
                placement: 'left'
        });

        // GTIP - TOOLTIP
        // ------------------------------------------------------------------------------------------------ * -->
        var shared = {
                position: {
                        viewport: $(window)
                },
                style: {
                        tip: true,
                        classes: 'ui-tooltip-shadow ui-tooltip-tipsy'
                }
        };

        $('.tip-tl').qtip($.extend({}, shared, {
                position: {
                        my: 'bottom right',
                        at: 'top left'
                }
        }));
        $('.tip-tc, .tip').qtip($.extend({}, shared, {
                position: {
                        my: 'bottom center',
                        at: 'top center'
                }
        }));
        $('.tip-tr').qtip($.extend({}, shared, {
                position: {
                        my: 'bottom left',
                        at: 'top right'
                }
        }));
        $('.tip-bl').qtip($.extend({}, shared, {
                position: {
                        my: 'top right',
                        at: 'bottom left'
                }
        }));
        $('.tip-bc').qtip($.extend({}, shared, {
                position: {
                        my: 'top center',
                        at: 'bottom center'
                }
        }));
        $('.tip-br').qtip($.extend({}, shared, {
                position: {
                        my: 'top left',
                        at: 'bottom right'
                }
        }));
        $('.tip-rt').qtip($.extend({}, shared, {
                position: {
                        my: 'left bottom',
                        at: 'right top'
                }
        }));
        $('.tip-rc').qtip($.extend({}, shared, {
                position: {
                        my: 'left center',
                        at: 'right center'
                }
        }));
        $('.tip-rb').qtip($.extend({}, shared, {
                position: {
                        my: 'left top',
                        at: 'right bottom'
                }
        }));
        $('.tip-lt').qtip($.extend({}, shared, {
                position: {
                        my: 'right bottom',
                        at: 'left top'
                }
        }));
        $('.tip-lc').qtip($.extend({}, shared, {
                position: {
                        my: 'right center',
                        at: 'left center'
                }
        }));
        $('.tip-lb').qtip($.extend({}, shared, {
                position: {
                        my: 'right top',
                        at: 'left bottom'
                }
        }));

        // BOOTSTRAP POPOVER
        // ------------------------------------------------------------------------------------------------ * -->
        // popover demo
        $('.popover').popover({html: true})
        $("[rel=popover]").popover({
                html: true
        });

        // popover hover
        $("[rel=popover-hover]")
                .popover({
                html: true,
                trigger: 'hover',
                delay: {
                        hide: 500
                }
        });

        // Popover hide click to element
        $('[rel=popover-click]')
                .popover({
                html: true,
                delay: {
                        show: 100,
                        hide: 300
                }
        })
                .click(function (e) {
                $(this).popover('toggle');
                e.stopPropagation();
        });
        
        var $modal = $('#ajax-modal');
        
    	$('.RodoviaModal').on('click', function () {               
    			
                rodovia = $(this).attr('data-rodovia');
                
                GlobalModalManager.loading();
                
                $modal.load('/infodprf/infodprf.rodovia.modal.php?rodovia=' + rodovia, '', function () {
					$modal.modal();
                });
    	});
        
        $('.widget-header').on('click', function () {
            setTimeout('scroll_resize()', 1000);
        });
        
        $('.page-bar .nav a').on('click', function () {
            setTimeout('scroll_resize()', 200);
        });

        // SPARKLINE 
        // ------------------------------------------------------------------------------------------------ * -->
        // Change class for tooltip 
		$.fn.sparkline.defaults.common.tooltipClassname = 'sparktip';
		

        // Bootstrap Hack for button radio to hidden input 
		// ------------------------------------------------------------------------------------------------ * -->
        var _old_toggle = $.fn.button.prototype.constructor.Constructor.prototype.toggle;
        $.fn.button.prototype.constructor.Constructor.prototype.toggle = function () {
                _old_toggle.apply(this);
                var $parent = this.$element.parent('[data-toggle="buttons-radio"]')
                var target = $parent ? $parent.data('target') : undefined;
                var value = this.$element.attr('value');
                if(target && value) {
                        $('#' + target).val(value);
                }
        };
       
})(jQuery, this, document);

function scroll_resize(){
    $("html").getNiceScroll().resize();
}

// Busca geral do topo
function validaBusca(is_link){
    var_busca = $('#input_busca_topo').val();
    if(var_busca != '' && var_busca != null){
        $('#form_busca_topo').submit();
    } else {
        $("#ErroBusca").modal('show');
        if(is_link == 0)
        return false;
    }
}

function escolhe_periodo(periodo){
    if(!periodo){
        $('.block-ano, .block-semestre, .block-trimestre, .block-mes, .block-dia').hide();
        return false;
    }
    $('.block-ano').show();       $(".block-ano option:first").attr('selected','selected');
    $('.block-semestre').hide();  $(".block-semestre option:first").attr('selected','selected');
    $('.block-trimestre').hide(); $(".block-trimestre option:first").attr('selected','selected');
    $('.block-mes').hide();       $(".block-mes option:first").attr('selected','selected');
    $('.block-dia').hide();       $(".block-dia option:first").attr('selected','selected');
    
    
}

function escolhe_ano(ano){
    // Identifica o periodo selecionado
    periodo = $('#sel_tp_periodo').val();
    // Semestre
    if(periodo == 'Semestral'){
        $('.block-semestre').show();
        $('.block-trimestre').val('').hide();
        $('.block-mes').val('').hide();
        $('.block-dia').val('').hide();
    }
    // Trimestre
    if(periodo == 'Trimestral'){
        $('.block-trimestre').show();
        $('.block-semestre').val('').hide();
        $('.block-mes').val('').hide();
        $('.block-dia').val('').hide();
    }
    // Mensal
    if(periodo == 'Mensal'){
        $('.block-mes').show();
        $('.block-semestre, .block-trimestre, .block-dia').hide();
    }
    // Diario
    if(periodo == 'Diario'){
        $('.block-mes').show();
        $('.block-semestre, .block-trimestre').hide();
    }
}

function escolhe_semestre(periodo){}
function escolhe_trimestre(periodo){}
function escolhe_mes(mes){
    periodo = $('#sel_tp_periodo').val();
    if(periodo == 'Diario'){
        $('.block-dia').show();
    }
}
function valida_filtro(){
    periodo = $('#sel_tp_periodo').val();
    $('#valida_filtro').validate({
						//ignore: "#accountAddressState input[type=hidden], #accountAddressCountry input[type=hidden]",
						ignore: "",
						rules: {
								sel_tp_periodo: {
										required: true
								}
						},
						messages: {
								sel_tp_periodo: {
										required: "Please enter a First Name"
								}
						},
						highlight: function (label) {
								$(label).closest('p').addClass('error');
						},
						success: function (label) {
								$(label).addClass('valid')
										.closest('p').addClass('success');
						},
						errorPlacement: function (error, label) {
						}
				});
                return false;
}


