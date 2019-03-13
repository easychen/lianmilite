Page({

    onLoad: function(options) {
        console.log("auth loaded");
    },

    doAuth(e) {
        if (e.detail.userInfo) {
            const user = e.detail.userInfo;
            getApp().saveUserRemote(user);
        }
        // console.log(e.detail.userInfo );

    }
})