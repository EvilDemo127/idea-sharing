<template>
    <Master>
        <div class="container py-2" v-for="q in questions">
            <div
                class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white"
            >
                <!-- 1. CARD HEADER (STATUS & ACTIONS) -->
                <div
                    class="card-header bg-light border-0 py-3 px-4 d-flex align-items-center justify-content-between"
                >
                    <div class="d-flex align-items-center gap-2">
                        <span
                            :class="
                                q.is_fixed
                                    ? 'bg-success-subtle text-success'
                                    : 'bg-danger-subtle text-danger'
                            "
                            class="badge rounded-pill px-2.5 py-1.5 fw-bold text-uppercase small"
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
                        <h5
                            class="text-dark fw-bold m-0 text-truncate ms-1"
                            style="max-width: 400px"
                        >
                            {{ q.title }}
                        </h5>
                    </div>
                    <!-- Owner Actions Links -->
                    <div class="d-flex gap-2" v-if="LandC.isOwner(q.user_id)">
                        <button
                            @click.prevent="LandC.needFixed(q.id)"
                            v-show="!q.is_fixed"
                            class="btn btn-sm btn-link text-warning p-0 fw-bold text-decoration-none"
                            style="font-size: 0.8rem"
                        >
                            <i class="fas fa-thumbtack"></i> Fix?
                        </button>
                        <button
                            @click.prevent="LandC.needFixed(q.id)"
                            v-show="q.is_fixed"
                            class="btn btn-sm btn-link text-warning p-0 fw-bold text-decoration-none"
                            style="font-size: 0.8rem"
                        >
                            <i
                                class="fas fa-thumbtack"
                                style="transform: rotate(45deg)"
                            ></i>
                            UnFix?
                        </button>
                        <Link
                            :href="route('edit_question', q.id)"
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

                <!-- 2. CARD BODY (DESCRIPTION) -->
                <div class="card-body px-4 py-3">
                    <p
                        class="card-text text-secondary lh-base mb-0"
                        style="font-size: 0.95rem; white-space: pre-line"
                    >
                        {{ q.description }}
                    </p>
                </div>

                <!-- 3. CARD FOOTER (INTERACTIONS & COMMENTS STREAM) -->
                <div
                    class="card-footer bg-white border-top border-light px-4 py-3"
                >
                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3"
                    >
                        <!-- Left: Interaction Icons -->
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
                                @click="LandC.click_save(q)"
                                class="d-flex align-items-center gap-1.5 cursor-pointer hover-scale"
                                style="cursor: pointer"
                            >
                                <i
                                    :class="
                                        q.is_Save
                                            ? 'fas fa-star text-warning fs-5'
                                            : 'far fa-star text-warning fs-5'
                                    "
                                ></i>
                                <span class="small fw-semibold text-warning">{{
                                    q.qsave_count || 0
                                }}</span>
                            </div>
                        </div>

                        <!-- Right: Pill Tags style -->
                        <div class="d-flex flex-wrap gap-1.5">
                            <a
                                href=""
                                v-for="t in q.tag"
                                :key="t.id"
                                class="badge rounded-pill bg-light text-secondary border px-2.5 py-1.5 font-weight-medium text-decoration-none hover-tag"
                                style="font-size: 0.75rem"
                            >
                                # {{ t.name || t }}
                            </a>
                        </div>
                    </div>

                    <!-- COLLAPSIBLE REPLIES & COMMENT BOX SECTION -->
                    <div
                        v-if="LandC.showCommentBox.value === q.id"
                        class="mt-3 pt-3 border-top border-light fade-in"
                    >
                        <form
                            @submit.prevent="LandC.addComment(q)"
                            class="mb-3"
                        >
                            <div
                                class="input-group shadow-sm rounded-3 overflow-hidden"
                            >
                                <input
                                    type="text"
                                    class="form-control border-1 ps-3 py-2"
                                    v-model="LandC.comment.value"
                                    placeholder="Write a comment..."
                                    style="font-size: 0.9rem"
                                />
                                <button
                                    class="btn btn-success px-3"
                                    type="submit"
                                >
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                        <div class="d-flex flex-column gap-3 mb-2">
                            <!-- Comment Card: မိုဘိုင်းလ်ဗျူးအတွက် အနားသတ် Padding ညှိထားပါသည် -->
                            <div
                                class="bg-white rounded-3 p-3 border border-light shadow-xs"
                                v-for="com in q.comment"
                                :key="com.id"
                            >
                             {{ com.user_id }}
                                <div
                                    class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3 mb-3"
                                >
                                    
                                    <div
                                        class="d-flex align-items-center gap-2.5"
                                    >
                                        <!-- <img
                                            :src="
                                                com.user.image
                                                    ? '/profile/' +
                                                      com.user.image
                                                    : '/images/default-avatar.png'
                                            "
                                            
                                            class="rounded-circle border flex-shrink-0"
                                            style="
                                                width: 32px;
                                                height: 32px;
                                                object-fit: cover;
                                            "
                                            alt="User Avatar"
                                        /> -->
                                        <div class="d-flex flex-column lh-sm">
                                            <span
                                                class="fw-bold text-dark"
                                                style="font-size: 0.88rem"
                                                >{{ q.user.name }}</span
                                            >
                                            <span
                                                class="text-muted"
                                                style="font-size: 0.72rem"
                                            >
                                                <i class="far fa-clock me-1"></i
                                                >{{ com.date || "just now" }}
                                            </span>
                                        </div>
                                    </div>

                                    <div
                                        class="d-flex align-items-center gap-2 ms-0 ms-sm-auto flex-shrink-0"
                                    >
                                        <!-- 1. Normal Mode Buttons -->
                                        <template
                                            v-if="
                                                !com.edit &&
                                                LandC.isOwner(com.user_id)
                                            "
                                        >
                                            <button
                                                @click.prevent="
                                                    LandC.editComment(com)
                                                "
                                                class="btn btn-sm btn-light text-warning border-0 py-1.5 px-2.5 rounded-2 fw-bold text-uppercase d-flex align-items-center gap-1"
                                                style="
                                                    font-size: 0.7rem;
                                                    letter-spacing: 0.5px;
                                                "
                                            >
                                                <i class="far fa-edit"></i> edit
                                            </button>
                                            <button
                                                @click.prevent="
                                                    LandC.deleteComment(com)
                                                "
                                                class="btn btn-sm btn-light text-danger border-0 py-1.5 px-2.5 rounded-2 fw-bold text-uppercase d-flex align-items-center gap-1"
                                                style="
                                                    font-size: 0.7rem;
                                                    letter-spacing: 0.5px;
                                                "
                                            >
                                                <i class="fas fa-trash-alt"></i>
                                                delete
                                            </button>
                                        </template>

                                        <!-- 2. Edit Mode Buttons -->
                                        <template
                                            v-if="
                                                com.edit &&
                                                LandC.isOwner(com.user_id)
                                            "
                                        >
                                            <button
                                                @click.prevent="
                                                    LandC.saveComment(com)
                                                "
                                                class="btn btn-sm btn-success border-0 py-1.5 px-3 rounded-2 fw-bold text-white text-uppercase d-flex align-items-center gap-1 shadow-xs"
                                                style="font-size: 0.75rem"
                                            >
                                                <i class="fas fa-save"></i> save
                                            </button>
                                            <button
                                                @click.prevent="
                                                    com.edit = false
                                                "
                                                class="btn btn-sm btn-secondary bg-secondary-subtle text-secondary border-0 py-1.5 px-3 rounded-2 fw-bold text-uppercase"
                                                style="font-size: 0.75rem"
                                            >
                                                cancel
                                            </button>
                                        </template>
                                    </div>
                                </div>

                                <!-- Bottom Section: Comment Text OR Input Edit Box -->
                                <div class="ps-1 pt-1">
                                    <!-- Content Text -->
                                    <p
                                        v-if="!com.edit"
                                        class="mb-0 text-secondary lh-base"
                                        style="
                                            font-size: 0.9rem;
                                            white-space: pre-line;
                                        "
                                    >
                                        {{ com.comment }}
                                    </p>

                                    <!-- Wide Input Edit Box -->
                                    <div
                                        v-else
                                        class="input-group shadow-xs rounded-3 overflow-hidden border fade-in"
                                    >
                                        <input
                                            type="text"
                                            v-model="
                                                LandC.editCommentText.value
                                            "
                                            class="form-control border-0 py-2 text-dark ps-3"
                                            placeholder="Update your comment..."
                                            style="font-size: 0.88rem"
                                        />
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
import Master from "./Layout/Master.vue";
import { LikeAndCom } from "./Comp/LikeAndCom.js";
import { Link } from "@inertiajs/vue3";
defineOptions({
    name: "Question",
});

defineProps({
    questions: Array,
});

const LandC = LikeAndCom();
</script>
