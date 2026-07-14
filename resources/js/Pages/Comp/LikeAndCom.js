import { ref } from "vue";
import axios from "axios";
import { computed } from "vue";
export function LikeAndCom() {
    const comment = ref("");
    const showCommentBox = ref(null);
    const search = ref("");
    const editCommentText = ref();

    //like handle
    const click_like = (like) => {
        axios
            .post(route("like.handle", like.id))
            .then((res) => {
                like.like_count = res.data.like_count;
                like.is_Like = res.data.is_like;
            })
            .catch((err) => console.log(err));
    };

    const toggleCommentBox = (id) => {
        if (showCommentBox.value === id) {
            showCommentBox.value = null;
        } else {
            showCommentBox.value = id;
        }
    };

    //add comment handle
    const addComment = (comm) => {
        if (!comment || !comment.value || !comment.value.trim()) return;

        axios
            .post(route("comment.create", comm.id), {
                comment: comment.value,
            })
            .then((res) => {
                // like.value.comment=res.data.comment.comment
                comm.comment.unshift(res.data.comment);
                comm.comment_count = res.data.comment_count;
                comment.value = "";
            })
            .catch();
    };

    //reply comment handle
    const addCommentandReply = (comm) => {
        console.log(comment.value);
        console.log(comm);

        if (!comment || !comment.value || !comment.value.trim()) return;

        axios
            .post(route("comment.create", comm.id), {
                comment: comment.value,
            })
            .then((res) => {
                // like.value.comment=res.data.comment.comment
                comm.comment.unshift(res.data.comment);
                comm.comment_count = res.data.comment_count;
                comment.value = "";
            })
            .catch();
    };

    const editComment = (comm) => {
        comm.edit = true;
        editCommentText.value = comm.comment;
    };

    const saveComment = (comm) => {
        console.log(editCommentText.value);
        axios
            .post(route("comment.edit", comm.id), {
                comment: editCommentText.value,
            })
            .then((res) => {
                comm.comment = editCommentText.value;
                comm.edit = false;
            })
            .catch((err) => console.log(err));
    };

    const deleteComment = (comm) => {
        console.log(comm);
        axios
            .post(route("comment.delete", comm.id))
            .then((res) => {
               console.log(res);
               
            })
            .catch((err) => console.log(err));
    };

    //delete question
    const deleteQues = (id) => {
        if (!confirm("Are You Sure.!?")) {
            return;
        }

        axios
            .post(route("question.delete", id))
            .then((res) => window.location.reload())
            .catch((err) => console.log(err));
    };

    const searching = (searchtex) => {
        axios
            .get(route("question.search", search.value))
            .then((res) => {
                searchtex.comment.unshift(res.data.comment);
                searchtex.comment_count = res.data.comment_count;
                searchtex.like_count = res.data.like_count;
                searchtex.is_Like = res.data.is_like;
            })
            .catch();
    };

    return {
        comment,
        showCommentBox,
        toggleCommentBox,
        click_like,
        addComment,
        deleteQues,
        searching,
        search,
        editComment,
        deleteComment,
        saveComment,
        editCommentText,
    };
}
