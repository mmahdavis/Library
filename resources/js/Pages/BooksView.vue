<script setup>
import {
    mdiPlus,
    mdiBookMultipleOutline,
} from "@mdi/js";
import SectionMain from "@/components/SectionMain.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import Books from "@/components/Tables/Books.vue";
import CardBox from "@/components/CardBox.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseButton from "@/components/BaseButton.vue";
</script>

<template>
    <LayoutAuthenticated>
        <SectionMain>
            <SectionTitleLineWithButton :icon="mdiBookMultipleOutline" title="Books" main>
                <BaseButton href="" target="_blank" :icon="mdiPlus" label="Add New" color="contrast" rounded-full small />
            </SectionTitleLineWithButton>

            <CardBox class="mb-6" has-table>
                <Books checkable />
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
