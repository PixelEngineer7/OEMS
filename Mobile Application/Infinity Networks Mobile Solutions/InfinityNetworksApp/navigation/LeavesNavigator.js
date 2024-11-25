import React from "react";
import { createNativeStackNavigator } from "@react-navigation/native-stack";
import LeavesScreen from "../screens/LeavesScreen";
import LeavesDetailsScreen from "../screens/LeavesDetailsScreen";

const Stack = createNativeStackNavigator();

const LeavesNavigator = () => {
  return (
    <Stack.Navigator>
      <Stack.Screen
        name="LeavesHome"
        component={LeavesScreen}
        options={{ headerShown: false }}
      />
      <Stack.Screen
        name="LeavesScreen"
        component={LeavesDetailsScreen}
        options={({ route }) => {
          const name = route.params.name;

          return {
            title: name,
          };
        }}
      />
    </Stack.Navigator>
  );
};

export default LeavesNavigator;
