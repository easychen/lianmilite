import regeneratorRuntime from 'wxPromise.min.js';
export default class lianmi {
    constructor(api_base) {
        this.api_base = api_base;
        this.token = '';
    }

    // 手动设置token
    setToken(token) {
        this.token = token;
    }

    // 微信登入以获取code
    async login() {
        let code = '';

        await wx.pro.login().then(async res => {
            if (res.code) code = res.code;
        })

        return code;
    }

    // code2token 
    async code2token(code) {
        let result = '';

        await wx.pro.request({
            url: this.api_base,
            data: {
                'code': code
            },
        }).then(ret => {
            if (ret.data && ret.data.data.token) {
                result = ret.data.data;
                this.token = result.token;
            } else {
                throw (ret.data.data.message);
            }
        }, e => {
            /* error */
        });

        return result;
    }

    // 同步服务器端用户
    async reg(user) {
        let result = 0;
        await wx.pro.request({
            url: this.api_base + '/reg',
            data: {
                'token': this.token,
                'nickname': user.nickName,
                'avatar': user.avatarUrl
            },
            method: 'POST',
            header: {
                'content-type': 'application/x-www-form-urlencoded'
            }
        }).then(ret => {
            if (ret.data.data.guid && ret.data.data.guid > 0) {
                result = ret.data.data.guid;
            }
        });

        return result;
    }

    // ====== user ================

    async userDetail(uid) {
        return await this._get('user/detail', {
            "id": uid
        });
    }

    async userFollow(uid, status) {
        return await this._post('user/follow', {
            uid,
            status
        });
    }

    // ======= message ==============
    async messageSend(text, to_uid) {
        return await this._post('message/send', {
            text,
            to_uid
        });
    }

    async messageGroupList(since_id) {
        return await this._post('message/grouplist', {
            since_id
        });
    }

    async messageLoad(since_id, to_uid, type = 'old') {
        type = type == 'old' ? 'old' : 'new';
        return await this._post('message/' + type, {
            since_id,
            to_uid
        });
    }

    async messageLoadNew(since_id, to_uid) {
        return await this.messageLoad(since_id, to_uid, 'new');
    }

    async messageLoadOld(since_id, to_uid) {
        return await this.messageLoad(since_id, to_uid, 'old');
    }


    // ======= feed ==============

    async feedHot(since) {
        return await this._post('feed/list', {
            since
        });
    }

    async feedFollowed(since) {
        return await this._post('feed/mylist', {
            since
        });
    }

    async feedPublish(content) {
        return await this._post('feed/publish', {
            content
        });
    }

    async feedDetail(fid) {
        return await this._get('feed/detail', {
            "id": fid
        });
    }

    async feedRemove(fid) {
        return await this._post('feed/remove', {
            "id": fid
        });
    }


    async feedUpdate(fid, content) {
        return await this._post('feed/update', {
            id: fid,
            content
        });
    }

    async feedRt(fid, content) {
        return await this._post('feed/rt', {
            id: fid,
            content
        });
    }

    // ========== private methods ==============

    async _get(url, param) {
        let result = {};

        await wx.pro.request({
                url: this.api_base + url,
                data: Object.assign({
                    'token': this.token
                }, param),
            })
            .then(ret => {
                if (ret.data.code == 0)
                    result = ret.data.data;
                else
                    throw (new Error(ret.data.message));
            })
        return result;
    }

    async _post(url, param) {
        let result = {};

        await wx.pro.request({
                url: this.api_base + url,
                data: Object.assign({
                    'token': this.token
                }, param),
                method: 'POST',
                header: {
                    'content-type': 'application/x-www-form-urlencoded'
                }
            })
            .then(ret => {
                if (ret.data.code == 0)
                    result = ret.data.data;
                else
                    throw (new Error(ret.data.message));
            })
        return result;
    }






}