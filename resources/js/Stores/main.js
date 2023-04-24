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

        /* Sample data (commonly used) */
        books: [{"code":"82832025","name":"Jace Jacobson Sr.","price":804170,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"23827837","name":"Leatha Auer I","price":479696,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"49781427","name":"Kattie Stoltenberg","price":416658,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"34170571","name":"Betsy Feeney PhD","price":553490,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"16605206","name":"Adaline Bradtke","price":847844,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"74705511","name":"Ms. Millie Nader I","price":569319,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"26281063","name":"Barbara Parisian","price":866505,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"18680812","name":"Mrs. Lydia Ankunding","price":635530,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"72373170","name":"Dr. Octavia Altenwerth Jr.","price":727097,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"81788965","name":"Dr. Madie Lehner","price":231409,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"30801431","name":"Aidan Bergnaum DDS","price":935373,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"95061887","name":"Aurelie Hane DVM","price":901109,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"58747070","name":"Madonna Purdy","price":105754,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"61263598","name":"Hilma Reilly","price":838435,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"37095376","name":"Brook Collins","price":699361,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"31843584","name":"Floyd Hermiston","price":566228,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"19608150","name":"Prof. Alexa Leannon I","price":491532,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"01325973","name":"Dr. Idell Denesik DDS","price":118762,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"03212547","name":"Prof. Julianne Stroman","price":466681,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"95285030","name":"Prof. Benny Ullrich III","price":351286,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"99002176","name":"Juliana Wisozk","price":587894,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"83276217","name":"Joshuah Morar","price":437395,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"05269778","name":"Isaac Hauck Sr.","price":727593,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"61626508","name":"Jaunita Sawayn","price":445986,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"71311845","name":"Dorothy Walker","price":422787,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"45120596","name":"Treva Collier IV","price":106420,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"31562485","name":"Damon Hessel","price":518371,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"51295943","name":"Idell McGlynn","price":469687,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"52492334","name":"Faustino Grimes III","price":279404,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"},{"code":"62769297","name":"Elsa Rogahn","price":799617,"image":"https:\/\/fakeimg.pl\/320\/","created_at":"2023-04-24T12:34:26.000000Z"}],
        history: [],
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
        fetch(sampleDataKey) {
            axios
                .get(`localhost:8000/api/v1/${sampleDataKey}`)
                .then((r) => {
                    if (r.data) {
                        this[sampleDataKey] = r.data;
                    }
                })
                .catch((error) => {
                    alert(error.message);
                });
        },
    },
});
