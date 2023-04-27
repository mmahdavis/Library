<script setup>
import { computed, reactive, ref } from "vue";
import moment from 'moment';
import { mdiEye, mdiPencil, mdiTrashCan } from "@mdi/js";
import CardBoxModal from "@/Components/CardBoxModal.vue";
import TableCheckboxCell from "@/Components/TableCheckboxCell.vue";
import BaseLevel from "@/Components/BaseLevel.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import BaseButton from "@/Components/BaseButton.vue";
import UserAvatar from "@/Components/UserAvatar.vue";
import CardBox from "@/Components/CardBox.vue";
import NotificationBarInCard from "@/Components/NotificationBarInCard.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import axios from "axios";

const prop = defineProps({
    checkable: Boolean,
    publishers: Object,
});
const emit = defineEmits(['updatePublishers'])

const Currency = new Intl.NumberFormat("fa-IR", { style: "currency", currency: "IRR" })

const items = computed(() => prop.publishers);

const isModalUpdateActive = ref(false);

const isModalDeleteActive = ref(false);

const perPage = ref(20);

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

const form = reactive({
    id: "",
    name: "",
    slug: "",
    image: "https://fakeimg.pl/320/",
});

const item = ref('')
function deleteItem(id) {
    isModalDeleteActive.value = true
    item.value = id
}
function confirmDelete() {
    axios.delete('http://localhost:8000/api/v1/publishers/' + item.value);
    isModalDeleteActive.value = false
    emit('updatePublishers')
}

const notificationText = ref('');
const formStatusCurrent = ref(0);
const formStatusOptions = ["info", "success", "danger", "warning"];
function editDetails(publisher) {
    notificationText.value = null;
    isModalUpdateActive.value = true;
    form.id = publisher.id
    form.name = publisher.name;
    form.slug = publisher.slug;
    form.image = publisher.image;
}
const formUpdateSubmit = () => {
    axios.put('http://localhost:8000/api/v1/publishers/' + form.id, {
        name: form.name,
        slug: form.slug,
        image: form.image,
    })
        .then((response) => {
            isModalUpdateActive.value = false
            emit('updatePublishers')
        })
        .catch((error) => {
            console.log(error);
            notificationText.value = error.response.data.message;
            formStatusCurrent.value = 2
        });
};
</script>

<template>
    <CardBoxModal v-model="isModalUpdateActive" title="Update Publisher" has-cancel>
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
                <th>Slug</th>
                <th>Created</th>
                <th />
            </tr>
        </thead>
        <tbody>
            <tr v-for="publisher in itemsPaginated" :key="publisher.id">
                <TableCheckboxCell v-if="checkable" @checked="checked($event, publisher)" />
                <td class="border-b-0 lg:w-6 before:hidden">
                    <UserAvatar :username="publisher.name" class="w-24 h-24 mx-auto lg:w-6 lg:h-6" />
                </td>
                <td data-label="Name">
                    {{ publisher.name }}
                </td>
                <td data-label="Code">
                    {{ publisher.slug }}
                </td>
                <td data-label="Created_at" class="lg:w-1 whitespace-nowrap">
                    <small class="text-gray-500 dark:text-slate-400" :title="publisher.created_at">{{
                        moment(publisher.created_at).format("MMM Do YY") }}</small>
                </td>
                <td class="before:hidden lg:w-1 whitespace-nowrap">
                    <BaseButtons type="justify-start lg:justify-end" no-wrap>
                        <BaseButton color="info" :icon="mdiPencil" small @click="editDetails(publisher)" />
                        <BaseButton color="danger" :icon="mdiTrashCan" small @click="deleteItem(publisher.id)" />
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
