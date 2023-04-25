<script setup>
import {
    mdiTableBorder,
    mdiPlus,
    mdiBookMultipleOutline,
} from "@mdi/js";
import SectionMain from "@/components/SectionMain.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import Translators from "@/components/Tables/Translators.vue";
import CardBox from "@/components/CardBox.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
</script>

<template>
    <LayoutAuthenticated>
        <SectionMain>
            <SectionTitleLineWithButton :icon="mdiBookMultipleOutline" title="Translators" main>
                <BaseButton href="" target="_blank" :icon="mdiPlus" label="Add New" color="contrast" rounded-full small />
            </SectionTitleLineWithButton>

            <CardBox class="mb-6" has-table>
                <Translators checkable />
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
