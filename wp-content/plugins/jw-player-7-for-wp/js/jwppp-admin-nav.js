//JW PLAYER PREMIUM PLUGIN

jQuery(document).ready(function ($) {

	//TABS
    var jwppp_pagination = function() {

        var $contents = $('.jwppp-admin')
        var url = window.location.href.split("#")[0];
        var hash = window.location.href.split("#")[1];

        if(hash) {
            $contents.hide();           
            $('#' + hash).fadeIn(200);      
            $('h2#jwppp-admin-menu a.nav-tab-active').removeClass("nav-tab-active");
            $('h2#jwppp-admin-menu a').each(function(){
                if($(this).data('link') == hash) {
                    $(this).addClass('nav-tab-active');
                }
            })
            
            $('html, body').animate({
                scrollTop: 0
            }, 'slow');
        }

        $("h2#jwppp-admin-menu a").click(function() {
            var $this = $(this);
            
            $contents.hide();
            $("#" + $this.data("link")).fadeIn(200);
            $('h2#jwppp-admin-menu a.nav-tab-active').removeClass("nav-tab-active");
            $this.addClass('nav-tab-active');

            window.location = url + '#' + $this.data('link');

            $('html, body').scrollTop(0);

        })
                
    }

    jwppp_pagination();

	//RELATED VIDEOS THUMBNAIL/ CUSTOM FIELD
    if($('#jwppp-show-related').prop('checked') == false) {
        $('.related-options').hide();
    }

    $('#jwppp-show-related').on('change',function() {
        if($('#jwppp-show-related').prop('checked')) {
            $('.related-options').show('slow');
        } else {
            $('.related-options').hide();
        }

    });

    if($("#thumbnail").val() == 'featured-image') {
        $(".cf-row").hide();
    }

	$('#thumbnail').on('change',function(){

        if( $(this).val() == "custom-field" ){
	        $(".cf-row").show('slow')
	        $(".cf-row").attr('required', 'required');
        }
        else{
	        $(".cf-row").hide();
	        $(".cf-row").removeAttr('required');
        }
    });

    //SHARE
    if($('#jwppp-active-share').prop('checked') == false) {
        $('.share-options').hide();
    }

    $('#jwppp-active-share').on('change',function() {
        if($('#jwppp-active-share').prop('checked')) {
            $('.share-options').show('slow');
        } else {
            $('.share-options').hide();
        }

    });

    //DIMENSIONS METHOD
    if($('#fixed').prop('selected') == true) {
        $('.more-responsive').hide();
    } else {
        $('.more-fixed').hide();
    }

    $('#jwppp-method-dimensions').on('change', function() {
        if($('#fixed').prop('selected')) {
            $('.more-responsive').hide();
            $('.more-fixed').show('slow');                   
        } else {
            $('.more-fixed').hide();
            $('.more-responsive').show('slow'); 
        }
    }); 

    //ADS
    if($('#jwppp-active-ads').prop('checked') == false) {
        $('.ads-options').hide();
    }

    $('#jwppp-active-ads').on('change',function() {
        if($('#jwppp-active-ads').prop('checked')) {
            $('.ads-options').show('slow');
        } else {
            $('.ads-options').hide();
        }

    });

    //COLOR FIELD FOR SUBTITLES
    $('.jwppp-color-field').wpColorPicker();

});
