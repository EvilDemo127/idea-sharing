<template>
    <Master>
        <div class="container py-2">
            <div
                class="card border-0 shadow-sm rounded-3 mb-4 bg-white overflow-hidden"
            >
                <!-- Card Header -->
                <div
                    class="card-header bg-light border-0 py-3 px-3 px-md-4 d-flex align-items-center justify-content-between gap-3"
                >
                    <div
                        class="d-flex align-items-start gap-2 flex-grow-1 overflow-hidden"
                    >
                        <span
                            :class="
                                ques.is_fixed
                                    ? 'bg-success-subtle text-success'
                                    : 'bg-danger-subtle text-danger'
                            "
                            class="badge rounded-pill px-2 py-1 fw-bold text-uppercase"
                            style="
                                font-size: 0.65rem;
                                white-space: nowrap;
                                margin-top: 3px;
                            "
                        >
                            <i
                                :class="
                                    ques.is_fixed
                                        ? 'fas fa-check-circle'
                                        : 'fas fa-exclamation-circle'
                                "
                                class="me-1"
                            ></i>
                            {{ ques.is_fixed ? "Fixed" : "Need Fix" }}
                        </span>
                        <h6
                            class="text-dark fw-bold mb-0 lh-base flex-grow-1 text-break"
                            style="font-size: 0.95rem"
                        >
                            {{ ques.title || ques.slug }}
                        </h6>
                    </div>

                    <div
                        v-if="LandC.isOwner(ques.user_id)"
                        class="flex-shrink-0 position-relative"
                    >
                        <div class="d-none d-sm-flex align-items-center gap-3">
                            <button
                                @click.prevent="LandC.needFixed(ques.id)"
                                v-show="!ques.is_fixed"
                                class="btn btn-sm btn-link text-warning p-0 fw-bold text-decoration-none d-flex align-items-center gap-1"
                                style="font-size: 0.78rem"
                            >
                                <i class="fas fa-thumbtack"></i> FIX?
                            </button>
                            <button
                                @click.prevent="LandC.needFixed(ques.id)"
                                v-show="ques.is_fixed"
                                class="btn btn-sm btn-link text-warning p-0 fw-bold text-decoration-none d-flex align-items-center gap-1"
                                style="font-size: 0.78rem"
                            >
                                <i
                                    class="fas fa-thumbtack"
                                    style="transform: rotate(45deg)"
                                ></i>
                                UNFIX?
                            </button>
                            <Link
                                :href="route('edit_question', ques.id)"
                                class="btn btn-sm btn-link text-primary p-0 fw-bold text-decoration-none d-flex align-items-center gap-1"
                                style="font-size: 0.78rem"
                            >
                                <i class="far fa-edit"></i> EDIT?
                            </Link>
                            <button
                                @click="LandC.deleteQues(ques.id)"
                                class="btn btn-sm btn-link text-danger p-0 fw-bold text-decoration-none d-flex align-items-center gap-1"
                                style="font-size: 0.78rem"
                            >
                                <i class="fas fa-trash-alt"></i> DELETE?
                            </button>
                        </div>

                        <div class="d-block d-sm-none">
                            <button
                                @click="LandC.mobileMenu(ques.id)"
                                class="btn btn-link text-secondary p-1"
                                type="button"
                                style="font-size: 1.1rem; line-height: 1"
                            >
                                <i class="fas fa-ellipsis-v"></i>
                            </button>

                            <ul
                                v-if="LandC.mobileMenuVie.value === ques.id"
                                class="dropdown-menu dropdown-menu-end shadow border border-light-subtle rounded-3 py-1 show"
                                style="
                                    position: absolute;
                                    right: 0;
                                    left: auto;
                                    top: 100%;
                                    z-index: 1000;
                                    display: block;
                                    min-width: 120px;
                                "
                            >
                                <li v-show="!ques.is_fixed">
                                    <Link
                                        @click.prevent="
                                            LandC.needFixed(ques.id);
                                            LandC.activeDropdownId = null;
                                        "
                                        class="dropdown-item py-2 text-warning d-flex align-items-center gap-2 small fw-semibold"
                                        href="#"
                                    >
                                        <i
                                            class="fas fa-thumbtack"
                                            style="width: 14px"
                                        ></i>
                                        FIX
                                    </Link>
                                </li>
                                <li v-show="ques.is_fixed">
                                    <Link
                                        @click.prevent="
                                            LandC.needFixed(ques.id);
                                            LandC.activeDropdownId = null;
                                        "
                                        class="dropdown-item py-2 text-warning d-flex align-items-center gap-2 small fw-semibold"
                                        href="#"
                                    >
                                        <i
                                            class="fas fa-thumbtack"
                                            style="
                                                transform: rotate(45deg);
                                                width: 14px;
                                            "
                                        ></i>
                                        UNFIX
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        :href="route('edit_question', ques.id)"
                                        @click="LandC.activeDropdownId = null"
                                        class="dropdown-item py-2 text-primary d-flex align-items-center gap-2 small fw-semibold"
                                    >
                                        <i
                                            class="far fa-edit"
                                            style="width: 14px"
                                        ></i>
                                        EDIT
                                    </Link>
                                </li>
                                <li>
                                    <hr
                                        class="dropdown-divider my-1 border-light"
                                    />
                                </li>
                                <li>
                                    <Link
                                        @click.prevent="
                                            LandC.deleteQues(ques.id);
                                            LandC.activeDropdownId = null;
                                        "
                                        class="dropdown-item py-2 text-danger d-flex align-items-center gap-2 small fw-semibold"
                                        href="#"
                                    >
                                        <i
                                            class="fas fa-trash-alt"
                                            style="width: 14px"
                                        ></i>
                                        DELETE
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body px-3 px-md-4 py-3">
                    <p
                        class="card-text text-secondary lh-base mb-0"
                        style="font-size: 0.9rem; white-space: pre-line"
                    >
                        {{ ques.description }}
                    </p>
                </div>

                <!-- Footer Operations -->
                <div
                    class="card-footer bg-white border-top border-light px-3 px-md-4 py-3"
                >
                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3"
                    >
                        <!-- Left Side: Interaction Icons -->
                        <div
                            class="d-flex align-items-center justify-content-between justify-content-md-start gap-4 text-muted"
                        >
                            <div
                                class="d-flex align-items-center gap-1.5 hover-scale"
                                @click="LandC.click_like(ques)"
                                style="cursor: pointer"
                            >
                                <i
                                    :class="
                                        ques.is_Like
                                            ? 'fas fa-heart text-danger fs-5'
                                            : 'far fa-heart text-muted fs-5'
                                    "
                                ></i>
                                <span
                                    class="small fw-semibold ms-1"
                                    :class="{ 'text-danger': ques.is_Like }"
                                    >{{ ques.like_count || 0 }}</span
                                >
                            </div>
                            <div
                                class="d-flex align-items-center gap-1.5 hover-scale"
                                @click="LandC.toggleCommentBox(ques.id)"
                                style="cursor: pointer"
                            >
                                <i class="far fa-comment text-success fs-5"></i>
                                <span
                                    class="small fw-semibold text-success ms-1"
                                    >{{ ques.comment_count || 0 }}</span
                                >
                            </div>
                            <div
                                @click="LandC.click_save(ques)"
                                class="d-flex align-items-center gap-1.5 hover-scale"
                                style="cursor: pointer"
                            >
                                <i
                                    :class="
                                        ques.is_Save
                                            ? 'fas fa-star text-warning fs-5'
                                            : 'far fa-star text-warning fs-5'
                                    "
                                ></i>
                                <span
                                    class="small fw-semibold text-warning ms-1"
                                    >{{ ques.qsave_count || 0 }}</span
                                >
                            </div>
                        </div>

                        <div
                            class="d-flex align-items-center justify-content-between justify-content-md-end gap-3 flex-wrap"
                        >
                            <div class="d-flex flex-wrap gap-1.5">
                                <span
                                    v-for="t in ques.tag"
                                    :key="t.id"
                                    class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1.5 fw-normal hover-tag"
                                    style="font-size: 0.7rem; cursor: pointer"
                                >
                                    #{{ t.name }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Comment Box System -->
                    <div
                        v-if="LandC.showCommentBox.value === ques.id"
                        class="mt-3 pt-3 border-top border-light fade-in"
                    >
                        <form
                            @submit.prevent="LandC.addComment(ques)"
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
                        <div
                            class="bg-white rounded-3 p-3 border border-light shadow-xs"
                            v-for="com in ques.comment"
                            :key="com.id"
                        >
                            <div
                                class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3 mb-3"
                            >
                                <div class="d-flex align-items-center gap-2.5">
                                    <img
                                            :src="
                                                com.user.image
                                                    ? `https://lh3.googleusercontent.com/d/${com.user.image}`
                                                    : '/images/default-avatar.png'
                                            "
                                            
                                            class="rounded-circle border flex-shrink-0"
                                            style="
                                                width: 32px;
                                                height: 32px;
                                                object-fit: cover;
                                            "
                                            alt="User Avatar"
                                        />
                                    <div class="d-flex flex-column lh-sm">
                                        <span
                                            class="fw-bold text-dark"
                                            style="font-size: 0.88rem"
                                            >{{ ques.user.name }}</span
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
                                            @click.prevent="com.edit = false"
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
                                        v-model="LandC.editCommentText.value"
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
import { usePage, Link } from "@inertiajs/vue3";
import Master from "./Layout/Master.vue";
import { ref } from "vue";
import axios from "axios";
import { LikeAndCom } from "./Comp/LikeAndCom.js";

defineOptions({
    name: "QuestionDetail",
});

defineProps({
    ques: Object,
});

const LandC = LikeAndCom();
</script>
