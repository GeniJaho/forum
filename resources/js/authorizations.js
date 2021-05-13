let userId = window.Vue.prototype.$userId;

module.exports = {
    owns(model, prop = 'user_id') {
        return model[prop].toString() === userId
    }
}
