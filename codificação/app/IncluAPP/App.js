import React from 'react';
import { WebView } from 'react-native-webview';

const App = () => {
    return (
        <WebView
            source={{ uri: 'https://app.plataformainclua.com' }}
            style={{ flex: 1 }}
            javaScriptEnabled={true}
            domStorageEnabled={true}
        />
    );
};

export default App;
