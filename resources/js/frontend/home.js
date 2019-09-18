$(function () {
    'use strict';

    $('.tooltipster').tooltipster({
        contentAsHTML: true,
        interactive: true,
        functionBefore(instance, helper) {

            let $origin = $(helper.origin);
            let regionId = $origin.attr('id');

                $.getJSON( "/api/regions/"+regionId, function( data ) {
                    let municipalities = data.data.municipalities;

                    let str = '';
                    for(let municipality of municipalities) {
                        str += '<div class="map-tooltip-item"><a target="_blank" href="'+municipality.website+'">'+municipality.name+'</a> (<a href="/municipalities/'+municipality.id+'">'+municipality.project_count+' პროექტი</a>)</div>';
                    }

                    if(municipalities.length === 0) {
                        str = 'მუნიციპალიტეტები არ არსებობს';
                    }

                    instance.content(str);
                });

                $origin.data('ajax', 'cached');
        },
        functionAfter(origin) {
            let regionName = $(origin._$origin).attr('name');
        }
    });
    //
    // function loadRegionData(id) {
    //     $('#tooltip_content').html('');
    //
    //     $.getJSON( "/api/regions/"+id, function( data ) {
    //         let municipalities = data.data.municipalities;
    //
    //         let str = '';
    //         for(let municipality of municipalities) {
    //             str += '<a class="d-block" target="_blank" href="'+municipality.website+'">'+municipality.name+'</a> (<a href="/municipalities/'+municipality.id+'">'+municipality.project_count+' პროექტი</a>)';
    //         }
    //
    //         if(municipalities.length === 0) {
    //             str = 'მუნიციპალიტეტები არ არსებობს';
    //         }
    //
    //         $('#tooltip_content').html(str);
    //
    //         // TODO not working
    //     });
    // }
});
