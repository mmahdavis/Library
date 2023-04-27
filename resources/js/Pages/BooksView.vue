<script setup>
import {
    mdiPlus,
    mdiBookMultipleOutline,
    mdiAccount,
    mdiMail,
    mdiBookAlphabet,
    mdiBarcode,
    mdiCurrencyUsd,
    mdiImageArea,
} from "@mdi/js";
import { Head } from '@inertiajs/vue3';
import SectionMain from "@/components/SectionMain.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import Books from "@/components/Tables/Books.vue";
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
    publisher_id: [{ "id": 0, "label": "Select Publisher" }],
    translator_id: [{ "id": 0, "label": "Select Tranlator" }],
    writer_id: [{ "id": 0, "label": "Select Writer" }],
});
const books = ref();
async function getBooks() {
    await axios.get('http://localhost:8000/api/v1/books').then((r) => { books.value = r.data; });
}
async function getBookdata() {
    await axios.get('http://localhost:8000/api/v1/bookdata')
        .then((r) => {
            selectOptions.category_id.push(...r.data.categories);
            selectOptions.tag_id.push(...r.data.tags);
            selectOptions.publisher_id.push(...r.data.publishers);
            selectOptions.translator_id.push(...r.data.translators);
            selectOptions.writer_id.push(...r.data.writers);
        });
}
getBooks()
getBookdata()
const isModalInsertActive = ref(false);

const form = reactive({
    category_id: selectOptions.category_id[0],
    tag_id: selectOptions.tag_id[0],
    publisher_id: selectOptions.publisher_id[0],
    translator_id: selectOptions.translator_id[0],
    writer_id: selectOptions.writer_id[0],
    code: "",
    name: "",
    price: "",
    image: "https://fakeimg.pl/320/",
});

const notificationText = ref('');
const formStatusCurrent = ref(0);
const formStatusOptions = ["info", "success", "danger", "warning"];
const fromInsertSubmit = () => {
    axios.post('http://localhost:8000/api/v1/books', {
        category_id: 1,
        tag_id: 1,
        publisher_id: 1,
        translator_id: 1,
        writer_id: 1,
        code: form.code,
        name: form.name,
        price: form.price,
        image: form.image
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
        <Head title="Books" />
        <SectionMain>
            <CardBoxModal v-model="isModalInsertActive" title="Add New Book" has-cancel>
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
                        <FormControl v-model="form.name" :icon="mdiBookAlphabet" placeholder="Book Name" required />
                        <FormControl v-model="form.code" :icon="mdiBarcode" placeholder="Book Code" required />
                        <FormControl v-model="form.price" :icon="mdiCurrencyUsd" placeholder="Book Price" required />
                        <FormControl v-model="form.image" :icon="mdiImageArea" placeholder="Book Image" required />
                    </FormField>
                    <FormField label="External Data">
                        <FormControl v-model="form.category_id" :options="selectOptions.category_id" />
                        <FormControl v-model="form.tag_id" :options="selectOptions.tag_id" />
                        <FormControl v-model="form.publisher_id" :options="selectOptions.publisher_id" />
                        <FormControl v-model="form.translator_id" :options="selectOptions.translator_id" />
                        <FormControl v-model="form.writer_id" :options="selectOptions.writer_id" />
                    </FormField>
                    <BaseDivider />
                    <BaseButtons>
                        <BaseButton type="submit" color="info" label="Submit" />
                        <BaseButton type="reset" color="info" outline label="Reset" />
                    </BaseButtons>
                </CardBox>
            </CardBoxModal>

            <SectionTitleLineWithButton :icon="mdiBookMultipleOutline" title="Books" main>
                <BaseButton href="" target="_blank" :icon="mdiPlus" label="Add New" color="contrast" rounded-full small
                    @click="isModalInsertActive = true" />
            </SectionTitleLineWithButton>

            <CardBox v-if=books class="mb-6" has-table>
                <Books checkable :books=books.data :selectOptions=selectOptions @update-books="getBooks()" />
            </CardBox>

            <CardBox v-else>
                <CardBoxComponentEmpty />
            </CardBox>

        </SectionMain>
    </LayoutAuthenticated>
</template>
