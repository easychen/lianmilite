import regeneratorRuntime from '../../utils/wxPromise.min.js';
const app = getApp();
Page({


    data: {
        content: '',
        feed: {},
        button_enabled: false
    },

    async onReady() {
        await app.code2token();

        let feed = {
            "id": "1",
            "rt_id": "0",
            "author_openid": "",
            "author_guid": app.globalData.guid,
            "content": ""
        };
        feed.user = {
            "id": app.globalData.guid,
            "nickname": app.globalData.nickname,
            "avatar": app.globalData.avatar
        };

        this.setData({
            'button_enabled': true,
            'feed': feed
        });

    },

    onChange(e) {
        let o = this.data.feed;
        o.content = e.detail.value;
        this.setData({
            "feed": o
        });
    },

    async publish(e) {
        const content = e.detail.value.content;
        if (content.length < 1) {
            wx.showToast({
                title: '发布内容不能为空',
                icon: 'none'
            });
            return false;
        }

        try {
            const feed = await wx.lm.feedPublish(content);
            if (feed.id > 0) {
                wx.showToast({
                    title: '内容已成功发布'
                });
                this.setData({
                    'content': '',
                    'feed.content': ''
                });
                app.globalData.event.emit("feedreload");
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