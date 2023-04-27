<script setup>
import {
    mdiTableBorder,
    mdiPlus,
    mdiBookMultipleOutline,
} from "@mdi/js";
import { Head } from '@inertiajs/vue3';
import SectionMain from "@/components/SectionMain.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import Tags from "@/components/Tables/Tags.vue";
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

const tags = ref();
async function getTags() {
    await axios.get('http://localhost:8000/api/v1/tags').then((r) => { tags.value = r.data; });
}
getTags()

const isModalInsertActive = ref(false);

const form = reactive({
    name: "",
    slug: "",
});

const notificationText = ref('');
const formStatusCurrent = ref(0);
const formStatusOptions = ["info", "success", "danger", "warning"];
const fromInsertSubmit = () => {
    axios.post('http://localhost:8000/api/v1/tags', {
        name: form.name,
        slug: form.slug,
    })
        .then((response) => {
            notificationText.value = 'Created Sucessfuly';
            formStatusCurrent.value = 1;
            getTags()
        })
        .catch((error) => {
            notificationText.value = error.response.data.message;
            formStatusCurrent.value = 2
        });
};
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Tags" />
        <SectionMain>
            <CardBoxModal v-model="isModalInsertActive" title="Add New Tag" has-cancel>
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
                        <FormControl v-model="form.name" :icon="mdiBookAlphabet" placeholder="Tag Name" required />
                        <FormControl v-model="form.slug" :icon="mdiBarcode" placeholder="Tag Slug" required />
                    </FormField>
                    <BaseDivider />
                    <BaseButtons>
                        <BaseButton type="submit" color="info" label="Submit" />
                        <BaseButton type="reset" color="info" outline label="Reset" />
                    </BaseButtons>
                </CardBox>
            </CardBoxModal>
            <SectionTitleLineWithButton :icon="mdiBookMultipleOutline" title="Tags" main>
                <BaseButton href="" target="_blank" :icon="mdiPlus" label="Add New" color="contrast" rounded-full small
                    @click="isModalInsertActive = true
                    " />
            </SectionTitleLineWithButton>

            <CardBox v-if=tags class="mb-6" has-table>
                <Tags checkable :tags=tags.data @update-tags="getTags()" />
            </CardBox>
            <CardBox v-else>
                <CardBoxComponentEmpty />
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
