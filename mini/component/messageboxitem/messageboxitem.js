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
        "boxdata": Object
    },
    data: {
        "boxdata": {}
    },
    computed: {
        time() {
            return !this.data.boxdata ? null : format(this.data.boxdata.created_at, 'zh_CN')
        }
    },
    methods: {
        showUser() {
            wx.navigateTo({
                url: '/pages/user/user?uid=' + this.data.boxdata.from_user.id
            })
        },
        showMessage() {
            const user = this.data.boxdata.from_user.id != this.data.boxdata.uid ? this.data.boxdata.from_user : this.data.boxdata.to_user;

            wx.navigateTo({
                url: '/pages/talk/talk?uid=' + user.id + '&nickname=' + encodeURIComponent(user.nickname)
            })
        }
    }
})