import { StatusBar } from 'expo-status-bar';
import { StyleSheet, Text, View } from 'react-native';
import { WebView } from 'react-native-webview';

export default function App() {
  return (
    
      
       <WebView
          style={styles.container} // Define que o webview deve ocupar todo o espaço disponível
          source={{ uri: 'https://app.plataformainclua.com/login' }} // Substitua 'https://www.example.com' pela URL do site que você deseja exibir
        >

      <StatusBar style="auto" />
      </WebView>
    
  );
}

const styles = StyleSheet.create({
  container: {
    marginTop: 40,
    flex: 1,
    backgroundColor: '#fff',
    alignItems: 'center',
    justifyContent: 'center',
  },
});
