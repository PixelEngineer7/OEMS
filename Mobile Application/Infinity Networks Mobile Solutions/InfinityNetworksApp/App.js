import { StyleSheet } from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";
import AppNavigator from "./navigation/AppNavigator";
import AuthContextProvider from "./context/AuthContext";

export default function App() {
  return (
    <SafeAreaView style={styles.container}>
      <AuthContextProvider>
        <AppNavigator />
      </AuthContextProvider>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
});
