import { FlatList, StyleSheet, Text, TouchableOpacity } from 'react-native';
import RestaurantCard from './RestaurantCard';
import { useNavigation } from '@react-navigation/native';

const RestaurantList = ({ restaurants }) => {
  const navigation = useNavigation();
  const displayRestaurant = ({ item }) => (
    <TouchableOpacity
      activeOpacity={0.8}
      onPress={() => {
        navigation.navigate('RestaurantDetail', {
          restId: item.id,
          restName: item.name,
        });
      }}
    >
      <RestaurantCard restaurant={item} />
    </TouchableOpacity>
  );

  return (
    <>
      <Text style={styles.text}>Found {restaurants.length} restaurants.</Text>
      <FlatList
        data={restaurants}
        keyExtractor={restaurant => restaurant.id}
        renderItem={displayRestaurant}
      />
    </>
  );
};

export default RestaurantList;

const styles = StyleSheet.create({
  text: {
    fontWeight: 'bold',
    marginBottom: 10,
    fontSize: 16,
  },
});
