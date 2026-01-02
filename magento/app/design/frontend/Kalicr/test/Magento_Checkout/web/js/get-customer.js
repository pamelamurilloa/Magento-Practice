define([
    'jquery',
    'Magento_Customer/js/customer-data'
], function ($, customerData) {
    'use strict';

    return function (config, element) {
        var displayElement = $(element).find('.customer-name-display');
        
        var customer = customerData.get('customer');

        var updateGreeting = function (data) {
            if (data && data.firstname) {
                displayElement.text(data.firstname);
            } else {
                displayElement.text('Guest');
            }
        };

        updateGreeting(customer());

        customer.subscribe(function (updatedData) {
            updateGreeting(updatedData);
        });
    };
});