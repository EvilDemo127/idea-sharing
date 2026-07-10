<template>
    <Master>
        <div class="card m-3" v-for="q in questions">
            <div class="card-header">
                <span class="badge badge-danger">Need Fixed</span>
                <span>{{ q.title }}</span>
                <a href="" class="badge badge-warning float-end ms-1"
                    >Delete?</a
                >
                <a href="" class="badge badge-danger float-end">Fixed?</a>
            </div>
            <div class="card-body">
                <p class="card-text">{{ q.description }}</p>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex gap-3">
                        <div>
                            <i
                                class="fa-regular fa-heart text-danger"
                                @click="LandC.click_like(q)"
                            ></i>
                            <small class="ms-1">{{ q.like_count || 0 }}</small>
                        </div>
                        <div >
                            <i class="fa-regular fa-comment text-success"
                            @click="LandC.toggleCommentBox(q.id)"></i>
                            <small class="ms-1">{{
                                q.comment_count || 0
                            }}</small>
                        </div>
                        <div>
                            <i class="fa-regular fa-star text-warning"></i>
                            <small class="ms-1">{{ q.qsave_count || 0 }}</small>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="" class="badge badge-dark">Android</a>
                        <a href="" class="badge badge-dark">Web</a>
                    </div>
                </div>
                <div v-if="LandC.showCommentBox.value === q.id">
                  <form @submit.prevent="LandC.addComment(q)"
                >
                    <div
                      
                        class="shadow-md my-3 border rounded-3 input-group"
                    >
                        <input
                            type="text"
                            class="form-control"
                            v-model="LandC.comment.value"
                            placeholder="Enter any Idea"
                        />
                        <button
                            class="p-1 btn btn-sm btn-success"
                            type="submit"
                        >
                            submit
                        </button>
                    </div>
                </form>
                <div
                    class="shadow-md border-2 rounded-3 m-2"
                    v-for="com in q.comment"
                    :key="com.id"
                >
                    <div
                        class="bg-dark p-1 text-white d-flex align-items-center justify-content-between"
                    >
                        <div class="d-flex align-items-center gap-3">
                            <img 
                                :src="(q.user.image ? '/profile/' + q.user.image :'') " 
                                class="rounded-circle" 
                                style="width: 30px; height: 30px; object-fit: cover;" 
                                alt="User Avatar"
                            >
                            <span class="fw-semibold">{{q.user.name}}</span>
                        </div>
                        <div>
                            <span class="small">{{com.date}}</span>
                        </div>
                    </div>
                    <div class="ms-1 p-2">
                        <p class="mb-0" style="font-size: 0.9rem">{{ com.comment }}</p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </Master>
</template>

<script setup>
import Master from "./Layout/Master.vue";
import { LikeAndCom } from "./Comp/LikeAndCom.js";

defineOptions({
    name: "Question",
});

defineProps({
    questions: Array,
});

const LandC =LikeAndCom();
</script>
