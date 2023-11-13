const WpReactionsUtils = {
    showMessage: function (msg, type, time = 'fast') {
        let mseconds = 6000;
        if (time === 'long') {
            mseconds = 8000;
        }
        let $obj = jQuery('<div class="wpra-message wpra-message-' + type + '"><p>' + msg + '</p><span>&times;</span></div>').appendTo('.wpra-messages-container');
        $obj.find('span').on('click', function () {
            $obj.fadeOut('slow', function () {
                $obj.remove();
            });
        });
        if (time !== 'stick') {
            $obj.delay(mseconds).fadeOut('slow', function () {
                $obj.remove();
            });
        }
        $obj.on('mouseover', function () {
            jQuery(this).clearQueue();
        });
    },
    toIntegerArray: function (arr) {
        return arr.split(',').map(function (num) {
            return parseInt(num);
        });
    },
    differ: function (arr1, arr2) {
        return arr1.filter(function (item) {
            return !arr2.includes(item);
        });
    },
}