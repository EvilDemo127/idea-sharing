<template>
    <!-- Centered Full-Height Wrapper -->
    <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
            
            <!-- Elegant Shadow Login Card -->
            <div class="card border-0 shadow-lg rounded-3 overflow-hidden bg-white animate-fade-in">
                <!-- Card Header -->
                <div class="card-header bg-light border-0 py-3.5 px-4 text-center border-bottom border-light">
                    <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                        <i class="fas fa-sign-in-alt text-success fs-4"></i>
                        <h4 class="card-title fw-bold text-dark m-0">Welcome Back</h4>
                    </div>
                    <p class="text-muted small m-0">Please sign in to continue your session</p>
                </div>

                <!-- Form Body -->
                <div class="card-body p-4">
                    <form @submit.prevent="login" class="d-flex flex-column gap-3.5">
                        
                        <!-- Email Input Group -->
                        <div class="form-group">
                            <label class="form-label fw-medium text-secondary small">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0" :class="{ 'border-danger': form.errors.email }">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input 
                                    type="text" 
                                    :class="['form-control border-start-0 ps-0 shadow-none', form.errors.email ? 'is-invalid border-danger' : '']" 
                                    v-model="form.email"
                                    placeholder="name@example.com"
                                >
                            </div>
                            <div v-if="form.errors.email" class="text-danger small mt-1.5 d-flex align-items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ form.errors.email }}
                            </div>
                        </div>

                        <!-- Password Input Group -->
                        <div class="form-group">
                            <label class="form-label fw-medium text-secondary small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0" :class="{ 'border-danger': form.errors.password }">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input 
                                    type="password" 
                                    :class="['form-control border-start-0 ps-0 shadow-none', form.errors.password ? 'is-invalid border-danger' : '']" 
                                    v-model="form.password"
                                    placeholder="••••••••"
                                >
                            </div>
                            <div v-if="form.errors.password" class="text-danger small mt-1.5 d-flex align-items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ form.errors.password }}
                            </div>
                        </div>

                        <!-- Full-Width Submit Button -->
                        <div class="mt-2">
                            <button 
                                class="btn btn-success w-100 py-2.5 fw-bold text-capitalize d-flex align-items-center justify-content-center gap-2 shadow-sm border-0" 
                                :disabled="form.processing"
                                style="background: linear-gradient(45deg, #00b74a, #00b0ff); border-radius: 6px;"
                            >
                                <div class="spinner-border spinner-border-sm" role="status" v-if="form.processing">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span v-else class="d-flex align-items-center gap-1">
                                    Login <i class="fas fa-arrow-right small"></i>
                                </span>
                            </button>
                        </div>

                        <!-- 🛠️ တိုးတက်မြှင့်တင်မှု- REGISTER BUTTON PANEL -->
                        <div class="text-center mt-3 pt-2 border-top border-light">
                            <span class="text-muted small">Don't have an account? </span>
                            <!-- Inertia Link သုံးထားသဖြင့် Page Reload မဖြစ်ဘဲ SPA စနစ်အတိုင်း ချက်ချင်းကူးပြောင်းပါမည် -->
                            <Link 
                                :href="route('register')" 
                                class="text-success small fw-bold text-decoration-none hover-underline ms-1"
                            >
                                Register here
                            </Link>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</template>



<style scoped>
.input-group-text, .form-control {
    border-color: #dee2e6;
    transition: all 0.2s;
}
.form-control:focus {
    border-color: #00b74a;
}
.input-group:focus-within .input-group-text:not(.border-danger) {
    border-color: #00b74a;
    color: #00b74a !important;
}
.input-group:focus-within .form-control:not(.border-danger) {
    border-color: #00b74a;
}
/* Register Link Hover Style */
.hover-underline:hover {
    text-decoration: underline !important;
    color: #00b0ff !important;
}
.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>


<script setup>
import { useForm, usePage,Link } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';

    const form =useForm({
        email:'',
        password:'',
    });
    
    const page= usePage();

    const login =()=>{
        form.post('/loginUser',{
            onFinish:()=>{
            if (page.props.flash?.error) {
                toast.error(page.props.flash.error, {
                    autoClose: 3000,
                    position: toast.POSITION.BOTTOM_RIGHT,
                });
                page.props.flash.error = null; 
                }
            }
        });
        
    }


   
</script>
