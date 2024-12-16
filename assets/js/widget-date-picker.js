jQuery(function() {
    // Get today's date in dd-mm-yy format
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
    var yyyy = today.getFullYear();
    today = dd + '-' + mm + '-' + yyyy;

    // Initialize the datepicker
    jQuery(".datepicker").datepicker({
        dateFormat: 'dd-mm-yy', // Set the date format
        defaultDate: today // Set today's date
    });

    // Set the placeholder to today's date
    jQuery(".datepicker").attr("placeholder", today);
});
