$(function () {
    'use strict';

    $('.tooltipster').tooltipster({
        contentCloning: true,
        interactive: true,
        functionBefore(origin) {
            let regionId = $(origin._$origin).attr('id');

            loadRegionData(regionId);
        },
        functionAfter(origin) {
            let regionName = $(origin._$origin).attr('name');
        }
    });

    function loadRegionData(id) {
        $('#tooltip_content').html('');

        $.getJSON( "/api/regions/"+id, function( data ) {
            let municipalities = data.data.municipalities;

            let str = '';
            for(let municipality of municipalities) {
                str += '<a class="d-block" target="_blank" href="'+municipality.website+'">'+municipality.name+'</a> (<a href="/municipalities/'+municipality.id+'">'+municipality.project_count+' პროექტი</a>)';
            }

            if(municipalities.length === 0) {
                str = 'მუნიციპალიტეტები არ არსებობს';
            }

            $('#tooltip_content').html(str);

            // TODO not working
        });
    }
});
