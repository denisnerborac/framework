var crop = {

    jcrop_api: null,
    boundx: 0,
    boundy: 0,

    init: function() {

        // Grab some information about the preview pane
        $preview = $('#preview-pane'),
        $pcnt = $('#preview-pane .preview-container'),
        $pimg = $('#preview-pane .preview-container img'),

        xsize = $pcnt.width(),
        ysize = $pcnt.height();

        console.log('init',[xsize,ysize]);

        $('#target').Jcrop({
            onChange: crop.updatePreview,
            onSelect: crop.updatePreview,
            aspectRatio: xsize / ysize
        }, function() {
            // Use the API to get the real image size
            var bounds = this.getBounds();
            crop.boundx = bounds[0];
            crop.boundy = bounds[1];

            // Store the API in the jcrop_api variable
            crop.jcrop_api = this;

            // Move the preview into the jcrop container for css positioning
            $preview.appendTo(crop.jcrop_api.ui.holder);
        });
    },

    updatePreview: function(c) {
        if (parseInt(c.w) > 0) {

            $('#x').val(c.x);
            $('#y').val(c.y);
            $('#w').val(c.w);
            $('#h').val(c.h);

            var rx = xsize / c.w;
            var ry = ysize / c.h;

            $pimg.css({
                width: Math.round(rx * crop.boundx) + 'px',
                height: Math.round(ry * crop.boundy) + 'px',
                marginLeft: '-' + Math.round(rx * c.x) + 'px',
                marginTop: '-' + Math.round(ry * c.y) + 'px'
            });
        }
    }

};

var admin = {

    init: function() {

        $('#side-menu').metisMenu();

        if ($('table.table').length > 0) {
            $('table.table').each(function() {
                var id = $(this).attr('id');
                $('#'+id).DataTable({
                    responsive: true
                });
            })
        }

        $(window).bind("load resize", function() {
            topOffset = 50;
            width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
            if (width < 768) {
                $('div.navbar-collapse').addClass('collapse');
                topOffset = 100; // 2-row-menu
            } else {
                $('div.navbar-collapse').removeClass('collapse');
            }

            height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
            height = height - topOffset;
            if (height < 1) height = 1;
            if (height > topOffset) {
                $("#page-wrapper").css("min-height", (height) + "px");
            }
        });

        crop.init();

    },



};

$(document).ready(function(){
    admin.init();
});