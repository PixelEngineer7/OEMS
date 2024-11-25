import React from "react";
import { createNativeStackNavigator } from "@react-navigation/native-stack";
import DirectoryScreen from "../screens/DirectoryScreen";
import DetailsScreen from "../screens/DetailsScreen";

const Stack = createNativeStackNavigator();

const DirectoryNavigator = () => {
  return (
    <Stack.Navigator>
      <Stack.Screen
        name="DirectoryHome"
        component={DirectoryScreen}
        options={{ headerShown: false }}
      />
      <Stack.Screen
        name="DetailsScreen"
        component={DetailsScreen}
        options={({ route }) => {
          const name = route.params.name;
          const surname = route.params.surname;
          const fullName = name + " " + surname;
          return {
            title: fullName,
          };
        }}
      />
    </Stack.Navigator>
  );
};

export default DirectoryNavigator;
