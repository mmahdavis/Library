import { defineStore } from "pinia";
import axios from "axios";

export const useMainStore = defineStore("main", {
    state: () => ({

        /* User */
        userName: null,
        userEmail: null,
        userAvatar: null,

        /* Field focus with ctrl+k (to register only once) */
        isFieldFocusRegistered: false,

        categories: [],
        tags: [],
        publishers: [],
        translators: [],
        writers: [],
    }),
    actions: {
        setUser(payload) {
            if (payload.name) {
                this.userName = payload.name;
            }
            if (payload.email) {
                this.userEmail = payload.email;
            }
            if (payload.avatar) {
                this.userAvatar = payload.avatar;
            }
        },
        async getExternalData() {
            try {
                const data = await axios('http://localhost:8000/api/v1/bookdata').then((r) => { return r.data })
                this.categories = data.categories
                this.tags = data.tags
                this.publishers = data.publishers
                this.translators = data.translators
                this.writers = data.writers
            } catch (error) {
                alert(error)
                console.log(error);
            }
        }
    },
});
