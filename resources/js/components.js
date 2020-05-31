export default function () {
    // chat
    Vue.component('chats', require('./components/chat/Chats.vue').default);
    Vue.component('chat', require('./components/chat/Chat.vue').default);
    Vue.component('message', require('./components/chat/Message.vue').default);
    Vue.component('chat-users', require('./components/chat/settings/ChatUsers.vue').default);

    Vue.component('chat-button', require('./components/chat/ChatButton.vue').default);

    Vue.component('chat-add-form', require('./components/chat/forms/ChatAddForm.vue').default);
    Vue.component('message-add-form', require('./components/chat/forms/MessageAddForm.vue').default);
    Vue.component('chat-user-add-form', require('./components/chat/forms/ChatUserAddForm.vue').default);
    Vue.component('chat-name-form', require('./components/chat/forms/ChatNameForm.vue').default);

    Vue.component('chat-settings', require('./components/chat/settings/ChatSettings.vue').default);

    //comments
    Vue.component('comments', require('./components/comments/Comments.vue').default);
    Vue.component('comment', require('./components/comments/Comment.vue').default);
    Vue.component('comment-add-form', require('./components/comments/AddCommentForm.vue').default);

    // articles
    Vue.component('tags-add-form', require('./components/article/AddTagForm.vue').default);
    Vue.component('find-articles-form', require('./components/article/FindArticlesForm.vue').default);
    Vue.component('writers-top', require('./components/article/writersTop.vue').default);
    Vue.component('articles-top', require('./components/article/articlesTop.vue').default);
    Vue.component('comments-top', require('./components/article/recentComments.vue').default);

    // home
    Vue.component('new-chat-button', require('./components/chat/NewChatButton.vue').default);
    Vue.component('user-photo', require('./components/user/Photo.vue').default);

    // rating
    Vue.component('rating', require('./components/rating/Rating.vue').default);
    Vue.component('rating-bar', require('./components/rating/Bar.vue').default);
    Vue.component('rating-select-date', require('./components/rating/DateSelect.vue').default);

    // vote
    Vue.component('vote', require('./components/vote/Vote.vue').default);
    Vue.component('add-questions', require('./components/vote/Questions.vue').default);

    //schedule
    Vue.component('sign-button', require('./components/schedule/SignButton.vue').default);
    Vue.component('people-list', require('./components/schedule/PeopleList.vue').default);

    // user statistics
    Vue.component('stat', require('./components/user/Statistics/Main.vue').default);
    Vue.component('stat-rating-points', require('./components/user/Statistics/RatingPoints.vue').default);
    Vue.component('stat-rating-categories', require('./components/user/Statistics/RatingCategories.vue').default);
}
