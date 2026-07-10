<template>
  <div style="padding: 50px; font-family: sans-serif; text-align: center;">
    <h1 style="color: #42b883; font-size: 2.5rem;">Vue 3 + Inertia v3 အလုပ်လုပ်နေပါပြီ! 🚀</h1>
    <p style="color: #666; font-size: 1.2rem;">Backend မှ ပို့လိုက်သောစာ - {{ message }}</p>
  </div>
</template>

<script setup>
defineProps({
  message: String
})
</script>
