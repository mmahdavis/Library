import {
    mdiAccountCircle,
    mdiMonitor,
    mdiSquareEditOutline,
    mdiBookMultiple,
    mdiViewList,
    mdiPublish,
    mdiAbjadArabic,
    mdiTranslateVariant,
    mdiTagMultiple,
    mdiShape,
    mdiDatabase,
    mdiMagazinePistol,
    mdiFileStarFourPoints,
} from "@mdi/js";

export default [
    {
        route: "dashboard",
        icon: mdiMonitor,
        label: "Dashboard",
    },
    {
        route: "books",
        label: "Books",
        icon: mdiBookMultiple,
    },
    {
        route: "magazines",
        label: "Magazines",
        icon: mdiMagazinePistol,
    },
    {
        route: "special_issue",
        label: "Special Issues",
        icon: mdiFileStarFourPoints,
    },
    {
        label: "Books Data",
        icon: mdiDatabase,
        menu: [
            {
                route: "writers",
                label: "Writers",
                icon: mdiAbjadArabic,
            },
            {
                route: "publisers",
                label: "Publisers",
                icon: mdiPublish,
            },
            {
                route: "translators",
                label: "Translators",
                icon: mdiTranslateVariant,
            },
            {
                route: "tags",
                label: "Tags",
                icon: mdiTagMultiple,
            },
            {
                route: "categories",
                label: "Categories",
                icon: mdiShape,
            },
        ],
    },
];
