import { Text, StyleSheet, View, ScrollView } from "react-native";
import { Card } from "react-native-paper";
const LeavesDetailsScreen = ({ route }) => {
  return (
    <ScrollView>
      <Card style={styles.card}></Card>
    </ScrollView>
  );
};

export default LeavesDetailsScreen;

const styles = StyleSheet.create({
  card: {
    flex: 0.5,
  },
  image: {
    padding: 10,
    height: 200,
  },
  textContainer: {
    padding: 10,
  },
  headerContainer: {
    justifyContent: "center",
    alignItems: "center",
    padding: 10,
  },
  headerText: {
    fontSize: 20,
    fontWeight: "bold",
    color: "#525B88",
  },
  headerText2: {
    fontSize: 15,

    textAlign: "justify",
  },
  textDate: {
    textAlign: "right",
    fontStyle: "italic",
  },
});
