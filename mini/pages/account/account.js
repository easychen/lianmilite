import regeneratorRuntime from '../../utils/wxPromise.min.js';
const app = getApp();

Page({
    data: {
        user: {}
    },

    async onReady(options) {
        await app.code2token();
        this.loadUser()
    },
    async loadUser() {
        try {
            const user = await wx.lm.userDetail(app.globalData.guid);
            if (user.id > 0) {
                this.setData({
                    "user": user
                });
            }
        } catch (e) {
            console.log(e);
            wx.showToast({
                title: e.messsage.toString(),
                icon: 'none'
            });
        }
    },

    info() {
        wx.showToast({
            title: '莲米粒v0.1'
        });
    }


})