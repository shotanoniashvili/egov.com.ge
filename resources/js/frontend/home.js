$(function () {
    'use strict';

    $('.tooltipster').tooltipster({
        contentAsHTML: true,
        interactive: true,
        functionBefore(instance, helper) {
            let $origin = $(helper.origin);
            let municipalityId = $origin.attr('data-id');

            $.getJSON( "/api/municipalities/"+municipalityId, function( data ) {
                let municipality = data.data;

                let str = '<div class="map-tooltip-item">' +
                    '   <div class="text-center"> <a id="municipalityLink" target="_blank" href="/municipalities/'+municipality.id+'">' + municipality.name + '</a></div>' +
                    '   <div class="municipality-image text-center"><a id="municipalityLink" target="_blank" href="/municipalities/'+municipality.id+'"><img src="'+municipality.image+'" /></a></div> ' +
                    '   <div class="municipality-website mb-3"><a target="_blank" href="'+municipality.website+'">ვებგვერდი</a></div> ' +
                    '   <div class="municipality-projects"><a href="/best-practice?municipalities[]='+municipality.id+'">'+municipality.project_count+' პროექტი</a></div> ' +
                    '</div>';

                instance.content(str);
            });

            $origin.data('ajax', 'cached');
        },
    });

    // $('.tooltipster').tooltipster({
    //     contentAsHTML: true,
    //     interactive: true,
    //     functionBefore(instance, helper) {
    //
    //         let $origin = $(helper.origin);
    //         let regionId = $origin.attr('id');
    //
    //         $.getJSON( "/api/regions/"+regionId, function( data ) {
    //             let municipalities = data.data.municipalities;
    //
    //             let str = '';
    //             for(let municipality of municipalities) {
    //                 str += '<div class="map-tooltip-item"><a target="_blank" href="'+municipality.website+'">'+municipality.name+'</a> (<a href="/municipalities/'+municipality.id+'">'+municipality.project_count+' პროექტი</a>)</div>';
    //             }
    //
    //             if(municipalities.length === 0) {
    //                 str = 'მუნიციპალიტეტები არ არსებობს';
    //             }
    //
    //             instance.content(str);
    //         });
    //
    //         $origin.data('ajax', 'cached');
    //     },
    //     functionAfter(origin) {
    //         let regionName = $(origin._$origin).attr('name');
    //     }
    // });
});
