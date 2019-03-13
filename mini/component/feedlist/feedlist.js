import regeneratorRuntime from '../../utils/wxPromise.min.js';
const app = getApp();
const menu = require('../../utils/menu.js');

Component({
    behaviors: [menu],
    properties: {
        method: String,
        pullreload: Boolean
    },

    data: {
        list: [],
        url: '',
        sinceid: 0,
        show_menu: false,
        actions: [],
        pullreload: false,
        loading: false,
        method: 'feedHot'
    },

    lifetimes: {
        async attached() {

            const last_list_string = wx.getStorageSync('last-list-' + this.data.method);
            if (last_list_string) {
                console.log("缓存存在，直接加载缓存");
                this.setData({
                    "list": JSON.parse(last_list_string)
                });

                console.log("加载完毕");
            }


            this.loadList(0);

            app.globalData.event.on('feedlistupdate', e => {
                if (e.feed && e.feed.id > 0) {
                    const feed = e.feed;
                    let newlist = this.data.list;
                    newlist.forEach((item, i) => {
                        if (item.id == feed.id) {
                            if (item.rt_id > 0)
                                newlist[i]['rt_content'] = feed.content;
                            else
                                newlist[i]['content'] = feed.content;
                        }

                    });
                    this.setData({
                        "list": newlist
                    });
                }
            });

            app.globalData.event.on('feedreload', e => {
                this.loadList(0);
            });
            // console.log("subend");

        }

    },
    methods: {
        async loadList(sinceid = 0) {
            console.log("sinceid = ", sinceid);

            try {
                const list = await wx.lm[this.data.method](sinceid);
                if (list.length > 0) {
                    if (sinceid == 0) {
                        let newlist = list;
                        this.setData({
                            list: newlist,
                            "sinceid": parseInt(list[list.length - 1].id, 10)
                        });
                        getApp().globalData.event.emit("newfeedloaded");
                        wx.setStorageSync('last-list-' + this.data.method, JSON.stringify(newlist));
                    } else {
                        let newlist = this.data.list.concat(list);
                        this.setData({
                            list: newlist,
                            "sinceid": parseInt(list[list.length - 1].id, 10)
                        });
                        wx.setStorageSync('last-list-' + this.data.method, JSON.stringify(newlist));

                        wx.showToast({
                            title: "更多内容已载入",
                            icon: 'none'
                        });
                    }
                }
            } catch (e) {
                console.log(e);
                wx.showToast({
                    title: e.messsage + '',
                    icon: 'none'
                });
            }


        },

        onTop(e) {
            console.log(this.data.pullreload);
            if (!this.data.pullreload) return true;
            // 需要将数据对象强制清零，以避免缓存
            this.loadList(0);
        },
        onBottom(e) {
            console.log("on bottom");
            this.loadList(this.data.sinceid);
        }
    }
})