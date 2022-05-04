define(
    [
        'uiComponent',
        'ko'
    ],
    (Component, ko) =>
    Component.extend({
        clock: ko.observable("Loading ..."),
        initialize: function () {
            this._super();
            setInterval(() => this.reloadTime(), 1000);
        },
        reloadTime: function () {
            let now = new Date(Date.now());
            let str = `${insertZeroBefore(now.getHours())}:${insertZeroBefore(now.getMinutes())}:${insertZeroBefore(now.getSeconds())}`;
            this.clock(str);

            function insertZeroBefore(val){
                if (val<10)
                    return `0${val}`;
                return `${val}`;
            }
        },
        getClock: function () {
            return this.clock;
        }
    })
);
