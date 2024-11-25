import { StyleSheet, SafeAreaView, View, ScrollView } from "react-native";
import React, { useContext, useEffect, useState } from "react";
import { AuthContext } from "../context/AuthContext";
import { getDoc, doc } from "firebase/firestore";
import { db } from "../config/firebase";

import { Avatar, Button, Card, Text } from "react-native-paper";

const LeavesScreen = () => {
  const { user } = useContext(AuthContext);
  const [userDetails, setUserDetails] = useState(null);
  const [bal_sick, setBal_sick] = useState(0);
  const [bal_wel, setBal_wel] = useState(0);
  const [bal_local, setBal_local] = useState(0);
  const [lastRefreshDate, setLastRefreshDate] = useState(new Date());
  useEffect(() => {
    getUserDetails();
  }, []);

  const getUserDetails = async () => {
    try {
      const userID = user.uid.toString();
      console.log(userID);
      const docRef = doc(db, "leaves", userID);
      const docSnap = await getDoc(docRef);

      if (docSnap.exists()) {
        setUserDetails(docSnap.data());
        console.log(docSnap.data().bal_wel);
        setBal_sick(docSnap.data().bal_sick);
        setBal_wel(docSnap.data().bal_wel);
        setBal_local(docSnap.data().bal_local);
        setLastRefreshDate(new Date());
      } else {
        console.log("No such document!");
      }
    } catch (error) {
      console.log("Error fetching user details:", error);
    }
  };
  return (
    <SafeAreaView style={styles.container}>
      <Text style={styles.title}>Leaves Balances</Text>

      <ScrollView>
        <Card style={styles.card} elevation={3}>
          <Card.Title title="Sick Leave" titleStyle={styles.titleCard} />
          <Card.Content>
            <Text style={styles.contentText}>
              Yearly Entitled Sick Leave Balance: 15
            </Text>
            <Text style={styles.contentText}>
              Current Sick Leave Balance: {bal_sick}
            </Text>
            <Text style={styles.contentTextSub}>
              Last Refresh: {lastRefreshDate.toLocaleString()}
            </Text>
          </Card.Content>
        </Card>

        <Card style={styles.card1} elevation={4}>
          <Card.Title title="Annual Leave" titleStyle={styles.titleCard} />
          <Card.Content>
            <Text style={styles.contentText}>
              Yearly Entitled Annual Leave Balance: 22
            </Text>
            <Text style={styles.contentText}>
              Current Annual Leave Balance: {bal_local}
            </Text>

            <Text style={styles.contentTextSub}>
              Last Refresh: {lastRefreshDate.toLocaleString()}
            </Text>
          </Card.Content>
        </Card>

        <Card style={styles.card2} elevation={5}>
          <Card.Title title="Wellness Leave" titleStyle={styles.titleCard} />
          <Card.Content>
            <Text style={styles.contentText}>
              Yearly Entitled Wellness Leave Balance: 5
            </Text>
            <Text style={styles.contentText}>
              Current Wellness Leave Balance: {bal_wel}
            </Text>
            <Text style={styles.contentTextSub}>
              Last Refresh: {lastRefreshDate.toLocaleString()}
            </Text>
          </Card.Content>
        </Card>
      </ScrollView>
    </SafeAreaView>
  );
};

export default LeavesScreen;

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 10,
    backgroundColor: "white",
  },
  card: {
    marginBottom: 20,
    backgroundColor: "#9C1AA3",
    borderRadius: 15,
  },
  card1: {
    marginBottom: 20,
    backgroundColor: "#47C63A",
    borderRadius: 15,
  },
  card2: {
    marginBottom: 30,
    backgroundColor: "#FFD300",
    borderRadius: 15,
  },

  title: {
    fontSize: 24,
    fontWeight: "bold",
    color: "#86B049",
    margin: 10,
  },
  contentText: {
    color: "white",
    fontWeight: "bold",
    marginTop: 6,
    fontSize: 16,
  },
  titleCard: {
    color: "white",
    fontSize: 18,
    fontWeight: "bold",
    textDecorationLine: "underline",
  },
  contentTextSub: {
    color: "white",
    textAlign: "right",
    marginTop: 6,
  },
});
