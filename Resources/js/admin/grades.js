

const tbConfig = { scrollX: true, dom: 'lBfrtip',
"language": {
    "lengthMenu": "<b>Entries</b> _MENU_",
},
buttons: [
    // { extend: 'copy' },
    { extend: 'csv' },
    { extend: 'excel' },
    { extend: 'pdf' },
    { extend: 'print' }
]};

var gradesTable = new DataTable('#gradesTable', tbConfig);

JSON
