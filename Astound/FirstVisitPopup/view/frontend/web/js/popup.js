define([
    'uiComponent',
    'jquery',
    'matchMedia',
    'Magento_Ui/js/modal/modal'
], function(Component, $, mediaCheck, modal) {
    'use strict';

    return Component.extend({
        defaults: {
            cookieName: '',
            cookieLifetime: '',
            content_width: '',

            modalSelector: '#modal-container-popup',
            modalInnerWrapSelector: '.modal-inner-wrap',
            modalClassName: 'newsletter-widget',
            formSelector: '#popup-newsletter-validate-detail',
            responseSelector: '.newsletter-response',
            loaderSelector: '.js-ajax-loader',
            mediaBreakpoint: '(max-width: 1024px)'
        },

        initialize: function() {
            this._super();

            if (!this._checkIfPopupVisible()) {
                return;
            }

            this._defineNodes();
            this._createModal();

            this._openModal();
        },
        _checkIfPopupVisible: function () {
            var self = this;

            mediaCheck({
                media: self.mediaBreakpoint,
                entry: function() {
                    self.isPopupVisible = false;
                },
                exit: function() {
                    self.isPopupVisible = true;
                }
            });
            return this.isPopupVisible;
        },
        _defineNodes: function() {
            this.$modal = $(this.modalSelector);
            this.$form = $(this.formSelector);
        },
        _createModal: function() {
            var self = this,
                modalOptions = {
                    type: 'popup',
                    responsive: false,
                    innerScroll: false,
                    title: false,
                    buttons: false,
                    modalClass: self.modalClassName,
                    closed: function() {
                        self.setModalCookie();
                    },
                    opened: function() {
                        self._registerFormSubmit();
                    }
                };
            this.modalInstance = new modal(modalOptions, this.$modal);
        },
        _openModal: function() {
            var modalContainer = this.modalInstance.element,
                modalInnerWrap = modalContainer.closest(this.modalInnerWrapSelector);

            if (this.getModalCookie()) {
                return;
            }
            modalInnerWrap.css('max-width', this.content_width);
            modalContainer.modal('openModal');

            $(this.modalSelector).trigger('newsletterPopUpOpen');
        },

        _registerFormSubmit: function() {
            var self = this, responseContainer = this.$form.find(this.responseSelector),
                loader = this.$form.find(this.loaderSelector);

            $('body').on('submit', this.formSelector, function(event) {
                var form = event.target;

                event.preventDefault();

                if (!$(form).validation().valid()) {
                    return;
                }

                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: $(form).serialize(),
                    beforeSend: function () {
                        loader.show();
                        responseContainer.text('');
                    },
                    complete: function(response) {
                        var result = JSON.parse(response.responseText);
                        loader.hide();
                        responseContainer.text(result.html_message);
                        if (!result.error) {
                            $(self.modalSelector).trigger('newsletterPopUpSubmit');
                        }
                    },
                    error: function(xhr, status, errorThrown, response) {
                        var result = JSON.parse(response.responseText);
                        responseContainer.text(result.html_message);
                    }
                });
            });
        },
        getModalCookie: function() {
            return $.mage.cookies.get(this.cookieName);
        },
        setModalCookie: function() {
            $.mage.cookies.set(this.cookieName, JSON.stringify(true), {
                lifetime: this.cookieLifetime * 24 * 60 * 60
            });
        }
    });
});
