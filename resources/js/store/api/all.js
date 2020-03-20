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
}
