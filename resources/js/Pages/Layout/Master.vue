<template>
    <!-- Modern Header Navigation -->
    <Nav />

    <!-- Main Content Application Grid Layout -->
    <main class="container py-4">
        <div class="row g-4">
            
            <!-- Left Panel: Responsive Sidebar (12 columns on Mobile, 4 on Desktop) -->
            <aside class="col-12 col-md-4">
                <SideBar />
            </aside>

            <!-- Right Panel: Dynamic Interchanging Views / Content Space -->
            <section class="col-12 col-md-8">
                <slot />
            </section>

        </div>
    </main>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import Nav from './Nav.vue';
import SideBar from './SideBar.vue';

defineOptions({
    name: 'Master',
});

// Global Notification Alert Trigger
const notify = () => {
    toast("Wow so easy!", {
        autoClose: 1000,
        position: toast.POSITION.BOTTOM_RIGHT,
    });
};
</script>
