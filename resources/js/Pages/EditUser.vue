<template>
    <Master>
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    
                    <form @submit.prevent="profileUpdate" class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white">
                        <!-- Card Header -->
                        <div class="card-header bg-light border-0 py-3 px-4 border-start border-4 border-primary">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-user-edit text-primary fs-5"></i>
                                <h5 class="card-title fw-bold text-dark m-0">Account Settings</h5>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <!-- Profile Image Section -->
                            <div class="d-flex flex-column align-items-center mb-4 p-3 bg-light rounded-3 border border-dashed text-center">
                                <div class="position-relative avatar-wrapper mb-2">
                                    <img 
                                        :src="user.image ? '/profile/' + user.image : '/images/default-avatar.png'"
                                        class="rounded-circle border border-3 border-white shadow" 
                                        style="width: 110px; height: 110px; object-fit: cover;"  
                                        alt="Profile Preview"
                                    />
                                    <label for="image-upload" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle shadow d-flex align-items-center justify-content-center cursor-pointer" style="width: 32px; height: 32px; cursor: pointer;">
                                        <i class="fas fa-camera small"></i>
                                    </label>
                                </div>
                                <span class="text-muted small">Click camera icon to change photo</span>
                            </div>

                            <div class="row g-3">
                                <!-- Name Input -->
                                <div class="col-md-6 form-group mt-3">
                                    <label class="form-label fw-medium text-secondary small">Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control shadow-none" v-model="form.name">
                                    </div>
                                    <div v-if="form.errors.name" class="text-danger small mt-1 d-flex align-items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i> {{ form.errors.name }}
                                    </div>
                                </div>

                                <!-- Email Input -->
                                <div class="col-md-6 form-group mt-3">
                                    <label class="form-label fw-medium text-secondary small">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted"><i class="fas fa-envelope"></i></span>
                                        <input type="text" class="form-control shadow-none" v-model="form.email">
                                    </div>
                                    <div v-if="form.errors.email" class="text-danger small mt-1 d-flex align-items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i> {{ form.errors.email }}
                                    </div>
                                </div>

                                <div class="col-12"><hr class="text-light my-2"></div>

                                <!-- Current Password Input -->
                                <div class="col-12 form-group mt-3">
                                    <label class="form-label fw-medium text-secondary small">Current Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted"><i class="fas fa-lock text-warning"></i></span>
                                        <input type="password" class="form-control shadow-none" v-model="form.current_password">
                                    </div>
                                    <div v-if="form.errors.current_password" class="text-danger small mt-1 d-flex align-items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i> {{ form.errors.current_password }}
                                    </div>
                                </div>

                                <!-- New Password Input -->
                                <div class="col-md-6 form-group mt-3">
                                    <label class="form-label fw-medium text-secondary small">New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted"><i class="fas fa-key text-success"></i></span>
                                        <input type="password" class="form-control shadow-none" v-model="form.newPassword">
                                    </div>
                                    <div v-if="form.errors.newPassword" class="text-danger small mt-1 d-flex align-items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i> {{ form.errors.newPassword }}
                                    </div>
                                </div>

                                <!-- Confirm Password Input -->
                                <div class="col-md-6 form-group mt-3">
                                    <label class="form-label fw-medium text-secondary small">Confirm Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted"><i class="fas fa-check-double text-success"></i></span>
                                        <input type="password" class="form-control shadow-none" v-model="form.newPassword_confirmation">
                                    </div>
                                    <div v-if="form.errors.newPassword_confirmation" class="text-danger small mt-1 d-flex align-items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i> {{ form.errors.newPassword_confirmation }}
                                    </div>
                                </div>

                                <!-- Hidden File Input linked with camera icon -->
                                <div class="form-group d-none">
                                    <input type="file" id="image-upload" class="form-control" @change="image" accept="image/*">
                                </div>
                            </div>

                            <!-- Action Button Panel -->
                            <div class="d-flex justify-content-end mt-4 pt-2 border-top border-light">
                                <button 
                                    class="btn btn-primary px-4 py-2 fw-bold text-capitalize d-flex align-items-center gap-2 shadow-sm" 
                                    :disabled="form.processing"
                                    style="background: linear-gradient(45deg, #1266f1, #00b0ff); border: 0; border-radius: 6px;"
                                >
                                    <div class="spinner-border spinner-border-sm" role="status" v-if="form.processing">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span v-else class="d-flex align-items-center gap-1">
                                        <i class="fas fa-save"></i> Update
                                    </span>
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </Master>
</template>

<style scoped>
.input-group-text {
    border-color: #dee2e6;
}
.form-control {
    border-color: #dee2e6;
}
.form-control:focus {
    border-color: #1266f1;
}
.input-group:focus-within .input-group-text {
    border-color: #1266f1;
    color: #1266f1 !important;
}
.avatar-wrapper:hover img {
    opacity: 0.9;
}
.avatar-wrapper label:hover {
    transform: scale(1.1);
    transition: transform 0.2s;
}
.border-dashed {
    border-style: dashed !important;
}
</style>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import Master from './Layout/Master.vue';
import { toast } from 'vue3-toastify';


    defineOptions({
        name:'EditUser'
    });

    const user = usePage().props.user;

    const form = useForm({
    name: user ? user.name : '',      
    email: user ? user.email : '',    
    current_password: '',                  
    newPassword: '',  
    newPassword_confirmation:'',                
    image: null, 
    });

    const image =(e)=>{
        form.image = e.target.files[0]        
    }
    
    const page =usePage();
    const profileUpdate =()=>{
        form.post('/profile/update',{
            onSuccess:()=>{
                form.reset('current_password','newPassword','newPassword_confirmation')
            },
            onFinish:()=>{
                if(page.props.flash?.success)
                {
                    toast.success(page.props.flash.success,{
                        autoClose: 3000,
                        position: toast.POSITION.TOP_RIGHT,
                    });
                page.props.flash.success = null; 
                }
                if (page.props.flash?.error) {
                toast.error(page.props.flash.error, {
                    autoClose: 3000,
                    position: toast.POSITION.BOTTOM_RIGHT,
                });
                page.props.flash.error = null; 
                }
            }
        })
    }

    

</script>