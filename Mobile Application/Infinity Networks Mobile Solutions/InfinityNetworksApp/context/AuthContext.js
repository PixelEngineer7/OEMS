import React, { createContext, useState } from "react";
import { Alert } from "react-native";
import { auth, firestore } from "../config/firebase";
import {
  signInWithEmailAndPassword,
  createUserWithEmailAndPassword,
  signOut,
} from "firebase/auth";

export const AuthContext = createContext();

const AuthContextProvider = ({ children }) => {
  const [user, setUser] = useState(null);

  const login = async (email, password) => {
    if (!email || !password) {
      Alert.alert(
        "Infinity Networks | Login Error",
        "Please check your email and password and try again."
      );
    } else {
      try {
        const userCredential = await signInWithEmailAndPassword(
          auth,
          email,
          password
        );
        const { user } = userCredential;
        setUser(user);
        Alert.alert(
          "Infinity Networks | Warning Message",
          "The content and features of this app are intended for internal use by authorized personnel only. Unauthorized access is prohibited. If you are not an authorized user, please exit the app."
        );
        navigation.navigate("Home");
      } catch (error) {
        const errorCode = error.code;
        const errorMessage = error.message;

        if (errorCode === "auth/user-not-found") {
          Alert.alert(
            "Infinity Networks | Account Not Found",
            "Please contact Infinity Networks Administrator on admin@infinitynetworks.com."
          );
          console.log(errorMessage);
        } else if (errorCode === "auth/wrong-password") {
          Alert.alert(
            "Infinity Networks | Login Failed",
            "Please check your password and try again."
          );

          console.log(errorMessage);
        }
      }
    }
  };

  const logout = async () => {
    try {
      await signOut(auth);
      setUser(null);
    } catch (error) {
      console.log("Logout error:", error);
    }
  };

  return (
    <AuthContext.Provider value={{ user, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
};

export default AuthContextProvider;
