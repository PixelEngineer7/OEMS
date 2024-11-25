import { FlatList, StyleSheet, Text, TouchableOpacity } from "react-native";
import NewsCard from "./NewsCard";
import { useNavigation } from "@react-navigation/native";
import * as Notifications from "expo-notifications";
import { useContext, useState, useEffect } from "react";

const NewsList = ({ news }) => {
  const setPushNotifications = async () => {
    const { status } = Notifications.getPermissionsAsync();
    let finalStatus = status;

    if (finalStatus !== "granted") {
      const { status } = Notifications.requestPermissionsAsync();
      finalStatus = status;
    }

    if (finalStatus !== "granted") {
      Alert.alert("Permission Error", "Permission could not be granted!");
      return;
    }

    const pushToken = await Notifications.getExpoPushTokenAsync();
    console.log(pushToken.data);

    if (Platform.OS === "android") {
      await Notifications.setNotificationChannelAsync("default", {
        name: "default",
        importance: Notifications.AndroidImportance.DEFAULT,
      });
    }
  };

  useEffect(() => {
    const subscriptionReceived = Notifications.addNotificationReceivedListener(
      (notification) => {
        console.log("NOTIFICATION RECEIVED");
        console.log(notification.request.content.data);
      }
    );
    const subscriptionResponse =
      Notifications.addNotificationResponseReceivedListener((response) => {
        console.log("NOTIFICATION RESPONSE");
        console.log(response);
      });
    return () => {
      subscriptionReceived.remove();
      subscriptionResponse.remove();
    };
  }, []);

  const sendNotification = () => {
    console.log("Sending a Notifiation!");

    Notifications.scheduleNotificationAsync({
      content: {
        title: "Exciting News!!!",
        body: "Be Proud of our Team - Infinity Networks",
        data: {
          subjects:
            "Be your Best!!!,Thank you for those efforts from the Management Team.",
        },
      },
      trigger: { seconds: 2 },
    });
    Notifications.setNotificationHandler({
      handleNotification: async () => {
        return {
          shouldShowAlert: true,
          shouldPlaySound: true,
          shouldSetBadge: false,
        };
      },
    });
  };
  const navigation = useNavigation();
  const displayNews = ({ item }) => (
    <TouchableOpacity
      activeOpacity={0.8}
      onPress={({ sendNotification }) => {
        navigation.navigate("NewsDetailScreen", {
          newsTitle: item.title,
          newsImage: item.image,
          newsContent: item.content,
          newsDate: item.date_published,
        });
      }}
    >
      <NewsCard news={item} />
    </TouchableOpacity>
  );

  return (
    <>
      <Text style={styles.text}>
        Live News Feed and Displaying {news.length} News
      </Text>
      <FlatList
        data={news}
        keyExtractor={(news) => news.post_id}
        renderItem={displayNews}
      />
    </>
  );
};

export default NewsList;

const styles = StyleSheet.create({
  text: {
    fontWeight: "bold",
    marginBottom: 15,
    fontSize: 22,
    textAlign: "center",
    color: "#86B049",
    textDecorationLine: "underline",
  },
});
