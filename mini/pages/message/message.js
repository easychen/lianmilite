import regeneratorRuntime from '../../utils/wxPromise.min.js';
const app = getApp();

Page({


    data: {
        "show_list": false
    },


    onLoad: function(options) {},

    async onReady() {
        await app.code2token();
        this.setData({
            "show_list": true,
            "api_base": app.globalData.api_base
        });
    }
})