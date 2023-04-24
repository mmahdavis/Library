import {
    mdiAccountCircle,
    mdiMonitor,
    mdiGithub,
    mdiLock,
    mdiAlertCircle,
    mdiSquareEditOutline,
    mdiTable,
    mdiViewList,
    mdiTelevisionGuide,
    mdiResponsive,
    mdiPalette,
    mdiReact,
} from "@mdi/js";

export default [
    {
        route: "dashboard",
        icon: mdiMonitor,
        label: "Dashboard",
    },
    {
        route: "tables",
        label: "Tables",
        icon: mdiTable,
    },
    {
        route: "forms",
        label: "Forms",
        icon: mdiSquareEditOutline,
    },
    {
        route: "profile",
        label: "Profile",
        icon: mdiAccountCircle,
    },
    //   {
    //     label: "Dropdown",
    //     icon: mdiViewList,
    //     menu: [
    //       {
    //         label: "Item One",
    //       },
    //       {
    //         label: "Item Two",
    //       },
    //     ],
    //   },
    //   {
    //     href: "https://github.com/justboil/admin-one-vue-tailwind",
    //     label: "GitHub",
    //     icon: mdiGithub,
    //     target: "_blank",
    //   },
];
