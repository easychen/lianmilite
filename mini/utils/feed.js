 export default async function loadFeed() {
     if (this.data.fid < 1) {
         wx.showToast({
             title: "错误的feedid" + this.data.fid,
             icon: 'none'
         });
         return false;
     }

     try {
         const feed = await wx.lm.feedDetail(this.data.fid);
         this.setData({
             feed
         });
     } catch (e) {
         wx.showToast({
             title: e.messsage + '',
             icon: 'none'
         });
     }
 }