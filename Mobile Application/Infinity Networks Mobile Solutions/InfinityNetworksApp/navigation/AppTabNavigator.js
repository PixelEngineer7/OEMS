import { createBottomTabNavigator } from "@react-navigation/bottom-tabs";
import LeavesScreen from "../screens/LeavesScreen";
import SettingsNavigator from "./SettingsNavigator";
import { Ionicons } from "@expo/vector-icons";
import NewsNavigator from "./NewsNavigator";
import DirectoryNavigator from "./DirectoryNavigator";

const Tab = createBottomTabNavigator();

const AppTabNavigator = () => {
  return (
    <Tab.Navigator
      initialRouteName="NewsHome"
      screenOptions={({ route }) => ({
        headerShown: false,
        headerTitleAlign: "center",
        headerStyle: {
          backgroundColor: "#621Faa",
        },
        headerTintColor: "#fff",
        headerTitleStyle: {
          fontWeight: "bold",
        },
        tabBarIcon: ({ color, size }) => {
          let iconName;

          if (route.name === "News") {
            iconName = "md-newspaper-sharp";
          } else if (route.name === "Settings") {
            iconName = "person-circle";
          } else if (route.name === "Directory") {
            iconName = "book";
          } else if (route.name === "Leaves") {
            iconName = "golf-sharp";
          }

          // You can return any component that you like here!
          return <Ionicons name={iconName} size={size} color={color} />;
        },
        tabBarActiveTintColor: "#86B049",
        tabBarInactiveTintColor: "#525B88",
      })}
    >
      <Tab.Screen name="News" component={NewsNavigator} />
      <Tab.Screen name="Leaves" component={LeavesScreen} />
      <Tab.Screen name="Directory" component={DirectoryNavigator} />
      <Tab.Screen name="Settings" component={SettingsNavigator} />
    </Tab.Navigator>
  );
};

export default AppTabNavigator;
