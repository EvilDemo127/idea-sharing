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
                        selectedUser === user.uuid
                            ? 'bg-primary text-white'
                            : ''
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
                    ref="messageContainer"
                    class="chat-messages flex overflow-auto mb-3 p-2"
                    style="max-height: 400px"
                >
                    <div v-if="newMessage && newMessage.length > 0">
                        <div
                            v-for="msg in newMessage"
                            :key="msg.id"
                            class="d-flex mb-3 align-items-end w-100"
                            :class="
                                authId == msg.receiver_id
                                    ? 'justify-content-start'
                                    : 'justify-content-end'
                            "
                        >
                            <div
                                class="d-flex flex-column"
                                :class="
                                    authId == msg.receiver_id
                                        ? 'align-items-start'
                                        : 'align-items-end'
                                "
                                style="max-width: 70%"
                            >
                                <div
                                    class="px-3 py-2 shadow-sm"
                                    :style="{
                                        borderRadius:
                                            authId == msg.receiver_id
                                                ? '16px 16px 16px 4px'
                                                : '16px 16px 4px 16px',
                                        backgroundColor:
                                            authId == msg.receiver_id
                                                ? '#f1f3f5'
                                                : '#0d6efd',
                                        color:
                                            authId == msg.receiver_id
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
                <form @submit.prevent="sendMessage" v-show="selectedUser">
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
import { nextTick, onMounted, ref, watch } from "vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import Master from "./Layout/Master.vue";
import Echo from "laravel-echo";

const notiCount = ref(0);
const authId = usePage().props.user.id;
const messageContainer = ref(null);
const props = defineProps({
    users: Object,
    messages: Object,
    selectedUser: [Number, String, Object],
});
const newMessage = ref(props.messages);
const selectedUser = ref(props.selectedUser || null);

const form = useForm({
    receiver_id: "",
    message: "",
});

const scolBut = async () => {
    await nextTick();// waiting to finished DOM
    if (messageContainer.value) {
        messageContainer.value.scrollTop = messageContainer.value.scrollHeight;
    }
};

watch(
    () => props.messages,
    (newVal) => {
        newMessage.value = newVal;
        scolBut();
    },
    { deep: true },
);

onMounted(() => {
    scolBut();

    window.Echo.private(`chat.${authId}`).listen(
        ".App\\Events\\MessageSent",
        (e) => {
            console.log(e);
            newMessage.value.push(e);
        },
    );
});

const selectUser = (user) => {
    selectedUser.value = user.uuid;
    form.receiver_id = user.id;
    router.get(
        route("get_message", user.uuid),
        {},
        {
            preserveScroll: true,
            preserveState: true,
            replace: true,
        },
    );
};

const sendMessage = () => {
    if (!form.message.trim()) return;
    form.post(route("store_message"), {
        onSuccess: () => {
            (form.reset("message"), scolBut());
        },
    });
};

const formatChatTime = (chatDate) => {
    const date = new Date(chatDate);
    return date.toLocaleString("en-US", {
        hour: "2-digit",
        minute: "2-digit",
        hour12: true,
    });
};
</script>
