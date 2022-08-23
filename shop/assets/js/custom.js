 $(document).ready(function () {
 
 $(document).on('click', '#proceed_to_checkout', function() {
    window.location.href='?c=checkout';
 });

 $(document).on('click', '#place_order', function() {
    window.location.href='?c=checkout&m=success';
 });


});