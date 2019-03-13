import regeneratorRuntime from '../../utils/wxPromise.min.js';
import {
    format,
    render,
    cancel,
    register
} from 'timeago.js';
const computedBehavior = require('miniprogram-computed');

const app = getApp();
Component({
    behaviors: [computedBehavior],
    properties: {
        messagedata: Object
    },


    data: {
        messagedata: {},
    },
    computed: {
        time() {
            return !this.data.messagedata ? null : format(this.data.messagedata.created_at, 'zh_CN')
        },
        my_uid() {
            return app.globalData.guid;
        }
    }
})