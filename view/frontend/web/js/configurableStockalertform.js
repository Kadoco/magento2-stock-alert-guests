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
            productId: 0,
            tracks: {
                displayStockAlertForm: true,
                productId:true,
                note:true,
                successNote:true
            }
        },

        initialize: function (config, element) {
            this._super();
            const self = this;
            setTimeout(() => {
                $('.super-attribute-select').prop( "disabled", false );
                $('.super-attribute-select').on('change', function() {
                    self.productId = $("[name='selected_configurable_option']").val();
                    self.note="";
                    self.successNote="";
                    self.email="";
                    if (self.productId) {
                        if (config.stock.hasOwnProperty(self.productId)) {
                            self.displayStockAlertForm = !config.stock[self.productId];
                        } else {
                            self.displayStockAlertForm = false;
                        }

                        if (self.displayStockAlertForm) {
                            $('.product-options-bottom').hide();
                        } else{
                            $('.product-options-bottom').show();
                        }
                    }
                });

                $("#stock-alert-submit").attr('action', config.url);
            }, 1000)

        },
        submitAlert: function(config, element) {
            let email = $('#stock-guest-email').val();
            if (!this.validateEmail(email)) {
                $('.stock-guest-note-' . productId).show();
                $('.stock-guest-note-success-'.  productId).hide();
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
                        $('.stock-guest-note').hide();
                        $('.stock-guest-note-success').show();
                        self.successNote = "Du modtager en e-mail, når produktet er på lager igen";
                    } else{
                        $('.stock-guest-note').show();
                        $('.stock-guest-note-success').hide();
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

