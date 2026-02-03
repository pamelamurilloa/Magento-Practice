define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote) {
    'use strict';

    return function (setShippingInformationAction) {
        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var shippingAddress = quote.shippingAddress();
            
            var inputSelector = '[name="shippingAddress.custom_attributes.cedula"]';
            var rawValue = $(inputSelector).val();

            if (!rawValue) {
                rawValue = $('input[name*="cedula"]').val();
            }

            if (rawValue) {
                if (shippingAddress['extension_attributes'] === undefined) {
                    shippingAddress['extension_attributes'] = {};
                }
                shippingAddress['extension_attributes']['cedula'] = rawValue;
            }

            return originalAction();
        });
    };
});