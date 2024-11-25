import React from "react";
import { createNativeStackNavigator } from "@react-navigation/native-stack";
import SettingsScreen from "../screens/SettingsScreen";
import UpdateProfileScreen from "../screens/UpdateProfileScreen";

const Stack = createNativeStackNavigator();

const LeavesNavigator = () => {
  return (
    <Stack.Navigator>
      <Stack.Screen
        name="SettingsHome"
        component={SettingsScreen}
        options={{ headerShown: false }}
      />

      <Stack.Screen
        name="UpdateProfileScreen"
        component={UpdateProfileScreen}
        options={{ headerTitle: "Profile Update Settings", headerShown: true }}
      />
    </Stack.Navigator>
  );
};

export default LeavesNavigator;
