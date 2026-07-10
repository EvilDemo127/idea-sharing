<template>
    <div class="sidebar-wrapper">
        <!-- 1. TAGS SIDEBAR PANEL -->
        <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden" v-if="isQues">
            <!-- Premium Action Button -->
            <div class="p-3 bg-white">
                <Link 
                    :href="route('question.create')" 
                    class="btn btn-primary w-100 py-2.5 fw-bold text-capitalize shadow-sm d-flex align-items-center justify-content-center gap-2"
                    style="background: linear-gradient(45deg, #1266f1, #00b0ff); border: 0; border-radius: 8px;"
                >
                    <i class="fas fa-plus-circle fs-6"></i> Ask New Question
                </Link>
            </div>

            <!-- Panel Header -->
            <div class="card-header bg-light border-0 py-3 px-4 d-flex align-items-center gap-2">
                <i class="fas fa-tags text-primary"></i>
                <span class="fw-bold text-dark text-uppercase small tracking-wider" style="letter-spacing: 0.5px;">Popular Tags</span>
            </div>

            <!-- Panel Body / Tag Lists -->
            <div class="card-body p-2 bg-white">
                <div class="d-flex flex-column gap-1">
                    <Link 
                        v-for="tag in $page.props.tag" 
                        :key="tag.id"
                        :href="'/?tag=' + tag.slug" 
                        class="nav-link tag-item d-flex align-items-center justify-content-between px-3 py-2 rounded-2"
                    >
                        <div class="d-flex align-items-center gap-2.5">
                            <span class="tag-hash text-muted">#</span>
                            <span class="tag-name fw-medium text-secondary">{{ tag.name }}</span>
                        </div>
                        <i class="fas fa-chevron-right text-muted small-arrow opacity-0"></i>
                    </Link>
                </div>
            </div>
        </div>

        <!-- 2. PROFILE SIDEBAR PANEL -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden" v-if="isProfile">
            <!-- Panel Header -->
            <div class="card-header bg-light border-0 py-3 px-4 d-flex align-items-center gap-2">
                <i class="fas fa-user-circle text-primary"></i>
                <span class="fw-bold text-dark text-uppercase small tracking-wider" style="letter-spacing: 0.5px;">Profile Menu</span>
            </div>

            <!-- Panel Body / Menu Lists -->
            <div class="card-body p-2 bg-white">
                <div class="d-flex flex-column gap-1">
                    <Link 
                        :href="route('profile.edit')" 
                        class="nav-link menu-item d-flex align-items-center gap-3 px-3 py-2.5 rounded-2"
                        :class="{ 'active-menu': $page.url.startsWith('/profile') }"
                    >
                        <i class="fas fa-user-cog text-muted icon-width"></i>
                        <span class="fw-medium">Account Settings</span>
                    </Link>

                    <Link 
                        :href="route('question.own')" 
                        class="nav-link menu-item d-flex align-items-center gap-3 px-3 py-2.5 rounded-2"
                    >
                        <i class="fas fa-question-circle text-muted icon-width"></i>
                        <span class="fw-medium">My Questions</span>
                    </Link>

                    <Link 
                        class="nav-link menu-item d-flex align-items-center gap-3 px-3 py-2.5 rounded-2"
                    >
                        <i class="fas fa-bookmark text-muted icon-width"></i>
                        <span class="fw-medium">Saved Bookmarks</span>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { LikeAndCom } from "../Comp/LikeAndCom";
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

defineOptions({
    name: "SideBar",
});

const page = usePage();
//set page is profile or questions
const isProfile = computed(() => {
    let url = page.url;
    return url ? url.startsWith("/profile") : false;
});

const isQues = computed(() => {
    return !isProfile.value;
});
</script>

<style scoped>
/* Icon အကျယ် ပုံသေညှိရန် */
.icon-width {
    width: 20px;
    text-align: center;
    font-size: 1.05rem;
    transition: color 0.2s;
}

/* --- Tag Items Styles --- */
.tag-item {
    transition: all 0.2s ease-in-out;
    background-color: transparent;
}
.tag-hash {
    font-weight: 700;
    font-size: 1.1rem;
    transition: color 0.2s;
}
.small-arrow {
    font-size: 0.75rem;
    transition: all 0.2s ease-in-out;
}
/* Tag ကို Hover တင်လိုက်သည့်အခါ Effect ပြုလုပ်ခြင်း */
.tag-item:hover {
    background-color: rgba(18, 102, 241, 0.05);
}
.tag-item:hover .tag-name {
    color: #1266f1 !important;
}
.tag-item:hover .tag-hash {
    color: #1266f1 !important;
}
.tag-item:hover .small-arrow {
    opacity: 1 !important;
    transform: translateX(3px);
    color: #1266f1 !important;
}

/* --- Profile Menu Items Styles --- */
.menu-item {
    color: #4f4f4f !important;
    transition: all 0.2s ease;
}
.menu-item:hover {
    background-color: #f8f9fa;
    color: #1266f1 !important;
}
.menu-item:hover .text-muted {
    color: #1266f1 !important;
}
/* လက်ရှိရောက်နေသော Active Menu ဖြစ်ပါက မီးလင်းနေစေရန် */
.active-menu {
    background-color: rgba(18, 102, 241, 0.07) !important;
    color: #1266f1 !important;
    font-weight: 600;
}
.active-menu .text-muted {
    color: #1266f1 !important;
}
</style>



