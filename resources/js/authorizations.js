let userId = window.Vue.prototype.$userId;
let userEmail = window.Vue.prototype.$userEmail;

module.exports = {
    owns(model, prop = 'user_id') {
        return model[prop].toString() === userId
    },

    isAdmin() {
        return ['jahogeni@gmail.com'].includes(userEmail);
    }
}
