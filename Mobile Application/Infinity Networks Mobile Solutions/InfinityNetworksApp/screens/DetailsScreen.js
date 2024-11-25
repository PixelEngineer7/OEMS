import { StyleSheet, View, Text, Image, SafeAreaView } from "react-native";
import { useRoute } from "@react-navigation/native";
import { Card } from "react-native-paper";

const DetailsScreen = () => {
  const route = useRoute();

  const name = route.params.name;
  const image_url = route.params.image_url;
  const surname = route.params.surname;
  const email = route.params.email;
  const posting = route.params.postingDep;
  const phone = route.params.phone;
  const site = route.params.siteOfWork;
  const mobile = route.params.mobile;
  const postition = route.params.postition;

  return (
    <Card style={styles.card}>
      <Card.Cover source={{ uri: image_url }} style={styles.image} />
      <View style={styles.textContainer}>
        <View style={styles.headerName}>
          <Text style={styles.textName}>
            {name} {surname}
          </Text>
        </View>

        <View style={styles.headerContent}>
          <Text style={styles.headerChild}>Position : </Text>
          <Text style={styles.postingText}>{postition} </Text>
        </View>

        <View style={styles.headerContent}>
          <Text style={styles.headerChild}>Posting : </Text>
          <Text style={styles.postingText}>{posting} </Text>
        </View>

        <View style={styles.headerContent}>
          <Text style={styles.headerChild}>Site : </Text>
          <Text style={styles.postingText}>{site} </Text>
        </View>

        <View style={styles.headerContent}>
          <Text style={styles.headerChild}>Work : </Text>
          <Text style={styles.postingText}>{phone} </Text>
        </View>

        <View style={styles.headerContent}>
          <Text style={styles.headerChild}>Mobile : </Text>
          <Text style={styles.postingText}>{mobile} </Text>
        </View>

        <View style={styles.headerContent}>
          <Text style={styles.headerChild}>Email: </Text>
          <Text style={styles.postingText}>{email} </Text>
        </View>
      </View>
    </Card>
  );
};

export default DetailsScreen;

const styles = StyleSheet.create({
  card: {
    flex: 1,
    backgroundColor: "#FFFFFF",
  },

  image: {
    height: 400,
  },
  textContainer: {
    padding: 10,
  },
  headerContainer: {
    justifyContent: "center",
    alignItems: "center",
    padding: 5,
  },
  textName: {
    textTransform: "uppercase",
    textAlign: "center",
    fontSize: 25,
    fontWeight: "bold",
    marginBottom: 10,
    color: "#288CBC",
  },
  headerContent: {
    flexDirection: "row",
    alignItems: "center",
  },
  headerChild: {
    textAlign: "left",
    fontSize: 14,
    fontWeight: "bold",
    marginBottom: 10,
  },
  postingText: {
    fontWeight: "normal",
    marginBottom: 10,
    fontSize: 14,
  },
});
