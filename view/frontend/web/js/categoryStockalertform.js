define([
    'uiComponent',
    'jquery',
    'domReady!'
], function (Component, $) {
    'use strict';

    return Component.extend({
        defaults: {
            displayStockAlertForm: false,
            note: "",
            successNote: "",
            tracks: {
                displayStockAlertForm: true,
                productId:true,
                note:true,
                successNote:true
            }
        },

        initialize: function (config, element) {
            this._super();
        },
        submitAlert: function(config, element) {
            $(element.target).parent().parent().parent().parent().parent().parent().find('.product-item-inner').css('height', 'unset');

            $('.stock-alert-category__wrapper-' + this.productId).show();
        },
        submitForm: function(config, element) {
            let productId = this.productId;
            let email = $('#stock-guest-email-'+ productId).val();
            if (!this.validateEmail(email)) {
                $('.stock-guest-note-' + productId).show();
                $('.stock-guest-note-success-' + productId).hide();
                this.note = "E-mailen er ikke gyldig";
                return;
            }
            const self = this;

            $.ajax({
                url: config.stockUrl,
                data: {'subscribe_id': this.productId, 'email': email},
                type: 'POST',
                dataType: 'json',
                success: function(data, status, xhr) {
                    if (data.hasOwnProperty('success')
                        && data.success){
                        self.note="";
                        this.email="";
                        $('.stock-guest-note-'  + productId).hide();
                        $('.stock-guest-note-success-' + productId).show();
                        self.successNote = "Du modtager en e-mail, når produktet er på lager igen";
                    } else{
                        $('.stock-guest-note-' + productId).show();
                        $('.stock-guest-note-success' + productId).hide();
                        self.successNote="";
                        self.note = "E-mailen er ikke gyldig";
                    }
                }
            });
        },
        validateEmail: function(email) {
            const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    });
});

