let userId = window.Vue.prototype.$userId;

module.exports = {
    updateReply(reply) {
        return reply.user_id.toString() === userId
    }
}
