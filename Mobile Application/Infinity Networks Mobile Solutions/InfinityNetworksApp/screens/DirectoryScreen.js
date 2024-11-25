import {
  StyleSheet,
  Text,
  SafeAreaView,
  FlatList,
  TextInput,
  View,
  ActivityIndicator,
  TouchableOpacity,
} from "react-native";
import { useContext, useEffect, useState } from "react";
import { AuthContext } from "../context/AuthContext";
import { collection, getDocs } from "firebase/firestore";
import { db } from "../config/firebase";
import { useNavigation } from "@react-navigation/native";

const DirectoryScreen = () => {
  const { user } = useContext(AuthContext);
  const [userDetails, setUserDetails] = useState([]);
  const [searchText, setSearchText] = useState("");
  const navigation = useNavigation();
  const [isLoading, setIsLoading] = useState(false);

  useEffect(() => {
    getUserDetails();
  }, []);

  const getUserDetails = async () => {
    try {
      setIsLoading(true);
      const querySnapshot = await getDocs(collection(db, "directory"));
      const userDetailsData = [];
      querySnapshot.forEach((doc) => {
        userDetailsData.push(doc.data());
      });
      setUserDetails(userDetailsData);
    } catch (error) {
      console.log("Error fetching user details:", error);
    } finally {
      setIsLoading(false);
    }
  };

  const filterUserDetails = (userDetails, searchText) => {
    return userDetails.filter(
      (user) =>
        user.surname.includes(searchText) || user.name.includes(searchText)
    );
  };

  if (isLoading)
    return (
      <View style={[styles.container, styles.horizontal]}>
        <ActivityIndicator size="large" color="#86B049" />
      </View>
    );
  const renderItem = ({ item }) => (
    <TouchableOpacity
      style={styles.itemContainer}
      onPress={() => {
        navigation.navigate("DetailsScreen", {
          name: item.name,
          surname: item.surname,
          image_url: item.image,
          email: item.email,
          phone: item.work_num,
          mobile: item.mobile_num,
          postingDep: item.posting,
          siteOfWork: item.site,
          postition: item.postition,
        });
      }}
    >
      <Text style={styles.itemSurname}>
        {item.surname} {item.name}
      </Text>
    </TouchableOpacity>
  );

  return (
    <SafeAreaView style={styles.container}>
      <Text style={styles.title}>Company Directory</Text>

      <TextInput
        style={styles.searchInput}
        placeholder="Search by Surname or Name"
        onChangeText={setSearchText}
        value={searchText}
      />

      <FlatList
        data={filterUserDetails(userDetails, searchText)}
        renderItem={renderItem}
        keyExtractor={(item, index) => index.toString()}
      />
    </SafeAreaView>
  );
};

export default DirectoryScreen;

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: "center",

    backgroundColor: "white",
  },
  title: {
    fontSize: 24,
    fontWeight: "bold",
    marginVertical: 20,
    justifyContent: "center",
    alignItems: "center",
    color: "#86B049",
    margin: 10,
  },
  searchInput: {
    width: "95%",
    height: 50,
    borderWidth: 2,
    borderColor: "#3a378b",
    borderRadius: 8,
    paddingHorizontal: 10,
    margin: 10,
  },
  itemSurname: {
    fontSize: 16,
    color: "white",
    fontWeight: "bold",
    margin: 8,
    padding: 10,
    borderWidth: 1,
    borderRadius: 8,
    borderColor: "#2986CC",
    justifyContent: "center",
    backgroundColor: "#2986CC",
  },

  horizontal: {
    flexDirection: "row",
    justifyContent: "space-around",
    padding: 10,
  },
});
