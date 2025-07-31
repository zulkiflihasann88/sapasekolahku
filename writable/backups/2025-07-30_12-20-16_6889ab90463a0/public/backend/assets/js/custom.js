

"use strict";

// custom menu active
var path = location.pathname.split('/')
var url = location.origin + '/' + path[1]
var url = location.origin + '/' + path[1] +  '/' + path[2] + '/' + path[3]
$('ul.sidebar-menu li a').each(function() {
    if($(this).attr('href').indexOf(url) !== -1) {
        $(this).parent().addClass('active').parent().parent('li').addClass('active')
    }
})
// console.log(url)

// datatables
$(document).ready( function () {
    $('#table1').DataTable();
});

// modal confirmation
function submitDel(id) {
    $('#del-'+id).submit()
}

function returnLogout() {
    var link = $('#logout').attr('href')
    $(location).attr('href', link)
}