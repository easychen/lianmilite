import regeneratorRuntime from '../../utils/wxPromise.min.js';
const app = getApp();

Component({
    properties: {
        url: String,
        pullreload: Boolean
    },

    data: {
        list: [],
        url: '',
        sinceid: 0,
        show_menu: false,
        actions: [],
        pullreload: false,
        loading: false
    },

    lifetimes: {
        async attached() {
            const last_list_string = wx.getStorageSync('last-list-' + this.data.url);
            if (last_list_string) {
                console.log("缓存存在，直接加载缓存");
                this.setData({
                    "list": JSON.parse(last_list_string)
                });

                console.log("加载完毕");
            }
            await this.loadList(0);
            // app.globalData.event.on('feedboxupdate', e => {

            //});
        }

    },
    pageLifetimes: {
        show() {
            this.loadList(0);
        }
    },
    methods: {
        async loadList(sinceid = 0) {

            console.log("sinceid = ", sinceid);

            this.setData({
                "loading": true
            });

            // messageGroupList
            try {
                const list = await wx.lm.messageGroupList(sinceid);
                if (list.length > 0) {
                    if (sinceid == 0) {
                        let newlist = list;
                        this.setData({
                            "list": newlist,
                            "sinceid": parseInt(list[list.length - 1].id, 10)
                        });
                        wx.setStorageSync('last-list-' + this.data.url, JSON.stringify(newlist));
                    } else {
                        let newlist = this.data.list.concat(list);
                        this.setData({
                            "list": newlist,
                            "sinceid": parseInt(list[list.length - 1].id, 10)
                        });

                        wx.showToast({
                            title: "更多内容已载入",
                            icon: 'none'
                        });
                    }

                    this.setData({
                        "loading": false
                    });
                }
            } catch (e) {
                console.log(e);
                wx.showToast({
                    title: e.messsage + '',
                    icon: 'none'
                });
            }



        },

        onBottom(e) {
            console.log("on bottom");
            this.loadList(this.data.sinceid);
        }
    }
})