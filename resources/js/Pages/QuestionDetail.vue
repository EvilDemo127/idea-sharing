<template>
    <Master>
        <div class="container py-2">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
                
                <!-- 1. CARD HEADER (STATUS & ACTIONS) -->
                <div class="card-header bg-light border-0 py-3 px-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span :class="ques.is_fixed ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'" class="badge rounded-pill px-2.5 py-1.5 fw-bold text-uppercase small" style="font-size: 0.7rem;">
                            <i :class="ques.is_fixed ? 'fas fa-check-circle' : 'fas fa-exclamation-circle'" class="me-1"></i>
                            {{ ques.is_fixed ? 'Fixed' : 'Need Fix' }}
                        </span>
                        <h5 class="text-dark fw-bold m-0 text-truncate ms-1" style="max-width: 400px;">{{ ques.title }}</h5>
                    </div>
                    <!-- Owner Actions Links -->
                    <div class="d-flex gap-2">
                        <a href="" class="btn btn-sm btn-link text-warning p-0 fw-bold text-decoration-none" style="font-size: 0.8rem;"><i class="fas fa-tools"></i> Fixed?</a>
                        <a href="" class="btn btn-sm btn-link text-danger p-0 fw-bold text-decoration-none" style="font-size: 0.8rem;"><i class="fas fa-trash-alt"></i> Delete?</a>
                    </div>
                </div>

                <!-- 2. CARD BODY (DESCRIPTION) -->
                <div class="card-body px-4 py-3">
                    <p class="card-text text-secondary lh-base mb-0" style="font-size: 0.95rem; white-space: pre-line;">{{ ques.description }}</p>
                </div>

                <!-- 3. CARD FOOTER (INTERACTIONS & COMMENTS STREAM) -->
                <div class="card-footer bg-white border-top border-light px-4 py-3">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <!-- Left: Interaction Icons -->
                        <div class="d-flex align-items-center gap-4 text-muted">
                            <div class="d-flex align-items-center gap-1.5 cursor-pointer hover-scale" @click="LandC.click_like(ques)" style="cursor: pointer;">
                                <i :class="ques.is_Like ? 'fas fa-heart text-danger fs-5' : 'far fa-heart text-muted fs-5'"></i>
                                <span class="small fw-semibold" :class="{'text-danger': ques.is_Like}">{{ ques.like_count || 0 }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-1.5 cursor-pointer hover-scale" @click="LandC.toggleCommentBox(ques.id)" style="cursor: pointer;">
                                <i class="far fa-comment text-success fs-5"></i>
                                <span class="small fw-semibold text-success">{{ ques.comment_count || 0 }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-1.5 cursor-pointer hover-scale" style="cursor: pointer;">
                                <i class="far fa-star text-warning fs-5"></i>
                                <span class="small fw-semibold text-warning">{{ ques.qsave_count || 0 }}</span>
                            </div>
                        </div>

                        <!-- Right: Pill Tags style -->
                        <div class="d-flex flex-wrap gap-1.5">
                            <a href="" v-for="t in ques.tag" :key="t.id" class="badge rounded-pill bg-light text-secondary border px-2.5 py-1.5 font-weight-medium text-decoration-none hover-tag" style="font-size: 0.75rem;">
                                # {{ t.name || t }}
                            </a>
                        </div>
                    </div>

                    <!-- COLLAPSIBLE REPLIES & COMMENT BOX SECTION -->
                    <div class="mt-4 pt-3 border-top border-light fade-in" v-if="LandC.showCommentBox.value === ques.id || LandC.showCommentBox === ques.id">
                        <!-- Submit Form -->
                        <form @submit.prevent="LandC.addCommentandReply(ques)">
                            <div class="input-group shadow-sm rounded-3 overflow-hidden border bg-white p-1 mb-4">
                                <input type="text" class="form-control border-0 py-2 shadow-none text-dark ps-3" v-model="comment" placeholder="Share your reply or technical solution..." style="font-size: 0.9rem;" />
                                <button class="btn btn-success px-4 py-2 fw-bold text-capitalize border-0" type="submit" style="border-radius: 6px !important;">Submit</button>
                            </div>
                        </form>

                        <!-- Clean Comments Wrapper -->
                        <div class="d-flex flex-column gap-3 mb-2">
                            <div class="bg-light rounded-3 p-3 border border-light" v-for="q in ques.comment" :key="q.id">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <img :src="q.user.image ? '/profile/' + q.user.image : '/images/default-avatar.png'" class="rounded-circle border" style="width: 26px; height: 26px; object-fit: cover;" alt="User Avatar">
                                        <span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ q.user.name }}</span>
                                    </div>
                                    <span class="text-muted small" style="font-size: 0.75rem;"><i class="far fa-clock me-1"></i>{{ q.date || 'just now' }}</span>
                                </div>
                                <p class="mb-0 text-secondary ps-1" style="font-size: 0.9rem; line-height: 1.5; white-space: pre-line;">{{ q.comment }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </Master>
</template>

<style scoped>
.hover-scale { transition: transform 0.15s ease; }
.hover-scale:hover { transform: scale(1.08); }
.hover-tag { transition: all 0.2s ease; }
.hover-tag:hover { background-color: rgba(18, 102, 241, 0.06) !important; color: #1266f1 !important; border-color: rgba(18, 102, 241, 0.2) !important; }
.fade-in { animation: slideDown 0.2s ease-out; }
@keyframes slideDown { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
</style>

<script setup>
import { usePage } from '@inertiajs/vue3';
import Master from './Layout/Master.vue';
import { ref } from 'vue';
import axios from 'axios';
import { LikeAndCom } from './Comp/LikeAndCom.js';

    defineOptions({
        name:'QuestionDetail'
    });
    
    defineProps({
      ques:Object
    });

  const LandC =LikeAndCom();
  

</script>