import regeneratorRuntime from '../../utils/wxPromise.min.js';
const app = getApp();
Page({
    data: {
        fid: 0,
        feed: {},
        show_menu: false
    },

    onLoad(options) {
        console.log("feed");
        this.setData({
            "fid": parseInt(options.fid, 10)
        });
    },

    async onReady() {
        await app.code2token();
        await this.loadFeed();
        app.globalData.event.on('feedlistupdate', e => {
            if (e.feed && e.feed.id == this.data.fid) {
                this.setData({
                    "feed.content": e.feed.content,
                    "feed.rt_content": e.feed.rt_content
                });
            }
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
            this.setData({
                feed
            });
        } catch (e) {
            wx.showToast({
                title: e.messsage + '',
                icon: 'none'
            });
        }
    }


})