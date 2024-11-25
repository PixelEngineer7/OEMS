import { StyleSheet, View, ActivityIndicator } from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";
import { useState, useEffect } from "react";
import axios from "axios";

import NewsList from "../components/NewsList";

const NewsScreen = (props) => {
  const [news, setNews] = useState([]);
  const [isLoading, setIsLoading] = useState(false);

  useEffect(() => {
    const fetchData = async () => {
      try {
        setIsLoading(true);
        const response = await axios.get(
          "https://devrg7.github.io/InfinityNetworksAPI/data.json"
        );
        setNews(response.data.posts);
        console.log(response.data.posts);
      } catch (error) {
        console.log(error);
      } finally {
        setIsLoading(false);
      }
    };

    fetchData();
  }, []);

  if (isLoading)
    return (
      <View style={[styles.container, styles.horizontal]}>
        <ActivityIndicator size="large" color="#86B049" />
      </View>
    );

  return (
    <SafeAreaView style={styles.container}>
      <View style={styles.resultsWrapper}>
        <NewsList news={news} />
      </View>
    </SafeAreaView>
  );
};

export default NewsScreen;

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: "white",
    justifyContent: "center",
  },

  resultsWrapper: {
    flex: 1,
    padding: 10,
  },

  horizontal: {
    flexDirection: "row",
    justifyContent: "space-around",
    padding: 10,
  },
});
