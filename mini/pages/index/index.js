import regeneratorRuntime from '../../utils/wxPromise.min.js';

//index.js
//获取应用实例
const app = getApp()

Page({
    data: {
        currentTab: 0,
        showList: false
    },
    async onReady() {
        await app.code2token();
        this.setData({
            "showList": true,
            "api_base": app.globalData.api_base
        });
    },
    swiperTab: function(e) {
        this.setData({
            currentTab: e.detail.current
        });
    },
    clickTab: function(e) {
        if (this.data.currentTab === e.target.dataset.current) {
            return false;
        } else {
            this.setData({
                currentTab: e.target.dataset.current
            })
        }
    }

})