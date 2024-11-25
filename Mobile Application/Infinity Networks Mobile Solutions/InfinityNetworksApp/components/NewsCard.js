import { StyleSheet, Text, View } from "react-native";
import React from "react";
import { Card } from "react-native-paper";

const NewsCard = ({ news }) => {
  const { title, image, date_published } = news;
  return (
    <Card style={styles.card}>
      <Card.Cover style={styles.image} source={{ uri: image }} />
      <View style={styles.textWrapper}>
        <Text style={styles.textTitle}>{title}</Text>
        <Text style={styles.textDate}>Posted Date: {date_published}</Text>
      </View>
    </Card>
  );
};

export default NewsCard;

const styles = StyleSheet.create({
  card: {
    marginBottom: 20,
    backgroundColor: "#DFF5CE",
  },

  image: {
    height: 220,
  },
  textWrapper: {
    marginTop: 10,
    padding: 10,
  },
  textTitle: {
    fontWeight: "bold",
  },
  textDate: {
    textAlign: "right",
    fontStyle: "italic",
  },
});
