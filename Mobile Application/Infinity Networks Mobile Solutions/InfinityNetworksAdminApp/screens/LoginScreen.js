import { useState, useContext } from "react";
import {
  StyleSheet,
  View,
  Text,
  SafeAreaView,
  TextInput,
  TouchableOpacity,
  Image,
} from "react-native";

import { AuthContext } from "../context/AuthContext";

const LoginScreen = ({ navigation }) => {
  const { login, setUser } = useContext(AuthContext);
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const loginUser = () => {
    login(email, password);
  };

  return (
    <SafeAreaView style={styles.container}>
      <Image
        source={require("../assets/images/logo.png")}
        style={styles.image}
      />
      <View>
        <Text style={styles.header}>ADMINISTRATOR PORTAL </Text>
      </View>
      <TextInput
        style={styles.inputBox}
        value={email}
        onChangeText={(email) => setEmail(email)}
        placeholder="Email"
        autoCapitalize="none"
      />
      <TextInput
        style={styles.inputBox}
        value={password}
        onChangeText={(password) => setPassword(password)}
        placeholder="Password"
        secureTextEntry={true}
      />
      <TouchableOpacity style={styles.button} onPress={loginUser}>
        <Text style={styles.buttonText}>Login</Text>
      </TouchableOpacity>
      <View>
        <Text style={styles.footer}>© 2023, Infinity Networks</Text>
      </View>
    </SafeAreaView>
  );
};

export default LoginScreen;

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: "#fff",
    alignItems: "center",
    justifyContent: "center",
  },
  inputBox: {
    width: "85%",
    margin: 10,
    padding: 15,
    fontSize: 16,
    borderColor: "#d3d3d3",
    borderBottomWidth: 2,
  },
  button: {
    marginTop: 30,
    marginBottom: 30,
    paddingVertical: 5,
    alignItems: "center",
    backgroundColor: "#3A96F1",
    borderColor: "#3A96F1",
    borderWidth: 1,
    borderRadius: 5,
    width: "85%",

    // Add shadow styles
    shadowColor: "#000",
    shadowOffset: {
      width: 0,
      height: 2,
    },
    shadowOpacity: 0.25,
    shadowRadius: 3.84,
    elevation: 5,
  },

  buttonText: {
    fontSize: 25,
    fontWeight: "bold",
    color: "#fff",
  },

  verticalLine: {
    height: "100%",
    width: 2,
    backgroundColor: "#909090",
  },
  image: {
    marginBottom: 20,
  },
  header: {
    fontSize: 20,
    alignItems: "center",
    justifyContent: "center",
    fontStyle: "italic",
    fontWeight: "bold",
  },
  footer: {
    marginTop: 80,
    fontSize: 16,
    alignItems: "center",
    justifyContent: "center",
  },
});
