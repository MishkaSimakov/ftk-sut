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
    storeChatMessage(id, {body, images, reply_id}) {
        // console.log(images.get('files'));

        return new Promise((resolve, reject) => {
            axios.post('/webapi/chats/' + id + '/message', {
                body: body,
                reply: reply_id
            })
            .then((message) => {
                this.storeMessageImage(message.data, {
                    images: images
                }).then((images) => {
                    resolve({
                        'id': message.data,
                        'images': images.data,
                    });
                });
            })
            .catch((e) => {
                resolve("error")
            });
        })
    },
    storeMessageImage(id, {images}) {
        return new Promise((resolve, reject) => {
            axios.post('/webapi/chats/message/' + id + '/image', images)
            .then((response) => {
                resolve(response)
            })
            .catch((e) => {
                resolve("error")
            });
        })
    },
    storeChat({title, recipients}) {
        return new Promise((resolve, reject) => {
            axios.post('/webapi/chats', {
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
    changeChatName(id, {name}) {
        return new Promise((resolve, reject) => {
            axios.post('/webapi/chats/' + id + "/name", {
                name: name
            }).then((response) => {
                resolve(response)
            })
        })
    },
    removeChatUser(id, {user}) {
        return new Promise((resolve, reject) => {
            axios.post('/webapi/chats/' + id + "/removeUser", {
                user: user
            }).then((response) => {
                resolve(response)
            })
        })
    },
    setRead(id) {
        return new Promise((resolve, reject) => {
            axios.post('/webapi/chats/' + id + "/read");
        })
    },
    removeChat(id) {
        return new Promise((resolve, reject) => {
            axios.delete('/webapi/chats/' + id).then((response) => {
                resolve(response)
            });
        })
    },
    editChatMessage(id, {body, message_id, reply_id}) {
        return new Promise((resolve, reject) => {
            axios.put('/webapi/chats/' + id + '/message/' + message_id, {
                body: body,
                reply: reply_id
            }).then((response) => {
                resolve(response)
            }).catch((e) => {
                resolve("error")
            });
        })
    },
}
