'use strict';

const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../public/bundles/fosjsrouting/js/router.min.js';

$(function() {
    //set the routes for the Routing object
    Routing.setRoutingData(routes);

    /*++++++++++++ start detail ++++++++++++++*/
    $(document).on("click", '.show-modal-detail', function(event) {
        getDetail(event, this);
    })

    function getDetail(event, selector) {
		event.preventDefault();
        let idMovie = $(selector).data('movie');
        $.ajax({
            type: 'get',
            url: Routing.generate('app_ajax_detail_movie', {id: idMovie}, true),
            success: function (data) {
                if (data.isValid == 1) {
                    $("#showDetail-content").html(data.content);
                    $("#showDetail").modal('show');
                } else {
                    console.log('error');
                }
            }
        });
	}
    /*------------- end detail ---------------*/

    /*++++++++ start movies_by_genres ++++++++*/
    $("input[id^='genre_']").on("click", function(event) {
        let genresIds = [];
        $("input[id^='genre_']:checked").each(function() {
            genresIds.push(this.value);
        });

        $.ajax({
            type: 'post',
            url: Routing.generate('app_ajax_movies_by_genres'),
            data: {genresIds:genresIds},
            success: function (data) {
                if (data.isValid == 1) {
                    $("#list_movies").html(data.content);
                    $("#main_video").attr('src', data.videoUrl);
                } else {
                    console.log('error');
                }
            }
        });
    })
    /*--------- end movies_by_genres ---------*/

    /*++++++++++++ start search ++++++++++++++*/
    let previousVal = null;
    let timer = null;
    $("#search").on("keyup change", function(event) {
        clearTimeout(timer);
        var self = this;
        let val = $(self).val().trim();
 
        timer = setTimeout(function () {
            search(val, previousVal);
            previousVal = val;
        }, 1000);
        
    })


    function search(val, previousVal)
    {
        if (val.length >= 2 && val !== previousVal) {
            $.ajax({
                type: 'post',
                url: Routing.generate('app_ajax_search_movies'),
                data: {needle:val},
                success: function (data) {
                    if (data.isValid == 1) {
                        $("#list_search").removeClass('d-none');
                        $("#list_search").addClass('d-block');
                        $("#list_search").html(data.content);
                    } else {
                        console.log('error');
                    }
                },
                error: function () {
                    $("#list_search").html(null);
                    $("#list_search").addClass('d-none');
                    $("#list_search").removeClass('d-block');
                }
            });
        }
    }

    $(document).on("click", function(event) {
        $("#search").val(null);
        $("#list_search").html(null);
        $("#list_search").addClass('d-none');
        $("#list_search").removeClass('d-block');
    })
    /*------------- end search ---------------*/
})