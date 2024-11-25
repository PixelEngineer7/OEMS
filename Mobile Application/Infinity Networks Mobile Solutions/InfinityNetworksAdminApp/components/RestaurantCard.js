import { StyleSheet, Text, View } from 'react-native';
import React from 'react';
import { Card, Avatar, Button } from 'react-native-paper';

const RestaurantCard = ({ restaurant }) => {
  const {
    image_url,
    name,
    rating,
    review_count,
    location: { display_address },
  } = restaurant;
  return (
    <Card style={styles.card}>
      <Card.Cover style={styles.image} source={{ uri: image_url }} />
      <View style={styles.textWrapper}>
        <Text>{name}</Text>
        <Text>{`${display_address[0]}, ${display_address[1]}`}</Text>
        <Text>{`${rating} stars, ${review_count} reviews`}</Text>
      </View>
    </Card>
  );
};

export default RestaurantCard;

const styles = StyleSheet.create({
  card: { marginBottom: 20, padding: 10 },
  image: {},
  textWrapper: {
    marginTop: 10,
  },
});
