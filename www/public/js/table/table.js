$("#estates-table").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
    // "order": [[ 3, "desc" ]]
}).buttons().container().appendTo('#estates-table__wrapper .col-md-6:eq(0)');
