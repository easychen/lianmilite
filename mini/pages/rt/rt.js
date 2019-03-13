import regeneratorRuntime from '../../utils/wxPromise.min.js';
const app = getApp();

Page({


    data: {
        fid: 0,
        content: '',
        origin: {},
        button_enabled: false
    },


    onLoad(options) {
        this.setData({
            "fid": parseInt(options.fid, 10)
        });
    },

    async loadFeed() {
        if (this.data.fid < 1) {
            wx.showToast({
                title: "错误的feedid" + this.data.fid,
                icon: 'none'
            });
            return false;
        }

        try {
            const feed = await wx.lm.feedDetail(this.data.fid);

            let origin = feed;
            origin.rt_id = origin.id;
            origin.rt_uid = app.globalData.guid;
            origin.rt_user = {
                "id": app.globalData.guid,
                "nickname": app.globalData.nickname,
                "avatar": app.globalData.avatar
            };


            this.setData({
                "origin": origin
            });
        } catch (e) {
            wx.showToast({
                title: e.messsage + '',
                icon: 'none'
            });
        }
    },


    async onReady() {
        await app.code2token();
        await this.loadFeed();
        this.setData({
            'button_enabled': true
        });
    },

    onChange(e) {
        this.setData({
            "origin.rt_content": e.detail.value
        });
    },

    async rt(e) {
        const content = e.detail.value.content;

        try {
            const feed = await wx.lm.feedRt(this.data.fid, content);
            if (feed.id > 0) {
                // 发布成功
                wx.showToast({
                    title: '转发成功'
                });
                // 清空content数据
                this.setData({
                    'content': ''
                });

                setTimeout(() => wx.navigateBack(), 500);
            }
        } catch (e) {
            wx.showToast({
                title: e.messsage + '',
                icon: 'none'
            });
        }
    }


})