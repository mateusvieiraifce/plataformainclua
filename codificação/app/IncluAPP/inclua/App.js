import { StatusBar } from 'expo-status-bar';
import { useEffect, useState } from 'react';
import { ActivityIndicator, Button, Image, StyleSheet, Text, View } from 'react-native';
import { WebView } from 'react-native-webview';
import NetInfo from '@react-native-community/netinfo';

export default function App() {
  const [isConnected, setIsConnected] = useState(null);
  const [isLoading, setIsLoading] = useState(true);
  useEffect(() => {
    // Verificar o estado da conexão
    const unsubscribe = NetInfo.addEventListener(state => {
      setIsConnected(state.isConnected);
      setIsLoading(false);
    });

    // Verificar conexão imediatamente
    checkConnection();

    return () => unsubscribe();
  }, []);

  const checkConnection = async () => {
    try {
      const state = await NetInfo.fetch();
      setIsConnected(state.isConnected);
    } catch (error) {
      console.error('Erro ao verificar conexão:', error);
      setIsConnected(false);
    } finally {
      setIsLoading(false);
    }
  };

  if (isLoading) {
    return (
      <View style={styles.centerContainer}>
        <ActivityIndicator size="large" color="#0000ff" />
        <Text>Verificando conexão...</Text>
      </View>
    );
  }

  if (!isConnected) {
    return (
      <View style={styles.centerContainer}>
        <Image source={require('./assets/logo.png')} style={styles.image} resizeMode="contain"/>
        <Text style={styles.errorText}>Sem conexão com a internet</Text>
        <Text style={styles.subText}>
          Verifique sua conexão Wi-Fi ou dados móveis
        </Text>
        <Button 
          title="Tentar Novamente" 
          onPress={checkConnection} 
        />
      </View>
    );
  }
  
  return (
    
      
       <WebView
          style={styles.container} // Define que o webview deve ocupar todo o espaço disponível
          source={{ uri: 'https://app.plataformainclua.com/login' }} // Substitua 'https://www.example.com' pela URL do site que você deseja exibir
        >
      </WebView>
    
  );
}

const styles = StyleSheet.create({

  container: {
    marginTop: 50,
    flex: 1,
    backgroundColor: '#fff',
    alignItems: 'center',
    justifyContent: 'center',
  },
  image:{
    width: '100%',
    height: 100,
    marginBottom: 20, 
  },
  centerContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    padding: 20,
  },
  errorText: {
    fontSize: 18,
    fontWeight: 'bold',
    color: 'red',
    marginBottom: 10,
    textAlign: 'center',
  },
  subText: {
    fontSize: 14,
    color: '#666',
    textAlign: 'center',
    marginBottom: 20,
  },
});
