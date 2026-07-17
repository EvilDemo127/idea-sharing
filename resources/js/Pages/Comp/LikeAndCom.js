import { ref } from "vue";
import axios from "axios";
import { computed } from "vue";
import { router, usePage } from "@inertiajs/vue3";

export function LikeAndCom() {
    const comment = ref("");
    const showCommentBox = ref(null);
    const search = ref("");
    const editCommentText = ref();
    const page = usePage();
    const activeDropdownId = ref(null);
    const mobileMenuVie = ref(null);
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

    //question save
    const click_save = (save) => {
        axios
            .post(route("save.handle", save.id))
            .then((res) => {
                console.log(res.data.is_Save);

                save.qsave_count = res.data.qsave_count;
                save.is_Save = res.data.is_Save;
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

    const mobileMenu = (id) => {
        console.log(id);
        console.log(mobileMenuVie.value);

        return mobileMenuVie.value === id
            ? (mobileMenuVie.value = null)
            : (mobileMenuVie.value = id);
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
        axios
            .post(route("comment.delete", comm.id))
            .then((res) => {})
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

    const searching = () => {
        if(!search.value || !search.value.trim()) return 
        router.get(route("question.search", search.value),{}, {
            preserveState: true,
            replace: true,
        });
    };

    const isOwner = (id) => {
        return page.props?.user?.id == id;
    };

    const needFixed = (id) => {
        router.post(route("fix_question", id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log("success");
            },
        });
    };

    return {
        isOwner,
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
        needFixed,
        click_save,
        mobileMenuVie,
        mobileMenu,
        activeDropdownId,
    };
}
