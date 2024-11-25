import { useContext } from "react";
import { NavigationContainer } from "@react-navigation/native";
import { createNativeStackNavigator } from "@react-navigation/native-stack";
import AppTabNavigator from "./AppTabNavigator";
import AuthNavigator from "./AuthNavigator";
import { AuthContext } from "../context/AuthContext";

const Stack = createNativeStackNavigator();

const AppNavigator = () => {
  const { user } = useContext(AuthContext);
  console.log("user: " + user?.uid);

  return (
    <NavigationContainer>
      <Stack.Navigator screenOptions={{ headerShown: false }}>
        {user ? (
          <>
            <Stack.Screen name="Home" component={AppTabNavigator} />
          </>
        ) : (
          <>
            <Stack.Screen name="Auth" component={AuthNavigator} />
          </>
        )}
      </Stack.Navigator>
    </NavigationContainer>
  );
};

export default AppNavigator;
