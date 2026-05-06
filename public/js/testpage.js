$(document).ready(function () {
    function filterFields() {
        var val = $('select[name="type_val"]').val();

        $('input[name]').each(function () {
            var $p = $(this).closest('p');
            var type = $(this).attr('name').split('_')[1]; // берем тип из name
            $p.toggle(type === val);
        });
    }

    $('select[name="type_val"]').on('change', filterFields);

    filterFields();
});
