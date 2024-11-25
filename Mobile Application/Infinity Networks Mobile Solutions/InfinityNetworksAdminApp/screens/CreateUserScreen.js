import React, { useState, useContext } from "react";
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  StyleSheet,
  ScrollView,
  Alert,
} from "react-native";
import { db } from "../config/firebase";
import { setDoc, doc } from "firebase/firestore";
import { SafeAreaView } from "react-native-safe-area-context";
import { AuthContext } from "../context/AuthContext";

const CreateUserScreen = () => {
  const { user, logout } = useContext(AuthContext);
  const [userID, setUserID] = useState("");
  const [email, setEmail] = useState("");
  const [emergency, setEmergency] = useState("");
  const [image, setImage] = useState("");
  const [mobile, setMobile] = useState("");
  const [name, setName] = useState("");
  const [surname, setSurname] = useState("");
  const [post, setPost] = useState("");
  const [posting, setPosting] = useState("");
  const [site, setSite] = useState("");
  const [workPhone, setWorkPhone] = useState("");
  const [yearsService, setYearsService] = useState("");
  const [bal_local, setBal_local] = useState("");
  const [bal_sick, setBal_sick] = useState("");
  const [bal_wel, setBal_wel] = useState("");

  const handleCreateUser = async () => {
    try {
      const userDetailsData = {
        email: email,
        emergency: emergency,
        image: image,
        mobile: mobile,
        name: name,
        surname: surname,
        post: post,
        posting: posting,
        site: site,
        workPhone: workPhone,
        years_service: yearsService,
      };

      const docRef = doc(db, "user-details", userID);
      await setDoc(docRef, userDetailsData);

      Alert.alert(
        "Infnity Networks | User Creation",
        "User details saved successfully!"
      );
    } catch (error) {
      console.log("Error saving user details:", error);
      Alert.alert(
        "Infnity Networks | User Creation",
        "Failed to save user details. Please try again later."
      );
    }
  };

  const handleCreateLeaves = async () => {
    try {
      const userLeavesData = {
        bal_local: bal_local,
        bal_wel: bal_wel,
        bal_sick: bal_sick,
      };

      const docRef = doc(db, "leaves", userID);
      await setDoc(docRef, userLeavesData);

      Alert.alert(
        "Infnity Networks | Leaves Creation",
        "User Leaves created successfully!"
      );
    } catch (error) {
      console.log("Error saving user leaves details:", error);
      Alert.alert(
        "Infnity Networks | Leaves Creation",
        "Failed to save user leaves details. Please try again later."
      );
    }
  };

  const handleCreateDirectory = async () => {
    try {
      const userDirectoryData = {
        email: email,
        image: image,
        mobile_num: mobile,
        name: name,
        surname: surname,
        postition: post,
        posting: posting,
        site: site,
        work_num: workPhone,
      };

      const docRef = doc(db, "directory", userID);
      await setDoc(docRef, userDirectoryData);

      Alert.alert(
        "Infnity Networks | Directory Creation",
        "User  created successfully!"
      );
    } catch (error) {
      console.log("Error saving user details:", error);
      Alert.alert(
        "Infnity Networks | Directory Creation",
        "Failed to save user  details. Please try again later."
      );
    }
  };

  return (
    <SafeAreaView style={styles.container}>
      <ScrollView>
        <View style={styles.container1}>
          <Text style={styles.header}>Infinity Networks User Creation</Text>
          <TextInput
            style={styles.input}
            placeholder="Firebase UserID: "
            value={userID}
            onChangeText={setUserID}
          />
          <TextInput
            style={styles.input}
            placeholder="Email"
            value={email}
            onChangeText={setEmail}
          />

          <TextInput
            style={styles.input}
            placeholder="Emergency"
            value={emergency}
            onChangeText={setEmergency}
          />

          <TextInput
            style={styles.input}
            placeholder="Image URL"
            value={image}
            onChangeText={setImage}
          />

          <TextInput
            style={styles.input}
            placeholder="Mobile"
            value={mobile}
            onChangeText={setMobile}
          />

          <TextInput
            style={styles.input}
            placeholder="Name"
            value={name}
            onChangeText={setName}
          />
          <TextInput
            style={styles.input}
            placeholder="Surname"
            value={surname}
            onChangeText={setSurname}
          />

          <TextInput
            style={styles.input}
            placeholder="Postition"
            value={post}
            onChangeText={setPost}
          />

          <TextInput
            style={styles.input}
            placeholder="Posting"
            value={posting}
            onChangeText={setPosting}
          />

          <TextInput
            style={styles.input}
            placeholder="Site"
            value={site}
            onChangeText={setSite}
          />

          <TextInput
            style={styles.input}
            placeholder="Work Phone"
            value={workPhone}
            onChangeText={setWorkPhone}
          />

          <TextInput
            style={styles.input}
            placeholder="Years of Service"
            value={yearsService}
            onChangeText={setYearsService}
          />
          <TextInput
            style={styles.input}
            placeholder="Balance Sick Leaves"
            value={bal_sick}
            onChangeText={setBal_sick}
          />
          <TextInput
            style={styles.input}
            placeholder="Balance Local Leaves"
            value={bal_local}
            onChangeText={setBal_local}
          />
          <TextInput
            style={styles.input}
            placeholder="Balance Wellness Leaves"
            value={bal_wel}
            onChangeText={setBal_wel}
          />
          <View style={styles.btnContainer}>
            <View>
              <TouchableOpacity
                style={styles.button}
                onPress={handleCreateUser}
              >
                <Text style={styles.buttonText}>Create User</Text>
              </TouchableOpacity>
            </View>
            <View>
              <TouchableOpacity
                style={styles.button1}
                onPress={handleCreateLeaves}
              >
                <Text style={styles.buttonText}>Create Leaves</Text>
              </TouchableOpacity>
            </View>
          </View>

          <View style={styles.btnContainer}>
            <View>
              <TouchableOpacity
                style={styles.button2}
                onPress={handleCreateDirectory}
              >
                <Text style={styles.buttonText}>Push on Directory</Text>
              </TouchableOpacity>
            </View>
            <View>
              <TouchableOpacity style={styles.button3} onPress={logout}>
                <Text style={styles.buttonText}>Log Out</Text>
              </TouchableOpacity>
            </View>
          </View>
        </View>
      </ScrollView>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  container1: {
    flex: 1,
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
    backgroundColor: "#9C1AA3",
    paddingHorizontal: 20,
    paddingVertical: 10,
    borderRadius: 8,
    marginBottom: 10,
    alignContent: "stretch",
  },
  button1: {
    backgroundColor: "#FFD300",
    paddingHorizontal: 20,
    paddingVertical: 10,
    borderRadius: 8,
    marginBottom: 10,
  },
  button2: {
    backgroundColor: "#47C63A",
    paddingHorizontal: 20,
    paddingVertical: 10,
    borderRadius: 8,
    marginBottom: 10,
  },
  button3: {
    backgroundColor: "#F44E5A",
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
  header: {
    alignItems: "center",
    color: "#3A96F1",
    padding: 20,
    fontWeight: "bold",
    fontSize: 22,
  },

  btnContainer: {
    flexDirection: "row",
    justifyContent: "space-between",
    width: "100%",
  },
});

export default CreateUserScreen;
