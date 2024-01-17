

const tbConfig = { scrollX: true, dom: 'lBfrtip',
"language": {
    "lengthMenu": "<b>Entries</b> _MENU_",
},
buttons: [
    // { extend: 'copy', exportOptions: { columns: ':not(:last-child)' } },
    { extend: 'csv', exportOptions: { columns: ':not(:last-child)' } },
    { extend: 'excel', exportOptions: { columns: ':not(:last-child)' } },
    {   extend: 'print', 
        exportOptions: { columns: ':not(:last-child)' }, 
        customize: function (win) {
            var title = $(win.document.body).find('h1');
            var table = $(win.document.body).find('table');
            title.css({
                'text-align': 'center',
                'margin-top': '30px',
                'font-size': '25px',
            });
            table.css({
                'margin-top': '30px',
                'margin-bottom': '30px',
            });

            var customHeader = `
            <div style="display: flex; justify-content: center;">
                <img src="../../images/victoria.png" style="max-width: 130px;">
                <div style="display: flex; flex-direction:column; align-items: center; justify-content: center;">
                    <h5>VICTORIA CATHOLIC SCHOOL OF TARLAC INC.</h5>
                    <small style="display:block">Sta. Lucia, Victoria, Tarlac</small>
                    <small style="display:block">School Year `+currentYear+`-`+(currentYear+1)+`</small>
                </div>
            </div>`;

            $(win.document.body).prepend(customHeader);
        }
    }
]};

var tablesID = new DataTable('#tablesID', tbConfig);
