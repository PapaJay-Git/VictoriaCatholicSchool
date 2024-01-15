

const tbConfig = { scrollX: true, dom: 'lBfrtip',
"language": {
    "lengthMenu": "<b>Entries</b> _MENU_",
},
buttons: [
    // { extend: 'copy', exportOptions: { columns: ':not(:last-child)' } },
    { extend: 'csv', exportOptions: { columns: ':not(:last-child)' } },
    { extend: 'excel', exportOptions: { columns: ':not(:last-child)' } },
    { extend: 'pdf', exportOptions: { columns: ':not(:last-child)' } },
    { extend: 'print', exportOptions: { columns: ':not(:last-child)' } }
]};

var tablesID = new DataTable('#tablesID', tbConfig);
