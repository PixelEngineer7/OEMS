import { Text, StyleSheet, View, ScrollView } from "react-native";
import { Card } from "react-native-paper";
const NewsDetailScreen = ({ route }) => {
  const { newsTitle, newsImage, newsContent, newsDate } = route.params;

  return (
    <ScrollView>
      <Card style={styles.card}>
        <Card.Cover source={{ uri: newsImage }} style={styles.image} />
        <View style={styles.textContainer}>
          <View style={styles.headerContainer}>
            <Text style={styles.headerText}>{newsTitle}</Text>
          </View>
          <View style={styles.headerContainer}>
            <Text style={styles.headerText2}>{newsContent}</Text>
          </View>
          <View style={styles.textDateContainer}>
            <Text style={styles.textDate}>Date Published {newsDate}</Text>
          </View>
        </View>
      </Card>
    </ScrollView>
  );
};

export default NewsDetailScreen;

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
