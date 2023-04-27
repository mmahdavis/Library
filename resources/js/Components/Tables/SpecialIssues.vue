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
    specialIssues: Object,
    selectOptions: Object,
});
const emit = defineEmits(['updateSpecialIssues'])

const Currency = new Intl.NumberFormat("fa-IR", { style: "currency", currency: "IRR" })

const items = computed(() => prop.specialIssues);

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
    id: "",
    slug: "",
    name: "",
    price: "",
});

function editDetails(specialIssue) {
    notificationText.value = null;
    isModalUpdateActive.value = true;
    form.id = specialIssue.id
    form.slug = specialIssue.slug;
    form.name = specialIssue.name;
    form.price = specialIssue.price;
    form.category_id = prop.selectOptions.category_id[specialIssue.category_id ?? 0]
    form.tag_id = prop.selectOptions.tag_id[specialIssue.tag_id ?? 0]
}

const notificationText = ref('');
const formStatusCurrent = ref(0);
const formStatusOptions = ["info", "success", "danger", "warning"];
const formUpdateSubmit = () => {
    axios.put('http://localhost:8000/api/v1/specialIssues/' + form.id, {
        category_id: null,
        tag_id: null,
        slug: form.slug,
        name: form.name,
        price: form.price,
    })
        .then(function (response) {
            isModalUpdateActive.value = false;
            emit('updateSpecialIssues')
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
    axios.delete('http://localhost:8000/api/v1/specialIssues/' + item.value)
    isModalDeleteActive.value = false
    emit('updateSpecialIssues')
}
</script>

<template>
    <CardBoxModal v-model="isModalUpdateActive" title="Update SpecialIssue" has-cancel>
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
                <FormControl v-model="form.name" :icon="mdiBookAlphabet" placeholder="SpecialIssue Name" required />
                <FormControl v-model="form.slug" :icon="mdiBarslug" placeholder="SpecialIssue slug" required />
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
                <th>slug</th>
                <th>Price</th>
                <th>Created</th>
                <th />
            </tr>
        </thead>
        <tbody>
            <tr v-for="specialIssue in itemsPaginated" :key="specialIssue.id">
                <TableCheckboxCell v-if="checkable" @checked="checked($event, specialIssue)" />
                <td class="border-b-0 lg:w-6 before:hidden">
                    <UserAvatar :username="specialIssue.name" class="w-24 h-24 mx-auto lg:w-6 lg:h-6" />
                </td>
                <td data-label="Name">
                    {{ specialIssue.name }}
                </td>
                <td data-label="slug">
                    {{ specialIssue.slug }}
                </td>
                <td data-label="Price">
                    {{ Currency.format(specialIssue.price) }}
                </td>
                <td data-label="Created_at" class="lg:w-1 whitespace-nowrap">
                    <small class="text-gray-500 dark:text-slate-400" :title="specialIssue.created_at">{{
                        moment(specialIssue.created_at).format("MMM Do YY") }}</small>
                </td>
                <td class="before:hidden lg:w-1 whitespace-nowrap">
                    <BaseButtons type="justify-start lg:justify-end" no-wrap>
                        <BaseButton color="info" :icon="mdiPencil" small @click="editDetails(specialIssue)" />
                        <BaseButton color="danger" :icon="mdiTrashCan" small @click="deleteItem(specialIssue.id)" />
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
