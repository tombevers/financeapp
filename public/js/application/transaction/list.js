$(document).ready(function() {
    $('#transactionsTable').dataTable({
        "asStripClasses": [],
        "iDisplayLength": 25,
        "aLengthMenu": [[25,50,100], [25,50,100]],
        "aoColumns": [
            { "bSortable": true },
            null,
            { "bSortable": false },
        ]
    });
});