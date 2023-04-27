<script setup>
import {
    mdiTableBorder,
    mdiPlus,
    mdiBookMultipleOutline,
} from "@mdi/js";
import { Head } from '@inertiajs/vue3';
import SectionMain from "@/components/SectionMain.vue";
import Publishers from "@/components/Tables/Publishers.vue";
import CardBox from "@/components/CardBox.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import { reactive, ref } from "vue";
import axios from "axios";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import CardBoxModal from "@/Components/CardBoxModal.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import NotificationBarInCard from "@/Components/NotificationBarInCard.vue";

const publishers = ref();
async function getPublisher() {
    await axios.get('http://localhost:8000/api/v1/publishers').then((r) => { publishers.value = r.data; });
}
getPublisher()

const isModalInsertActive = ref(false);

const form = reactive({
    name: "",
    slug: "",
    image: "https://fakeimg.pl/320/",
});

const notificationText = ref('');
const formStatusCurrent = ref(0);
const formStatusOptions = ["info", "success", "danger", "warning"];
const fromInsertSubmit = () => {
    axios.post('http://localhost:8000/api/v1/publishers', {
        name: form.name,
        slug: form.slug,
        image: form.image,
    })
        .then((response) => {
            notificationText.value = 'Created Sucessfuly';
            formStatusCurrent.value = 1;
            getPublisher()
        })
        .catch((error) => {
            notificationText.value = error.response.data.message;
            formStatusCurrent.value = 2
        });
};
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Publishers" />
        <SectionMain>
            <CardBoxModal v-model="isModalInsertActive" title="Add New Publisher" has-cancel>
                <template v-slot:Notification>
                    <NotificationBarInCard v-if=notificationText :color="formStatusOptions[formStatusCurrent]"
                        :is-placed-with-header="true">
                        <span><b class="capitalize">{{
                            formStatusOptions[formStatusCurrent]
                        }}</b>
                            {{ notificationText }}</span>
                    </NotificationBarInCard>
                </template>
                <CardBox is-form is-hoverable @submit.prevent="fromInsertSubmit">
                    <FormField label="Required Data">
                        <FormControl v-model="form.name" :icon="mdiBookAlphabet" placeholder="Publisher Name" required />
                        <FormControl v-model="form.slug" :icon="mdiBarcode" placeholder="Publisher Slug" required />
                        <FormControl v-model="form.image" :icon="mdiBarcode" placeholder="Publisher Image" required />
                    </FormField>
                    <BaseDivider />
                    <BaseButtons>
                        <BaseButton type="submit" color="info" label="Submit" />
                        <BaseButton type="reset" color="info" outline label="Reset" />
                    </BaseButtons>
                </CardBox>
            </CardBoxModal>
            <SectionTitleLineWithButton :icon="mdiBookMultipleOutline" title="Publisher" main>
                <BaseButton href="" target="_blank" :icon="mdiPlus" label="Add New" color="contrast" rounded-full small
                @click="isModalInsertActive = true" />
            </SectionTitleLineWithButton>

            <CardBox v-if=publishers class="mb-6" has-table>
                <Publishers checkable :publishers=publishers.data @update-publishers="getPublisher()" />
            </CardBox>
            <CardBox v-else>
                <CardBoxComponentEmpty />
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
