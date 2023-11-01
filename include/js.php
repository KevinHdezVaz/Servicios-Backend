<?php
require 'include/dbconfig.php';
echo $fetch_main['data'];
?>
<script src="select2/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2-multi-select').select2({
    placeholder: "Select a Product",
    allowClear: true
});
})
</script>