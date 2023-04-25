<script setup>
import { computed, reactive, ref } from "vue";
import moment from 'moment';
import { mdiEye, mdiPencil, mdiTrashCan, mdiUpdate } from "@mdi/js";
import CardBoxModal from "@/Components/CardBoxModal.vue";
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";
import BaseLevel from "@/Components/BaseLevel.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import BaseButton from "@/Components/BaseButton.vue";
import UserAvatar from "@/Components/UserAvatar.vue";
import CardBox from "@/Components/CardBox.vue";
import axios from "axios";
import NotificationBarInCard from "@/Components/NotificationBarInCard.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseDivider from "@/Components/BaseDivider.vue";

const prop = defineProps({
    checkable: Boolean,
    perPage: Number,
    books: Object,
});
const Currency = new Intl.NumberFormat("fa-IR", { style: "currency", currency: "IRR" })
const items = computed(() => prop.books);

const isModalUpdateActive = ref(false);

const isModalDangerActive = ref(false);

const perPage = ref(prop.perPage ?? 20);

const currentPage = ref(0);

const checkedRows = ref([]);

const itemsPaginated = computed(() =>
    items.value.slice(
        perPage.value * currentPage.value,
        perPage.value * (currentPage.value + 1)
    )
);

const numPages = computed(() => Math.ceil(items.value.length / perPage.value));

const currentPageHuman = computed(() => currentPage.value + 1);

const pagesList = computed(() => {
    const pagesList = [];

    for (let i = 0; i < numPages.value; i++) {
        pagesList.push(i);
    }

    return pagesList;
});

const remove = (arr, cb) => {
    const newArr = [];

    arr.forEach((item) => {
        if (!cb(item)) {
            newArr.push(item);
        }
    });

    return newArr;
};

const checked = (isChecked, client) => {
    if (isChecked) {
        checkedRows.value.push(client);
    } else {
        checkedRows.value = remove(
            checkedRows.value,
            (row) => row.id === client.id
        );
    }
};

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

function editDetails(book) {
    isModalUpdateActive.value = true;
    form.code = book.code;
    form.name = book.name;
    form.price = book.price;
    from.image = book.image;
}
</script>

<template>
    <CardBoxModal v-model="isModalUpdateActive" title="Add New Book" has-cancel>
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

    <CardBoxModal v-model="isModalDangerActive" title="Please confirm" button="danger" has-cancel>
        <p>Lorem ipsum dolor sit amet <b>adipiscing elit</b></p>
        <p>This is sample modal</p>
    </CardBoxModal>

    <div v-if="checkedRows.length" class="p-3 bg-gray-100/50 dark:bg-slate-800">
        <span v-for="checkedRow in checkedRows" :key="checkedRow.id"
            class="inline-block px-2 py-1 rounded-sm mr-2 text-sm bg-gray-100 dark:bg-slate-700">
            {{ checkedRow.name }}
        </span>
    </div>

    <table>
        <thead>
            <tr>
                <th v-if="checkable" />
                <th />
                <th>Name</th>
                <th>Code</th>
                <th>Price</th>
                <th>Created</th>
                <th />
            </tr>
        </thead>
        <tbody>
            <tr v-for="book in itemsPaginated" :key="book.id">
                <TableCheckboxCell v-if="checkable" @checked="checked($event, book)" />
                <td class="border-b-0 lg:w-6 before:hidden">
                    <UserAvatar :username="book.name" class="w-24 h-24 mx-auto lg:w-6 lg:h-6" />
                </td>
                <td data-label="Name">
                    {{ book.name }}
                </td>
                <td data-label="Code">
                    {{ book.code }}
                </td>
                <td data-label="Price">
                    {{ Currency.format(book.price) }}
                </td>
                <td data-label="Created_at" class="lg:w-1 whitespace-nowrap">
                    <small class="text-gray-500 dark:text-slate-400" :title="book.created_at">{{
                        moment(book.created_at).format("MMM Do YY") }}</small>
                </td>
                <td class="before:hidden lg:w-1 whitespace-nowrap">
                    <BaseButtons type="justify-start lg:justify-end" no-wrap>
                        <BaseButton color="info" :icon="mdiPencil" small @click="editDetails(book)" />
                        <BaseButton color="danger" :icon="mdiTrashCan" small @click="isModalDangerActive = true" />
                    </BaseButtons>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="p-3 lg:px-6 border-t border-gray-100 dark:border-slate-800">
        <BaseLevel>
            <BaseButtons>
                <BaseButton v-for="page in pagesList" :key="page" :active="page === currentPage" :label="page + 1"
                    :color="page === currentPage ? 'lightDark' : 'whiteDark'" small @click="currentPage = page" />
            </BaseButtons>
            <small>Page {{ currentPageHuman }} of {{ numPages }}</small>
        </BaseLevel>
    </div>
</template>
