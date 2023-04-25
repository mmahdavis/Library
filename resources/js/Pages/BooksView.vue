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

defineProps({ books: Object })

const isModalInsertActive = ref(false);

const selectOptions = {
    category_id: [
        { id: 1, label: "cat1" },
        { id: 2, label: "cat2" },
        { id: 3, label: "cat3" },
    ],
    tag_id: [
        { id: 1, label: "tag1" },
        { id: 2, label: "tag2" },
        { id: 3, label: "tag3" },
    ],
    publisher_id: [
        { id: 1, label: "pub1" },
        { id: 2, label: "pub2" },
        { id: 3, label: "pub3" },
    ],
    translator_id: [
        { id: 1, label: "tr1" },
        { id: 2, label: "tr2" },
        { id: 3, label: "tr3" },
    ],
    writer_id: [
        { id: 1, label: "wr1" },
        { id: 2, label: "wr1" },
        { id: 3, label: "wr1" },
    ],
};

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
    // translator_id: selectOptions[0],
});

const formStatusCurrent = ref(0);
const formStatusOptions = ["info", "success", "danger", "warning"];
const formStatusWithHeader = ref(true);
const formStatusSubmit = () => {
    formStatusCurrent.value = formStatusOptions[formStatusCurrent.value + 1]
        ? formStatusCurrent.value + 1
        : 0;
};
</script>

<template>
    <LayoutAuthenticated>
        <SectionMain>
            <CardBoxModal v-model="isModalInsertActive" title="Add New Book" has-cancel>
                <template v-slot:Notification>
                    <NotificationBarInCard :color="formStatusOptions[formStatusCurrent]"
                        :is-placed-with-header="formStatusWithHeader">
                        <span><b class="capitalize">{{
                            formStatusOptions[formStatusCurrent]
                        }}</b>
                            state</span>
                    </NotificationBarInCard>
                </template>
                <CardBox is-form is-hoverable @submit.prevent="formStatusSubmit">
                    <FormField label="Required Data">
                        <FormControl v-model="form.name" :icon="mdiBookAlphabet" placeholder="Book Name" />
                        <FormControl v-model="form.code" :icon="mdiBarcode" placeholder="Book Code" />
                        <FormControl v-model="form.price" :icon="mdiCurrencyUsd" placeholder="Book Price" />
                        <FormControl v-model="form.image" :icon="mdiImageArea" placeholder="Book Image" />
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
                <Books checkable :books=books.data />
            </CardBox>

            <CardBox v-else>
                <CardBoxComponentEmpty />
            </CardBox>

        </SectionMain>
    </LayoutAuthenticated>
</template>
