import regeneratorRuntime from 'utils/wxPromise.min.js';
import 'utils/wxPromise.min.js';
import EventEmitter from 'eventemitter3';
import lianmi from 'utils/lianmi.js';
App({

    onLaunch() {
        this.globalData.event = new EventEmitter();
        wx.lm = new lianmi(this.globalData.api_base);
    },
    async code2token(force = false) {

        if (this.globalData.token.length > 0 && !force) return true;

        try {
            const code = await wx.lm.login();
            const token_info = await wx.lm.code2token(code);
            this.globalData.token = token_info.token;

            if (token_info.guid > 0) {
                this.globalData.guid = token_info.guid;
                this.globalData.nickname = token_info.nickname;
                this.globalData.avatar = token_info.avatar;
            }
        } catch (e) {
            wx.showModal({
                title: '系统消息',
                content: '和服务器端通信失败',
            })
        }

        await this.doRegister();
    },
    async doRegister() {
        // 检查是否已经授权登入
        if (this.globalData.guid < 1) {

            //检查是否已经授权过
            wx.pro.getSetting().then(res => {
                if (!res.authSetting['scope.userInfo']) {

                    // 如果没有授权过
                    wx.navigateTo({
                        url: '/pages/auth/auth'
                    });
                } else {
                    // 如果授权过了
                    // 调用授权
                    wx.pro.getUserInfo().then(async res => {
                        await this.saveUserRemote(res.userInfo, false, callback);
                    });

                }
            });
        }
    },
    async saveUserRemote(user, goback = true) {

        const guid = await wx.lm.reg(user);
        this.globalData.guid = guid;
        if (goback) wx.navigateBack();
    },
    globalData: {
        userInfo: null,
        token: '',
        guid: 0,
        nickname: '',
        avatar: '',
        api_base: 'http://192.168.31.131:8000/' // 修改成自己API server的地址
    }
})