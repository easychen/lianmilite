import regeneratorRuntime from '../../utils/wxPromise.min.js';
const app = getApp();

Page({


    data: {
        user: {},
        show_feed: false
    },


    onLoad(options) {
        const uid = options.uid > 0 ? options.uid : app.globalData.guid;
        this.setData({
            "uid": uid,
            "myuid": app.globalData.guid,
            "api_base": app.globalData.api_base
        });
    },


    async onReady() {
        await app.code2token();
        await this.loadUser();
        console.log("show feed with" + this.data.uid);
        this.setData({
            "show_feed": true
        });
        wx.setNavigationBarTitle({
            title: this.data.user.nickname,
        })

    },

    async loadUser() {

        try {
            const user = await wx.lm.userDetail(this.data.uid);
            if (user.id > 0) {
                this.setData({
                    "user": user
                });
            }
        } catch (e) {
            wx.showToast({
                title: e.messsage + '',
                icon: 'none'
            });
        }
    },
    talk() {
        wx.navigateTo({
            url: '/pages/talk/talk?uid=' + this.data.uid + '&nickname=' + encodeURIComponent(this.data.user.nickname),
        })
    },
    follow() {
        this.userFollow(this.data.uid, 1);
    },
    unfollow() {
        this.userFollow(this.data.uid, 0);
    },
    async userFollow(uid, status) {
        try {
            const user = await wx.lm.userFollow(uid, status);
            console.log("user", user);
            if (user.id > 0) {
                this.setData({
                    user
                });
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