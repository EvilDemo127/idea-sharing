<template>
    <!-- Centered Full-Height Wrapper -->
    <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            
            <!-- Elegant Shadow Register Card -->
            <div class="card border-0 shadow-lg rounded-3 overflow-hidden bg-white animate-fade-in">
                <!-- Card Header -->
                <div class="card-header bg-light border-0 py-3.5 px-4 text-center border-bottom border-light">
                    <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                        <i class="fas fa-user-plus text-success fs-4"></i>
                        <h4 class="card-title fw-bold text-dark m-0">Create Account</h4>
                    </div>
                    <p class="text-muted small m-0">Join us today by filling out your information below</p>
                </div>

                <!-- Form Body -->
                <div class="card-body p-4">
                    <form @submit.prevent="register" class="d-flex flex-column gap-3.5">
                        
                        <!-- Name Input Group -->
                        <div class="form-group">
                            <label class="form-label fw-medium text-secondary small">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0" :class="{ 'border-danger': form.errors.name }">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" :class="['form-control border-start-0 ps-0 shadow-none', form.errors.name ? 'is-invalid border-danger' : '']" v-model="form.name" placeholder="Jet Denal">
                            </div>
                            <div v-if="form.errors.name" class="text-danger small mt-1.5 d-flex align-items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ form.errors.name }}
                            </div>
                        </div>

                        <!-- Email Input Group -->
                        <div class="form-group">
                            <label class="form-label fw-medium text-secondary small">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0" :class="{ 'border-danger': form.errors.email }">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="text" :class="['form-control border-start-0 ps-0 shadow-none', form.errors.email ? 'is-invalid border-danger' : '']" v-model="form.email" placeholder="example@domain.com">
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
                                <input type="password" :class="['form-control border-start-0 ps-0 shadow-none', form.errors.password ? 'is-invalid border-danger' : '']" v-model="form.password" placeholder="Minimum 8 characters">
                            </div>
                            <div v-if="form.errors.password" class="text-danger small mt-1.5 d-flex align-items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ form.errors.password }}
                            </div>
                        </div>

                        <!-- Image File Input Group -->
                        <div class="form-group">
                            <label class="form-label fw-medium text-secondary small">Profile Image (Optional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0" :class="{ 'border-danger': form.errors.image }">
                                    <i class="fas fa-image"></i>
                                </span>
                                <input type="file" :class="['form-control border-start-0 ps-2 shadow-none py-2', form.errors.image ? 'is-invalid border-danger' : '']" @change="image" accept="image/*">
                            </div>
                            <div v-if="form.errors.image" class="text-danger small mt-1.5 d-flex align-items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ form.errors.image }}
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
                                    Register <i class="fas fa-user-check small"></i>
                                </span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</template>

<style scoped>
.input-group-text {
    border-color: #dee2e6;
    transition: all 0.2s;
}
.form-control {
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
.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<script setup>
    import { defineOptions } from 'vue';
    import { useForm } from '@inertiajs/vue3';

    defineOptions({
        name:"Register",
    });

    const form = useForm({
    name: '',
    email: '',
    password: '',
    image: null, 
    });
    
    
    
    const image =(e) =>{
        form.image = e.target.files[0]
        
    }

    const register = () =>{
        form.post('/register',{
       
        });
        
    }
    
</script>
