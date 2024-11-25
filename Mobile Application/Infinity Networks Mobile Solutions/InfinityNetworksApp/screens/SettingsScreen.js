import { useContext, useState, useEffect } from "react";
import {
  SafeAreaView,
  Text,
  StyleSheet,
  TouchableOpacity,
  Image,
  View,
  ActivityIndicator,
} from "react-native";
import { AuthContext } from "../context/AuthContext";
import { getDoc, doc } from "firebase/firestore";
import { db } from "../config/firebase";

const SettingsScreen = ({ navigation }) => {
  const { user, logout } = useContext(AuthContext);
  const [userDetails, setUserDetails] = useState([]);
  const [isLoading, setIsLoading] = useState(false);
  console.log("Setting User ID:", user.uid);
  useEffect(() => {
    getUserDetails();
  }, []);

  const getUserDetails = async () => {
    try {
      setIsLoading(true);
      const userID = user.uid.toString();
      const docRef = doc(db, "user-details", userID);
      const docSnap = await getDoc(docRef);

      if (docSnap.exists()) {
        setUserDetails(docSnap.data());
      } else {
        console.log("No such document!");
      }
    } catch (error) {
      console.log("Error fetching user details:", error);
    } finally {
      setIsLoading(false);
    }
  };
  console.log(userDetails);

  const handleChangePassword = () => {
    console.log("Change password option pressed.");
    navigation.navigate("ChangePasswordScreen");
  };

  const handleUpdateDetails = () => {
    console.log("Update Detais option pressed.");
    navigation.navigate("UpdateProfileScreen");
  };

  if (isLoading)
    return (
      <View style={[styles.containerActivity, styles.horizontal]}>
        <ActivityIndicator size="large" color="#86B049" />
      </View>
    );

  return (
    <SafeAreaView style={styles.container}>
      <Text style={styles.titleText}>Settings and Profile</Text>
      <Image source={{ uri: userDetails.image }} style={styles.profileImage} />
      <Text style={styles.name}>
        {userDetails.name} {userDetails.surname}
      </Text>
      <Text style={styles.posting}>Post: {userDetails.post}</Text>
      <Text style={styles.years}>
        Years of Service: {userDetails.years_service}
      </Text>
      <Text style={styles.posting}>Site: {userDetails.site}</Text>
      <Text style={styles.email}>E-mail: {userDetails.email}</Text>
      <Text style={styles.phone}>Mobile: {userDetails.mobile}</Text>

      <TouchableOpacity
        style={styles.changePasswordButton}
        onPress={handleUpdateDetails}
      >
        <Text style={styles.buttonText}>Update Details</Text>
      </TouchableOpacity>

      <TouchableOpacity style={styles.signOutButton} onPress={logout}>
        <Text style={styles.buttonText}>Sign Out</Text>
      </TouchableOpacity>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    alignItems: "center",
    justifyContent: "center",
    backgroundColor: "white",
  },
  profileImage: {
    width: 250,
    height: 250,
    borderRadius: 75,
    marginBottom: 20,
  },
  name: {
    fontSize: 24,
    fontWeight: "bold",
    marginBottom: 10,
    textTransform: "uppercase",
  },

  posting: {
    fontSize: 16,
    marginBottom: 10,
  },
  email: {
    fontSize: 16,
    marginBottom: 10,
  },
  phone: {
    fontSize: 16,
    marginBottom: 10,
  },
  years: {
    fontSize: 16,
    marginBottom: 10,
  },
  changePasswordButton: {
    backgroundColor: "#3A96F1",
    paddingHorizontal: 20,
    paddingVertical: 10,
    borderRadius: 8,
    marginBottom: 8,
  },
  signOutButton: {
    backgroundColor: "#FF4500",
    paddingHorizontal: 20,
    paddingVertical: 10,
    borderRadius: 8,
  },
  buttonText: {
    color: "white",
    fontWeight: "bold",
    fontSize: 16,
  },
  containerActivity: {
    flex: 1,
    justifyContent: "center",
    margin: 15,
    backgroundColor: "#F5F5F5",
  },
  horizontal: {
    flexDirection: "row",
    justifyContent: "space-around",
    padding: 10,
  },
  titleText: {
    fontSize: 24,
    fontWeight: "bold",
    color: "#86B049",
    margin: 10,
  },
});

export default SettingsScreen;
