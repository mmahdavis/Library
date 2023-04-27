<script setup>
import {
    mdiPlus,
    mdiBookMultipleOutline,
    mdiBookAlphabet,
    mdiBarcode,
    mdiCurrencyUsd,
    mdiImageArea,
} from "@mdi/js";
import { Head } from '@inertiajs/vue3';
import SectionMain from "@/components/SectionMain.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import SpecialIssues from "@/components/Tables/SpecialIssues.vue";
import CardBox from "@/components/CardBox.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import { reactive, ref } from "vue";
import CardBoxModal from "@/Components/CardBoxModal.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import NotificationBarInCard from "@/Components/NotificationBarInCard.vue";
import axios from "axios";

const selectOptions = reactive({
    category_id: [ { "id": 0, "label": "Select Category" }],
    tag_id: [{ "id": 0, "label": "Select Tag" }],
});
const specialIssues = ref();
async function getSpecialIssues() {
    await axios.get('http://localhost:8000/api/v1/specialIssues').then((r) => { specialIssues.value = r.data; });
}
getSpecialIssues()
const isModalInsertActive = ref(false);

const form = reactive({
    category_id: selectOptions.category_id[0],
    tag_id: selectOptions.tag_id[0],
    slug: "",
    name: "",
    price: "",
});

const notificationText = ref('');
const formStatusCurrent = ref(0);
const formStatusOptions = ["info", "success", "danger", "warning"];
const fromInsertSubmit = () => {
    axios.post('http://localhost:8000/api/v1/specialIssues', {
        category_id: 1,
        tag_id: 1,
        slug: form.slug,
        name: form.name,
        price: form.price,
    })
        .then(function (response) {
            notificationText.value = 'Created Sucessfuly';
            formStatusCurrent.value = 1;
        })
        .catch(function (error) {
            notificationText.value = error.response.data.message;
            formStatusCurrent.value = 2
        });
};
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Special Issues" />
        <SectionMain>
            <CardBoxModal v-model="isModalInsertActive" title="Add New SpecialIssue" has-cancel>
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
                        <FormControl v-model="form.name" :icon="mdiBookAlphabet" placeholder="SpecialIssue Name" required />
                        <FormControl v-model="form.slug" :icon="mdiBarcode" placeholder="SpecialIssue slug" required />
                        <FormControl v-model="form.price" :icon="mdiCurrencyUsd" placeholder="SpecialIssue Price" required />
                    </FormField>
                    <FormField label="External Data">
                        <FormControl v-model="form.category_id" :options="selectOptions.category_id" />
                        <FormControl v-model="form.tag_id" :options="selectOptions.tag_id" />
                    </FormField>
                    <BaseDivider />
                    <BaseButtons>
                        <BaseButton type="submit" color="info" label="Submit" />
                        <BaseButton type="reset" color="info" outline label="Reset" />
                    </BaseButtons>
                </CardBox>
            </CardBoxModal>

            <SectionTitleLineWithButton :icon="mdiBookMultipleOutline" title="SpecialIssues" main>
                <BaseButton href="" target="_blank" :icon="mdiPlus" label="Add New" color="contrast" rounded-full small
                    @click="isModalInsertActive = true" />
            </SectionTitleLineWithButton>

            <CardBox v-if=specialIssues class="mb-6" has-table>
                <SpecialIssues checkable :specialIssues=specialIssues.data :selectOptions=selectOptions @update-specialIssues="getSpecialIssues()" />
            </CardBox>

            <CardBox v-else>
                <CardBoxComponentEmpty />
            </CardBox>

        </SectionMain>
    </LayoutAuthenticated>
</template>
