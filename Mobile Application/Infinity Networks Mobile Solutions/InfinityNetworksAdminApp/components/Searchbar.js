import { View, StyleSheet, TextInput } from 'react-native';
import Ionicons from '@expo/vector-icons/Ionicons';

const Searchbar = ({ term, onTermChange, onReady }) => {
  console.log(term);
  return (
    <View style={styles.search}>
      <Ionicons size={30} color={'gray'} name="md-search" />
      <TextInput
        style={styles.searchInput}
        placeholder={'Search'}
        onChangeText={onTermChange}
        value={term}
        onEndEditing={onReady}
        autoCorrect={false}
        autoCapitalize="none"
      />
    </View>
  );
};

export default Searchbar;

const styles = StyleSheet.create({
  searchInput: {
    fontSize: 18,
    color: 'gray',
    marginLeft: 10,
  },
  search: {
    flexDirection: 'row',
    backgroundColor: '#f0eeee',
    borderRadius: 20,
    padding: 10,
  },
});
