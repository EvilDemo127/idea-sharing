<template>
    <!-- Navbar Custom Shadow & Glassmorphism feel -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm py-2 px-3 border-bottom border-light">
        <div class="container-fluid">
            <!-- Brand / Logo (Optional) -->
            

            <!-- Toggle button (Mobile Menu Button) -->
            <button
                class="navbar-toggler border-0 p-2 shadow-none"
                type="button"
                aria-expanded="false"
                aria-label="Toggle navigation"
                @click="toggleMobileMenu"
            >
                <i class="fas fa-bars fs-5 text-dark"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div 
                class="collapse navbar-collapse transition-all" 
                :class="{ 'show': mobileMenuOpen }" 
                id="navbarSupportedContent" 
            >
                <!-- Left Links (Modern Hover Styles) -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1 gap-lg-3">
                    <li class="nav-item">
                        <Link class="nav-link px-2 text-secondary hover-link active-link" :href="route('home')">All Questions</Link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 text-secondary hover-link" href="#">Answered</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2 text-secondary hover-link" href="#">Unanswered</a>
                    </li>
                </ul>
            </div>
            <!-- Right Elements / Actions -->
            <div class="d-flex align-items-center gap-3">
                <!-- Notifications Dropdown -->
                <div class="dropdown">
                    <a
                        class="position-relative p-2 text-reset hover-icon rounded-circle d-flex align-items-center justify-content-center"
                        href="#"
                        role="button"
                        style="width: 38px; height: 38px;"
                    >
                        <i class="fas fa-bell fs-5 text-secondary"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white" style="font-size: 0.65rem; margin-left: -8px; margin-top: 8px;">
                            1
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2 rounded-3 animate-fade-in" style="min-width: 230px;">
                        <li><h6 class="dropdown-header font-weight-bold text-dark px-3 py-2">Notifications</h6></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><a class="dropdown-item rounded-2 py-2" href="#">🔔 Some news updates</a></li>
                        <li><a class="dropdown-item rounded-2 py-2" href="#">🔔 Another news alert</a></li>
                    </ul>
                </div>
                <!-- message -->
                <div class="border-0 mt-2 p-2 rounded-3 animate-fade-in cursor-pointer">
                    <Link :href="route('message')"><i class="fas fa-comment"></i> </Link>
                </div>

                <!-- Avatar Dropdown with Modern Border and Shadow -->
                <div class="dropdown position-relative">
                    <div
                        @click="dropDownMenu()"
                        class="d-flex align-items-center rounded-circle border border-2 border-primary-subtle p-0.5 cursor-pointer avatar-wrapper"
                        role="button"
                        style="cursor: pointer;"
                    >
                        <!-- when i use https://google.com/d/${user.image} it seeing error -->
                        <img
                           :src="user.image ? `https://lh3.googleusercontent.com/d/${user.image}`:''"
                            class="rounded-circle shadow-sm"
                            style="width: 32px; height: 32px; object-fit: cover;"
                            alt="Profile Avatar"
                        />
                    </div>
                    
                    <!-- Premium Rounded Dropdown Card -->
                    <ul
                        :class="{ 'show': dropDownOpen }"
                        class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2 rounded-3"
                        style="right: 0; left: auto; min-width: 200px;"
                    >
                        <li>
                            <div class="px-3 py-2 d-flex flex-column">
                                <span class="fw-bold text-dark text-truncate" style="max-width: 150px;">{{ user.name || 'User Name' }}</span>
                                <span class="text-muted small text-truncate" style="max-width: 150px;">{{ user.email || 'user@email.com' }}</span>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <Link class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2" :href="route('profile.edit')">
                                <i class="fas fa-user-cog text-muted" style="width: 18px;"></i> My Profile
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('question.own')" class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2">
                                <i class="fas fa-question-circle text-muted" style="width: 18px;"></i> Questions
                            </Link>
                        </li>
                        <li>
                            <Link :href="route('question.save')" class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2">
                                <i class="fas fa-bookmark text-muted" style="width: 18px;"></i> Saved Lists
                            </Link>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <a class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2 text-danger fw-bold" href="/logout">
                                <i class="fas fa-sign-out-alt text-danger" style="width: 18px;"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Modern Floating Search Input (Centered layout option) -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form @submit.prevent ="LandC.searching">
                <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white border border-light">
                    
                        <span class="input-group-text bg-white border-0 ps-4 pe-2 text-muted">
                        <i class="fas fa-search"></i>
                    </span>
                    <input 
                        v-model="LandC.search.value"
                        name="search"
                        type="search"
                        id="form1" 
                        class="form-control border-0 py-3 shadow-none text-dark ps-2" 
                        placeholder="Search questions, topics or tags..."
                        style="font-size: 0.95rem;"
                    />
                    <button 
                        type="submit" 
                        class="btn btn-primary px-4 fw-bold border-0"
                        style="background: linear-gradient(45deg, #1266f1, #00b0ff); border-radius: 0 50rem 50rem 0 !important;"
                    >
                        Search
                    </button>
                </div>
                    </form>

            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, usePage, router } from "@inertiajs/vue3";
import { LikeAndCom } from "../Comp/LikeAndCom";
import { ref } from "vue";

defineOptions({
    name: "Nav",
});

// Reactive States 
const dropDownOpen = ref(false);
const mobileMenuOpen = ref(false);

// Get current search value from URL

const dropDownMenu = () => {
    dropDownOpen.value = !dropDownOpen.value;
};

const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
};


const user = usePage().props.user;
const LandC = LikeAndCom();
</script>

<style scoped>
/* Smooth hover effects & premium touches */
.hover-link {
    transition: all 0.2s ease-in-out;
}
.hover-link:hover {
    color: #1266f1 !important;
    background-color: rgba(18, 102, 241, 0.05);
    border-radius: 6px;
}
.active-link {
    color: #1266f1 !important;
    font-weight: 600;
}
.hover-icon {
    transition: background-color 0.2s;
}
.hover-icon:hover {
    background-color: rgba(0, 0, 0, 0.05);
}
.avatar-wrapper:hover {
    border-color: #1266f1 !important;
    transform: scale(1.02);
    transition: all 0.2s;
}
.dropdown-item {
    transition: all 0.15s ease;
}
.dropdown-item:hover {
    background-color: rgba(18, 102, 241, 0.06);
    color: #1266f1;
}
.dropdown-menu {
    display: none;
}
.dropdown-menu.show {
    display: block;
    animation: fadeIn 0.2s ease-out;
}
/* @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
} */
</style>
