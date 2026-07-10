<template>
    <Master>
        <div class="container py-2">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
                <!-- Card Header -->
                <div class="card-header bg-light border-0 py-3 px-4 border-start border-4 border-success">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-plus-circle text-success fs-5"></i>
                        <h5 class="card-title fw-bold text-dark m-0">Ask a New Question</h5>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="card-body p-4">
                    <form @submit.prevent="create_question" class="row g-3">
                        <!-- Title Input -->
                        <div class="col-12 form-group">
                            <label class="form-label fw-medium text-secondary small">Question Title</label>
                            <input type="text" v-model="form.title" class="form-control py-2.5 shadow-none" placeholder="Be specific and imagine you’re asking a person">
                        </div>

                        <!-- Description Textarea -->
                        <div class="col-12 form-group">
                            <label class="form-label fw-medium text-secondary small">Description</label>
                            <textarea v-model="form.description" class="form-control shadow-none" rows="5" placeholder="Include all the information someone would need to answer your question"></textarea>
                        </div>

                        <!-- Modern Checkbox Tags Selector -->
                        <div class="col-12 form-group">
                            <label class="form-label fw-medium text-secondary small d-block mb-2">Select Relevant Tags</label>
                            <div class="d-flex flex-wrap gap-2">
                                <label v-for="t in tag" :key="t.id" class="tag-checkbox-label cursor-pointer">
                                    <input type="checkbox" :value="t.id" v-model="form.tag_id" class="d-none">
                                    <span class="badge rounded-pill border px-3 py-2 fw-medium transition-all tag-pill">
                                        <i class="fas fa-hashtag small me-1"></i> {{ t.name }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 d-flex justify-content-end mt-4 pt-2 border-top border-light">
                            <button type="submit" class="btn btn-success px-4 py-2 fw-bold text-capitalize shadow-none" style="border-radius: 6px;">
                                <i class="fas fa-paper-plane me-1"></i> Submit Question
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Master>
</template>

<style scoped>
.form-control {
    border-color: #dee2e6;
    transition: all 0.2s;
}
.form-control:focus {
    border-color: #00b74a;
}
/* Modern Tag Checkbox Style */
.tag-checkbox-label input[type="checkbox"] + .tag-pill {
    background-color: #f8f9fa;
    color: #4f4f4f;
    border-color: #dee2e6 !important;
}
.tag-checkbox-label input[type="checkbox"]:checked + .tag-pill {
    background-color: rgba(0, 183, 74, 0.1) !important;
    color: #00b74a !important;
    border-color: rgba(0, 183, 74, 0.3) !important;
}
.tag-checkbox-label:hover .tag-pill {
    transform: translateY(-1px);
}
</style>


<script setup>
import { useForm } from '@inertiajs/vue3';
import Master from './Layout/Master.vue';
import axios from 'axios';
import { toast } from 'vue3-toastify';
    defineOptions({
        name:'CreateQuestion'
    });
    defineProps({
        tag: Array
    });

const form =useForm({
    title:'',
    description:'',
    tag_id:[]
});

const create_question=()=>{
    console.log(form);
    
    axios.post(route('question.store'),form)
        .then(res =>{
            if(res.data.message)
                {
                    toast.success(res.data.message)
                    form.reset();
                }
            
        })
        .catch(err=>console.log(err)
        )
    
}

</script>