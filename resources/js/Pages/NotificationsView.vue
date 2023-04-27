<script setup>
import { Head } from '@inertiajs/vue3';
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import CardBox from "@/components/CardBox.vue";
import SectionTitle from "@/components/SectionTitle.vue";
import SectionMain from "@/components/SectionMain.vue";
import BaseButton from "@/components/BaseButton.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import axios from 'axios';
import { ref } from 'vue';
import { mdiBell, mdiBellBadge, mdiInformation } from '@mdi/js';

const notifications = ref();
async function getNotifacations() {
    await axios.get('http://localhost:8000/api/v1/notifications/4').then((r) => { notifications.value = r.data; });
};
getNotifacations();

function readNotification(id) {
    axios.put('http://localhost:8000/api/v1/notifications/' + id, { checked: true });
    getNotifacations();
}
</script>

<template>
    <LayoutAuthenticated>

        <Head title="Notifications" />
        <SectionTitle custom>
            <h1 class="text-2xl text-gray-500 dark:text-slate-400">Notifications</h1>
            <div class="flex items-center justify-center mt-6">
                <FormCheckRadioGroup v-model="notificationSettingsModel" type="switch" name="notifications-switch"
                    :options="{ outline: 'Outline' }" />
            </div>
        </SectionTitle>

        <SectionMain>

            <CardBox v-if=notifications>
                <NotificationBar v-for="notification in notifications.data" :key="notification.id"
                    :color="notification.checked ? '' : notification.type"
                    :icon="notification.checked ? mdiBell : mdiBellBadge" :outline="notificationsOutline">
                    <div class="font-bold mx-3">{{ notification.title }}</div>
                    <p class="mx-3">{{ notification.message }}</p>
                    <template #right v-if="!notification.checked">
                        <BaseButton label="Read" :color="notificationsOutline ? notification.type : 'white'"
                            :outline="notificationsOutline" rounded-full small @click="readNotification(notification.id)" />
                    </template>
                </NotificationBar>
            </CardBox>

            <CardBox v-else>
                <CardBoxComponentEmpty />
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
