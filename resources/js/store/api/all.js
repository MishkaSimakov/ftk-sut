export default {
    getChats(page) {
        return new Promise((resolve, reject) => {
            axios.get('/webapi/chats?page=' + page).then((response) => {
                resolve(response)
            })
        })
    },
    getChat(id) {
        return new Promise((resolve, reject) => {
            axios.get('/webapi/chats/' + id).then((response) => {
                resolve(response)
            })
        })
    },
    storeChatMessage(id, {body}) {
        return new Promise((resolve, reject) => {
            axios.post('/webapi/chats/' + id + '/message', {
                body: body
            }).then((response) => {
                console.log(response);
                resolve(response)
            }).catch((e) => {
                resolve("error")
            });
        })
    },
    storeChat({title, recipients}) {
        return new Promise((resolve, reject) => {
            axios.post('/webapi/chats/', {
                title: title,
                recipients: recipients
            }).then((response) => {
                resolve(response)
            })
        })
    },
    storeChatUsers(id, {recipients}) {
        return new Promise((resolve, reject) => {
            axios.post('/webapi/chats/' + id + "/users", {
                recipients: recipients
            }).then((response) => {
                resolve(response)
            })
        })
    },
}
