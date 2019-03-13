import {
    format,
    render,
    cancel,
    register
} from 'timeago.js';
import regeneratorRuntime from '../../utils/wxPromise.min.js';
const computedBehavior = require('miniprogram-computed');

Component({
    behaviors: [computedBehavior],
    properties: {
        feeddata: Object,
        inlist: Boolean
    },

    data: {
        feeddata: null,
        inlist: true
    },
    computed: {
        time() {
            return !this.data.feeddata ? null : format(this.data.feeddata.created_at, 'zh_CN')
        },
        rt_time() {
            return !this.data.feeddata ? null : format(this.data.feeddata.rt_at, 'zh_CN')
        },
        current_uid() {
            return getApp().globalData.guid
        }
    },
    lifetimes: {
        attached() {
            // this.getTime();
            // getApp().globalData.event.on('newfeedloaded', () => this.getTime());
        },
    },
    methods: {
        menu(e) {
            this.triggerEvent('menu', {
                "fid": this.data.feeddata.id
            });
        },
        rt() {
            const fid = this.data.feeddata.rt_id > 0 ? this.data.feeddata.rt_id : this.data.feeddata.id;


            wx.navigateTo({
                url: '/pages/rt/rt?fid=' + fid
            })
        },
        author(e) {
            wx.navigateTo({
                url: '/pages/user/user?uid=' + e.target.dataset.uid
            })
        },
        detail(e) {
            if (!this.data.inlist && e.target.dataset.fid > 0)
                wx.navigateTo({
                    url: '/pages/feed/feed?fid=' + e.target.dataset.fid
                })
        }

    }
})