<template>
    <Master>
        <div class="row g-3">
            <div class="col-4 bg-white shadow rounded p-2">
                <div
                    class="d-flex align-items-center p-2 mb-1 rounded"
                    v-for="user in users"
                    :key="user.id"
                    @click.prevent="selectUser(user)"
                    :class="
                        selectedUser === user.id ? 'bg-primary text-white' : ''
                    "
                    style="cursor: pointer"
                >
                    <img
                        :src="
                            user.image
                                ? `https://lh3.googleusercontent.com/d/${user.image}`
                                : '/images/default-avatar.png'
                        "
                        class="rounded-circle border"
                        style="width: 32px; height: 32px; object-fit: cover"
                        alt="User Avatar"
                    />
                    <div class="d-flex flex-column lh-sm ps-2">
                        <span
                            class="fw-bold text-dark"
                            style="font-size: 0.88rem"
                            >{{ user.name }}</span
                        >
                    </div>
                </div>
            </div>

            <div
                class="col-8 bg-white shadow rounded p-3 d-flex flex-column justify-content-between"
                style="height: 450px"
            >
                <div
                    class="chat-messages flex overflow-auto mb-3 p-2"
                    style="max-height: 400px"
                >
                    <div v-if="messages && messages.length > 0">
                        <div
                            v-for="msg in messages"
                            :key="msg.id"
                            class="d-flex mb-3 align-items-end w-100"
                            :class="
                                selectedUser == msg.sender_id
                                    ? 'justify-content-start'
                                    : 'justify-content-end'
                            "
                        >
                           
                            <div
                                class="d-flex flex-column"
                                :class="
                                    selectedUser == msg.sender_id
                                        ? 'align-items-start'
                                        : 'align-items-end'
                                "
                                style="max-width: 70%"
                            >
                                <div
                                    class="px-3 py-2 shadow-sm"
                                    :style="{
                                        borderRadius:
                                            selectedUser == msg.sender_id
                                                ? '16px 16px 16px 4px'
                                                : '16px 16px 4px 16px',
                                        backgroundColor:
                                            selectedUser == msg.sender_id
                                                ? '#f1f3f5'
                                                : '#0d6efd',
                                        color:
                                            selectedUser == msg.sender_id
                                                ? '#212529'
                                                : '#ffffff',
                                    }"
                                >
                                    {{ msg.message }}
                                </div>

                                <small
                                    class="text-muted mt-1 px-1"
                                    style="font-size: 0.7rem"
                                >
                                    {{ formatChatTime(msg.created_at) }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <div v-else>
                        <p class="text-muted text-center mt-5">
                            No conversation logs found. Say hello!
                        </p>
                    </div>
                </div>

                <!-- Chat Input Form -->
                <form @submit.prevent="sendMessage">
                    <div
                        class="input-group shadow-sm rounded-pill overflow-hidden"
                    >
                        <input
                            v-model="form.message"
                            name="message"
                            type="text"
                            placeholder="Type a message..."
                            class="form-control border-0 py-3 shadow-none text-dark ps-3"
                            style="font-size: 0.95rem"
                        />
                        <button
                            type="submit"
                            class="btn btn-primary px-4 fw-bold border-0"
                            style="
                                background: linear-gradient(
                                    45deg,
                                    #1266f1,
                                    #00b0ff
                                );
                                border-radius: 0 50rem 50rem 0 !important;
                            "
                        >
                            send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </Master>
</template>

<script setup>
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import Master from "./Layout/Master.vue";

const selectedUser = ref(null);

defineProps({
    users: Object,
    messages: Object,
    selectedUser: [Number, String],
});

const form = useForm({
    receiver_id: "",
    message: "",
});

const selectUser = (user) => {
    selectedUser.value = user.id;
    form.receiver_id = user.id;
    router.get(
        route("get_message", user.id),
        {},
        {
            preserveScroll: true,
            preserveState: true,
            replace: true,
        },
    );
};

const sendMessage = () => {
    console.log(form);

    form.post(route("store_message"), {
        onSuccess: () => form.reset("message"),
    });
};

const formatChatTime = (chatDate) => {
    const date = new Date(chatDate);
    return date.toLocaleString({
        hour: "2-digit",
        minute: "2-digit",
        hour12: true,
    });
};
</script>
