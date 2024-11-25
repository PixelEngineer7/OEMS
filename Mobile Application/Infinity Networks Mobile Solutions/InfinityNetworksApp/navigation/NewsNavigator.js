import { createNativeStackNavigator } from "@react-navigation/native-stack";
import NewsScreen from "../screens/NewsScreen";
import NewsDetailScreen from "../screens/NewsDetailScreen";

const Stack = createNativeStackNavigator();

const NewsNavigator = () => {
  return (
    <Stack.Navigator
      screenOptions={{
        headerStyle: {
          backgroundColor: "#525B88",
          justifyContent: "center",
        },
        headerTintColor: "#fff",
      }}
    >
      <Stack.Screen
        name="Internal News Feed"
        component={NewsScreen}
        options={{ headerShown: false }}
      />
      <Stack.Screen
        name="NewsDetailScreen"
        component={NewsDetailScreen}
        options={({ route }) => ({ title: route.params.newsTitle })}
      />
    </Stack.Navigator>
  );
};

export default NewsNavigator;
