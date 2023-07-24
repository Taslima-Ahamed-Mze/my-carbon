$(document).ready(function () {
    if ($(".table").length) {
        $(".table").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
            },
        });
    }
});
