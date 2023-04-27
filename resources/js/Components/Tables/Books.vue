<script setup>
import { computed, reactive, ref } from "vue";
import moment from 'moment';
import { mdiEye, mdiPencil, mdiTrashCan, mdiUpdate } from "@mdi/js";
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";
import BaseLevel from "@/Components/BaseLevel.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import BaseButton from "@/Components/BaseButton.vue";
import UserAvatar from "@/Components/UserAvatar.vue";
import axios from "axios";
import CardBox from "@/Components/CardBox.vue";
import CardBoxModal from "@/Components/CardBoxModal.vue";
import NotificationBarInCard from "@/Components/NotificationBarInCard.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseDivider from "@/Components/BaseDivider.vue";

const prop = defineProps({
    checkable: Boolean,
    perPage: Number,
    books: Object,
    selectOptions: Object,
});
const emit = defineEmits(['updateBooks'])

const Currency = new Intl.NumberFormat("fa-IR", { style: "currency", currency: "IRR" })

const items = computed(() => prop.books);

const isModalUpdateActive = ref(false);

const isModalDeleteActive = ref(false);

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

const form = reactive({
    category_id: prop.selectOptions.category_id[0],
    tag_id: prop.selectOptions.tag_id[0],
    publisher_id: prop.selectOptions.publisher_id[0],
    translator_id: prop.selectOptions.translator_id[0],
    writer_id: prop.selectOptions.writer_id[0],
    id: "",
    code: "",
    name: "",
    price: "",
    image: "https://fakeimg.pl/320/"
});

function editDetails(book) {
    notificationText.value = null;
    isModalUpdateActive.value = true;
    form.id = book.id
    form.code = book.code;
    form.name = book.name;
    form.price = book.price;
    form.image = book.image;
    form.category_id = prop.selectOptions.category_id[book.category_id ?? 0]
    form.tag_id = prop.selectOptions.tag_id[book.tag_id ?? 0]
    form.publisher_id = prop.selectOptions.publisher_id[book.publisher_id ?? 0]
    form.translator_id = prop.selectOptions.translator_id[book.translator_id ?? 0]
    form.writer_id = prop.selectOptions.writer_id[book.writer_id ?? 0]
}

const notificationText = ref('');
const formStatusCurrent = ref(0);
const formStatusOptions = ["info", "success", "danger", "warning"];
const formUpdateSubmit = () => {
    axios.put('http://localhost:8000/api/v1/books/' + form.id, {
        category_id: null,
        tag_id: null,
        publisher_id: null,
        translator_id: null,
        writer_id: null,
        code: form.code,
        name: form.name,
        price: form.price,
        image: form.image
    })
        .then(function (response) {
            isModalUpdateActive.value = false;
            emit('updateBooks')
        })
        .catch(function (error) {
            notificationText.value = error.response.data.message;
            formStatusCurrent.value = 2
        });
};

const item = ref('')
function deleteItem(id) {
    isModalDeleteActive.value = true
    item.value = id
}
function confirmDelete() {
    axios.delete('http://localhost:8000/api/v1/books/' + item.value)
    isModalDeleteActive.value = false
    emit('updateBooks')
}
</script>

<template>
    <CardBoxModal v-model="isModalUpdateActive" title="Update Book" has-cancel>
        <template v-slot:Notification>
            <NotificationBarInCard v-if=notificationText :color="formStatusOptions[formStatusCurrent]"
                :is-placed-with-header="true">
                <span><b class="capitalize">{{
                    formStatusOptions[formStatusCurrent]
                }}</b>
                    {{ notificationText }}</span>
            </NotificationBarInCard>
        </template>
        <CardBox is-form is-hoverable @submit.prevent="formUpdateSubmit">
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

    <CardBoxModal v-model="isModalDeleteActive" title="Please Confirm to Delete" button="danger" has-cancel>
        <BaseButtons>
            <BaseButton color="danger" label="DELETE" @click="confirmDelete()" />
        </BaseButtons>
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
                        <BaseButton color="danger" :icon="mdiTrashCan" small @click="deleteItem(book.id)" />
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
