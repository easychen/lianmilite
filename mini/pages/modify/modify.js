import regeneratorRuntime from '../../utils/wxPromise.min.js';
const app = getApp();

Page({


    data: {
        fid: 0,
        content: '',
        feed: {},
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

            const content_field = feed.rt_id > 0 ? 'rt_content' : 'content';
            this.setData({
                "content": feed[content_field],
                feed
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
        const content_field = this.data.feed.rt_id > 0 ? 'rt_content' : 'content';
        let o = this.data.feed;
        o[content_field] = e.detail.value;
        this.setData({
            "feed": o
        });
    },

    async update(e) {
        const content = e.detail.value.content;
        if (content.length < 1) {
            wx.showToast({
                title: '发布内容不能为空',
                icon: 'none'
            });
            return false;
        }

        try {
            const feed = await wx.lm.feedUpdate(this.data.fid, content);

            if (feed.id > 0) {
                wx.showToast({
                    title: '内容更新成功'
                });

                // 清空content数据
                this.setData({
                    'content': ''
                });

                // console.log("emit feedlistupdate start");
                app.globalData.event.emit("feedlistupdate", {
                    "feed": feed
                });

                setTimeout(() => wx.navigateBack(), 500);
            }
        } catch (e) {
            console.log(e);
            wx.showToast({
                title: e.messsage + '',
                icon: 'none'
            });
        }



    }


})