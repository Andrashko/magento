define(
    [
        'uiComponent',
        'ko',
        'underscore'
    ],
    (Component, ko, _) =>
    Component.extend({
        initialize: function () {
            this._super();
        },
        getItems: function (){
            return _.toArray(this.items);
        }
    })
);
