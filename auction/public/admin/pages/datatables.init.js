/*
 Template Name: Lexa - Responsive Bootstrap 4 Admin Dashboard
 Author: Themesbrand
 File: Datatable js
 */

$(document).ready(function() {
    var table = $('#datatable').DataTable({
        "processing": false
    });
    showLoaderAndHideAfterEventFinished(table);
    $('.dataTables_filter input').attr('placeholder', 'Minimum 3 characters').off()
        .on('keyup', function() {
            if(this.value.trim().length > 2 || this.value.trim().length === 0){
                table.search( this.value ).draw();
            }
        });
} );
function showLoaderAndHideAfterEventFinished(table){
    var _loader = $('.loader');
    table
        .on( 'preDraw', function () {
            _loader.show();
        } )
        .on( 'search.dt', function () {
            _loader.show();
        } )
        .on( 'page.dt', function () {
            _loader.show();
        } )
        .on( 'row-reorder', function () {
            _loader.show();
        } )
        .on( 'draw.dt', function () {
            _loader.fadeOut(1000);
        } );
}
