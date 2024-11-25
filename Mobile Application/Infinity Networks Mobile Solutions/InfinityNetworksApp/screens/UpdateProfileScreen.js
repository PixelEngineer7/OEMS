import React, { useContext, useState } from "react";
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  StyleSheet,
} from "react-native";
import { AuthContext } from "../context/AuthContext";
import { db } from "../config/firebase";
import { doc, setDoc } from "firebase/firestore";

const UpdateProfileScreen = () => {
  const { user } = useContext(AuthContext);
  const [site, setSite] = useState("");
  const [mobile, setMobile] = useState("");

  const handleUpdateProfile = async () => {
    try {
      const userID = user.uid;
      console.log("User ID:", userID);

      // Check the values before calling the update method
      console.log("Site:", site);
      console.log("Mobile:", mobile);

      const docRef = doc(db, "user-details", userID);

      const data = {
        site: site,
        mobile: mobile,
      };

      await setDoc(docRef, data, { merge: true });

      console.log(
        "Infinity Networks | Profile Update",
        "Document Field has been updated successfully"
      );
    } catch (error) {
      console.log(error);
      console.log("Error updating profile:", error);
      alert(
        "Infinity Networks | Error",
        "Failed to update profile. Please try again later."
      );
    }
  };

  return (
    <View style={styles.container}>
      <TextInput
        style={styles.input}
        placeholder="Site"
        value={site}
        onChangeText={setSite}
      />

      <TextInput
        style={styles.input}
        placeholder="Mobile"
        value={mobile}
        onChangeText={setMobile}
      />

      <TouchableOpacity style={styles.button} onPress={handleUpdateProfile}>
        <Text style={styles.buttonText}>Update Profile</Text>
      </TouchableOpacity>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
    backgroundColor: "#F5F5F5",
    padding: 20,
  },
  input: {
    width: "100%",
    height: 40,
    borderColor: "#CCCCCC",
    borderWidth: 1,
    borderRadius: 5,
    marginBottom: 10,
    paddingHorizontal: 10,
  },
  button: {
    backgroundColor: "#3A96F1",
    paddingHorizontal: 20,
    paddingVertical: 10,
    borderRadius: 8,
    marginBottom: 10,
  },
  buttonText: {
    color: "white",
    fontWeight: "bold",
    fontSize: 16,
  },
});

export default UpdateProfileScreen;
