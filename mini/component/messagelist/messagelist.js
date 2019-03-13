import regeneratorRuntime from '../../utils/wxPromise.min.js';
const app = getApp();

Component({
    properties: {
        to_uid: Number,
        pullreload: Boolean
    },

    data: {
        list: [],
        url: '',
        sinceid: 0,
        show_menu: false,
        actions: [],
        loading: false,
        to_uid: 0
    },

    lifetimes: {
        async attached() {
            console.log("MESSG", this.data.to_uid);
            await this.loadListNew(0);

            this.check = setInterval(() => this.loadListNew(this.data.maxid), 10000);

            console.log("绑定事件");

            app.globalData.event.on('messagelistloadold', e => {
                const minid = e && e.minid ? e.minid : this.data.minid;
                this.loadListOld(minid);
            });

            app.globalData.event.on('messagelistloadnew', async e => {
                const maxid = e && e.maxid ? e.maxid : this.data.maxid;
                await this.loadListNew(maxid);
                this.setData({
                    "scrolldown": "mid-" + this.data.maxid
                });
            });
        },
        detached() {
            clearInterval(this.check);
        }

    },
    methods: {
        async loadListOld(minid = 0) {
            console.log("minid = ", minid);

            // this.setData({ "loading": true });
            try {
                const list = await wx.lm.messageLoadOld(minid, this.data.to_uid);

                if (list.length > 0) {
                    const thismax = parseInt(list[0].id, 10);

                    let maxid = thismax;
                    if (maxid < this.data.maxid) maxid = this.data.maxid;
                    let minid = parseInt(list[list.length - 1].id, 10);
                    if (minid > this.data.minid) minid = this.data.minid;

                    let newlist = list.reverse().concat(this.data.list);
                    newlist = newlist.filter((value, index, self) => {
                        return self.indexOf(value) === index;
                    });

                    this.setData({
                        list: newlist,
                        "maxid": maxid,
                        "minid": minid,
                        "scrolldown": "mid-" + thismax
                    });
                    app.globalData.event.emit('messagelistloadolded');
                }

            } catch (e) {
                console.log(e);
                wx.showToast({
                    title: e.messsage + '',
                    icon: 'none'
                });
            }

        },

        async loadListNew(maxid = 0) {
            console.log("maxid = ", maxid);

            // this.setData({ "loading": true });
            try {
                const list = await wx.lm.messageLoadNew(maxid, this.data.to_uid);
                if (list.length > 0) {
                    let maxid = parseInt(list[list.length - 1].id, 10);
                    if (maxid < this.data.maxid) maxid = this.data.maxid;

                    let minid = parseInt(list[0].id, 10);
                    if (minid > this.data.minid) minid = this.data.minid;

                    let newlist = this.data.list.concat(list);
                    newlist = newlist.filter((value, index, self) => {
                        return self.indexOf(value) === index;
                    });


                    this.setData({
                        list: newlist,
                        "maxid": maxid,
                        "minid": minid,
                        "scrolldown": "mid-" + maxid
                    });
                    app.globalData.event.emit('messagelistloadnewed');
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

            console.log("inTOP");
            this.loadListOld(this.data.minid);
        }
    }
})