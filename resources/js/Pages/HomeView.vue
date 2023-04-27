<script setup>
import { computed, ref, onMounted, reactive } from "vue";
import { useMainStore } from "@/Stores/main";
import {
    mdiAccountMultiple,
    mdiCartOutline,
    mdiChartTimelineVariant,
    mdiReload,
    mdiGithub,
    mdiChartPie,
} from "@mdi/js";
import { Head } from '@inertiajs/vue3';
import * as chartConfig from "@/Components/Charts/chart.config.js";
import LineChart from "@/Components/Charts/LineChart.vue";
import SectionMain from "@/Components/SectionMain.vue";
import CardBoxWidget from "@/Components/CardBoxWidget.vue";
import CardBox from "@/Components/CardBox.vue";
import Books from "@/Components/Tables/Books.vue";
import BaseButton from "@/Components/BaseButton.vue";
import CardBoxTransaction from "@/Components/CardBoxTransaction.vue";
import CardBoxClient from "@/Components/CardBoxClient.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import axios from "axios";

const chartData = ref(null);
const books = ref();
const selectOptions = reactive({
    category_id: [ { "id": 0, "label": "Select Category" }],
    tag_id: [{ "id": 0, "label": "Select Tag" }],
    publisher_id: [{ "id": 0, "label": "Select Publisher" }],
    translator_id: [{ "id": 0, "label": "Select Tranlator" }],
    writer_id: [{ "id": 0, "label": "Select Writer" }],
});

const fillChartData = () => {
    chartData.value = chartConfig.sampleChartData();
};
async function getBooks() {
    await axios.get('http://localhost:8000/api/v1/books').then((r) => { books.value = r.data; });
}

onMounted(() => {
    getBooks();
    fillChartData();
});

const mainStore = useMainStore();

const clientBarItems = computed(() => mainStore.books.slice(0, 4));

const transactionBarItems = computed(() => mainStore.magazines.slice(0, 4));
</script>

<template>
    <LayoutAuthenticated>

        <Head title="Dashbord" />
        <SectionMain>
            <SectionTitleLineWithButton :icon="mdiChartTimelineVariant" title="Overview" main>
            </SectionTitleLineWithButton>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
                <CardBoxWidget trend="12%" trend-type="up" color="text-emerald-500" :icon="mdiAccountMultiple" :number="512"
                    label="Clients" />
                <CardBoxWidget trend="12%" trend-type="down" color="text-blue-500" :icon="mdiCartOutline" :number="7770"
                    prefix="$" label="Sales" />
                <CardBoxWidget trend="Overflow" trend-type="alert" color="text-red-500" :icon="mdiChartTimelineVariant"
                    :number="256" suffix="%" label="Performance" />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="flex flex-col justify-between">
                    <CardBoxTransaction v-for="(transaction, index) in transactionBarItems" :key="index"
                        :amount="transaction.amount" :date="transaction.date" :business="transaction.business"
                        :type="transaction.type" :name="transaction.name" :account="transaction.account" />
                </div>
                <div class="flex flex-col justify-between">
                    <CardBoxClient v-for="client in clientBarItems" :key="client.id" :name="client.name"
                        :login="client.login" :date="client.created" :progress="client.progress" />
                </div>
            </div>



            <SectionTitleLineWithButton :icon="mdiChartPie" title="Trends overview">
                <BaseButton :icon="mdiReload" color="whiteDark" @click="fillChartData" />
            </SectionTitleLineWithButton>

            <CardBox class="mb-6">
                <div v-if="chartData">
                    <line-chart :data="chartData" class="h-96" />
                </div>
            </CardBox>

            <SectionTitleLineWithButton :icon="mdiAccountMultiple" title="Books" />

            <!-- <NotificationBar color="info" :icon="mdiMonitorCellphone">
            <b>Responsive table.</b> Collapses on mobile
          </NotificationBar> -->
          <CardBox v-if=books class="mb-6" has-table>
                <Books perPage="5" :books=books.data :selectOptions=selectOptions @update-books="getBooks()" />
            </CardBox>

            <CardBox v-else>
                <CardBoxComponentEmpty />
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
