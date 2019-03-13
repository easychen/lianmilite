import regeneratorRuntime from 'wxPromise.min.js';
module.exports = Behavior({
    methods: {
        onMenu(e) {
            // 设置action
            const fid = parseInt(e.detail.fid, 10);
            const theaction = [{
                    "name": "编辑",
                    "action": "modify",
                    "fid": fid
                },
                {
                    "name": "删除",
                    "action": "remove",
                    "fid": fid
                },
            ];

            this.setData({
                "actions": theaction,
                "show_menu": true
            });
        },
        onClose() {
            console.log("inclose");
            this.setData({
                "show_menu": false
            });
        },
        async onSelect(e) {
            const fid = e.detail.fid;
            const action = e.detail.action;

            if (action == 'remove') {
                console.log("remove" + fid);
                // return ;
                try {
                    const feed = await wx.lm.feedRemove(fid);
                    if (feed.id > 0)
                        this.setData({
                            "show_menu": false,
                            "list": this.data.list.filter(feed => feed.id != fid)
                        });
                } catch (e) {
                    console.log(e);
                    wx.showToast({
                        title: e.messsage + '',
                        icon: 'none'
                    });
                }
            }

            if (action == 'modify') {
                this.setData({
                    "show_menu": false
                });
                wx.navigateTo({
                    url: '/pages/modify/modify?fid=' + fid
                })
            }
        }
    }
})