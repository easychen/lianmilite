import regeneratorRuntime from '../../utils/wxPromise.min.js';
const app = getApp();

Page({

    data: {
        uid: 0,
        show_message_list: false
    },


    onLoad(options) {
        console.log(options);
        this.setData({
            "uid": options.uid,
            "nickname": options.nickname
        });

    },


    async onReady() {
        wx.setNavigationBarTitle({
            title: '和' + this.data.nickname + '的对话',
        });
        await app.code2token();
        this.setData({
            'show_message_list': true,
            "api_base": app.globalData.api_base
        });
    },

    async talk(e) {
        const text = e.detail.value.text;
        if (text.length < 1) {
            wx.showToast({
                title: '发送内容不能为空',
                icon: 'none'
            });
            return false;
        }

        try {
            const result = await wx.lm.messageSend(text, this.data.uid);
            if (result == 'done') {
                wx.showToast({
                    title: '私信已成功发送'
                });
                this.setData({
                    'text': ''
                });
                console.log("触发事件");
                app.globalData.event.emit('messagelistloadnew');
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