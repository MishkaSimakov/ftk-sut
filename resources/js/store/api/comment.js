export default {
    getComments(id) {
        return new Promise((resolve, reject) => {
            axios.get('/webapi/comments/' + id).then((response) => {
                resolve(response)
            })
        })
    },
    storeArticleComment(id, {body}) {
        return new Promise((resolve, reject) => {
            axios.post('/webapi/comments/' + id, {
                body: body
            }).then((response) => {
                resolve(response)
            }).catch((e) => {
                resolve("error")
            });
        })
    },
    editArticleComment(comment, {body}) {
        return new Promise((resolve, reject) => {
            axios.put('/webapi/comments/' + comment, {
                body: body
            }).then((response) => {
                resolve(response)
            }).catch((e) => {
                resolve("error")
            });
        })
    },
}
