<template>
    <Master>
        <div class="container py-2">
            <!-- 1. COMPACT PAGINATION -->
            <div
                class="d-flex justify-content-center my-3"
                v-if="questions.links && questions.links.length > 3"
            >
                <ul
                    class="pagination pagination-circle shadow-sm p-1 bg-white border rounded-pill align-items-center"
                >
                    <li
                        v-for="(link, index) in questions.links"
                        :key="index"
                        class="page-item mx-1"
                        :class="{ active: link.active, disabled: !link.url }"
                    >
                        <Link
                            :href="link.url || '#'"
                            class="page-link border-0 d-flex align-items-center justify-content-center fw-medium text-decoration-none transition-all"
                            :style="
                                link.label.includes('Previous') ||
                                link.label.includes('Next')
                                    ? 'padding: 0 14px; height: 34px; border-radius: 20px; font-size: 0.85rem;'
                                    : 'width: 34px; height: 34px; border-radius: 50%; font-size: 0.85rem;'
                            "
                            v-html="link.label"
                        />
                    </li>
                </ul>
            </div>

            <!-- 2. MODERN QUESTION CARD -->
            <div
                class="card border-0 shadow-sm rounded-3 mb-4 bg-white overflow-hidden"
                v-for="q in questions.data"
                :key="q.id"
            >
                <div
                    class="card-header bg-light border-0 py-3 px-4 d-flex align-items-center justify-content-between"
                >
                    <div class="d-flex align-items-center gap-2">
                        <span
                            :class="
                                q.is_fixed
                                    ? 'badge bg-success-subtle text-success'
                                    : 'badge bg-danger-subtle text-danger'
                            "
                            class="rounded-pill px-2.5 py-1.5 fw-bold text-uppercase small"
                            style="font-size: 0.7rem"
                        >
                            <i
                                :class="
                                    q.is_fixed
                                        ? 'fas fa-check-circle'
                                        : 'fas fa-exclamation-circle'
                                "
                                class="me-1"
                            ></i>
                            {{ q.is_fixed ? "Fixed" : "Need Fix" }}
                        </span>
                        <span
                            class="text-dark fw-bold text-truncate ms-1"
                            style="max-width: 300px"
                            >{{ q.slug }}</span
                        >
                    </div>
                    <!-- Owner Actions -->
                    <div class="d-flex gap-2" v-show="isOwner(q.user_id)">
                        <Link
                            href=""
                            class="btn btn-sm btn-link text-warning p-0 fw-bold text-decoration-none"
                            style="font-size: 0.8rem"
                            ><i class="fas fa-tools"></i> Fix?</Link
                        >
                        <Link
                            :href="route('edit_question',q.id)"
                            class="btn btn-sm btn-link text-warning p-0 fw-bold text-decoration-none"
                            style="font-size: 0.8rem"
                        >
                            <i class="far fa-keyboard"></i> Edit?
                        </Link>
                        <button
                            @click="LandC.deleteQues(q.id)"
                            class="btn btn-sm btn-link text-danger p-0 fw-bold text-decoration-none"
                            style="font-size: 0.8rem"
                        >
                            <i class="fas fa-trash-alt"></i> Delete?
                        </button>
                    </div>
                </div>

                <div class="card-body px-4 py-3">
                    <p
                        class="card-text text-secondary lh-base mb-0"
                        style="font-size: 0.95rem; white-space: pre-line"
                    >
                        {{ q.description }}
                    </p>
                </div>

                <!-- Footer Operations -->
                <div
                    class="card-footer bg-white border-top border-light px-4 py-3"
                >
                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3"
                    >
                        <!-- Counters -->
                        <div class="d-flex align-items-center gap-4 text-muted">
                            <div
                                class="d-flex align-items-center gap-1.5 cursor-pointer hover-scale"
                                @click="LandC.click_like(q)"
                                style="cursor: pointer"
                            >
                                <i
                                    :class="
                                        q.is_Like
                                            ? 'fas fa-heart text-danger fs-5'
                                            : 'far fa-heart text-muted fs-5'
                                    "
                                ></i>
                                <span
                                    class="small fw-semibold"
                                    :class="{ 'text-danger': q.is_Like }"
                                    >{{ q.like_count || 0 }}</span
                                >
                            </div>
                            <div
                                class="d-flex align-items-center gap-1.5 cursor-pointer hover-scale"
                                @click="LandC.toggleCommentBox(q.id)"
                                style="cursor: pointer"
                            >
                                <i class="far fa-comment text-success fs-5"></i>
                                <span class="small fw-semibold text-success">{{
                                    q.comment_count || 0
                                }}</span>
                            </div>
                            <div
                                class="d-flex align-items-center gap-1.5 cursor-pointer hover-scale"
                                style="cursor: pointer"
                            >
                                <i class="far fa-star text-warning fs-5"></i>
                                <span class="small fw-semibold text-warning">{{
                                    q.qsave_count || 0
                                }}</span>
                            </div>
                        </div>
                        <!-- Pill Tags -->
                        <div class="d-flex flex-wrap gap-1.5">
                            <Link
                                href=""
                                v-for="t in q.tag"
                                :key="t.id"
                                class="badge rounded-pill bg-light text-secondary border px-2.5 py-1.5 font-weight-medium text-decoration-none hover-tag"
                                style="font-size: 0.75rem"
                            >
                                # {{ t.name }}
                            </Link>
                        </div>
                        <div>
                            <Link
                                :href="route('question.details', q.slug)"
                                class="btn btn-sm btn-primary px-3 py-1.5 fw-bold text-capitalize shadow-none"
                                style="border-radius: 6px"
                                >View Details</Link
                            >
                        </div>
                    </div>

                    <!-- 3. CLEAN COMMENT BOX PANEL -->
                    <div
                        class="mt-4 pt-3 border-top border-light fade-in"
                        v-if="LandC.showCommentBox.value === q.id"
                    >
                        <form @submit.prevent="LandC.addComment(q)">
                            <div
                                class="input-group shadow-sm rounded-3 overflow-hidden border bg-white p-1 mb-4"
                            >
                                <input
                                    type="text"
                                    class="form-control border-0 py-2 shadow-none text-dark ps-3"
                                    v-model="LandC.comment.value"
                                    placeholder="Share your technical solution..."
                                    style="font-size: 0.9rem"
                                />
                                <button
                                    class="btn btn-success px-4 py-2 fw-bold text-capitalize border-0"
                                    type="submit"
                                    style="border-radius: 6px !important"
                                >
                                    Submit
                                </button>
                            </div>
                        </form>
                        <!-- Comments Cards -->
                        <div class="d-flex flex-column gap-3 mb-2">
                            <div
                                class="bg-light rounded-3 p-3 border"
                                v-for="com in q.comment"
                                :key="com.id"
                            >
                                <div
                                    class="d-flex align-items-center justify-content-between mb-2"
                                >
                                    <div
                                        class="d-flex align-items-center gap-2"
                                    >
                                        <img
                                            :src="
                                                q.user.image
                                                    ? '/profile/' + q.user.image
                                                    : '/images/default-avatar.png'
                                            "
                                            class="rounded-circle border"
                                            style="
                                                width: 26px;
                                                height: 26px;
                                                object-fit: cover;
                                            "
                                        />
                                        <span
                                            class="fw-bold text-dark"
                                            style="font-size: 0.85rem"
                                            >{{ q.user.name }}</span
                                        >
                                    </div>
                                    <span
                                        class="text-muted small"
                                        style="font-size: 0.75rem"
                                        ><i class="far fa-clock me-1"></i
                                        >{{ com.date }}</span
                                    >
                                </div>
                                <div class="d-flex justify-content-between align-items-center ">
                                    <p
                                        v-if="!com.edit"
                                        class="mb-0 mt-1 text-secondary ps-1"
                                        style="
                                            font-size: 0.9rem;
                                            line-height: 1.5;
                                            white-space: pre-line;
                                        "
                                    >
                                        {{ com.comment }}
                                    </p>
                                    <input
                                        v-else
                                        type="text"
                                        v-model="LandC.editCommentText.value"
                                        class="form-control text-dark "
                                        style="
                                            font-size: 0.9rem;
                                            line-height: 1.5;
                                        "
                                    />

                                    <div
                                        v-if="!com.edit"
                                        class="d-flex gap-1 justify-content-end w-25"
                                    >
                                        <button
                                            @click.prevent="
                                                LandC.editComment(com)
                                            "
                                            class="btn btn-sm btn-warning py-0 px-1"
                                            style="font-size: 0.8rem"
                                        >
                                            edit
                                        </button>
                                        <button
                                            @click.prevent="
                                                LandC.deleteComment(com,)
                                            "
                                            class="btn btn-sm btn-danger py-0 px-1"
                                            style="font-size: 0.8rem"
                                        >
                                            delete
                                        </button>
                                    </div>
                                    <div
                                        v-else
                                        class="d-flex gap-1 justify-content-end w-25"
                                    >
                                        <button
                                            @click.prevent="
                                                LandC.saveComment(com,q.comment)
                                            "
                                            class="btn btn-sm btn-warning py-0 px-1"
                                            style="font-size: 0.8rem"
                                        >
                                            save
                                        </button>
                                        <button
                                            @click.prevent="com.edit = false"
                                            class="btn btn-sm btn-danger py-0 px-1"
                                            style="font-size: 0.8rem"
                                        >
                                            cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Master>
</template>

<style scoped>
.hover-scale {
    transition: transform 0.15s ease;
}
.hover-scale:hover {
    transform: scale(1.08);
}
.hover-tag {
    transition: all 0.2s ease;
}
.hover-tag:hover {
    background-color: rgba(18, 102, 241, 0.06) !important;
    color: #1266f1 !important;
    border-color: rgba(18, 102, 241, 0.2) !important;
}
.fade-in {
    animation: slideDown 0.2s ease-out;
}
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import Master from "./Layout/Master.vue";
import Content from "./Layout/Content.vue";
import { LikeAndCom } from "./Comp/LikeAndCom.js";
import axios from "axios";
import { ref, toRefs } from "vue";

defineOptions({
    name: "Home",
});

defineProps({
    questions: Object,
});
const page = usePage();
const LandC = LikeAndCom();

// check post owner
const isOwner = (id) => {
    if (page.props.user.id == id) {
        return true;
    }
    return false;
};

// login alert
if (page.props.flash?.success) {
    toast.success(page.props.flash.success, {
        autoClose: 4000,
        position: toast.POSITION.BOTTOM_RIGHT,
    });
    page.props.flash.success = null;
}
</script>
