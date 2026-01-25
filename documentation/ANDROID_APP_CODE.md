# Complete Android App Guide (WebView) 📱

Since you have the Website ready, the best way to make an App is using **WebView**.
Here is the **Complete Code** you need to paste into Android Studio.

## Prerequisites
1.  **Android Studio** installed.
2.  Your Laptop and Mobile must be on the **Same WiFi**.
3.  Your Local IP is `192.168.1.9` (as per your error logs).

---

### Step 1: Permissions (AndroidManifest.xml)
Go to `app > manifests > AndroidManifest.xml` and add these lines:

```xml
<?xml version="1.0" encoding="utf-8"?>
<manifest xmlns:android="http://schemas.android.com/apk/res/android"
    package="com.saif47s.hyperlocal">

    <!-- Add Internet Permissions -->
    <uses-permission android:name="android.permission.INTERNET" />
    <uses-permission android:name="android.permission.ACCESS_NETWORK_STATE" />
    <uses-permission android:name="android.permission.ACCESS_WIFI_STATE" />

    <application
        android:allowBackup="true"
        android:icon="@mipmap/ic_launcher"
        android:label="@string/app_name"
        android:roundIcon="@mipmap/ic_launcher_round"
        android:supportsRtl="true"
        android:theme="@style/Theme.HyperLocal"
        android:usesCleartextTraffic="true"> <!-- IMPORTANT for HTTP (Localhost) -->
        
        <activity android:name=".MainActivity"
            android:exported="true">
            <intent-filter>
                <action android:name="android.intent.action.MAIN" />
                <category android:name="android.intent.category.LAUNCHER" />
            </intent-filter>
        </activity>
    </application>

</manifest>
```

---

### Step 2: Layout (activity_main.xml)
Go to `app > res > layout > activity_main.xml`:

```xml
<?xml version="1.0" encoding="utf-8"?>
<RelativeLayout xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="match_parent">

    <!-- WebView Container -->
    <WebView
        android:id="@+id/myWebView"
        android:layout_width="match_parent"
        android:layout_height="match_parent" />

</RelativeLayout>
```

---

### Step 3: Java Logic (MainActivity.java)
Go to `app > java > com.saif47s.hyperlocal > MainActivity.java`:

```java
package com.saif47s.hyperlocal;

import androidx.appcompat.app.AppCompatActivity;
import android.os.Bundle;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;

public class MainActivity extends AppCompatActivity {

    private WebView myWebView;
    // CHANGE THIS IP TO YOUR COMPUTER'S CURRENT IP
    private String websiteURL = "http://192.168.1.9/hs/index.php"; 

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        // 1. Find WebView
        myWebView = findViewById(R.id.myWebView);

        // 2. Enable Settings
        WebSettings webSettings = myWebView.getSettings();
        webSettings.setJavaScriptEnabled(true);
        webSettings.setDomStorageEnabled(true);

        // 3. Prevent opening in Chrome (Keep inside App)
        myWebView.setWebViewClient(new WebViewClient());

        // 4. Load URL
        myWebView.loadUrl(websiteURL);
    }

    // 5. Handle Back Button (Go back in history instead of closing app)
    @Override
    public void onBackPressed() {
        if (myWebView.canGoBack()) {
            myWebView.goBack();
        } else {
            super.onBackPressed();
        }
    }
}
```

---

### Step 4: Run the App
1.  Connect your Mobile via USB.
2.  Click **Run (Green Play Button)** in Android Studio.
3.  Ensure XAMPP is Running on Laptop.

**Note:** If you want to share this app with others (Global), you must host your PHP Website on a Live Server (like Hostinger/GoDaddy) and update the `websiteURL` in Java code.

---

### Step 5: Remove Top Title Bar (Action Bar)
To remove the "HyperLocal" header shown in your screenshot:
1.  Go to `app > res > values > themes > themes.xml`.
2.  Look for the line starting with `<style name="Theme.HyperLocal" parent="...">`.
3.  Change the `parent` to **NoActionBar**.

**Before:**
`parent="Theme.MaterialComponents.DayNight.DarkActionBar"`

**After (Fix):**
`parent="Theme.MaterialComponents.DayNight.NoActionBar"`

Do this for `themes.xml (night)` as well if it exists.
