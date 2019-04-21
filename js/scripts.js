'use strict';
(function ($) {
    $("body").on("change", "select", function () {
        let $this = $(this);
        let prevVal = $this.data("prev");
        let otherSelects = $("select").not(this);
        let value = $(this).val();
        if (value != 0) {
            otherSelects.find("option[value=" + $(this).val() + "]").attr('disabled', true);
        }
        if (prevVal) {
            otherSelects.find("option[value=" + prevVal + "]").attr('disabled', false);
        }
        $this.data("prev", $this.val());
    });

})(jQuery);
