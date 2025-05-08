// resources/js/firebase.js
import { initializeApp } from "firebase/app";
import { getDatabase } from "firebase/database";

const firebaseConfig = {
    apiKey: "AIzaSyBjq9XoU3ynkknYQaRsy4WCrBVkj3pPrYU",
    authDomain: "afetyardim-e16c1.firebaseapp.com",
    databaseURL: "https://afetyardim-e16c1-default-rtdb.europe-west1.firebasedatabase.app",
    projectId: "afetyardim-e16c1",
    storageBucket: "afetyardim-e16c1.firebasestorage.app",
    messagingSenderId: "428052170605",
    appId: "1:428052170605:web:a6081ced73d9f60ba37c64",
    measurementId: "G-KCKT3K14RZ"
};

const app = initializeApp(firebaseConfig);
const database = getDatabase(app);

export { database };
