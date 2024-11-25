// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAuth } from "firebase/auth";
import { getFirestore } from "firebase/firestore";

// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyBh1p-bPwEEq6c_uJ_Zad3ZJegSYfmPk8Y",
  authDomain: "infinity-network-app.firebaseapp.com",
  projectId: "infinity-network-app",
  storageBucket: "infinity-network-app.appspot.com",
  messagingSenderId: "101325868125",
  appId: "1:101325868125:web:06c53c69832eeced6b51b4",
  measurementId: "G-RMNQ9CQYWE",
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

const auth = getAuth(app);
const db = getFirestore(app);
const firestore = getFirestore(app);

export { auth, db, firestore };
